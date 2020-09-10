<?php
/* 
	This is phpSitemapNG, a php script that creates your personal google sitemap
	It can be downloaded under http://enarion.net/google/
	License: GPL
	
	Tobias Kluge, enarion.net
*/
/**
 * this class gets all messages from the application and
 * creates a html output as result of getContent()
 */
class LayoutEngine {
	var $content = array();
	var $buffering = true;
	var $static_title = "";
	
    function LayoutEngine($staticTitle) {
/*		$this->content[error] = array();
		$this->content[warning] = array();
		$this->content[info] = array();
		$this->content[success] = array();
		$this->content[text] = array();
    	$this->content[debug][] = array();
*/    	$this->content['content_header'] = "";
    	$this->content['content_footer'] = "";
    	$this->content['title'] = "";
    	$this->content['charset'] = "";
		$this->content['header'] = array();
    	$this->content['css'] = array();
    	$this->content['body'] = array();
    	$this->static_title = $staticTitle;
    }
    
    function addHeader($header) {
    	$this->content['header'][] = $header;
    }
    function switchOffBuffer() {
    	$this->buffering = false;
    }

    function addCss($msg) {
    	$this->content['css'][] = $msg;
    }
    
    function addContentHeader($msg) {
    	$tmp = '<div class="content_header">'.$msg.'</div>'. "\n";

    	if ($this->buffering) {
    		$this->content['content_header'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    }

    function addContentFooter($msg) {
    	$tmp = '<div class="content_footer">'.$msg.'</div>'. "\n";
    	if ($this->buffering) {
    		$this->content['content_footer'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    }

    function setTitle($msg) {
    	$this->content['title'] = $msg;
    }

    function setCharset($msg) {
    	$this->content['charset'] = $msg;
    }
   
    function addError($msg, $title="") {
    	if ($title != "") {
    		$tmp = '<h4 class="error">Error: '.$title.'</h4>'."\n".'<div class="error">'.$msg.'</div>'."\n";
    	} else {
    		$tmp = '<div class="error">Error: '.$msg.'</div>'."\n";
    	}
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    }

    function addWarning($msg, $title = "") {
    	if ($title != "") {
    		$tmp = '<h4 class="warning">Warning: '.$title.'</h4>'."\n".'<div class="warning">'.$msg.'</div>'."\n";
    	} else {
    		$tmp = '<div class="warning">Warning: '.$msg.'</div>'."\n";
    	}
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    }
    	
    function addInfo($msg, $title = "") {
    	if ($title != "") {
    		$tmp = '<h4 class="info">Info: '.$title.'</h4>'."\n".'<div class="info">'.$msg.'</div>'."\n";
    	} else {
    		$tmp = '<div class="info">Info: '.$msg.'</div>'."\n";
    	}
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    	
    }
    
    function addText($msg, $title = "", $css_class="") {
    	if ($css_class != "") $css_class = ' class="'.$css_class.'"';
    	if ($title != "") $title = '<h4'.$css_class.'>'.$title.'</h4>';
    	$tmp = $title.'<div'.$css_class.'>'.$msg.'</div>';
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    	
    }
        
    function addDebug($msg, $title = '') {
    	if ($title != "") {
    		$tmp = '<h4 class="debug">Debug: '.$title.'</h4>'."\n".'<div class="debug">'.$msg.'</div>'."\n";
    	} else {
    		$tmp = '<div class="debug">Debug: '.$msg.'</div>'."\n";
    	}
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}
    	
    }

    function addSuccess($msg, $title = '') {
    	if ($title != "") {
    		$tmp = '<h4 class="success">Successful: '.$title.'</h4>'."\n".'<div class="success">'.$msg.'</div>'."\n";
    	} else {
    		$tmp = '<div class="success">Successful: '.$msg.'</div>'."\n";
    	}
    	if ($this->buffering) {
    		$this->content['body'][] = $tmp;
    	} else {
    		print $tmp;
    	}    	
    }
    
    
    function getFooterLayout() {
    	if ($this->buffering) return '';
    	$res = '';
		if(($this->content['content_footer'] != "") && count($this->content['content_footer']) > 0) {		
	    	foreach ($this->content['content_footer'] as $id => $line) {
	    		$res .= '<div class="content_footer">'.$line.'</div>'. "\n";
	    	}
		}
		
      $res .= '</td>';
      $res .= '</tr>';
      $res .= '</table>';
      $res .= htmlFoot();;

    	$res .= "</body>";
    	$res .= "</html>";
    	return $res;
    }

    function getHeaderLayout() {
      
    	if ($this->buffering) return '';
    	$res = '<html><head>'."\n";
    	$res .= htmlMetas();
//    	$res .= '<title>'.$this->static_title .' ' . $this->content['title'].'</title>'."\n";
    	// header
    	if(($this->content['header'] != "") && count($this->content['header']) > 0) {
    		foreach ($this->content['header'] as $id => $head) {
    			$res .= $head . "\n";
    		}
    	}
    	// css
    	$res .= '<style type="text/css">'."\n".'<!--'."\n";
    	if(($this->content['css'] != "") && count($this->content['css']) > 0) {
	    	foreach ($this->content['css'] as $id => $line) {
    			$res .= $line . "\n";
    		}
    	}
    	$res .= '-->'."\n".'</style>'."\n";
		
		//end of head
		$res .= '</head><body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >'."\n";
		$res .= htmlHeader();
//		$res .= '<h1>'.$this->content['title'].'</h1>';
      $res .= '

<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>'.t('configtexttitle').'</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td valign="top" width="33"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"></td>
								<td class="text10">'.t('youarein').': <a href="../../index.php">'.t('home').'</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php">'.t('utils').'</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">'. t('configtexttitle').'</font></td>
							</tr>
						</table>

					</td>
					<td width="20%" class="vermell10b" align="right">

					</td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
	<tr>
		<td class="text" style="padding:5px;"  bgcolor="#FFFFFF">

';		
		if(($this->content['content_header'] != "") && count($this->content['content_header'])>0) {		
	    	foreach ($this->content['content_header'] as $id =>  $line) {
	    		$res .= $line . "\n";
	    	}
		}
    	return $res;
    }
    
    function getContent() {
    	if (! $this->buffering) {
	    	$res = '<html><head>'."\n";
			$res .= '<meta http-equiv="Content-Type" content="text/html; charset='.$this->content[charset].'">'."\n";
	    	$res .= '<title>'.$this->static_title .' ' . $this->content['title'].'</title>'."\n";
	    	// header
	    	if(($this->content['header'] != "") && count($this->content['header']) > 0) {
	    		foreach ($this->content['header'] as $id => $head) {
	    			$res .= $head . "\n";
	    		}
	    	}
	    	// css
	    	$res .= '<style type="text/css">'."\n".'<!--'."\n";
	    	if(($this->content['css'] != "") && count($this->content['css']) > 0) {
		    	foreach ($this->content['css'] as $id => $line) {
	    			$res .= $line . "\n";
	    		}
	    	}
	    	$res .= '-->'."\n".'</style>'."\n";
			
			//end of head
			$res .= '</head><body>'."\n";


			//$res .= '<h1>'.$this->content['title'].'</h1>';
			
			if(($this->content['content_header'] != "") && count($this->content['content_header'])>0) {		
		    	foreach ($this->content['content_header'] as $id => $line) {
		    		$res .= $line . "\n";
		    	}
			}
			
			if(($this->content['body'] != "") && count($this->content['body']) > 0) {		
		    	foreach ($this->content['body'] as $id => $line) {
		    		$res .= $line . "\n";
		    	}
			}
			
			if(($this->content['content_footer'] != "") && count($this->content['content_footer']) > 0) {		
		    	foreach ($this->content['content_footer'] as $id => $line) {
		    		$res .= '<div class="content_footer">'.$line.'</div>'. "\n";
		    	}
			}
	    	
      $res .= '</td>';
      $res .= '</tr>';
      $res .= '</table>';
      $res .= htmlFoot();;

    	$res .= "</body>";
    	$res .= "</html>";

    	} else {
    		$res = '';
    	}    	
    	return $res;
    }    
}
?>