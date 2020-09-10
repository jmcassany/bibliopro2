<?php

include dirname(__FILE__).'/config.php';
include_once 'database/database.inc';

	$result = db_connect($db_url);

	function getSiteMap($nom_menu, $nivells =2){
		$sql = "SELECT ID FROM MENUS WHERE NOM='".$nom_menu."' ";
		$res = db_query($sql);
		$fila = db_fetch_array($res);

		$sql = "SELECT * FROM MENUITEMS WHERE MENU=".$fila['ID']." ORDER BY ORDRE ASC";
		$res = db_query($sql);
		$content="<ul class=\"nivell_1\">";
		while($fila = db_fetch_array($res) )
		{
			if($fila['FINESTRA'] ==1)
			{
				$desti =  ' rel="external"';
			}
			else
			{
				$desti ="";
			}

			if($nivells==1)
			{
				if($fila['LINKPAGE'] == ''){
					$content .= "\n<li>".stripslashes($fila['TEXT'])."</li>";
				}
				else{
					$content .= "\n<li><a href=\"".$fila['LINKPAGE']."\"  $desti >".stripslashes($fila['TEXT'])."</a></li>";
				}

			}
			else{
				$content_nivell2 ="";
					$sql = "SELECT * FROM MENUITEMSSUB WHERE MENUITEM=".$fila['ID']." ORDER BY ORDRE ASC";
					$res_sub = db_query($sql);
					while($fila_sub = db_fetch_array($res_sub) )
					{
						if($fila_sub['FINESTRA'] ==1)
						{
							$desti_sub = ' rel="external"';
						}
						else
						{
							$desti_sub ="";
						}

						if($fila_sub['LINKPAGE']==''){
							$content_nivell2 .= "\n<li>".stripslashes($fila_sub['TEXT'])."</li>";
						}
						else{
							$content_nivell2 .= "\n<li><a href=\"".$fila_sub['LINKPAGE']."\"  $desti_sub >".stripslashes($fila_sub['TEXT'])."</a></li>";
						}
					}
				if(	$content_nivell2 != "" )
				{
					$content_nivell2 = "\n<ul class=\"nivell_2\">".$content_nivell2."</ul>";
					if( $nivells > 2 )
					{
					}
					else{
//						$content_nivell2 = "\n<ul class=\"nivell_2\">".$content_nivell2."</ul>";
						if($fila['LINKPAGE'] ==''){
							$content .= "\n<li>".stripslashes($fila['TEXT']).$content_nivell2."</li>";
						}
						else{
							$content .= "\n<li><a href=\"".$fila['LINKPAGE']."\"  $desti >".stripslashes($fila['TEXT'])."</a>".$content_nivell2."</li>";
						}
					}
				}
				else{
					if($fila['LINKPAGE'] ==''){
						$content .= "\n<li>".stripslashes($fila['TEXT'])."</li>";
					}
					else{
						$content .= "\n<li><a href=\"".$fila['LINKPAGE']."\"  $desti >".stripslashes($fila['TEXT'])."</a></li>";
					}

				}
			}
		}
		$content .= "</ul>";
		$content = str_replace("&","&amp;",$content);
		return $content;
	}

?>
