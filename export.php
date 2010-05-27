<?php
	include ("include/dbconnect.php");
   
  if($submit) {
   	
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
     	 $vcfname = $address['lastname']."_".$address['firstname']."-".$address['id'].".vcf";
     	 setlocale(LC_ALL, 'en_US.UTF8');
     	 $vcfname = str_replace( "?", "", iconv('UTF-8', 'ASCII//TRANSLIT', $vcfname));
       $zip->addFromString($vcfname, address2vcard($address));
     }
     $zip->close();    
     readfile($filename);
     unlink($filename);

  } else {
  	
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('EXPORT'); ?></h1> 
<form>
  <label>vCards for Outlook:</label>
  <input type="submit" name="submit" value="Download"><br>
</form>
<form method="get" action="csv<?php echo $page_ext; ?>">
  <label>CSV for Excel: </label>
  <input type="submit" name="submit" value="Download"><br>
</form>
<?php

 include ("include/footer.inc.php");
 }
?>