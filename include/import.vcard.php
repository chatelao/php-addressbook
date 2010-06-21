<?php

//
// see: http://tools.ietf.org/html/rfc2426
//

$addresses = array();

foreach($file_lines as $vcards_line) {
	
	// Basic split
  $kv = explode(':', $vcards_line, 2);
 	$key = $kv[0];
  
  if($key == "BEGIN") {
    $address   = array();  	
  }
  if($key == "END") {
    $addresses[] = $address;
  }
  
  if(count($kv) == 2) {
  	$val = $kv[1];

  	//
  	// Key Analyzer
  	//
  	$subkeys = explode(';', $key);
  	$pkey    = $subkeys[0];
  	
  	$addr_line = array();
  	$addr_line['SRC'] = $vcards_line;
  	
  	for($i = 1; $i < count($subkeys); $i++) {
  	  $subkey = explode('=', $subkeys[$i]);
  	  $subkey_name = strtoupper($subkey[0]);
  	  if(!isset($subkey[1])) {
  	    $addr_line[$subkey_name] = "";
  	  } else {
  	    $addr_line[$subkey_name][] = $subkey[1];
  	    
  	    if($subkey[0] == 'TYPE' && count(explode(',',$subkey[1])) > 1) {
  	      foreach(explode(',',$subkey[1]) as $subtype) {
  	    	  $addr_line['SUBTYPE'][] = $subtype;
  	    	}
  	    }
  	  }
  	}
  	
  	//
  	// Value Analyzer
  	//
  	$addr_line['VALUE'] = $val;
  	if(count(explode(';', $val)) > 1) {
  	  $addr_line['SEMI-COLON'] = explode(';', $val);  	  
  	}

  	$address[$pkey][] = $addr_line;
  }
}

foreach($addresses as $address) {

  	$dest_addr = array();

    foreach($address as $type => $entries) {  	

    //
    // "N" Type, X.520 based, delimiter ";" (5 fields)
    //
    // Family Name;Given Name;Additional Names;Honorific Prefixes;Honorific Suffixes
    //
    if($type == "N") {
      $dest_addr['lastname']  = $entries[0]['SEMI-COLON'][0];
      $dest_addr['firstname'] = $entries[0]['SEMI-COLON'][1];
    }
  
    //
    // "ADR" Type, delimiter ";" (7 fields)
    //
    // post office box; the extended address; the street                
    // address; the locality (e.g., city); the region (e.g., state or
    // province); the postal code; the country name
    //
    if($type == "ADR") {
  
    	foreach($entries as $entry) {
    	  $street      = $entry['SEMI-COLON'][2];
    	  $city        = $entry['SEMI-COLON'][3];
    	  $postal_code = $entry['SEMI-COLON'][5];
    	  $country     = $entry['SEMI-COLON'][6];
    	  
    	  $dest_address = trim($street."\n".$postal_code." ".$city."\n".$country);
    	  
    	  if(strlen($dest_address) > 0) {
    	  	if(isset($entry['TYPE'])) {
    	      if($entry['TYPE'][0] == "home") {
    	        $dest_addr['address']  = $dest_address;
    	      } else {
    	        $dest_addr['address2'] = $dest_address;
    	      }
    	    } else {
    	      if(array_key_exists('HOME',$entry)) {
    	    	  $dest_addr['address']  = $dest_address;
    	    	} else {
    	        $dest_addr['address2'] = $dest_address;
    	      }
    	    }
    	  }
    	}
    }
  
    //
    // "TEL" Type, X.500 Telephone Number attribute
    //
    if($type == "EMAIL") {

      $dest_addr['email']  = $entries[0]['VALUE'];
      if(isset($entries[1]['VALUE'])) {
        $dest_addr['email2'] = $entries[1]['VALUE'];
      }
    }
    
    //
    // "TEL" Type, X.500 Telephone Number attribute
    //
    if($type == "TEL") {

    	foreach($entries as $entry) {
    		  	
    	  if(isset($entry['TYPE'])) {
    	    if($entry['TYPE'][0]       == "home") {
    	      $dest_addr['home']   = $entry['VALUE'];
    	    } elseif($entry['TYPE'][0] == "work") {
    	      $dest_addr['work']   = $entry['VALUE'];
    	    } elseif(count($entry['SUBTYPE']) > 0 && in_array('fax', $entry['SUBTYPE'])) {
    	      $dest_addr['fax']    = $entry['VALUE'];  	  	
    	    } elseif(count($entry['SUBTYPE']) > 0 && in_array('cell', $entry['SUBTYPE'])) {
    	      $dest_addr['mobile'] = $entry['VALUE'];  	  	
    	    } else {
    	      $dest_addr['phone2'] = $entry['VALUE'];  	  	
    	    }
    	  } else {
    	    if(      array_key_exists('HOME',$entry)) {
    	      $dest_addr['home']   = $entry['VALUE'];
    	    } elseif(array_key_exists('WORK',$entry)) {
    	      $dest_addr['work']   = $entry['VALUE'];
    	    } elseif(array_key_exists('FAX',$entry)) {
    	      $dest_addr['fax']    = $entry['VALUE'];  	  	
    	    } elseif(array_key_exists('CELL',$entry)) {
    	      $dest_addr['mobile'] = $entry['VALUE'];  	  	
    	    } else {
    	      $dest_addr['phone2'] = $entry['VALUE'];  	  	
    	    }
    	  	
    	  }
    	}
    }
  
    //
    // "BDAY" Type, Birthday
    //
    // Examples
    //
    // - BDAY:1996-04-15
    // - BDAY:1953-10-15T23:10:00Z
    // - BDAY:1987-09-27T08:30:00-06:00
    if($type == "BDAY" && strlen($entries[0]['VALUE']) >= 10) {
    	$date = substr($entries[0]['VALUE'], 0, 10);
    	$date_parts = explode("-",$date);

    	$dest_addr['bday']  = ltrim($date_parts[2],"0");
    	$dest_addr['byear'] = $date_parts[0];
      switch ($date_parts[1]) {
        case "01":
             $dest_addr['bmonth'] = "January"; break;
        case "02":
             $dest_addr['bmonth'] = "February"; break;
        case "03":
             $dest_addr['bmonth'] = "March"; break;
        case "04":
             $dest_addr['bmonth'] = "April"; break;
        case "05":
             $dest_addr['bmonth'] = "May"; break;
        case "06":
             $dest_addr['bmonth'] = "June"; break;
        case "07":
             $dest_addr['bmonth'] = "July"; break;
        case "08":
             $dest_addr['bmonth'] = "August"; break;
        case "09":
             $dest_addr['bmonth'] = "September"; break;
        case "10":
             $dest_addr['bmonth'] = "October"; break;
        case "11":
             $dest_addr['bmonth'] = "November"; break;
        case "12":
             $dest_addr['bmonth'] = "Dezember"; break;
        default:
             $dest_addr['bmonth'] = "";
      }
    	
    }  
    
    //
    // "ORG" Type, the Company
    //  
    if($type == "ORG") {
      $dest_addr['company']  = $entries[0]['VALUE'];
    }
    
    //
    // "NOTE" Type, just Notes
    //
    if($type == "NOTE") {
      $dest_addr['notes']  = $entries[0]['VALUE'];
    }    
  }
  $ab[] = $dest_addr;
}
?>