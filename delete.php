<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");
include ("include/header.inc.php");

$sql="SELECT * FROM $base_from_where AND $table.id=$id";
$result = mysql_query($sql);
$resultsnumber = mysql_numrows($result);

if($resultsnumber > 0)
{
	mysql_query("DELETE FROM $table_grp_adr WHERE id='$id'",$db);
	mysql_query("DELETE FROM $table         WHERE id='$id'",$db);
	echo "Record deleted.<br><br>";
} else
{
	echo "Invalid record<br><br>";	
}
echo "<a href='index.php'>home page</a>";

include ("include/footer.inc.php");

?>