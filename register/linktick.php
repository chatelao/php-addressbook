<?php


include"master_inc.php";


function sanitize_paranoid_string($string, $min='', $max='')
{
  $string = preg_replace("/[^a-zA-Z0-9:\/\._]/", "", $string);
  $len = strlen($string);
  if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
    return FALSE;
  return $string;
}
	  
	  
	       $site = $_REQUEST['site'];
		   $site = sanitize_paranoid_string($site);		
		   
		   //Time & Date
			$date = date ('m/d/y  g:i a');
			
			//IP Address
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$type = "link";
			
	   $query = "INSERT INTO `traffic` (`date`,`ip`,`link`,`notes`,`site`,`type`) 
         VALUES ( '$date','$ip','$link','$notes','$site','$type')";   
		 		 
		  // save the info to the database
   $results = mysql_query( $query );

$url = str_replace("316AMPERSAND316","&","$link");

//echo "URL: $url";

header ("Location: $url");


?>
