<?php

// Enable output compression for bandwith-saving
if(ini_get('zlib.output_compression') != 1) {
   ini_set('zlib.output_compression_level', 3);
   ob_start('ob_gzhandler');
   
}

include("config.php");

//
// --- Set default values to parameters, if need
//
if(!isset($page_ext))
  $page_ext = ".php";

if(!isset($read_only))
  $read_only = false;
$read_only = $read_only || isset($_GET["readonly"]);

$group_name   = $_GET["group"];
$is_fix_group = isset($_GET["fixgroup"]);

// Remember the current group
if(!$is_fix_group and $group_name)
{
  $page_ext_qry = "$page_ext?group=$group_name&";
  $page_ext     = "$page_ext?group=$group_name";
} else {
  $page_ext_qry = "$page_ext?";
//$page_ext     = "$page_ext";
}


//
// --- Connect to DB ---
//
$db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);

// To run the script on systeme with "register_globals" disabled.
// N.B.: Enabling with ".htaccess" didn't work.
/*
import_request_variables("id");
import_request_variables("searchstring");
import_request_variables("alphabet");
*/

// Import all variables in a secured way (HTML)
foreach($_REQUEST as $key => $value)
{
	  if(is_array($value)) {
	  	foreach($value as $entry)
	  	${$key}[] = $entry;
	  }else {
    	${$key} = htmlspecialchars($value);
    }
    
    // tbd: prevent SQL-Injection
}

 if($group_name == "") {
    $base_from  = $table;
    $base_where = "1=1";
 } else {

    if($group_name == "[none]")
    {
      $base_from  = "$table";
      $base_where = "$table.id not in (select distinct id from $table_grp_adr)";
    }
    else
    {
      $base_from  = "$table_grp_adr, $table_groups, $table";
      $base_where = "$table.id = $table_grp_adr.id "
                   ."AND $table_grp_adr.group_id  = $table_groups.group_id "
                   ."AND $table_groups.group_name = '$group_name'";
    }
 }
 
$base_from_where  = "$base_from WHERE $base_where";
$month_from_where = "$base_from LEFT OUTER JOIN $month_lookup ON $table.bmonth = $month_lookup.bmonth WHERE $base_where";

$group_from_where = "$table_groups WHERE group_name = '$group_name'";

?>