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
     echo '	<style type="text/css"> <!-- body{background:none;}#container{margin:0 2px 0;width:700px;} --> </style></head><body><div id="container"><div>';
     // echo '</head><body onload="javascript:window.setTimeout(window.print(self), 1000)";>';
   }
}

function showOneEntry($r, $only_phone = false) 
{
	
	 global $db, $table, $table_grp_adr, $table_groups, $print, $is_fix_group;
	
   $view  = "<b>".$r['firstname']." ".$r['lastname']."</b>: <br />";
   
   if(! $only_phone)
	   $view .= "<br />".str_replace("\n", "<br />", trim($r["address"]))."<br /><br />";	   
   $view .= ($r['home']   != "" ? ucfmsg('H:')." ".$r['home']."<br />" : "");
   $view .= ($r['mobile'] != "" ? ucfmsg('M:')." ".$r['mobile']."<br />" : "");
   $view .= ($r['work']   != "" ? ucfmsg('W:')." ".$r['work']."<br />" : "");
   if(! $only_phone) {
	   $view .= "<br />";
	   if( isset($_GET["print"])) {
	     $view .= ($r['email'] != "" ?  "<a href=".'"'.getMailer().$r['email'].'"'.">".$r['email']."</a><br/>" : "");
	     $view .= ($r['email2'] != "" ? "<a href=".'"'.getMailer().$r['email2'].'"'.">".$r['email2']."</a><br/>" : "");
	   } else {
	     include ("include/guess.inc.php");
	     
 	     $view .= ($r['email'] != "" ?  "<a href=".'"'.getMailer().$r['email'].'"'.">".$r['email']."</a>" : "");
 	     $homepage = guessOneHomepage($r['email']);
	     $view .= ($homepage != "" ?  " (<a href=".'"http://'.$homepage.'"'.">".$homepage."</a>)" : "");
	     $view .= ($r['email'] != "" ? "<br/>" : "");

	     $view .= ($r['email2'] != "" ? "<a href=".'"'.getMailer().$r['email2'].'"'.">".$r['email2']."</a>" : "");
	     $homepage = guessOneHomepage($r['email2']);
	     $view .= ($homepage != "" ?  " (<a href=".'"http://'.$homepage.'"'.">".$homepage."</a>)" : "");
	     $view .= ($r['email2'] != "" ? "<br/>" : "");
	   }
	   $view .= "<br />";
   }
   $month = ucfmsg(strtoupper($r['bmonth']));
   $view .= ( $r['bday'] != 0 || $month != "-" || $r['byear'] != ""
            ? ucfmsg('BIRTHDAY').": ".($r['bday'] > 0 ? $r['bday'].". " : "").($month != '-' ? $month : "")." ".$r['byear'] : "")."<br />"; 


   if(! $only_phone) {
	   $view .= ($r['address2'] != "" || $r['phone2'] != "" ? "<br /><br /><b>".ucfmsg('SECONDARY')."</b><br />" : "");
	   $view .= ($r['address2'] != "" ? "<br />".str_replace("\n", "<br />", trim($r['address2']))."<br /><br />" : "");
	 }	   
   $view .= ($r['phone2']   != "" ? "P: ".$r['phone2']."<br />" : "");

   echo $view."\n";

   if( !isset($print) and !$is_fix_group) {
   	 
	   $sql = "SELECT group_name 
	             FROM $table_grp_adr, $table_groups, $table
	            WHERE $table.id = $table_grp_adr.id
	              AND $table.id = ".$r['id']."
	              AND $table_grp_adr.group_id  = $table_groups.group_id";
	
	   $result = mysql_query($sql, $db);
	
	   $first = true;
	   while($g = mysql_fetch_array($result)) {
	   	 if($first)
	   	   echo "<br /><i>".ucfmsg('MEMBER_OF').": ";
	   	 else
			echo ", ";
			echo "<a href='./?group=".urlencode($g['group_name'])."'>".$g['group_name']."</a>";
	   	   
	   	 $first = false;
	   }
	   if($first != true)
	     echo "</i>";
   }
}

if ($id) {
if($resultsnumber == 0) {

   echo "<div class'msgbox'>Please select a valid entry.</div>";

} else {

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

   $sql = "SELECT * FROM $base_from_where order by lastname, firstname";
   $result = mysql_query($sql, $db);

	 $cnt = 0;
	 echo "<h1>".ucfmsg('ADDRESS_BOOK').($group ? " ".msg('FOR')." <i>$group</i></h1>" : "</h1>");
	 ?>
   <table id="view">

   <?php
   while($r = mysql_fetch_array($result)) {
       if( ($cnt % 6) == 0)
       		echo "<tr class='odd'>";
       if( ($cnt % 6) == 3)
       		echo "<tr class='even'>";
       		
       echo "<td valign='top'>";
   	   showOneEntry($r, isset($_REQUEST['phones']));
       echo "</td>";

       $cnt++;
       if( ($cnt % 3) == 0)
       		echo "</tr>";
       		
   }
   while(($cnt % 3) != 0)
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
