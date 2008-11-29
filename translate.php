<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
<?php

include("include/translations.inc.php");

//
// Result:
// - Generate final translation file
//
if(isset($_REQUEST['translation'])) { ?>

&lt;?php;<br>
//<br>
// New translations & fixes are welcome:<br>
// * chatelao(ät)users.sourceforge.net<br>
//<br>

$supported_langs[] = '<?php echo $_REQUEST['target_language']?>';<br>
<br>
<?php 
	if(isset($_REQUEST['target_flag']) && $_REQUEST['target_flag'] != "") {
?>		
	$use_flag['<?php echo $_REQUEST['target_language']?>'] = '<?php echo $_REQUEST['target_flag']?>';<br>
	<br><?php
	} 
  $i = 0;
  $translations = mb_split("\r\n", $_REQUEST['translation']);
	// foreach($messages as $key => $message) {
	// 	
	// 	echo "\$messages['".$key."']['".$_REQUEST['target_language']."'] = '".$translations[$i++]."';";
	// 	echo "    // ".$messages[$key]['en']."<br>";
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
	  
	    $translation = $translations[$i++];
	  } else {
	    $translation = $messages[$key][$target_language];
	  }
		
	 	echo "\$messages['".$key."']['".$_REQUEST['target_language']."'] = ".'"'.$translation.'"'.";";
	 	echo "    // ".$messages[$key]['en']."<br>";

	} 


?>
?&gt;<br>
<?php

//
// Form:
// - Translatete texts
//
} elseif(isset($_GET['lang'])) { ?>
	
  <h1>Prepare translation file</h1>
  => you may use: <a href="http://translate.google.de">translate.google.de</a>
  or <a href="http://www.stars21.net/translator">www.stars21.net/translator</a>
  <br><br>
<form accept-charset="utf-8" method=post>
<li>Target language (e.g.: en): <input name="target_language" size="2" value="<?php echo $_GET['target_language']; ?>"/>
(see also: <a href="http://www.anglistikguide.de/info/tools/languagecode.html">languagecode.html</a>)<br>
<li>Country flag for language (e.g.: uk): <input name="target_flag" size="2" value="<?php echo $use_flag[$_GET['target_language']]; ?>"/>
(see also: <a href="http://www.anglistikguide.de/info/tools/countrycode.html">countrycode.html</a>)<br>
<input type="submit" value="2. Send translation"><br>
<textarea name="translation" rows=<?php echo count($messages); ?> cols=50>
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
<input type="submit" value="2. Send translation"><br>
</form>
<?php 

//
// Form:
// - Source and target language
// - Target flag
// - Translation mode
//
} else { ?>

  <h1>Generate Name List</h1>
	<form method=get>
		<ul>
		<li>The source language: <select name="lang">
		<option>en</option>
<?php	
	foreach($supported_langs as $supported_lang) {
		echo "<option>".$supported_lang."</option>";
	} ?></select><br>

<li>Target language (e.g.: en): <input name="target_language" size="2"/>
(see also: <a href="http://www.anglistikguide.de/info/tools/languagecode.html">languagecode.html</a>)<br>

<li>Affected words:<br>
  <input type="radio" name="Mode" value="Range" checked=true>Show all missing texts to translate<br>
	<input type="radio" name="Mode" value="All">Show merged texts with missing words from source language<br>
	<input type="radio" name="Mode" value="New">Use only the source language texts for a new translation<br>
</ul>
  <input type="submit" value='1. List candidates'/><br>
  </form>
<?php	
}
?>