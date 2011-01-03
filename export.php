<?php
	include ("include/dbconnect.php");
   
  if(isset($_REQUEST['type']) && $_REQUEST['type'] == "vCard-zip") {
   	
     require "include/export.vcard.php";
     
     Header("Content-Type: archive/zip");
     Header('Content-Disposition: attachment; filename="'.date("Y_m_d-Hi").'.zip"');

     $zip = new ZipArchive();
     $filename = tempnam("/tmp", "pdd").".zip";

     if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
       exit("cannot open <$filename>\n");
     }

	   $sql="SELECT * FROM $month_from_where";
	   if(isset($part_sql)) {
	     $sql .= " AND ".$part_sql;
	   }
	   $result = mysql_query($sql);
     while($address = mysql_fetch_array($result)) {	
     	 $vcfname = $address['firstname']."_".$address['lastname']."-".$address['id'].".vcf";
     	 setlocale(LC_ALL, 'en_US.UTF8');
     	 $vcfname = str_replace( "?", "", iconv('UTF-8', 'ASCII//TRANSLIT', $vcfname));
       $zip->addFromString($vcfname, address2vcard($address));
     }
     $zip->close();    
     readfile($filename);
     unlink($filename);

  } elseif(isset($_REQUEST['type']) && $_REQUEST['type'] == "vCard-one") {
  	
     Header("Content-Type: text/x-vCard");
     $filename = utf8_to_latin1("All_Contacts_of_domin-".$domain_id."-".date("Y_m_d-Hi"));
     Header('Content-Disposition: attachment; filename="'.$filename.'.vcf"');
     require "include/export.vcard.php";

    $sql = "SELECT * FROM $month_from_where";
     $result = mysql_query($sql);
     while($links  = mysql_fetch_array($result)) {
        echo address2vcard($links);
     }
  } elseif(isset($_REQUEST['type']) && $_REQUEST['type'] == "xls-Nokia") {  	
  	
     require "include/export.xls-nokia.php";     
     
  } else {
  	
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('EXPORT'); ?></h1> 
 <h2>Addressbook</h2> 
<form>
  <label>vCards for Outlook:</label>
  <input type="hidden" name="type"   value="vCard-zip">
  <input type="submit" name="submit" value="Download"><br>
</form>
<form>
  <label>All in one vCard:</label>
  <input type="hidden" name="type"   value="vCard-one">
  <input type="submit" name="submit" value="Download"><br>
</form>
<form method="get" action="csv<?php echo $page_ext; ?>">
  <label>CSV for Excel: </label>
  <input type="hidden" name="group"  value="<?php echo $group; ?>">
  <input type="submit" name="submit" value="Download"><br>
</form>
<form>
  <label>CSV for Nokia:</label>
  <input type="hidden" name="type"   value="xls-Nokia">
  <input type="submit" name="submit" value="Download"><br>
</form>
 <h2>Calendar</h2> 
<form method="get" action="birthdays<?php echo $page_ext; ?>">
  <label>Birthdays (iCalendar): </label>
  <input type="hidden" name="ics"    value="">
  <input type="submit" name="submit" value="Download"> (<a href="birthdays<?php echo $page_ext; ?>?ics&user=XXX&pass=YYY">Link</a>)<br>
</form>
<?php

 include ("include/footer.inc.php");
 }
?>