<?php

//
// Begin LDIF-Parser
//
$dn = "";
foreach($file_lines as $ldif_line) {
	
  //
  // Extract and convert Base64 strings
  //  
  if(preg_match("/^\w+:: /",$ldif_line)) {
  	$kv = explode(':: ', $ldif_line, 2);
  	$key   = $kv[0];
  	$value = base64_decode($kv[1]);
  } else {
  	$kv = explode(': ', $ldif_line, 2);  	
  	$key   = $kv[0];
  	if(count($kv) == 2) {
  	  $value = $kv[1];
  	} else {
  	  $value = "";
  	}
  }
  
  //
  // Detect a new UID
  //  
  if($key == "dn") {
  	$dn = $value;
  }
  
  if($key != "") {
    $ldif_as_array[$dn][$key][] = $value;
  }
}

//
// Begin LDIF-2-Addressbook convertor
//
function getIfSetDouble($ldif_record, $key) {                               
	                                                                    
	if(isset($ldif_record[$key]) && isset($ldif_record[$key][0])) {  		
	  return $ldif_record[$key][0];                                     
	} else {                                                            
		return "";                                                        
	}                                                                   
	                                                                    
}                                                                     
                                                                      
$ab = array();                                                        
                                                                      
foreach($ldif_as_array as $r) {                                       
                                                                      
	$addressbook['firstname'] = getIfSetDouble($r,'givenName');               
	$addressbook['lastname']  = getIfSetDouble($r,'sn');                      
	$addressbook['email']     = getIfSetDouble($r,'mail');                    
	$addressbook['email2']    = getIfSetDouble($r,'mozillaSecondEmail');      
  $addressbook['address']   = trim(str_replace("\r\n\r\n", "\r\n",    
                              getIfSetDouble($r,'mozillaHomeStreet')."\r\n" 
	                           .getIfSetDouble($r,'mozillaHomePostalCode')." ".getIfSetDouble($r,'mozillaHomeLocalityName')."\r\n"
	                           .getIfSetDouble($r,'mozillaHomeCountryName')));
  $addressbook['company']   = getIfSetDouble($r,'o');                       
  $addressbook['homepage']  = getIfSetDouble($r,'mozillaHomeUrl');          
  $addressbook['home']      = getIfSetDouble($r,'homePhone');               
  $addressbook['mobile']    = getIfSetDouble($r,'mobile');                  
  $addressbook['work']      = getIfSetDouble($r,'telephoneNumber');         
  $addressbook['fax']       = getIfSetDouble($r,'facsimiletelephonenumber');

  $bmonth = getIfSetDouble($r,'birthmonth');
  switch ($bmonth) {
    case "01":
         $addressbook['bmonth'] = "January"; break;
    case "02":
         $addressbook['bmonth'] = "February"; break;
    case "03":
         $addressbook['bmonth'] = "March"; break;
    case "04":
         $addressbook['bmonth'] = "April"; break;
    case "05":
         $addressbook['bmonth'] = "May"; break;
    case "06":
         $addressbook['bmonth'] = "June"; break;
    case "07":
         $addressbook['bmonth'] = "July"; break;
    case "08":
         $addressbook['bmonth'] = "August"; break;
    case "09":
         $addressbook['bmonth'] = "September"; break;
    case "10":
         $addressbook['bmonth'] = "October"; break;
    case "11":
         $addressbook['bmonth'] = "November"; break;
    case "12":
         $addressbook['bmonth'] = "December"; break;
    default:
         $addressbook['bmonth'] = "";
  }

  $addressbook['bday']      = ltrim(getIfSetDouble($r,'birthday'),"0");
  $addressbook['byear']     = getIfSetDouble($r,'birthyear');
	$addressbook['address2']  = trim(str_replace("\r\n\r\n", "\r\n",
                              getIfSetDouble($r,'street')."\r\n"
	                           .getIfSetDouble($r,'postalCode')." ".getIfSetDouble($r,'l')));
	$addressbook['phone2']    = getIfSetDouble($r,'pager');
  $addressbook['notes']     = getIfSetDouble($r,'description');

  $ab[] = $addressbook;
}
?>