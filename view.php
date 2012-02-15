<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");

$resultsnumber = 0;
if ($id) {

   $sql = "SELECT * FROM $base_from_where AND $table.id='$id'";
   $result = mysql_query($sql, $db);
   $r = mysql_fetch_array($result);

   $resultsnumber = mysql_numrows($result);
}

if( ($resultsnumber == 0 && !isset($all)) || (!$id && !isset($all))) {
   ?><title>Address book <?php echo ($group_name != "" ? "($group_name)":""); ?></title><?php
   include ("include/header.inc.php");
} else {
   if(!$id) {
     ?><title>Address book <?php echo ($group_name != "" ? "($group_name)":""); ?></title><?php
   } else {
     ?><title><?php echo $r["firstname"]." ".$r["lastname"]." ".($group_name != "" ? "($group_name)":"")."\n"; ?></title><?php
   }
   if( !isset($_GET["print"]))
   {
     include ("include/header.inc.php");
   } else {
     echo '	<style type="text/css"> <!-- body{background:none;}#container{margin:0 2px 0;width:700px;} @media only screen and (max-device-width: 480px) {#container {margin:0 2px 0;width:99%;}} --> </style></head><body><div id="container"><div>';
     // echo '</head><body onload="javascript:window.setTimeout(window.print(self), 1000)";>';
   }
}


if ($id) {
if($resultsnumber == 0) {

   echo "<div class'msgbox'>Please select a valid entry.</div>";

} else {

include "widget/view.w.php";
showOneEntry($r);

?>	
<br />
<br />
<?php if( !isset($_GET["print"])) 
{ ?>
<form method="get" action="edit<?php echo $page_ext; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
<?php if(! $read_only) { ?>
    <input type="submit" name="modifiy" value="<?php echo ucfmsg('MODIFY'); ?>" />
<?php } ?>
</form>

<form method="get" action="view<?php echo $page_ext; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="submit" name="print" value="<?php echo ucfmsg('PRINT'); ?>" />
</form>

<?php
}
}
} else if(isset($_REQUEST['all'])) {

   include "widget/view.w.php";

   $sql = "SELECT * FROM $base_from_where order by lastname, firstname";
   $result = mysql_query($sql, $db);

	 $cnt = 0;
	 echo "<h1>".ucfmsg('ADDRESS_BOOK').($group ? " ".msg('FOR')." <i>$group</i></h1>" : "</h1>");
	 ?>
   <table id="view">

   <?php
   
   $only_phones = isset($_REQUEST['phones']);

   $addr_per_line  = ($only_phones ? 4 : 3);
   
   function trimAll($r) {
    	$res = array();
    	foreach($r as $key => $val) {
    		$res[$key] = trim($val);
    	}
    	return $res;
   } 

   while($r = mysql_fetch_array($result)) {
   	 $r = trimAll($r);   	
   	 $address = new Address($r);
   	 if($address->hasPhone() || !$only_phones) {
       if( ($cnt % (2*$addr_per_line)) == 0)
       		echo "<tr class='odd'>";
       if( ($cnt % (2*$addr_per_line)) == $addr_per_line)
       		echo "<tr class='even'>";
       		
       echo "<td valign='top'>";
   	   showOneEntry($r, $only_phones);
       echo "</td>";

       $cnt++;
       if( ($cnt % $addr_per_line) == 0)
       		echo "</tr>";       	
     }	
   }
   while(($cnt % $addr_per_line) != 0)
   {
      echo "<td>.</td>";   	
      $cnt++;
   }
   ?>

   </tr></table>
<?php
} else {

	echo "<div class'msgbox'>Please select a valid entry.</div>";

}
include ("include/footer.inc.php");
?>