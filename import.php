<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
 <h1><?php echo ucfmsg('IMPORT'); ?></h1> 
<?php
function getIfSet($ldif_record, $key) {
	
	if(isset($ldif_record[$key])) {
	  return $ldif_record[$key];
	} else {
		return "";
	}
	
}

if(!$submit) {
?>
<form method="post" enctype="multipart/form-data">
  <label for="file">LDIF / vCard(s):</label>
  <input size=30 type="file" name="file" id="file" />
  <br/>
  <input type="submit" name="submit" value="Submit" />
</form>

<?php
} else if ($_FILES["file"]["error"] > 0 || $read_only) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
} else {
  
  $file_lines = file($_FILES["file"]["tmp_name"], FILE_IGNORE_NEW_LINES); 
  
  include "include/import.common.php";
  
   //
  // Save the group & addresses
  //
  $file_group_name = "";
  if(count($ab) > 0) {  	
  	$file_group_name = "@IMPORT-".$_FILES["file"]["name"]."-".Date("Y-m-j_H:i:s");
    saveGroup($file_group_name);
  }
  
  foreach($ab as $addressbook) {
  	
    saveAddress($addressbook, $file_group_name);
    echo "- <b><i>".getIfSet($addressbook,'firstname')
        .", ".getIfSet($addressbook,'lastname')
        ."</i></b>, ".getIfSet($addressbook,'email')
        .", ".getIfSet($addressbook,'email2')
        .", ".getIfSet($addressbook,'company')."<br>";

  }
	echo "<br/><br/><div class='msgbox'>The ".$import_type."-file '".$_FILES["file"]["name"]."' is imported into ".count($ab)." records<br/>";
	echo "<i>of the new group <a href='index$page_ext?group_name=".$file_group_name."'>".$file_group_name."</a></i></div>";	               
//*/
} // end if(!$submit)
include ("include/footer.inc.php");
?>