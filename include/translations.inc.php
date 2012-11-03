<?php
//
// New translations are welcome:
// * chatelao(@)users.sourceforge.net
//

//
// Find your missing flag here:
// * http://www.famfamfam.com/lab/icons/flags
//

require_once("translator.class.php");
$trans = new GetTextTranslator();

$trans->setDefaultLang('en');

$default_lang    = $trans->getDefaultLang();
// Register translated languages
$supported_langs = $trans->getSupportedLangs();
$right_to_left_languages = array('ar', 'fa', 'he');

//
// Handle language choice
//
$choose_lang = false;
if($lang == 'choose') {
  $choose_lang = true;
  $lang = 'auto';
}

if($choose_lang && getPref('lang') != NULL ) {
	$lang = getPref('lang');
}
  
if(!isset($lang)) {
   $lang == 'auto';
}

//
// Auto-Detect best possible language
//
if($lang == 'auto') {

  if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lang = $trans->getBestAcceptLang($_SERVER['HTTP_ACCEPT_LANGUAGE']);
  	$trans->setDefaultLang($lang);
  } else {
  	$lang = $trans->getDefaultLang();
  }
}
/*
function get_flag($language) {
	
	global $use_flag;
	
	if(isset($use_flag[$language]))
	  return $use_flag[$language];
	else
	  return $language;
}
*/

//
// Return if a language is writte from 
// right-to-left
// - Default: false
//
function is_right_to_left($language) {
	global $trans;	
	return $trans->isRTL($language);
}

function msg($value) {
	global $trans;
  return $trans->msg($value);
}

function ucfmsg($value) {
	global $trans;
  return $trans->ucfmsg($value);
}

//
// Try the best to convert UTF-8 to latin1.
//
function utf8_to_latin1($text) {
	
  if(function_exists('iconv')) {
       setlocale(LC_CTYPE, 'cs_CZ');
       return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
     
  } else {
  	  return utf8_decode($text);
	  }
}

function translateTags($text) {
	
	global $messages;
	
	foreach($messages as $key => $translations) {
		$text = str_replace("%".$key."%", msg($key), $text);
	}
	return $text;
}

?>