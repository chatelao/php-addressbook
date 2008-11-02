<?php

$default_lang   = 'en';

//
// New translations are welcome:
// * chatelao(@)users.sourceforge.net
//
// Find your missing flag here:
// * http://www.famfamfam.com/lab/icons/flags
//

// Register translated languages
include("translation.ar.php");
include("translation.bg.php");
include("translation.ca.php");
include("translation.cz.php");
include("translation.cn.php");
include("translation.de.php");
include("translation.el.php");
include("translation.en.php");
include("translation.es.php");
include("translation.fr.php");
include("translation.he.php");
include("translation.hi.php");
include("translation.it.php");
include("translation.jp.php");
include("translation.ko.php");
include("translation.nl.php");
include("translation.pl.php");
include("translation.pt.php");
include("translation.ru.php");
// include("translation.rm.php");
include("translation.se.php");
include("translation.th.php");
include("translation.vi.php");

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

  // Try to use the browser's wish
  $lang_variable = strtolower( $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
  $accepted_languages = split('[,:=-]', $lang_variable);
  
  foreach($accepted_languages as $curr_lang)
  {
    if( array_search($curr_lang, $supported_langs) !== FALSE ) {
    	$lang = $curr_lang;
      break;
    }
  }
}

//
// Choose "default" if no supported language chosen
//
if( array_search($lang, $supported_langs) === FALSE ) {
 	$lang = $default_lang;
}


//
// Return the country flag for a language
// - Default: langauge = country
// - Custom:  $use_flag['lang'] = 'country';
//
function get_flag($language) {
	
	global $use_flag;
	
	if(isset($use_flag[$language]))
	  return $use_flag[$language];
	else
	  return $language;
}

//
// Return if a language is writte from 
// right-to-left
// - Default: false
//
function is_right_to_left($language) {
	
	global $is_right_to_left;
	
	if(isset($is_right_to_left[$language]))
	  return $is_right_to_left[$language];
	else
	  return false;
}

function msg($value)
{
	global $lang, $messages;
		
	if(isset($messages[$value][$lang])) {
	  return $messages[$value][$lang];
	} else {
	  return $value;
	}
}

//
// Uppercase the first character with UTF-8 if possible,
// else try to use "ucfirst".
//
function ucfmsg($value) {
	
	$msg = msg($value);

  // Multibyte "ucfirst" function
  if( function_exists('mb_strtoupper') ) {
    mb_internal_encoding("UTF-8");
  	$msg = mb_strtoupper(mb_substr($msg, 0,1),"UTF-8").mb_substr($msg, 1);
  	
  } else { // Backward compatiblity
  	$msg = ucfirst($msg);
  }
	
	return $msg;
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

?>