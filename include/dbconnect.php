<?php
/*
 * Core file for library and parameter handling:
 *
 * - $LastChangedDate$
 * - $Rev$
 */

include("config/config.php");

// Check for any mistakes (Debugging)
// error_reporting(E_ALL);
// http://www.php.net/ini.core
// * short_open_tag  	"0"
// * register_globals  	"0"
// * memory_limit  	"8M"

// Suppress caching, force refresh on every reload.
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Activate compression, if disabled in ".htaccess"
if(   ini_get('zlib.output_compression') != 1
   && isset($compression_level) 
   && $compression_level > 0) {
  ini_set('zlib.output_compression_level', $compression_level);
  ob_start('ob_gzhandler');
}

// Copy only used variables into global space.
$get_vars = array( 'searchstring', 'alphabet', 'group', 'resultnumber'
                 , 'submit', 'update', 'delete', 'id' 
                 , 'new', 'add', 'remove', 'edit' );

foreach($get_vars as $get_var) {
   if(isset($_GET[$get_var])) {
     ${$get_var} = $_GET[$get_var];
   } elseif(isset($_POST[$get_var])) {
     ${$get_var} = $_POST[$get_var];
   } else {
     ${$get_var} = null;
   }  	
}

//
// Define the tablenames,
// if not defined in "config.php"
//
if(!isset($table))         $table        = "addressbook";
if(!isset($month_lookup))  $month_lookup = "month_lookup";

// (optional) group function
if(!isset($table_groups))  $table_groups  = "group_list";
if(!isset($table_grp_adr)) $table_grp_adr = "address_in_groups";

// the table prefix
if(!isset($table_prefix))  $table_prefix  = "";

// Show link to "group-edit" menu
if(!isset($public_group_edit)) $public_group_edit = true;

// Define default map guessing
if(!isset($map_guess)) $map_guess  = true;

// Define default ZIP handling
if(isset($plz_pattern)) $zip_pattern  = $plz_pattern;
if(!isset($zip_pattern)) $zip_pattern = "";

// Define default image location (same server)
if(!isset($url_images)) $url_images = "";

// Define default language behavoir
if(!isset($lang)) $lang  = 'choose';

// Define default UNO-languages
if(!isset($default_languages)) $default_languages = "ar,de,fr,it,th,ru";

// Split the default (displayed) languages
if(isset($default_languages)) {
	$default_languages = split(",", $default_languages);
}

// Apply the table prefix, if available
$table         = $table_prefix.$table;
$month_lookup  = $table_prefix.$month_lookup;
$table_groups  = $table_prefix.$table_groups;
$table_grp_adr = $table_prefix.$table_grp_adr;

//
// --- Set default values to parameters, if need
//
if(!isset($page_ext))
  $page_ext = ".php";
$page_ext_qry = $page_ext."?";

if(!isset($read_only))
  $read_only = false;
$read_only = $read_only || isset($_GET["readonly"]);

$group_name = null;
if(isset($_GET["group"])) {
  $group_name   = $_GET["group"];
}
if(isset($nogroups)) {
  $is_fix_group = $nogroups;
}
$is_fix_group = isset($_GET["fixgroup"]);

// Remember the current group
if(!$is_fix_group and $group_name)
{
  $page_ext_qry = "$page_ext?group=$group_name&amp;";
  $page_ext     = "$page_ext?group=$group_name";
}

include("prefs.inc.php");
include("translations.inc.php");
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

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
mysql_query('set character set utf8;');
mysql_query("SET NAMES `utf8`");

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

//
// ------------------- Group query handling ------------------------
//

$select_groups = "SELECT groups.*
       	               , parent_groups.group_name  parent_name
       	               , parent_groups.group_id    parent_id
       	            FROM $table_groups AS groups
               LEFT JOIN $table_groups AS parent_groups
                      ON groups.group_parent_id = parent_groups.group_id";
          
// Create "n-level" non-locking recursion
$max_level = 3;

$sql_from  = "";
$sql_where = "";
                   
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
 
$base_from_where  = "$base_from WHERE $base_where ";
$month_from_where = "$base_from LEFT OUTER JOIN $month_lookup ON $table.bmonth = $month_lookup.bmonth WHERE $base_where ";

$group_from_where = "$table_groups WHERE group_name = '$group_name' ";

$version = '4.0';

?>
