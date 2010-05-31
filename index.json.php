<?php
	include ("include/dbconnect.php");

  $addresses = new Addresses($searchstring);
  // $addr_recs = $addresses->getResults();
  
  while($addr = $addresses->nextAddress()) {
  	$rec = $addr->getData();
  	echo $rec['id'].";";
  }

?>