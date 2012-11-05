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
<?php

include "include/translation.ua.php";
include "include/translation.no.php";

if(isset($_GET['lang'])) {

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
  echo extractLang($_GET['lang'], isset($_GET['pot']));
} else {
  $trans = extractLang("en", true);
  file_put_contents ( "translations/php-addressbook.pot", $trans);
	foreach($supported_langs as $lang) {
    $trans = extractLang($lang, false);
		$res = file_put_contents ( "translations/".$lang.".po", $trans);
		echo "Wrote $lang: $res<br>";
	}
}
}
?>