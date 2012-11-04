<?php
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="PHP-Addressbook" />
	<meta name="Keywords" content="" />
	<link rel="icon" type="image/png" href="<?php echo $url_images; ?>icons/font.png" />
	<title>Translate</title>
</head>
<body>
*/

$lang = "en";
include("include/translations.inc.php");
// echo implode(", ", $trans->getSupportedLangs())."<br><br>";

//
// grep "msgid" from "*.pot" in translations, could be done nicer ...
//
$msgids = array
( "2ND_ADDRESS", "2ND_PHONE", "ADDRESS", "ADDRESS_BOOK", "ADD_NEW", "ADD_TO", "ALL", "ALL_EMAILS", "ALL_PHONES"
, "ANNIVERSARY", "APRIL", "APT", "AUGUST", "BIRTHDAY", "CITY", "COMPANY", "COUNTRY", "CREATED", "CREATE_ACCOUNT"
, "DECEMBER", "DELETE", "DELETE_GROUPS", "DEPT", "DETAILS", "DIR", "EDIT", "EDIT_ADD_ENTRY", "EDIT_GROUP"
, "EMAIL", "ENTER", "EXPORT", "EXPORT_CSV", "E_MAIL_HOME", "E_MAIL_OFFICE", "FAX", "FAX_SHORT", "FEBRUARY"
, "FIRSTNAME", "FIRST_LAST", "FOR", "FORGOT_PASSWORD", "GROUP", "GROUPS", "GROUP_FOOTER", "GROUP_HEADER"
, "GROUP_NAME", "GROUP_PARENT", "GRP_NAME", "GUESSED_HOMEPAGE", "HOME", "HOMEPAGE", "HOME_SHORT", "IMPORT"
, "INVALID", "JANUARY", "JULY", "JUNE", "LANGUAGE", "LASTNAME", "LAST_FIRST", "LOGIN", "LOGOUT", "MAIL_CLIENT"
, "MANAGE_GROUPS", "MAP", "MARCH", "MAY", "MEMBER_OF", "MIDDLENAME", "MISC", "MOBILE", "MOBILE_SHORT", "MODIFIED"
, "MODIFY", "MORE", "NAME_PREFIX", "NAME_SUFFIX", "NEW_GROUP", "NEXT", "NEXT_BIRTHDAYS", "NICKNAME", "NONE"
, "NOTES", "NOVEMBER", "NUMBER_OF_RESULTS", "OCCUPATION", "OCTOBER", "PAGER", "PASSWORD", "PHONE2_SHORT"
, "PHONE_HOME", "PHONE_MOBILE", "PHONE_WORK", "PHOTO", "POB", "PREFERENCES", "PRINT", "PRINT_ALL"
, "PRINT_PHONES", "REMOVE_FROM", "SEARCH", "SEARCH_FOR_ANY_TEXT", "SECONDARY", "SELECT_ALL", "SEND_EMAIL"
, "SEPTEMBER", "SIGN_IN_WITH", "STATE", "STREET", "TELEPHONE", "TITLE", "TITLES", "TRANSLATOR", "UPDATE"
, "UPDATED", "USER", "WORK", "WORK_SHORT", "ZIP", "ar", "auto", "bg", "ca", "cs", "da", "de", "el", "en"
, "es", "fa", "fi", "fr", "he", "hi", "hu", "it", "ja", "ko", "nl", "pl", "pt", "rm", "ru", "sl", "sr", "sv"
, "th", "tr", "ua", "vi", "zh"
);

// include "include/csv.class.php";

$supp_langs = $trans->getSupportedLangs();

//
// Print headers with all languages.
//
$values   = array();
$values[] = ".";
foreach($supp_langs as $lang) {
  $values[] = $lang;
}

$use_utf_16LE = function_exists('mb_convert_encoding');

function utf8_to_utf16le($line) {

  	global $use_utf_16LE;
  	
  	/*
  	// Remove whitespaces, Replace newlines and escape ["] character
  	$res = trim($value);
  	$res = str_replace("\r", "", $res);
  	$res = str_replace("\n", ", ", $res);
  	$res = str_replace('"', '""',  $res);
    */
  
  	// Add to result
  	if($use_utf_16LE) {  		
  	  $res = '"'.implode('"'."\t".'"', $line).'"'."\n";
      return mb_convert_encoding( $res, 'UTF-16LE', 'UTF-8');
      
    } else { // Fallback to ISO-8859-1
  	  $res = '"'.implode('"'.";".'"', $line).'"'."\r\n";
      return utf8_decode($res);
    }	

}

// Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
Header("Content-Type: application/vnd.ms-excel");
Header("Content-disposition: attachement; filename=translate.csv");
Header("Content-Transfer-Encoding: 8bit");  

// Magic-Word
if($use_utf_16LE)
  print chr(255).chr(254);



$values = array(".");
foreach($supp_langs as $lang) {
	$values[] = $lang;
}
echo utf8_to_utf16le($values);

//
// Print one msgid on each line
//
foreach($msgids as $msgid) {
	$values = array($msgid);
  foreach($supp_langs as $lang) {
  	$value = $trans->msg($msgid, $lang);
	  $values[] = ($value == $msgid ? "" : $value);
  }
  echo utf8_to_utf16le($values);
}

die;

//
// Result:
// - Generate final translation file
//
if(isset($_REQUEST['translation'])) { 

$trans_mode = ".php.inc";
// $trans_mode = ".pot";

if($trans_mode == ".php.inc") {
?>
&lt;?php<br />
//<br />
// New translations & fixes are welcome:<br />
// * chatelao(Ã¤t)users.sourceforge.net<br />
//<br />

$supported_langs[] = '<?php echo $_REQUEST['target_language']?>';<br />
<br />
<?php 
	if(isset($_REQUEST['target_flag']) && $_REQUEST['target_flag'] != "") {
?>		
	$use_flag['<?php echo $_REQUEST['target_language']?>'] = '<?php echo $_REQUEST['target_flag']?>';<br />
	<br /><?php
	} 
} elseif($trans_mode == ".pot") {
	echo "# Target language: ".$_REQUEST['target_language']."<br/><br/>";
}
  $i = 0;
  $translations = mb_split("\r\n", $_REQUEST['translation']);
	// foreach($messages as $key => $message) {
	// 	
	// 	echo "\$messages['".$key."']['".$_REQUEST['target_language']."'] = '".$translations[$i++]."';";
	// 	echo "    // ".$messages[$key]['en']."<br />";
  // 
	// }
	
  $source_language = $_GET['lang'];
  $target_language = $_GET['target_language'];

	foreach($messages as $key => $message) {
	
	  // It's a kind of magic ...
	  if(   $_GET['Mode'] == 'New'
	     || $_GET['Mode'] == 'All'
	     || !isset($messages[$key][$target_language] )
			 || $messages[$key][$target_language] == "" ) {
	  
	    $translation = trim($translations[$i++]);
	  } else {
	    $translation = $messages[$key][$target_language];
	  }
		
    if($trans_mode == ".php.inc") {
	 	  echo "\$messages['".$key."']['".$_REQUEST['target_language']."'] = ".'"'.$translation.'"'.";";
	 	  echo "    // ".$messages[$key]['en']."<br/>";
	 	} elseif($trans_mode == ".pot") {
	 		echo '# English: "'.$messages[$key]['en'].'"<br/>';
	 		echo 'msgid "'.$key.'"<br />';
	 		echo 'msgstr "'.$translation.'"<br/><br/>';
	 	}
	} 

if($trans_mode == ".php.inc") { ?>
?&gt;<br />
<?php	}

} elseif(isset($_GET['lang']) && isset($_GET['po'])) {

function extractLang($lang, $is_pot) {
	
	global $messages;
	
$str = '# SOME DESCRIPTIVE TITLE.
# Copyright (C) YEAR THE PACKAGE COPYRIGHT HOLDER
# This file is distributed under the same license as the PACKAGE package.
# FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.
#
#, fuzzy
msgid ""
msgstr ""
"Project-Id-Version: PACKAGE VERSION\n"
"Report-Msgid-Bugs-To: \n"
"POT-Creation-Date: 2012-10-25 14:49+0200\n"
"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\n"
"Last-Translator: FULL NAME <EMAIL@ADDRESS>\n"
"Language-Team: LANGUAGE <LL@li.org>\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=utf-8\n"
"Content-Transfer-Encoding: 8bit\n"
';  
  foreach($messages as $key => $message) {
    
    if(isset($message[$lang]) || $is_pot) {
      $str .= "#:\n";
      $str .= 'msgid "'.$key.'"'."\n";
      if(isset($_GET['pot'])) {
        $str .= '""'."\n";
      } else {
        $str .= 'msgstr "'.$message[$lang].'"'."\n";
      }
      $str .= "\n";
    }
  }
  return $str;
}

/* 
if(false){ 
/*/ 
if(true){
// */
  echo extractLang($_GET['lang'], $_GET['pot']);
} else {
  $trans = extractLang("en", true);
  file_put_contents ( "translations/php-addressbook.pot", $trans);
	foreach($supported_langs as $lang) {
    $trans = extractLang($lang, false);
		$res = file_put_contents ( "translations/".$lang.".po", $trans);
		echo "Wrote $lang: $res<br>";
	}
}

//
// Form:
// - Translatete texts
//
} elseif(isset($_GET['lang'])) { ?>
	
  <h1>Prepare translation file</h1>
  => you may use: <a href="http://translate.google.de">translate.google.de</a>
  or <a href="http://www.stars21.net/translator">www.stars21.net/translator</a>
  or <a href="http://www.microsoft.com/language">www.microsoft.com/language</a>
  <br /><br />

<form accept-charset="utf-8" method="post" action="#">

<label>Target language (e.g.: en):</label>
<input name="target_language" size="2" value="<?php echo $_GET['target_language']; ?>" /><br />
(see also: <a href="http://www.anglistikguide.de/info/tools/languagecode.html">languagecode.html</a>)<br /><br />

<label>Country flag for language (e.g.: uk):</label>
<input name="target_flag" size="2" value="<?php echo $use_flag[$_GET['target_language']]; ?>"/><br />
(see also: <a href="http://www.anglistikguide.de/info/tools/countrycode.html">countrycode.html</a>)<br /><br />

<input type="submit" value="2b. Send translation" /><br />
<textarea id="translation" name="translation" rows="<?php echo count($messages); ?>" cols="50">
<?php

  $source_language = $_GET['lang'];
  $target_language = $_GET['target_language'];

	foreach($messages as $key => $message) {
		
    // 
    // New: Show all messages in source language words
    //
		if($_GET['Mode'] == 'New') {
		  echo $message[$source_language]."\n";

		} else {

			if(  !isset($messages[$key][$target_language] )
			  || $messages[$key][$target_language] == "" ) 
			{
				// All/Range: Show missing word in source language
		  	echo $messages[$key][$source_language]."\n";
 		  } else { 
 		  	
 		  	// All: Show existing word in target language (for corrections)
			  if($_GET['Mode'] == 'All') {
		  	  echo $messages[$key][$target_language]."\n";
			  }
		  }
		}
	} 
	
?>	
</textarea>
<input type="submit" value="2. Send translation" /><br />
</form>
<?php 
// Form:
// - Source and target language
// - Target flag
// - Translation mode
} else { 	?>

<h1>Generate Name List</h1>
	<form method="get" action="#">

		<label>The source language:</label>
			<select name="lang">
				<option>en</option>
					<?php	
						foreach($supported_langs as $supported_lang) {
							echo "<option>".$supported_lang."</option>";
						}
					?>
			</select><br />

		<label>Target language (e.g.: en):</label>
		<input type="text" name="target_language" size="2" /><br />
		(see also: <a href="http://www.anglistikguide.de/info/tools/languagecode.html">languagecode.html</a>)<br /><br />

		<label>Affected words:</label><br /><br class="clear" />
		<input type="radio" name="Mode" value="Range" checked="checked" />Show all missing texts to translate<br />
		<input type="radio" name="Mode" value="All" />Show merged texts with missing words from source language<br />
		<input type="radio" name="Mode" value="New" />Use only the source language texts for a new translation<br />
		<input type="submit" value="1. List candidates" /><br />
	</form>
<?php } ?>
</body>
</html>