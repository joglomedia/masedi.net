<?Php
if (eregi("functions.php",$_SERVER['PHP_SELF'])) {
	die("<h4>You don't have right permission to access this file directly.</h4>");
}

/** GET XML ELEMENT
@original file name shared.php
(c) flatnuke.org
**/
@include 'php-sanitize.php';

function fnsanitize($string) {

	$string = str_replace(chr(10), "", $string);
	$string = str_replace(chr(13), "", $string);
	$string = str_replace(chr(00), "", $string);
	$string = str_replace("%00", "", $string);
	$string = str_replace("[", "&#91;", $string);
	$string = str_replace("]", "&#93;", $string);

	return $string;
}

function getparam($param, $opt, $sanitize) {

	if(!isset($sanitize) OR ($sanitize==SAN_FLAT))
		$sanitize="fnsanitize";
	else if($sanitize==SAN_SYST)
		$sanitize="sanitize_system_string";
	else if($sanitize==SAN_PARA)
		$sanitize="sanitize_paranoid_string";
	else if($sanitize==SAN_NULL)
		$sanitize="sanitize_null_string";
	else if($sanitize==SAN_HTML)
		$sanitize="sanitize_html_string";

	//cut till there
	if($opt==PAR_NULL) {
		if(isset($param))
			return($sanitize($param));
		else
			return("");
	}

	return("");
}
/*
function get_xml_element($elem, $xml) {
	$elem = getparam($elem,PAR_NULL, SAN_FLAT);
	$xml  = getparam($xml, PAR_NULL, SAN_NULL);
	// se l'elemento non esiste restituisco una stringa vuota
	if (!eregi("<$elem>.*</$elem>", $xml)) {
		return "";
	}
	$buff = ereg_replace(".*<".$elem.">", "", $xml);
	$buff = ereg_replace("</".$elem.">.*", "", $buff);
	return $buff;
}
*/

function get_xml_element($elem, $attr="", $xml) {
	$elem = getparam($elem, PAR_NULL, SAN_FLAT);
	$xml  = getparam($xml, PAR_NULL, SAN_NULL);
	// se l'elemento non esiste restituisco una stringa vuota
	if(!empty($attr)){
		if (!eregi("<$elem $attr>.*</$elem>", $xml)) {
			return "";
		}else{
			$buff = ereg_replace(".*<".$elem." ".$attr.">", "", $xml);
			$buff = ereg_replace("</".$elem.">.*", "", $buff);
			return $buff;
		}
	}else{
		if (!eregi("<$elem.*>.*</$elem>", $xml)) {
			return "";
		}else{
			$buff = ereg_replace(".*<".$elem.">", "", $xml);
			$buff = ereg_replace("</".$elem.">.*", "", $buff);
			return $buff;
		}
	}
}


function get_xml_array($elem, $xml) {
	$elem = getparam($elem,PAR_NULL, SAN_FLAT);
	$xml  = getparam($xml, PAR_NULL, SAN_NULL);
	$buff = explode("</".$elem.">", $xml);
	array_splice ($buff, count($buff)-1);
	$buffelement = "";
	$newbuff = array();
	foreach($buff as $buffelement){
		$newbuff[] = eregi_replace("^\<$elem\>","",ltrim($buffelement));
	}
	//return $buff;
	return $newbuff;
}

/*
function get_xml_array($elem, $xml) {
	$elem = getparam($elem, PAR_NULL, SAN_FLAT);
	$xml  = getparam($xml, PAR_NULL, SAN_NULL);
	$buff = explode("</$elem>", $xml);
	// cleansing the 1st xml element 
	//$buff0 = explode("<$elem>", $buff[0]);
	//$buff0 = array_slice($buff0, 1);
	// replace cleansed 1st xml element to array 
	//array_splice ($buff, 0, 1, $buff0);
	// remove last exploded array value, cause it's not a xml element
	array_splice ($buff, count($buff)-1);
	$buffelement = "";
	$newbuff = array();
	foreach($buff as $buffelement){
		$newbuff[] = eregi_replace("^\<$elem\>","",ltrim($buffelement));
	}
	return $newbuff;
}
*/
//ENDOF GET XML ELEMENT

function get_xml_array2($elem, $attr="", $xml) {
	$elem = getparam($elem, PAR_NULL, SAN_FLAT);
	$xml  = getparam($xml, PAR_NULL, SAN_NULL);
	$buff = explode("</".$elem.">", $xml);
	array_splice ($buff, count($buff)-1);
	$buffelement = "";
	$newbuff = array();
	foreach($buff as $buffelement){
		if(!empty($attr)){
			$newbuff[] = eregi_replace("^\<".$elem." ".$attr."\>","",ltrim($buffelement));
		}else{
			$newbuff[] = eregi_replace("^\<$elem\>","",ltrim($buffelement));
		}
	}
	//return $buff;
	return $newbuff;
}

/**
(c) echiex@gmail.com
**/

//comparing searched string ($needle) in a sequence strings	($haystack)

function isResponse($elem, $str, $respon){
	$yes = false;
	$strings = get_xml_array($elem, $respon);
	foreach($strings as $num=>$string){
		if(!empty($str)){
			if(stristr($string, $str)){
				$yes = true;
				break;
			}
		}
	}
	return $yes;
}

	
//get some string from strings
function getString($str1,$str2,$str){
	$x1=strpos($str,$str1);
		if($x1){
			$x2=strpos($str,$str2 , $x1+1);
			$getbet=substr($str,$x1+strlen($str1),$x2-$x1-strlen($str1));
		}else{
			$getbet="";
		}
	return $getbet;
}

// validate email
function is_validemail($emailaddr) {
	if(preg_match("/^[\w.-]+\@[\w.-]+$/", $emailaddr))
		return true;
	else return false;
}

// READING TEXT FILE
function getFileContent($file, $mode='r', $type='ARRAY') {
	$fp = @fopen($file, $mode);
	$fsize = @filesize($file);
	if($fp){
		switch($type) {
			case 'ARRAY':
			$contents = array();
			while(@!feof($fp)){
				$contents[] .= @fgets($fp, $fsize);
			}
			break;
			
			case 'STRING':
			$contents = @fread($fp, $fsize);
			break;
			
		}
	}
	@fclose($fp);
	//return $contents
	return $contents;
}

// WRITING TEXT FILE
function writeToFile($file, $mode="a", $text) {
	if(!is_writeable($file)) {
		chmod($file, 0777);
	}
	$fp = @fopen($file, $mode);
	$fsize = @filesize($file);
	if($fp){
		@fwrite($fp, "$text \n");
	}
	@fclose($fp);
}

// READING DIRECTORY
function getDirContent($dir) {
	$contents = array();
	if(is_dir($dir)) {
		if ($dh = @opendir($dir)) {
			while (($file = @readdir($dh)) !== false ) {
				if(!strstr("..", $file)){
					$contents[] .= $file;
				}
			}
			@closedir($dh);
		}
	}
	//return $contents as array
	return $contents;
}

function serverPath($opt="PS") {
	if(strstr(PHP_OS, 'WINNT')){
		$ps='\\';
		$docroot=str_replace('/', '\\', $_SERVER["DOCUMENT_ROOT"]);
	}else{
		$ps='/';
		$docroot=$_SERVER["DOCUMENT_ROOT"];
	}
	
	switch($opt) {
		case "PS":
			return $ps;
		break;
		
		case "DR":
			return $docrrot;
		break;
	}
}

?>