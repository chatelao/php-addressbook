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
include("include/translations.inc.php");
$supported_langs = array("ar","bg","ca","cs","da"
                        ,"de","el","en","es","fa"
                        ,"fi","fr","he","hi","hu"
                        ,"it","ja","ko","nl","no"
                        ,"pl","pt","ru","sr"
                        ,"sv","sl","th","tr","vi","zh");

foreach($supported_langs as $lang) {
 include_once("include/translation.".$lang.".php");
}

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