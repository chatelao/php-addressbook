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
  	$res = str_replace("\r\n", ", ", $res);
  	$res = str_replace('"', '""',  $res);
  
	// addition by rehan@itlinkonline.com
    $res = str_replace('-', ' ',  $res);
	// end addition by rehan@itlinkonline.com

  	// Add to result
  	if($use_utf_16LE) {  		
  	  $res = ($first ? "" : "\t" ) . '"'.$res.'"';
      print mb_convert_encoding( $res, 'UTF-16LE', 'UTF-8');
      
    } else { // Fallback to ISO-8859-1
      $res = ($first ? "" : ";" ) . '"'.$res.'"';
      print utf8_decode($res);
    }
  
  }
	
// addition by rehan@itlinkonline.com
$sql = "SELECT $table.*, $month_lookup.bmonth_num FROM $month_from_where ORDER BY firstname, lastname ASC";
// end addition by rehan@itlinkonline.com

	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);	

// addition by rehan@itlinkonline.com
$phoneTypes = mysql_query('SELECT * FROM ' . $table_phone_type . ' ORDER BY phone_type asc');
$emailTypes = mysql_query('SELECT * FROM ' . $table_email_type . ' ORDER BY email_type asc');
$addressTypes = mysql_query('SELECT * FROM ' . $table_address_type . ' ORDER BY address_type asc');
// end addition by rehan@itlinkonline.com

  // Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
  Header("Content-Type: application/vnd.ms-excel");
  Header("Content-disposition: attachement; filename=export-".date("Ymd").($group_name != "" ? "-".$group_name : "").".csv");
  Header("Content-Transfer-Encoding: 8bit");  

  if($use_utf_16LE)
 	  print chr(255).chr(254);

// addition by rehan@itlinkonline.com
add(ucfmsg("FIRSTNAME"), true);
add(ucfmsg("LASTNAME"));
	add(ucfmsg("BIRTHDAY"));
// end addition by rehan@itlinkonline.com

// addition by rehan@itlinkonline.com
while($addType = mysql_fetch_array($addressTypes)) {
    add(ucfmsg("ADDRESS_".ucwords($addType['address_type'])));
// end addition by rehan@itlinkonline.com
    if($zip_pattern != "") {
		add(ucfmsg("ZIP"));
		add(ucfmsg("CITY"));
	}
// addition by rehan@itlinkonline.com
}
        
while($phoneType = mysql_fetch_array($phoneTypes)) {
    add(ucfmsg("PHONE_".ucwords($phoneType['phone_type'])));
}

while($emailType = mysql_fetch_array($emailTypes)) {
    add(ucfmsg("E_MAIL_".ucwords($emailType['email_type'])));
}
// end addition by rehan@itlinkonline.com
	
  if($use_utf_16LE)
  	print mb_convert_encoding( "\n", 'UTF-16LE', 'UTF-8');
  else
	  echo "\r\n";

while ($myrow = mysql_fetch_array($result)) {
    // addition by rehan@itlinkonline.com
    
    // phone
    $phoneQuery = 'SELECT p.phone_number, pt.phone_type, pt.phone_type_id FROM ' . $table_phone_type . ' pt LEFT OUTER JOIN ' . $table_phone . ' p on pt.phone_type_id = p.phone_type_id AND p.addressbook_id = ' . $myrow['id'] . ' GROUP BY phone_type_id ORDER BY phone_type asc';
    // email
    $emailQuery = 'SELECT e.email_address, et.email_type, et.email_type_id FROM ' . $table_email_type . ' et LEFT OUTER JOIN ' . $table_email . ' e on et.email_type_id = e.email_type_id AND e.addressbook_id = ' . $myrow['id'] . ' GROUP BY email_type_id ORDER BY email_type asc';
    // address
    $addQuery = 'SELECT a.postal_address, at.address_type, at.address_type_id  FROM ' . $table_address_type . ' at LEFT OUTER JOIN ' . $table_address . ' a on at.address_type_id = a.address_type_id AND a.addressbook_id = ' . $myrow['id'] . ' GROUP BY address_type_id ORDER BY address_type asc ';

    $phones = mysql_query($phoneQuery);
    $emails = mysql_query($emailQuery);
    $addresses = mysql_query($addQuery);
    // end addition by rehan@itlinkonline.com

    add($myrow["firstname"], true);
    add($myrow["lastname"]);

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
	// addition by rehan@itlinkonline.com
    while($address = mysql_fetch_array($addresses) ) {
	// end addition by rehan@itlinkonline.com
        if($zip_pattern != "") {
// addition by rehan@itlinkonline.com
			preg_match( "/(.*)(\b".$zip_pattern."\b)(.*)/m"
                    , str_replace("\r\n", ", ", trim($address["psotal_address"])), $matches);
		if(count($matches) > 1)
			add(preg_replace("/,$/", "", trim($matches[1])));
		if(count($matches) > 2)
			add($matches[2]);
		if(count($matches) > 3)
			add(preg_replace("/^,/", "", trim($matches[3])));
		}
        else {
            add($address["postal_address"]);
        }
    }

    while($phone = mysql_fetch_array($phones) ) {
        add($phone['phone_number']);
    }

    while($email = mysql_fetch_array($emails) ) {
        add($email['email_address']);
    }
// end addition by rehan@itlinkonline.com

    if($use_utf_16LE)
    	print mb_convert_encoding( "\n", 'UTF-16LE', 'UTF-8');
    else
      echo "\r\n";
	}

?>