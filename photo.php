<?php
	include ("include/dbconnect.php");
	include ("include/photo.class.php");

if ($id) {

   $sql = "SELECT photo FROM $base_from_where AND $table.id=?";
   $result = $db_access->execute($sql, [$id]);
   $r = $db_access->fetchArray($result);

   $resultsnumber = $db_access->numRows($result);
}

$encoded = isset($r['photo']) ? $r['photo'] : '';

header('Content-Type: image/jpeg');
echo binaryImg($encoded);

?>