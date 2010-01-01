<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");

$resultsnumber = 0;
if ($id) {

   $sql = "SELECT * FROM $base_from_where AND $table.id='$id'";

   $result = mysql_query($sql, $db);
   $r = mysql_fetch_array($result);

    // addition by rehan@itlinkonline.com
    // phone
    $query = 'SELECT p.phone_number, pt.phone_type FROM ' . $table_phone . ' p LEFT JOIN ' . $table_phone_type . ' pt on pt.phone_type_id = p.phone_type_id WHERE p.addressbook_id = ' . $r['id'] . ' ORDER BY phone_type asc';
    $phones = mysql_query($query, $db);
    // email
    $query = 'SELECT e.email_address, et.email_type FROM ' . $table_email . ' e LEFT JOIN ' . $table_email_type . ' et on et.email_type_id = e.email_type_id WHERE e.addressbook_id = ' . $r['id'] . ' ORDER BY email_type asc';
    $emails = mysql_query($query, $db);
    // address
    $query = 'SELECT a.postal_address, at.address_type FROM ' . $table_address . ' a LEFT JOIN ' . $table_address_type . ' at on at.address_type_id = a.address_type_id WHERE a.addressbook_id = ' . $r['id'] . ' ORDER BY address_type asc';
    $addresses = mysql_query($query, $db);
    // end addition by rehan@itlinkonline.com

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
// addition by rehan@itlinkonline.com
function showOneEntry($r, $phoneArray, $emailArray, $addressArray, $only_phone = false, $primary = false) {
// end addition by rehan@itlinkonline.com	
	 global $db, $table, $table_grp_adr, $table_groups, $print, $is_fix_group, $mail_as_image;
	
   $view  = "<b>".$r['firstname']." ".$r['lastname']."</b>: <br />";   
   if(! $only_phone) {
     $view .= ($r['company']   != "" ? $r['company']."<br />" : "");
	   // addition by rehan@itlinkonline.com
                while($address = mysql_fetch_array($addressArray)){
                    if(!$primary){
                        $view .= "<b><br />".str_replace("\n", "<br />", trim($address["address_type"])).":</b>";
                        $view .= "<br />".str_replace("\n", "<br />", trim($address["postal_address"]))."<br /><br />";
                    }else{
                        if($address['primary_address']){
                            $view .= "<b><br />".str_replace("\n", "<br />", trim($address["address_type"])).":</b>";
                            $view .= "<br />".str_replace("\n", "<br />", trim($address["postal_address"]))."<br /><br />";
                        }
                    }
                }
                //$view .= "<br />".str_replace("\n", "<br />", trim($r["address"]))."<br /><br />";
            }
            while($phone = mysql_fetch_array($phoneArray)){
                if(!$primary){
                    $view .= ucfmsg($phone['phone_type'].':')." ".$phone['phone_number']."<br />";
                }else{
                    if($phone['primary_number']){
                        $view .= '<b>' . ucfmsg($phone['phone_type'].':</b><br />')." ".$phone['phone_number']."<br />";
                    }
                }
				// end addition by rehan@itlinkonline.com
	 }
   if(! $only_phone) {
	   $view .= "<br />";
// addition by rehan@itlinkonline.com
                while($email = mysql_fetch_array($emailArray)){
                if($mail_as_image) { // B64IMG: Thanks to NelloD
                        $view .= "<img src=\"b64img.php?text=".base64_encode(($email['email_address']))."\"><br/>";
                } else {
                    if( isset($_GET["print"])) {
                        if(!$primary){
                           $view .= $email['email_type'] . ": <a href=".'"'.getMailer().$email['email_address'].'"'.">".$email['email_address']."</a><br />";
                        }else{
                            if($email['primary_email']){
                                $view .= '<b>'.$email['email_type'] . ":</b><br /><a href=".'"'.getMailer().$email['email_address'].'"'.">".$email['email_address']."</a><br />";
                            }
                        }
                    } else {
                        include_once ("include/guess.inc.php");

                        $view .= $email['email_type'] . ": <a href=".'"'.getMailer().$email['email_address'].'"'.">".$email['email_address']."</a>";
                        $homepage = guessOneHomepage($email['email_address']);
                        $view .= ($homepage != "" ?  " (<a href=".'"http://'.$homepage.'"'.">".$homepage."</a>)" : "");
                        $view .= "<br/>";
                    }
                }
                }
                $homepage = $r['homepage'];
                $view .= ($homepage != "" ?  "<br /><a href=".'"http://'.$homepage.'"'.">".$homepage."</a>" : "");
                $view .= "<br />";

                $month = ucfmsg(strtoupper($r['bmonth']));
                $view .= ( $r['bday'] != 0 || $month != "-" || $r['byear'] != ""
                        ? '<br />'.ucfmsg('BIRTHDAY').": ".($r['bday'] > 0 ? $r['bday'].". " : "").($month != '-' ? $month : "")." ".$r['byear'] : "")."<br />";
            }
			// addition by rehan@itlinkonline.com
   if(! $only_phone) {
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

showOneEntry($r,$phones,$emails,$addresses);

?>	
<br />
<br />
<?php if( !isset($_GET["print"])) { ?>
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
	// addition by rehan@itlinkonline.com
    $sql = "SELECT * FROM $base_from_where order by firstname, lastname";
	// end addition by rehan@itlinkonline.com
   $result = mysql_query($sql, $db);

	 $cnt = 0;
	 echo "<h1>".ucfmsg('ADDRESS_BOOK').($group ? " ".msg('FOR')." <i>$group</i></h1>" : "</h1>");
	 ?>
   <table id="view">

   <?php
   while($r = mysql_fetch_array($result)) {
    // addition by rehan@itlinkonline.com
    // phone
    $query = 'SELECT * FROM ' . $table_phone . ' p LEFT JOIN ' . $table_phone_type . ' pt on pt.phone_type_id = p.phone_type_id WHERE p.addressbook_id = ' . $r['id'] . ' ORDER BY phone_type asc';
    $phones = mysql_query($query, $db);
    // email
    $query = 'SELECT * FROM ' . $table_email . ' e LEFT JOIN ' . $table_email_type . ' et on et.email_type_id = e.email_type_id WHERE e.addressbook_id = ' . $r['id'] . ' ORDER BY email_type asc';
    $emails = mysql_query($query, $db);
    // address
    $query = 'SELECT * FROM ' . $table_address . ' a LEFT JOIN ' . $table_address_type . ' at on at.address_type_id = a.address_type_id WHERE a.addressbook_id = ' . $r['id'] . ' ORDER BY address_type asc';
    $addresses = mysql_query($query, $db);
    // end addition by rehan@itlinkonline.com

       if( ($cnt % 6) == 0)
       		echo "<tr class='odd'>";
       if( ($cnt % 6) == 3)
       		echo "<tr class='even'>";
       		
       echo "<td valign='top'>";
                    // addition by rehan@itlinkonline.com
                    showOneEntry($r, $phones, $emails, $addresses, isset($_REQUEST['phones']), isset($_REQUEST['primary']));
					// end addition by rehan@itlinkonline.com
       echo "</td>";

       $cnt++;
       if( ($cnt % 3) == 0)
       		echo "</tr>";
       		
   }
   while(($cnt % 3) != 0)   {
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
