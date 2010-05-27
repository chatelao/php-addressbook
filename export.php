<?php
	include ("include/dbconnect.php");
   
   $VCFZIP = "vCard for Outlook";
   $VCF    = "vcf";
   $LDIF   = "ldif";
   
   if($submit == $VCFZIP) {
   	
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

   } elseif($submit == $VCF) {
     Header("Content-Type: text/x-vCard");
     
   } elseif($submit == $LDIF) {
     Header('Content-Disposition: attachment; filename="'.$firstname.'_'.$lastname."_".$id."-".date("Ymd").'.vcf"');
     
   } else {
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('EXPORT'); ?></h1> 
<form>
<?php
  if(isset($parts) && count($parts) > 0) { ?>
<h2>Selection to Download</h2>
    <input type="radio" name="range" value="sel">Selected<br>
    <input type="radio" name="range" value="all">All<br>
<?php } else { ?>  
  <input type="hidden" name="range" value="all">
<?php } ?>  
<h2>Target</h2>
  <input type="radio" name="format" value="csv"><u>Excel</u> - A special ".csv" file (UTF-16)<br>
  <input type="radio" name="format" value="vcf-zip"><u>Outlook</u> - One .vcf per record in a .zip file (Latin-1)<br>
  <input type="radio" name="format" value="ldif"><u>Thunderbird</u> - Mozilla LDAP Data Interchange Format (Base64)<br>
  <input type="radio" name="format" value="vcf"><u>vCard</u> - All vCards in one file<br>
  <br>
  <input type="submit" name="submit" value="vCard for Outlook">
  <input type="submit" name="submit" value="csv for Excel">
  <input type="submit" name="submit" value="ldif for Thunderbird">
  <input type="submit" name="submit" value="vCards in one file">
  <form>
<?php

 include ("include/footer.inc.php");
 }
?>