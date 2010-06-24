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

function showOneEntry($r, $only_phone = false) 
{
	
	 global $db, $table, $table_grp_adr, $table_groups, $print, $is_fix_group, $mail_as_image;
	
   $view  = "<b>".$r['firstname']." ".$r['lastname']."</b>: <br />";   
   if(! $only_phone) {
     $view .= ($r['company']   != "" ? $r['company']."<br />" : "");
	   $view .= "<br />".str_replace("\n", "<br />", trim($r["address"]))."<br /><br />";
	 }
   $view .= ($r['home']   != "" ? ucfmsg('H:')." ".$r['home']."<br />" : "");
   $view .= ($r['mobile'] != "" ? ucfmsg('M:')." ".$r['mobile']."<br />" : "");
   $view .= ($r['work']   != "" ? ucfmsg('W:')." ".$r['work']."<br />" : "");
   $view .= ($r['fax']   != "" ?  ucfmsg('F:')." ".$r['fax']."<br />" : "");
   if(! $only_phone) {
	   $view .= "<br />";

  	 if($mail_as_image) { // B64IMG: Thanks to NelloD
      $view .= ($r['email'] != "" ? "<img src=\"b64img.php?text=".base64_encode(($r['email']))."\"><br/>" : "");
       $view .= ($r['email2'] != "" ? "<img src=\"b64img.php?text=".base64_encode(($r['email2']))."\"><br/>" : "");
     } else {
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
	   }
	   $homepage = $r['homepage'];
	   $view .= ($homepage != "" ?  "<a href=".'"http://'.$homepage.'"'.">".$homepage."</a>" : "");
	   $view .= "<br />";

     $month = ucfmsg(strtoupper($r['bmonth']));
     $view .= ( $r['bday'] != 0 || $month != "-" || $r['byear'] != ""
              ? ucfmsg('BIRTHDAY').": ".($r['bday'] > 0 ? $r['bday'].". " : "").($month != '-' ? $month : "")." ".$r['byear'] : "");
     $age = date("Y")-$r['byear'];
     $view .= ($age < 120 ? " (".$age.")" : ""); 
     $view .="<br />"; 

	   $view .= ($r['address2'] != "" || $r['phone2'] != "" ? "<br /><br /><b>".ucfmsg('SECONDARY')."</b><br />" : "");
	   $view .= ($r['address2'] != "" ? "<br />".str_replace("\n", "<br />", trim($r['address2']))."<br /><br />" : "");
	 }	   
   $view .= ($r['phone2']   != "" ? "P: ".$r['phone2']."<br />" : "");
   if(! $only_phone) {
   	
   	 // Detect URLs (http://*, www.*) and show as link.
   	 //
   	 // $text = "Hello, http://www.google.com";
     // $new = preg_replace("/(http:\/\/[^\s]+)/", "<a href=\"$1\">$1</a>", $test);
   	 //
	   $view .= ($r['notes'] != "" ? "<br />".str_replace("\n", "<br />", trim($r['notes']))."<br /><br />" : "");
   }
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
	     
	   /*
     echo "<br/><br/>";
     echo ucfmsg('MODIFIED') . ": ".$r['modified'];
     echo "<i>(".ucfmsg('CREATED')  . ": ".$r['created'].")</i><br/>";
     */
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
   
   $only_phones = isset($_REQUEST['phones']);

   $addr_per_line  = ($only_phones ? 4 : 3);
   
   while($r = mysql_fetch_array($result)) {
   	 $address = new Address($r);
   	 if($address->hasPhone()) {
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