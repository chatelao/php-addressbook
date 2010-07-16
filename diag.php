<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>

<br>
<br>
<hr>
<table>
	<tr><th>Test</th><th>Expected</th><th>Result</th></tr>
	<tr>
		<td><b>DB-Connection</b></td>
		<td><?php echo ($db ? "ok" : "nok"); ?></td>
	</tr>
	<tr>
<?php
 $tbls = array($table, $month_lookup, $table_groups, $table_grp_adr);
 $sql = "select * from information_schema.tables where table_name in ('".implode("', '", $tbls)."');";
 $result = mysql_query($sql);
 $resultsnumber = mysql_num_rows($result);
 ?>
		<td><b>Tables</b><br><?php echo $sql;?></td>
		<td><?php echo count($tbls); ?></td>
		<td><?php echo $resultsnumber; ?></td>
	</tr>
</table>

<?php include("include/footer.inc.php"); ?>