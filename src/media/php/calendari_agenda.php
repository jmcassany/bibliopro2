<?php

	$CONFIG_PATHPHP = dirname(__FILE__);
	require_once($CONFIG_PATHPHP."/config.php");
	require_once("database/database.inc");
	require_once("PHPcalendar/class.Calendar_Events.php");

	
	function GetCalendari($idioma)
	{		
		global $CONFIG_NOMCARPETA, $ID_CARPETA;
		$array_lang = array (
		'ca' => array (
				'info_calendari' => 'Cursos i seminaris del mes de',
				'mes_seguent' => 'Mes següent',
				'mes_anterior' => 'Mes anterior',
				'mes_01' => 'Gener',
				'mes_02' => 'Febrer',
				'mes_03' => 'Març',
				'mes_04' => 'Abril',
				'mes_05' => 'Maig',
				'mes_06' => 'Juny',
				'mes_07' => 'Juliol',
				'mes_08' => 'Agost',
				'mes_09' => 'Setembre',
				'mes_10' => 'Octubre',
				'mes_11' => 'Novembre',
				'mes_12' => 'Desembre',
				'dilluns' => 'Dilluns',
				'dilluns_abr' => 'dl',
				'dimarts' => 'Dimarts',
				'dimarts_abr' => 'dm',
				'dimecres' => 'Dimecres',
				'dimecres_abr' => 'dc',
				'dijous' => 'Dijous',
				'dijous_abr' => 'dj',
				'divendres' => 'Divendres',
				'divendres_abr' => 'dv',
				'dissabte' => 'Dissabte',
				'dissabte_abr' => 'ds',
				'diumenge' => 'Diumenge',
				'diumenge_abr' => 'dg',
				),
		'es' => array (
				'info_calendari' => 'Cursos y seminarios del mes de',
				'mes_seguent' => 'Mes seguiente',
				'mes_anterior' => 'Mes anterior',
				'mes_01' => 'Enero',
				'mes_02' => 'Febrero',
				'mes_03' => 'Marzo',
				'mes_04' => 'Abril',
				'mes_05' => 'Mayo',
				'mes_06' => 'Junio',
				'mes_07' => 'Julio',
				'mes_08' => 'Agosto',
				'mes_09' => 'Septiembre',
				'mes_10' => 'Octubre',
				'mes_11' => 'Noviembre',
				'mes_12' => 'Diciembre',
				'dilluns' => 'Lunes',
				'dilluns_abr' => 'Lun',
				'dimarts' => 'Martes',
				'dimarts_abr' => 'Mar',
				'dimecres' => 'Miércoles',
				'dimecres_abr' => 'Mié',
				'dijous' => 'Jueves',
				'dijous_abr' => 'Jue',
				'divendres' => 'Viernes',
				'divendres_abr' => 'Vie',
				'dissabte' => 'Sábado',
				'dissabte_abr' => 'Sab',
				'diumenge' => 'Domingo',
				'diumenge_abr' => 'Dom',
				),
		'en' => array(
				'info_calendari' => 'Courses and seminars for',
				'mes_seguent' => 'Next month',
				'mes_anterior' => 'Previous month',
				'mes_01' => 'January',
				'mes_02' => 'February',
				'mes_03' => 'March',
				'mes_04' => 'April',
				'mes_05' => 'May',
				'mes_06' => 'June',
				'mes_07' => 'July',
				'mes_08' => 'August',
				'mes_09' => 'September',
				'mes_10' => 'October',
				'mes_11' => 'November',
				'mes_12' => 'December',
				'dilluns' => 'Monday',
				'dilluns_abr' => 'Mon',
				'dimarts' => 'Tuesday',
				'dimarts_abr' => 'Tue',
				'dimecres' => 'Wednesday',
				'dimecres_abr' => 'Wed',
				'dijous' => 'Thursday',
				'dijous_abr' => 'Thu',
				'divendres' => 'Friday',
				'divendres_abr' => 'Fri',
				'dissabte' => 'Saturday',
				'dissabte_abr' => 'Sat',
				'diumenge' => 'Sunday',
				'diumenge_abr' => 'Sun',
				),
		);
		
		
		/*
		 * 
		 *  inicialitzem les variables per al calendari
		 * 
		 */
		
	
		if(isset($_GET['month']))
		{
			$month = $_GET['month'];
		}
		else 
		{
			$month = date("m",time());
		}
		if(isset($_GET['year']))
		{
			$year = $_GET['year'];
		}
		else 
		{
			$year = date("Y",time());
		}
		if(isset($_GET['CATEGORY2']))		
		{			
			$CATEGORY2 = $_GET['CATEGORY2'];
		}	
	
		
		$next_month = $month+1;
		$next_year=$year;
		if($next_month==13)
		{
			$next_month=1;
			$next_year ++;
		}
		if($next_month<10)
		{
			$next_month='0'.$next_month;
		}		
	
		$prev_month = $month-1;
		$prev_year=$year;
		if($prev_month==0)
		{
			$prev_month=12;
			$prev_year --;
		}
		if($prev_month<10)
		{
			$prev_month = '0'.$prev_month;
		}
		
		//Calendar_Events
		$calendari = new Calendar_Events( $year, $month );		
	
		$next_month_link='?month='.$next_month.'&amp;year='.$next_year;
		$prev_month_link='?month='.$prev_month.'&amp;year='.$prev_year;
		
		if(isset($CATEGORY2))
		{
			$next_month_link .='&amp;CATEGORY2='.$CATEGORY2;
			$prev_month_link .='&amp;CATEGORY2='.$CATEGORY2;			
		}
		$calendar_header='

					<table summary="'.$array_lang[$idioma]['mes_'.$month].'">
						<caption>
							<a href="'.$prev_month_link.'" class="anterior"><img src="'.$CONFIG_NOMCARPETA.'/media/comu/enrera_calendari.gif" alt="'.$array_lang[$idioma]['mes_anterior'].'"/></a>
							<span>'.$array_lang[$idioma]['mes_'.$month].'</span>
							<a href="'.$next_month_link.'" class="seguent"><img src="'.$CONFIG_NOMCARPETA.'/media/comu/endavant_calendari.gif" alt="'.$array_lang[$idioma]['mes_seguent'].'"/></a>
		
						</caption>
						<thead>
							<tr>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['dilluns'].'">'.$array_lang[$idioma]['dilluns_abr'].'</abbr></th>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['dimarts'].'">'.$array_lang[$idioma]['dimarts_abr'].'</abbr></th>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['dimecres'].'">'.$array_lang[$idioma]['dimecres_abr'].'</abbr></th>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['dijous'].'">'.$array_lang[$idioma]['dijous_abr'].'</abbr></th>
		
								<th scope="col"><abbr title="'.$array_lang[$idioma]['divendres'].'">'.$array_lang[$idioma]['divendres_abr'].'</abbr></th>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['dissabte'].'">'.$array_lang[$idioma]['dissabte_abr'].'</abbr></th>
								<th scope="col"><abbr title="'.$array_lang[$idioma]['diumenge'].'">'.$array_lang[$idioma]['diumenge_abr'].'</abbr></th>
							</tr>	
						</thead>
						<tbody>';	
		
		$calendar_foot='
						</tbody>
					</table>

			';	
	
		
	
		/*
		 * 
		 * afegim els actes de l'agenda
		 * 
		 */

		if($month < 10 && strpos($month,'0')===false)
		{
			$month = '0'.$month;
		}
		
		$sql = "select * from editora_".$ID_CARPETA." where STATUS=1 AND (CALENDAR_START_TIME LIKE '$year-$month%' OR CALENDAR_END_TIME LIKE '$year-$month%' )";
		if(isset($CATEGORY2))
		{
			$sql = "select * from editora_".$ID_CARPETA." where STATUS=1 AND CATEGORY2=$CATEGORY2 AND (CALENDAR_START_TIME LIKE '$year-$month%' OR CALENDAR_END_TIME LIKE '$year-$month%' )";
		}
		$result = db_query($sql);		
		while($row = db_fetch_array($result))
		{
			
			ereg( "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $row['CALENDAR_START_TIME'], $regs );	
			$dia = $regs[3];
			$mes = $regs[2];
			$any = $regs[1];
			
			$link = $CONFIG_NOMCARPETA.'/'.folderPath($ID_CARPETA).'/index.php?day='.$dia.'&amp;month='.$mes.'&amp;year='.$any;
			if(isset($CATEGORY2))
			{
				$link .= '&amp;CATEGORY2='.$CATEGORY2;
			}
			
			// posem dates dels intervals
			$data_ini_timestamp = strtotime($row['CALENDAR_START_TIME']);
			$data_fi_timestamp = strtotime($row['CALENDAR_END_TIME']);
			while($data_ini_timestamp <= $data_fi_timestamp)
			{
				$dia = date('d',$data_ini_timestamp);
				$mes = date('m',$data_ini_timestamp);
				$any = date('Y',$data_ini_timestamp);
				if($mes == $month)
				{
					$link = $CONFIG_NOMCARPETA.'/'.folderPath($ID_CARPETA).'/index.php?day='.$dia.'&amp;month='.$mes.'&amp;year='.$any;
					if(isset($CATEGORY2))
					{
						$link .= '&amp;CATEGORY2='.$CATEGORY2;
					}
										
					$calendari->addEvent($dia, $link);	
				}
				$data_ini_timestamp = $data_ini_timestamp + (24 * 60 * 60);			
			}

		}
		
		/*
		 * 
		 * mostrem per pantalla el calendari
		 * 
		 */
		
		$calendar_month = $calendari->display();
		
		return $calendar_header.$calendar_month.$calendar_foot;
	}
	if(!isset($IDIOMA_CALENDARI))
	{
		$IDIOMA_CALENDARI = 'ca';
	}
	
	echo GetCalendari($IDIOMA_CALENDARI);		
?>

