<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('IMPORT'); ?></h1> 
<?php
if(!$submit) {
?>
<form method="post" enctype="multipart/form-data">
  <label for="file">LDIF:</label>
  <input size=30 type="file" name="file" id="file" />
  <br/>
  <input type="submit" name="submit" value="Submit" />
</form>
<?php

} else if ($_FILES["file"]["error"] > 0 || $read_only) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
  } else {
  
  $ldif_as_lines = file($_FILES["file"]["tmp_name"], FILE_IGNORE_NEW_LINES); 
  
  //
  // Begin LDIF-Parser
  //
  $dn = "";
  foreach($ldif_as_lines as $ldif_line) {
  	
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
  function getIfSet($ldif_record, $key) {
  	
  	if(isset($ldif_record[$key]) && isset($ldif_record[$key][0])) {  		
  	  return $ldif_record[$key][0];
  	} else {
  		return "";
  	}
  	
  }
  
  $file_group_name = "";
  if(count($ldif_as_array) > 0) {
  	$file_group_name = "@IMPORT-".$_FILES["file"]["name"]."-".Date("Y-m-j_H:i:s");
    saveGroup($file_group_name);
  }
  
  foreach($ldif_as_array as $r) {
  
  	$addressbook['firstname'] = getIfSet($r,'givenName');
  	$addressbook['lastname']  = getIfSet($r,'sn');
  	$addressbook['email']     = getIfSet($r,'mail');
  	$addressbook['email2']    = getIfSet($r,'mozillaSecondEmail');
    $addressbook['address']   = trim(str_replace("\r\n\r\n", "\r\n",
                                getIfSet($r,'mozillaHomeStreet')."\r\n"
  	                           .getIfSet($r,'mozillaHomePostalCode')." ".getIfSet($r,'mozillaHomeLocalityName')."\r\n"
  	                           .getIfSet($r,'mozillaHomeCountryName')));
    $addressbook['company']   = getIfSet($r,'o');
    $addressbook['homepage']  = getIfSet($r,'mozillaHomeUrl');
    $addressbook['home']      = getIfSet($r,'homePhone');
    $addressbook['mobile']    = getIfSet($r,'mobile');
    $addressbook['work']      = getIfSet($r,'telephoneNumber');
    $addressbook['fax']       = getIfSet($r,'facsimiletelephonenumber');
  
    $bmonth = getIfSet($r,'birthmonth');
    switch ($bmonth) {
      case "01":
           $addressbook['bmonth'] = "Januar"; break;
      case "02":
           $addressbook['bmonth'] = "Februar"; break;
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
           $addressbook['bmonth'] = "Oktober"; break;
      case "11":
           $addressbook['bmonth'] = "November"; break;
      case "12":
           $addressbook['bmonth'] = "Dezember"; break;
      default:
           $addressbook['bmonth'] = "";
    }
  
    $addressbook['bday']      = getIfSet($r,'birthday');
    $addressbook['byear']     = getIfSet($r,'birthyear');
  	$addressbook['address2']  = trim(str_replace("\r\n\r\n", "\r\n",
                                getIfSet($r,'street')."\r\n"
  	                           .getIfSet($r,'postalCode')." ".getIfSet($r,'l')));
  	$addressbook['phone2']    = getIfSet($r,'pager');
    $addressbook['notes']     = getIfSet($r,'description');
    
    saveAddress($addressbook, $file_group_name);
    echo "- <b><i>".     $addressbook['firstname']
                .", ".$addressbook['lastname']
                ."</i></b>, ".$addressbook['email']
                .", ".$addressbook['email2']
                .", ".$addressbook['company']."<br>";

  }
	echo "<br/><br/><div class='msgbox'>The file '".$_FILES["file"]["name"]."' is imported into ".count($ldif_as_array)." records<br/>";
	echo "<i>of the new group <a href='index$page_ext?group_name=".$file_group_name."'>".$file_group_name."</a></i></div>";	               
} // end if(!$submit)
include ("include/footer.inc.php");
?>