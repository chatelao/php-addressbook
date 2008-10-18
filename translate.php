<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
<?php

include("include/translations.inc.php");

//
// Generate final translation file
//
if(isset($_POST['translation'])) { ?>

&lt;?php;<br>
//<br>
// New translations & fixes are welcome:<br>
// * chatelao(ät)users.sourceforge.net<br>
//<br>

$supported_langs[] = '<?php echo $_POST['target_language']?>';<br>
<br>
<?php 
	if(isset($_POST['target_flag']) && $_POST['target_flag'] != "") {
	$use_flag['<?php echo $_POST['target_language']?>'] = '<?php echo $_POST['target_flag']?>';<br>
	<br><?php
	} 
  $i = 0;
  $translations = mb_split("\r\n", $_POST['translation']);
	foreach($messages as $key => $message) {
		
		echo "\$messages['".$key."']['".$_POST['target_language']."'] = '".$translations[$i++]."';";
		echo "    // ".$messages[$key]['en']."<br>";

	}
?>
?&gt;<br>
<?php

//
// Prepare source language
//
} elseif(isset($_GET['lang'])) { ?>
	
  <h1>Prepare translation file</h1>
  => you may use: <a href="http://translate.google.de">translate.google.de</a>
  <br><br>
<form accept-charset="utf-8" method=post>
<input type="submit" value='2. Generate "translation.<?php echo $_GET['lang']; ?>.php"'/><br>
Target language (e.g.: en): <input name="target_language" size="2"/>
(see also: <a href="http://www.anglistikguide.de/info/tools/languagecode.html">languagecode.html</a>)<br>
Country flag for language (e.g.: uk): <input name="target_flag" size="2"/>
(see also: <a href="http://www.anglistikguide.de/info/tools/countrycode.html">countrycode.html</a>)<br>
<textarea name="translation" rows=<?php echo count($messages); ?> cols=50>
<?php
	foreach($messages as $message) {		
		echo $message[$_GET['lang']]."\n";
	} ?>	
</textarea>
</form>
<?php 

//
// Select source language
//
} else { ?>

  <h1>Generate Name List</h1>
	<form method=get>
		The source language: <select name="lang">
		<option>en</option>
<?php	
	foreach($supported_langs as $supported_lang) {
		echo "<option>".$supported_lang."</option>";
	} ?></select><br>
	<input type="submit" value="1. Get foreign base">
  </form>
<?php	
}
?>