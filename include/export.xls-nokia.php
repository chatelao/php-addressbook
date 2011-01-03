<?php

  //
  // Excel export module
  // - Support ".csv" with Unicode-Characters.
  //
  // The working encoding concept was found on:
  // - http://forum.de.selfhtml.org/archiv/2007/6/t154117/
  //

  // Check if we can produce the Unicode-Excel.
  $use_utf_16LE = function_exists('mb_convert_encoding');

  function add($value, $first = false) {
  	
  	global $use_utf_16LE;
  	
  	// Remove whitespaces, Replace newlines and escape ["] character
  	$res = trim($value);
  	$res = str_replace("\r\n", ", ", $res);
  	$res = str_replace('"', '""',  $res);
  
  	// Add to result
  	if($use_utf_16LE) {  		
  	  $res = ($first ? "" : "," ) . '"'.$res.'"';
      print mb_convert_encoding( $res, 'UTF-16LE', 'UTF-8');
      
    } else { // Fallback to ISO-8859-1
      $res = ($first ? "" : ";" ) . '"'.$res.'"';
      print utf8_decode($res);
    }
  
  }
	
	$sql = "SELECT $table.*, $month_lookup.bmonth_num FROM $month_from_where ORDER BY lastname, firstname ASC";

	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);	

  // Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
  Header("Content-Type: application/vnd.ms-excel");
  Header("Content-disposition: attachement; filename=export-".date("Ymd").($group_name != "" ? "-".$group_name : "").".csv");
  Header("Content-Transfer-Encoding: 8bit");  

  // Add Byte-Order-Mark (BOM)
  if($use_utf_16LE)
 	  print chr(255).chr(254);

$headers = array( 0 => "Name"
                , 1 => "Vorname"
                , 2 => "Weitere Vornamen"
                , 3 => "Nachname"
                , 4 => "Namenszusatz"
                , 5 => "Position"
                , 6 => "Firma"
                , 7 => "Geburtstag"
                , 8 => "SIP-Adresse"
                , 9 => "Push-to-talk"
                , 10 => "Gemeinsame Ansicht"
                , 11 => "Benutzer-ID"
                , 12 => "Notizen"
                , 13 => "Mobiltelefon, allgemein"
                , 14 => "Telefon, allgemein"
                , 15 => "E-Mail, allgemein"
                , 16 => "Fax, allgemein"
                , 17 => "Videoanruf, allgemein"
                , 18 => "Webadresse, allgemein"
                , 19 => "VoIP-Adresse, allgemein"
                , 20 => "Postfach, allgemein"
                , 21 => "Durchwahl, allgemein"
                , 22 => "Straße, allgemein"
                , 23 => "Postleitzahl, allgemein"
                , 24 => "Stadt, allgemein"
                , 25 => "Bundesland, allgemein"
                , 26 => "Land/Region, allgemein"
                , 27 => "Mobiltelefon, privat"
                , 28 => "Telefon, privat"
                , 29 => "E-Mail, privat"
                , 30 => "Fax, privat"
                , 31 => "Videoanruf, privat"
                , 32 => "Webadresse, privat"
                , 33 => "VoIP-Adresse, privat"
                , 34 => "Postfach, privat"
                , 35 => "Durchwahl, privat"
                , 36 => "Straße, privat"
                , 37 => "Postleitzahl, privat"
                , 38 => "Stadt, privat"
                , 39 => "Bundesland, privat"
                , 40 => "Land/Region, privat"
                , 41 => "Mobiltelefon, geschäftlich"
                , 42 => "Telefon, geschäftlich"
                , 43 => "E-Mail, geschäftlich"
                , 44 => "Fax, geschäftlich"
                , 45 => "Videoanruf, geschäftlich"
                , 46 => "Webadresse, geschäftlich"
                , 47 => "VoIP-Adresse, geschäftlich"
                , 48 => "Postfach, geschäftlich"
                , 49 => "Durchwahl, geschäftlich"
                , 50 => "Straße, geschäftlich"
                , 51 => "Postleitzahl, geschäftlich"
                , 52 => "Stadt, geschäftlich"
                , 53 => "Bundesland, geschäftlich"
                , 54 => "Land/Region, geschäftlich" );

  add(ucfmsg($headers[0]), true);
	for($i = 1; $i < count($headers); $i++) {
	  add(ucfmsg(utf8_encode($headers[$i])));
	}
	
  if($use_utf_16LE)
  	print mb_convert_encoding( "\r\n", 'UTF-16LE', 'UTF-8');
  else
	  echo "\r\n";

	while ($myrow = mysql_fetch_array($result))
	{
		$rec = array();

		# Name + Geburtstag
		 // $rec[3] = $myrow["lastname"]." ".$myrow["firstname"];
		$rec[3] = $myrow["lastname"];
		$rec[1] = $myrow["firstname"];

		# Telefonnummern
		$rec[13] = $myrow["home"];
		$rec[14] = $myrow["mobile"];
		$rec[28] = $myrow["email"];
		
    add(ucfmsg(""), true);
  	for($i = 1; $i < count($headers); $i++) {
  	  add(isset($rec[$i]) ? $rec[$i] : "");
  	}

    if($use_utf_16LE)
    	print mb_convert_encoding( "\r\n", 'UTF-16LE', 'UTF-8');
    else
      echo "\r\n";
	}

?>