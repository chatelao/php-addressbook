<?php

	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>	
	<meta HTTP-EQUIV="REFRESH" content="3;url=.">
<?php	

	echo "<title>Delete</title>";
	include ("include/header.inc.php");

	echo '<h1>Delete record</h1>';

  if(! $read_only)
  {
	$sql="SELECT * FROM $base_from_where AND ".$part_sql;
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

  	if(! deleteAddresses($part_sql)) {
  		echo "<br /><div class='msgbox'>Invalid record, sorry but the record no longer exsists<br /><i>return to <a href='index.php'>home page</a></i></div>";
  	} else {
  		echo "<br /><div class='msgbox'>Record successful deleted</i></div>";
  	}
	} else {
    echo "<br /><div class='msgbox'>Deleting is disabled.</div>\n";  	
	}

	include ("include/footer.inc.php");
?>
