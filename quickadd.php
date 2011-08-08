<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");

   ?><title>Address book <?php echo ($group_name != "" ? "($group_name)":""); ?></title><?php
   include ("include/header.inc.php");

if(!$add) {
?>
	<form accept-charset="utf-8" method="post" action="quickadd<?php echo $page_ext; ?>">

		<label><?php echo ucfmsg("ADDRESS") ?>:</label>
		<textarea name="address" rows="20">
<?php
include "test/test_address_parse.php";
echo utf8_encode($address_parse[4]);
?>
</textarea><br />
  	<input type="submit" name="add" value="<?php echo ucfmsg('ADD') ?>" />
  </form>
<?php
} else {
	
  //
  // Preprocess:
  // * Revert "mysql_real_escape"
  // * Split into block (newline, pipe, colon)
  // * Remove whitespaces & empty lines
  //  
	$address = stripslashes($address);
	$addr_list = split("[\n*|,]", $address);
	for($i = 0; $i < count($addr_list); $i++) {
		$addr_line = $addr_list[$i];
		$addr_line = trim($addr_line);
		if($addr_line != "" && $addr_line != null) {
		  $new_addr_list[] = $addr_line;
	  }
	}
	$addr_list = $new_addr_list;

	echo "<h1>Schritt 4: Detect</h1>";	
	$is_phone = false;
	$is_url   = false;
	
	$phones  = array();
	$mails   = array();
	$company = "";
	
	for($i = 0; $i < count($addr_list); $i++) {
		
		$addr_line = $addr_list[$i];

    //
    // Firmen
    // * Eng: Ltd, Plc
    // * Deu: AG, GmbH
    // * Frz: SA, SaRL
    //
	  if(preg_match("/ (LTD|PLC|AG|GMBH|SA|SARL)/", strtoupper($addr_line), $matches) > 0) {
	  	$company = $addr_line;
	  }

    //
    // Mailadressen
    //
	  if(preg_match("/([A-Za-z-_.])*\@([A-Za-z.-_])*\.([A-Za-z]){2,3}/", $addr_line, $matches) > 0) {
	  	$mails[] = $matches[0];
	  }

    // Webseiten:
    // * http://
    // * https://
    // * www.
    //
  	if(preg_match("/(http(s)?:\/\/|www.)([A-Za-z.-_])*\.([A-Za-z]){2,3}/", $addr_line, $matches) > 0) {
  		echo nl2br($matches[0]."\n");
  	}

    //
    // Telefonnummern
    //
	  if(preg_match("/(\+)?([0-9\(\)])+([0-9\(\) -\/'])*/", $addr_line, $matches) > 0) {
	  	$phone_number = $matches[0];

	  	$phone_type = "";

	  	// Telefon, Fon, Privat(e), Home
	    if(preg_match("/^(T|F|P|H)/", strtoupper($addr_line), $matches) > 0) {
	  	  $phone_type = "HOME";
	    }
	  	
	  	// Mobil(e), Natel, Cell
	    if(preg_match("/^(M|N|C)/", strtoupper($addr_line), $matches) > 0) {
	  	  $phone_type = "CELL";
	    }
	  	
	  	// Geschäft, Business
	    if(preg_match("/^(G|B)/", strtoupper($addr_line), $matches) > 0) {
	  	  $phone_type = "WORK";
	    }
	  	
	  	// Fax, Facsmile
	    if(preg_match("/^(F)/", strtoupper($addr_line), $matches) > 0) {
	  	  $phone_type = "FAX";
	    }
	  	
	  	if(strlen($phone_number) > 6) {
	  	  $phones[$phone_type][] = $phone_number;
	  	}
	  }
	}
	echo nl2br(print_r($phones, true));
	

	// Namen Vornamen   Erste Line
	// Firma            Zweite Line
	// Weg/Strasse +Nr  Dritte Line
	// Ort / PLZ        Vierte Line
	                    
	// e-Mail:          (Mailto:|Mail)xxx@yyy.zz
	// Webseite:        www.xxxx oder http://
	// Telefon Privat   (P|Fon|Phone|Privat|Home) +xx(0)yyyy
	// Telefon Geschäft (G|Geschäft|Office) +xx(0)yyyy
	// Telefon Mobil    (C|Cell|M|Mobil|Mobile|Natel) +xx(0)yyyy
	// Fax              (F|Fax|Telefax) +xx(0)yyyy
	
	//*/

	echo "<h1>Schritt 5: Republish</h1>";
	?>
<form>
	<form accept-charset="utf-8" method="post" action="quickadd<?php echo $page_ext; ?>">

		<label><?php echo ucfmsg("ADDRESS") ?>:</label>
		<textarea name="address" rows="20">
<?php echo implode("\n", $addr_list); ?>
  </textarea><br />
 	<input type="submit" name="add" value="<?php echo ucfmsg('ADD') ?>" />
</form>	
<?php  
}

include ("include/footer.inc.php"); ?>