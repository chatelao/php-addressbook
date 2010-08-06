<?php
	include ("include/dbconnect.php");
	
if ($id) {

   $sql = "SELECT photo FROM $base_from_where AND $table.id='$id'";
   $result = mysql_query($sql, $db);
   $r = mysql_fetch_array($result);

   $resultsnumber = mysql_numrows($result);
}

$encoded = $r['photo'];
?><img src="data:image/jpg;base64,<?php echo $r['photo']; ?>">
