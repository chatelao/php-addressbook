<?php

include("config.php");

// Suppress caching
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Activate compression, if disabled in ".htaccess"
if(   ini_get('zlib.output_compression') != 1
   && $compression_level > 0) {
  ini_set('zlib.output_compression_level', $compression_level);
  ob_start('ob_gzhandler');
}

// Apply the table prefix
$table         = $table_prefix.$table;
$month_lookup  = $table_prefix.$month_lookup;
$table_groups  = $table_prefix.$table_groups;
$table_grp_adr = $table_prefix.$table_grp_adr;

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
  // $page_ext = "$page_ext";
}  

include("translation.inc.php");
include("prefs.inc.php");
include("mailer.inc.php");

// --- Connect to DB, retry 5 times ---
for ($i = 0; $i < 5; $i++) {
	
    $db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
    $errno = mysql_errno();
    if ($errno == 1040 || $errno == 1226 || $errno == 1203) {
        sleep(1);
    }  else {
        break;
    }
}
mysql_select_db("$dbname", $db);

// To run the script on systeme with "register_globals" disabled,
// import all variables in a bit secured way: Remove HTML Tags
foreach($_REQUEST as $key => $value)
{
	  // Allow all tags in headers and footers
	  if($key == "group_header" || $key == "group_footer"){
	  	${$key} = $value;
	  	
	  // Handle arrays
	  } elseif(is_array($value)) {
	  	foreach($value as $entry)
	  	{
	  		${$key}[] = strip_tags($entry);
	  	}
	  // Handle the rest
	  } else {
    	// ${$key} = htmlspecialchars($value); --chatelao-20071121, doesn't work with Chinese Characters
    	${$key} = strip_tags($value);
    }
    
    // TBD: prevent SQL-Injection
}

// Create "n-level" non-locking recursion
$max_level = 3;
                   
for($i = 0; $i < $max_level; $i++)
{
	if($i > 0) {
    $sql_from  .= "     , ";
		$sql_where .= " OR ";
	}
 	$sql_from  .= "$table_groups g$i";
	$sql_where .= "( ";
	
  for($j = 0; $j < $max_level; $j++)
  {
  	if($j > 0) {
  		$sql_where .= "\n  AND ";    	
  	}
  	if($j >= $i) {
			$sql_where .= "g$j.group_name = '$group_name'";
		} else {
			$sql_where .= "g$j.group_parent_id = g".($j+1).".group_id";
		}
  }
	$sql_where .= ")\n";
}
      // echo nl2br("select * from ".$sql_from." WHERE ".$sql_where."\n");

// Assemble the statements
if($group_name == "") {
    $base_select = " * ";
    $base_from  = $table;
    $base_where = "1=1";
 } else {

    if($group_name == "[none]")
    {
      $base_select = " * ";
      $base_from   = "$table";
      $base_where  = "$table.id not in (select distinct id from $table_grp_adr)";
    }
    elseif(isset($_REQUEST['nosubgroups']) )
    {
      $base_select = " * ";
      $base_from  = "$table_grp_adr, $table_groups, $table";
      $base_where = "$table.id = $table_grp_adr.id "
                   ."AND $table_grp_adr.group_id  = $table_groups.group_id "
                   ."AND $table_groups.group_name = '$group_name'";
    }
    else
    {
      $base_select = "DISTINCT $table.*";
      $base_from   = "$table_grp_adr, $sql_from, $table";
      $base_where  = "$table.id = $table_grp_adr.id "
                    ."AND $table_grp_adr.group_id  = g0.group_id "
                    ."AND ($sql_where)";
    }
 }
 
$base_from_where  = "$base_from WHERE $base_where";
$month_from_where = "$base_from LEFT OUTER JOIN $month_lookup ON $table.bmonth = $month_lookup.bmonth WHERE $base_where";

$group_from_where = "$table_groups WHERE group_name = '$group_name'";

$version = '3.2.3';

?>