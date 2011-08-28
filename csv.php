<?php

  //
  // Excel export module
  // - Support ".csv" with Unicode-Characters.
  //
  // The working encoding concept was found on:
  // - http://forum.de.selfhtml.org/archiv/2007/6/t154117/
  //

  include ("include/dbconnect.php");

  // Check if we can produce the Unicode-Excel.
  $use_utf_16LE = function_exists('mb_convert_encoding');

  function add($value, $first = false) {
  	
  	global $use_utf_16LE;
  	
  	// Remove whitespaces, Replace newlines and escape ["] character
  	$res = trim($value);
  	$res = str_replace("\r", "", $res);
  	$res = str_replace("\n", ", ", $res);
  	$res = str_replace('"', '""',  $res);
  
  	// Add to result
  	if($use_utf_16LE) {  		
  	  $res = ($first ? "" : "\t" ) . '"'.$res.'"';
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

  if($use_utf_16LE)
 	  print chr(255).chr(254);

	# Name + Geburtstag
	add(ucfmsg("LASTNAME"), true);
	add(ucfmsg("FIRSTNAME"));
	add(ucfmsg("BIRTHDAY"));

	# Home contact
	add(ucfmsg("ADDRESS"));
	if($zip_pattern != "")
	{
		add(ucfmsg("ZIP"));
		add(ucfmsg("CITY"));
	}
        
	add(ucfmsg("PHONE_HOME"));
	add(ucfmsg("PHONE_MOBILE"));
	add(ucfmsg("E_MAIL_HOME"));

	# Work contact
	add(ucfmsg("PHONE_WORK"));
	add(ucfmsg("FAX"));
	add(ucfmsg("E_MAIL_OFFICE"));


	# 2nd contact
	add(ucfmsg("2ND_ADDRESS"));
	add(ucfmsg("2ND_PHONE"));
	
  if($use_utf_16LE)
  	print mb_convert_encoding( "\n", 'UTF-16LE', 'UTF-8');
  else
	  echo "\r\n";

	while ($myrow = mysql_fetch_array($result))
	{

		# Name + Geburtstag
		add($myrow["lastname"], true);
		add($myrow["firstname"]);

		$day    = $myrow["bday"];
		$year   = $myrow["byear"];
                if(false) // verbose month
                {
		  // $month  = $myrow["bmonth"];
		  add( ($day > 0 ? "$day. ":"").($month != null ? $month : "")." $year"); 
                } else {
		  $month  = $myrow["bmonth_num"];
		  add( ($day > 0 ? "$day.":"").($month != null ? "$month." : "")."$year"); 
                }
		
		# Home contact
		if($zip_pattern != "")
		{
		  $address = "";
		  $zip     = "";
		  $city    = "";
			preg_match( "/(.*)(\b".$zip_pattern."\b)(.*)/m"
                                  , str_replace("\r", "", str_replace("\n", ", ", trim($myrow["address"]))), $matches);
		if(count($matches) > 1)
			$address = preg_replace("/,$/", "", trim($matches[1]));
		if(count($matches) > 2)
			$zip = $matches[2];
		if(count($matches) > 3)
			$city = preg_replace("/^,/", "", trim($matches[3]));
			
		add($address);
		add($zip);
		add($city);		
		}
		else add($myrow["address"]);

		# Privat contact
		add($myrow["home"]);
		add($myrow["mobile"]);
		add($myrow["email"]);


		# Work contact
		add($myrow["work"]);
		add($myrow["fax"]);
		add($myrow["email2"]);

		# 2nd contact
		add($myrow["address2"]);
		add($myrow["phone2"]);

    if($use_utf_16LE)
    	print mb_convert_encoding( "\n", 'UTF-16LE', 'UTF-8');
    else
      echo "\r\n";
	}

?>