<?php
class awBlock {
	function awBlock($name = '', $content = '', $char = '|', $unknowns = 'KEEP')
	{
		$this->Content = $content;
		$this->Name = $name;
		$this->Char = $char;
		$this->Unknowns = $unknowns;
		$this->Error = '';
		$this->Ok = true;
	}
	function setContent($content)
	{
		$this->Content = $content;
	}
	function setName($name)
	{
		$this->Name = $name;
	}
	function setChar($char)
	{
		$this->Char = $char;
	}
	function setUnknowns($unknowns)
	{
		$this->Unknowns = $unknowns;
	}
	function setErrorOk()
	{
		$this->Error = '';
		$this->Ok = true;
	}
	function setUniverseID($chars)
	{
		$this->UniverseID = $chars;
	}

	function merge($vars) {
		$char = $this->Char;
		$content = $this->Content;
		$universeID = $this->universeID;

		preg_match_all("/".str_replace('|', '\|',$char)."([".str_replace('-', '\-', $universeID)."]+?)".str_replace('|', '\|',$char)."/", $content, $values);
		$values = array_unique($values[1]);

		foreach($values as $id) {

			if (isset($vars[$id])) {
				$substitute = $vars[$id];
			} elseif (preg_match('#LANG\_([A-Z]+)#',$id,$reg)) {
				//// gestiona les traduccions de templates ////
				if (function_exists('t')) {
					$substitute = t(strtolower($reg[1]));
				}
			} else {				switch ($this->Unknowns) {
					case 'KEEP':$substitute = $char . $id . $char;
						break;
					case 'REMOVE':$substitute = '';
						break;					case 'COMMENT':$substitute = '<!-- ' . $char . $id . $char . '-->';
						break;
					case 'NBSP':$substitute = '&nbsp;';
						break;					default:$substitute = '<!-- ' . $char . $id . $char . '-->';
				}
			}

			$content = str_replace($char . $id . $char, $substitute, $content);
		}
		return $content;
	}


	function getVars()
	{
		$char = $this->Char;
		$content = $this->Content;
		$length = strlen($content);
		$vars = array();
		$i = 0;
		while ($i < $length) {
			$pos = strpos($content, $char, $i);
			if ($pos === false) {
				break;
			}
			$i = $pos + 1;
			$num = strspn(substr($content, $i), $this->universeID);
			if (substr($content, $i + $num, 1) == $char) {
				$vars[] = substr($content, $i, $num) . ' ';
				$i = $i + $num + 1;
			} else {
				$i = $i + $num;
			}
		}
		return($vars);
	}
	function debugEcho()
	{
		$out = "----------------------\n";
		$out .= $this->Name . ' (´' . $this->Char . '´, ' . $this->Unknowns . '): ';
		$vars = $this->getVars();
		foreach($vars as $var) {
			$out .= $var . ' ';
		}
		$out .= "\n----------------------\n";
		return($out);
	}
	var $Content;
	var $Name;
	var $Number;
	var $Char;
	var $Unknowns;
	var $Error;
	var $Ok;
	var $universeID = "ABCÇDEFGHIJKLMNÑOPQRSTUVWXYZabcçdefghijklmnñopqrstuvwxyz0123456789_-";
}

class awTemplate {
	function awTemplate($char = '|', $unknowns = 'REMOVE')
	{
		$this->Blocks = array();
		$this->NumBlocks = 0;
		$this->Char = $char;
		$this->Unknowns = $unknowns;
		$this->FileName = '';
		$this->Error = '';
		$this->Ok = true;
	}
	function setChar($char)
	{
		$this->Char = $char;
	}
	function setUnknowns($unknowns)
	{
		$this->Unknowns = $unknowns;
	}
	function scanFile($filename)
	{
		if (!$fp = fopen($filename, 'r')) {
			//return(null);
			$this->error('scanFile: Unable to open `$filename`');
			return;

		} else {
			$data = fread($fp, filesize($filename));
			fclose($fp);
			return $this->scanData($data);
		}
	}
	function scanData($data)
	{
		$lines = explode("\n", $data);
		$total = count($lines);
		$block_content = '';
		$block_name = 'HEAD';
		$block_number = $this->NumBlocks;
		$block_char = $this->Char;
		$block_unk = $this->Unknowns;
		for($i = 0;$i < $total;$i++) {
			$candidat = $lines[$i] . "\n";
			$pos = strpos($lines[$i], '!');
			if (!($pos === false)) {
				while ($candidat) {
					$fragments = $this->fragLine($candidat);
					if (!$fragments) {
						break;
					}
					$block_content .= $fragments['LEFT'];
					$candidat = $fragments['RIGHT'];
					switch ($fragments['BLOCKTYPE']) {
						case 'BEGIN':$this->NumBlocks++;
							$this->Blocks[$this->NumBlocks] = new awBlock($block_name, $block_content, $block_char, $block_unk);
							$block_content = '';
							$block_name = $fragments['BLOCKPARAM'];
							break;
						case 'END':$this->NumBlocks++;
							$this->Blocks[$this->NumBlocks] = new awBlock($block_name, $block_content, $block_char, $block_unk);
							$block_content = '';
							$block_name = 'UNK' . ($this->NumBlocks-1);
							break;
						case 'CHAR':$block_char = $fragments['BLOCKPARAM'];
							break;
						case 'UNK':$block_unk = $fragments['BLOCKPARAM'];
							break;
						default:$block_content .= '<!-- BLOCK_' . $fragments['BLOCKTYPE'] . '_' . $fragments['BLOCKPARAM'] . ' -->';
							break;
					}
				}
			}
			$block_content .= $candidat;
		}
		$this->NumBlocks++;
		if ($this->NumBlocks == 1) {
			$block_name = 'ALL';
		} else {
			$block_name = 'FOOT';
		}
		$this->Blocks[$this->NumBlocks] = new awBlock($block_name, $block_content, $block_char, $block_unk);
		return($this->Blocks);
	}
	function mergeBlock($name, $vars_hash)
	{
		$i = $this->getBlockNumber($name);
		if ($i == null) {
			return '';
		} else {
			return $this->Blocks[$i]->merge($vars_hash);
		}
	}
	function getBlockNumber($name)
	{
		$max = $this->NumBlocks;
		for($i = 1;$i <= $max;$i++) {
			$block = $this->Blocks[$i];
			$thisname = $block->Name;
			if ($thisname == $name) {
				return($i);
			}
		}
		return(null);
	}
	function getBlockName($number)
	{
		if (($number > 0) && ($number <= ($this->NumBlocks))) {
			return($this->Blocks[$number]->Name);
		} else {
			return null;
		}
	}
	function debugEcho($title = '?')
	{
		$out = "\n===============================================\n";
		$out .= $title . ": Template Structure \n";
		$out .= "===============================================\n";
		$max = $this->NumBlocks;
		for($i = 1;$i <= $max;$i++) {
			$thisblock = $this->Blocks[$i];
			$out .= $this->Blocks[$i]->debugEcho();
		}
		$out .= "===============================================\n";
		return($out);
	}
	function fragLine($dataline)
	{
		$fragments['ALL'] = $dataline;
		$l = strlen($dataline);
		$i = 0;
		$pos = strpos($dataline, '<!--');
		if ($pos === false) {
			return(null);
		}
		$i = $pos;
		$fragments['LEFT'] = substr($dataline, 0, $pos);
		$i += 4;
		while (substr($dataline, $i, 1) == ' ') {
			$i++;
		}
		if (strtoupper(substr($dataline, $i, 6)) != 'BLOCK_') {
			return(null);
		}
		$i += 6;
		$tmp = '';
		for(;$i < $l;$i++) {
			$c = strtoupper(substr($dataline, $i, 1));
			$pos = strpos('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $c);
			if ($pos === false) {
				break;
			}
			$tmp .= $c;
		}
		if ($i < $l) {
			$fragments['BLOCKTYPE'] = $tmp;
		} else {
			return(null);
		}
		if (strtoupper(substr($dataline, $i, 1)) != '_') {
			return(null);
		}
		$i += 1;
		$tmp = '';
		for(;$i < $l;$i++) {
			$c = strtoupper(substr($dataline, $i, 1));
			if ($c == ' ' || $c == '-') {
				break;
			}
			$tmp .= $c;
		}
		if ($i < $l) {
			$fragments['BLOCKPARAM'] = $tmp;
		} else {
			return(null);
		} while (substr($dataline, $i, 1) == ' ') {
			$i++;
		}
		if (strtoupper(substr($dataline, $i, 3)) != '-->') {
			return(null);
		}
		$i += 3;
		$fragments['RIGHT'] = substr($dataline, $i, $l - $i);
		$i += ($l - $i);
		return $fragments;
	}
	function fragLineOld($dataline)
	{
		if (preg_match("#^(.*)\<\!\-\-[ ]*BLOCK\_([a-zA-Z]+)\_([^ \f\r\t]*)[ ]*\-\-\>(.*)#", $dataline, $values)) {
			$fragments['ALL'] = $values[0];
			$fragments['LEFT'] = $values[1];
			$fragments['BLOCKTYPE'] = $values[2];
			$fragments['BLOCKPARAM'] = $values[3];
			$fragments['RIGHT'] = $values[4];
			return $fragments;
		} else {
			return(null);
		}
	}
	function error($msg)
	{
		$this->Ok = false;
		$this->Error = " awTemplate. $msg";
	}
	var $Blocks;
	var $NumBlocks;
	var $Char;
	var $Unknowns;
	var $FileName;
	var $Error;
	var $Ok;
	var $universeID = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-";
}
?>
