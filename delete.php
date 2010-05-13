<?php

	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>	
	<meta HTTP-EQUIV="REFRESH" content="3;url=.">
<?php	

	echo "<title>Delete</title>";
	include ("include/header.inc.php");

	echo '<h1>Delete record</h1>';

	$sql="SELECT * FROM $base_from_where AND ".$part_sql;
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	if($resultsnumber > 0) {
		$sql = "DELETE FROM $table_grp_adr WHERE ".$part_sql;
		mysql_query($sql,$db);
		$sql = "DELETE FROM $table         WHERE ".$part_sql;
		mysql_query($sql,$db);
	} else {
		echo "<br /><div class='msgbox'>Invalid record, sorry but the record no longer exsists<br /><i>return to <a href='index.php'>home page</a></i></div>";	
	}

	include ("include/footer.inc.php");
?>
