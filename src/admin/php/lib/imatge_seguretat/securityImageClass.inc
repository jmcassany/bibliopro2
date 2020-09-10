<?php
#################################
#
# Author: Joel Finkel
# Email: finkel@sd-il.com
#
# Credits:
#	Concept by vImage by Rafael Machado Dohms (dooms@terra.com.br)
#
#	Coding example from HumanCheck 2.1 by Yuriy Horobey (yuriy@horobey.com)
#
#	The function, simpleRandString, is by demogracia@metropoliglobal.com and posted
#	to www.php.net
#
#################################


class securityImage {

var $inputParam = "";			// Public; $x->inputParam = "style='color:blue'"
var $name 	= "security";		// Public; $x->name = "mySecurityInputField"

var $codeLength = 5;			// Private; use setCodeLength()
var $fontSize	= 5;			// Private; use setFontSize()
var $fontColor  = "000000";		// Private; use setFontColor()
var $imageFile  = "securityImg.png";	// Private; use setImageFile()  MUST BE PNG FILE!

var $securityCode = "";			// Private

function securityImage() {

//	session_start();
	/*
	 * Save this so it is available in the next instantiation; required for isValid().
	*/
	if (isset($_SESSION['securityImage']['securityCode'])) {
		$this->userSecurityCode = $_SESSION['securityImage']['securityCode'];
	} else {
		$this->userSecurityCode = "";
	}

	/*
	 * Save the items required by the instance created by securityImageImage.php
	*/
	if (isset($_SESSION['securityImage']['codeLength'])) {
		$this->codeLength = $_SESSION['securityImage']['codeLength'];
	} 

	if (isset($_SESSION['securityImage']['fontSize'])) {
		$this->fontSize = $_SESSION['securityImage']['fontSize'];
	}

	if (isset($_SESSION['securityImage']['fontColor'])) {
		$this->fontColor = $_SESSION['securityImage']['fontColor'];
	}

	if (isset($_SESSION['securityImage']['imageFile'])) {
		$this->imageFile = $_SESSION['securityImage']['imageFile'];
	}
}

function simpleRandString($length=16, $list="123456789ABCDEFGHIJKLMNPQRSTUVWXYZ") {
	/*
	 * Generates a random string with the specified length
	 * Chars are chosen from the provided [optional] list
	*/
	mt_srand((double)microtime()*1000000);

	$newstring = "";

	if ($length > 0) {
		while (strlen($newstring) < $length) {
			$newstring .= $list[mt_rand(0, strlen($list)-1)];
		}
	}
	return $newstring;
}

/*
 * Not to be called directly.  Called by securityImageImage.php.
*/
function showImage() {
	header("Content-type: image/pang");
	$this->generateImage();
	imagepng($this->img);
	imageDestroy($this->img); 
}

/*
 * Private
*/
function generateImage() {
	$this->securityCode = $this->simpleRandString($this->codeLength);

	$_SESSION['securityImage']['securityCode'] = $this->securityCode;

	$img_path = dirname(__FILE__)."/$this->imageFile";

	$this->img = ImageCreateFrompng($img_path);

	$img_size = getimagesize($img_path);

	$color = imagecolorallocate($this->img,
			hexdec(substr($this->fontColor, 1, 2)),
			hexdec(substr($this->fontColor, 3, 2)), 
			hexdec(substr($this->fontColor, 5, 2))
			);

	$fw = imagefontwidth($this->fontSize);
	$fh = imagefontheight($this->fontSize);

	// create a new string with a blank space between each letter so it looks better
	$newstr = "";
	for ($i = 0; $i < strlen($this->securityCode); $i++) {
		$newstr .= $this->securityCode[$i] ." ";
	}
	
	// remove the trailing blank
	$newstr = trim($newstr);

	// center the string 
	$x = ($img_size[0] - strlen($newstr) * $fw ) / 2;

	// output each character at a random height and standard horizontal spacing
	for ($i = 0; $i < strlen($newstr); $i++) {
		//$hz = mt_rand( 10, $img_size[1] - $fh - 5);
		$hz = 3;
		imagechar( $this->img, $this->fontSize, $x + ($fw*$i), $hz, $newstr[$i], $color);
	}
}

/*
 * PUBLIC FUNCTIONS
*/
function showFormInput() {
	return "<input $this->inputParam TYPE=text NAME=$this->name MAXLENGTH=$this->codeLength></input>";
}

function showFormImage() {
	return "<img src=\"securityImageImage.php\">";
}

function isValid() {

	return strtolower ($_POST["$this->name"]) == strtolower ($this->userSecurityCode);
}	

function setCodeLength($p) {

	$this->codeLength = $p;
	$_SESSION['securityImage']['codeLength'] = $this->codeLength;
}

function setFontSize($p) {

	$this->fontSize = $p;
	$_SESSION['securityImage']['fontSize'] = $this->fontSize;
}

function setFontColor($p) {

	$this->fontColor = $p;
	$_SESSION['securityImage']['fontColor'] = $this->fontColor;
}

function setImageFile($p) {

	$this->imageFile = $p;
	$_SESSION['securityImage']['imageFile'] = $this->imageFile;
}

} 
?>
