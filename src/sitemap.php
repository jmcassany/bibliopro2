<?php
require_once('config.php');
require_once('configdb.php');
require_once ("database/database.inc");
require_once ("funcions_base.inc");
require_once ("formatting.php");
db_connect($db_url);

function crea_sitemap() {
	global $CONFIG_URLBASE;

	/* EL FITXER DE CONFIGURACI� �S /lib/sitemap.inc */

	/* Variables predefinides per la funci� */

	$fSitemap="sitemap.xml";	//ATENCIO! Fer anar rutes RELATIVES a on es posi el sitemap.php!
	$pingGoogle=false;
	$pingYahoo=false;
	$pingAsk=false;
	//Determina on esta posicionat el sitemap.xml des de la web per a fer els pings
	$fSitemapAbs=$CONFIG_URLBASE."/".$fSitemap;

	/* Carregar Filtres de p�gines i carpetes */

	$handle = fopen('lib/sitemap.inc','r');

	$carpetesNo = explode(',', trim(fgets($handle)));
	$estatiquesNo = explode(',', trim(fgets($handle)));

	/* P�gines est�tiques */

	//Agafem la llista de pagines a analitzar
	$result=db_query("select ID,NOMPAG,PARE,MODIFICAT,REFERENCIA from ESTATICA where STATUS=1 order by PARE");
	//Agafem la carpeta Home per comprovar si es tracta de la portada
	$result2=db_query("select ID from CARPETES where PARE is null");
	$filaPare=db_fetch_array($result2);

	while ($row=db_fetch_array($result)) {
		//Filtrem l'est�tica
		if (!in_array($row['ID'],$estatiquesNo) && !in_array($row['REFERENCIA'],$estatiquesNo)) {
			//Variable de control pel filtre de carpetes
			$allowContinue = true;

			//Definim quin pare t�
			$pare=$row["PARE"];

			//Iniciem la variable del nom complet del fitxer
			$fitxer=$row["NOMPAG"];

			//Trobem la ruta completa de la p�gina i afegim el filtre de carpetes
			while ($pare!=0) {
				if (in_array($pare,$carpetesNo)) {
					$allowContinue = false;
				}
				$result2=db_query("select NOMCARPETA,PARE from CARPETES where ID='".$pare."' and PARE is not null");
				if (db_num_rows($result2)!=0) {
					$row2=db_fetch_array($result2);
					//Assignem la carpeta anterior
					$fitxer=$row2['NOMCARPETA']."/".$fitxer;
					$pare=(int)$row2["PARE"];
				} else {
					break;
				}
			}

			if (!$allowContinue) {
				continue;
			}

			//Comprovem si es tracta de la portada
			if ($filaPare["ID"]==$row["PARE"] && $row["NOMPAG"]=="index.html") {
				$frequencies[]="hourly";
				$prioritats[]="1";
			} else {
				$frequencies[]="weekly";
				$prioritats[]="0.6";
			}

			//Convertim la data a format de sitemap i l'afegim
			$data=strtotime($row['MODIFICAT']);
			$dataCorrecta=date("Y-m-d",$data)."T".date("H:i:sP",$data);
			$dates[]=$dataCorrecta;

			//Afegim la direcci� de la web
			$fitxer=$CONFIG_URLBASE. '/' .$fitxer;
			//Afegim la p�gina a la llista
			$pagines[]=$fitxer;
		}
	}

	/* P�gines din�miques */

	//Agafem la llista d'editores i anem fent coses per cada una d'elles
	$result=db_query("select ID,NOMCARPETA,PARE from CARPETES where CATEGORY1=1 order by ID");
	while ($row=db_fetch_array($result)) {
		if (!in_array($row['ID'], $carpetesNo)) {
			//D�na el nom de l'arrel de l'editora
			$fitxer=$row["NOMCARPETA"];
			//Inicialitzem el pare
			$pare=$row["PARE"];
			//Trobem la ruta completa de la p�gina
			while ($pare!=0) {
				$result2=db_query("select NOMCARPETA,PARE from CARPETES where ID='".$pare."' and PARE is not null");
				if (mysql_num_rows($result2)!=0) {
					$row2=db_fetch_array($result2);
					//Assignem la carpeta anterior
					$fitxer=$row2['NOMCARPETA']."/".$fitxer;
					$pare=(int)$row2["PARE"];
				} else {
					break;
				}
			}
			//Adequem la carpeta mare de l'editora completament
			$fitxer=$CONFIG_URLBASE.'/'.$fitxer;

			//Afegim l'arrel de la editor a la llista d'adreces
			$pagines[]=$fitxer;
			$frequencies[]="daily";
			$prioritats[]="0.8";
			$dates[]=date("Y-m-d",time())."T".date("H:i:sP",time());		//La hora de la portada es posa sempre com l'hora actual

			//Agafem totes les p�gines publicades de cada editora
			$result2=db_query("select URL_TITOL,ID,MODIFICAT from editora_".$row["ID"]." where STATUS=1 order by ORDRE");
			while ($row2=db_fetch_array($result2)) {
				//Adaptem la url i l'afegim
				$subfitxer=$fitxer."/".$row2["ID"]."/".$row2["URL_TITOL"];
				$pagines[]=$subfitxer;
				//Adaptem la data al format sitemap i l'afegim
				$data=strtotime($row2['MODIFICAT']);
				$dates[]=date("Y-m-d",$data)."T".date("H:i:sP",$data);
				//Frequencia i prioritats
				$frequencies[]="weekly";
				$prioritats[]="0.6";
			}
		}
	}

//Agafem la llista d'editores i anem fent coses per cada una d'elles


			//Agafem totes les p�gines publicades de cada editora
			$result2=db_query("select NOM_CAST,ID,MODIFICAT from  Cuestionarios where STATUS=1 order by CREATION ASC");
			while ($row2=db_fetch_array($result2)) {
				//Adaptem la url i l'afegim
				$subfitxer=$CONFIG_URLBASE.'/buscador/' . $row2['ID'].'/'.sanitize_title($row2['NOM_CAST']);
				//$subfitxer='/buscador'."/".$row2["ID"]."/".$row2["URL_TITOL"];
				$pagines[]=$subfitxer;
				//Adaptem la data al format sitemap i l'afegim
				$data=strtotime($row2['MODIFICAT']);
				$dates[]=date("Y-m-d",$data)."T".date("H:i:sP",$data);
				//Frequencia i prioritats
				$frequencies[]="weekly";
				$prioritats[]="0.6";
			}


	/* Assignem el contingut del fitxer xml */
	$final='<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$final.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
	$t=0;
	while ($t<(count($pagines))) {
		$final.="<url>\n";
		//Nom de p�gina
		$final.="\t<loc>";
		$final.=htmlspecialchars($pagines[$t]);
		$final.="</loc>\n";
		//Data de la �ltima modificaci�
		$final.="\t<lastmod>";
		$final.=$dates[$t];
		$final.="</lastmod>\n";
		//Freq��ncia d'actualitzacio
		$final.="\t<changefreq>";
		$final.=$frequencies[$t];
		$final.="</changefreq>\n";
		//Prioritats
		$final.="\t<priority>";
		$final.=$prioritats[$t];
		$final.="</priority>\n";
		$final.="</url>\n";
		$t++;
	}
	$final.='</urlset>';

	/* Creem el fitxer xml */
	/*if (file_exists($fSitemap)) {
		unlink($fSitemap);
	}
	$ffSitemap=fopen($fSitemap,"a");
	fputs($ffSitemap,$final);
	fclose($ffSitemap);*/

	/* Fem el ping a Google, Yahoo i Ask si est�n activats */
	if ($pingGoogle) {
		$intents=0;
		while (pingGoogleSitemaps($fSitemapAbs)!=200 && $intents<3) {
			$intents++;
		}
	}
	if ($pingYahoo) {
		$intents=0;
		while (pingYahooSitemaps($fSitemapAbs)!=200 && $intents<3) {
			$intents++;
		}
	}
	if ($pingAsk) {
		$intents=0;
		while (pingAskSitemaps($fSitemapAbs)!=200 && $intents<3) {
			$intents++;
		}
	}

	return $final;
}

/**
 * Function to ping Google Sitemaps.
 *
 * Function to ping Google Sitemaps. Returns an integer, e.g. 200 or 404,
 * 0 on error.
 *
 * @author     J de Silva                           <giddomains@gmail.com>
 * @copyright  Copyright &copy; 2005, J de Silva
 * @link       http://www.gidnetwork.com/b-54.html  PHP function to ping Google Sitemaps
 * @param      string   $url_xml  The sitemap url, e.g. http://www.example.com/google-sitemap-index.xml
 * @return     integer            Status code, e.g. 200|404|302 or 0 on error
 */
function pingGoogleSitemaps($url_xml)
{
   $status = 0;
   $google = 'www.google.com';
   if( $fp=@fsockopen($google, 80) )
   {
      $req =  'GET /webmasters/sitemaps/ping?sitemap=' .
              urlencode( $url_xml ) . " HTTP/1.1\r\n" .
              "Host: $google\r\n" .
              "User-Agent: Mozilla/5.0 (compatible; " .
              PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
              "Connection: Close\r\n\r\n";
      fwrite( $fp, $req );
      while( !feof($fp) )
      {
         if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
         {
            $status = intval( $m[1] );
            break;
         }
      }
      fclose( $fp );
   }
   return( $status );
}

//Modificaci� de la funci� anterior per a sitemaps de Ask.com

function pingAskSitemaps($url_xml)
{
   $status = 0;
   $google = 'submissions.ask.com';
   if( $fp=@fsockopen($google, 80) )
   {
      $req =  'GET /ping?sitemap=' .
              urlencode( $url_xml ) . " HTTP/1.1\r\n" .
              "Host: $google\r\n" .
              "User-Agent: Mozilla/5.0 (compatible; " .
              PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
              "Connection: Close\r\n\r\n";
      fwrite( $fp, $req );
      while( !feof($fp) )
      {
         if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
         {
            $status = intval( $m[1] );
            break;
         }
      }
      fclose( $fp );
   }
   return( $status );
}

//Modificaci� de la funci� anterior per a sitemaps de Yahoo

function pingYahooSitemaps($url_xml)
{
   $status = 0;
   $google = 'search.yahooapis.com';
   if( $fp=@fsockopen($google, 80) )
   {
      $req =  'GET /SiteExplorerService/V1/updateNotification?appid=YahooDemo&url=' .
              urlencode( $url_xml ) . " HTTP/1.1\r\n" .
              "Host: $google\r\n" .
              "User-Agent: Mozilla/5.0 (compatible; " .
              PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
              "Connection: Close\r\n\r\n";
      fwrite( $fp, $req );
      while( !feof($fp) )
      {
         if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
         {
            $status = intval( $m[1] );
            break;
         }
      }
      fclose( $fp );
   }
   return( $status );
}

// Header per escriure XML

header('Content-type: text/xml; charset="UTF-8"', true);

// Escrivim el fitxer Sitemap
$sortida=crea_sitemap();

echo $sortida;

?>
