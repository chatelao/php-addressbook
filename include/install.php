<?php
// Check connection
if(   isset($_POST['db_host']) 
   && isset($_POST['db_name']) 
   && isset($_POST['db_user']) 
   && isset($_POST['db_pass'])
   && isset($_POST['db_tbl_prefix'])
   && isset($_POST['db_hist'])) {

   $cfg  = "<?php\n";
   $cfg .= '$dbserver     = "'.$_POST['db_host']      .'";'."\n";
   $cfg .= '$dbname       = "'.$_POST['db_name']      .'";'."\n";
   $cfg .= '$dbuser       = "'.$_POST['db_user']      .'";'."\n";
   $cfg .= '$dbpass       = "'.$_POST['db_pass']      .'";'."\n";
   $cfg .= '$table_prefix = "'.$_POST['db_tbl_prefix'].'";'."\n";
   $cfg .= '$keep_history = '.($_POST['db_hist'] == "" ? "false" : "true").";\n";
   $cfg .= "?>";

   //
   // Check DB connection
   //
   $level = error_reporting();
   error_reporting(E_ERROR);
   $db = mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);
   error_reporting($level);
   if($db) {
   	 // Write valid values to "cfg.db.php"
     file_put_contents("config/cfg.db.php", $cfg);
   } else {
   	 contine;
   }
   mysql_select_db($_POST['db_name'], $db);  

   $sql_ddl_arr = file("addressbook.sql");
   
   $search_arr = array("TABLE addressbook"
                      ,"TABLE month_lookup"
                      ,"TABLE group_list"
                      ,"TABLE address_in_groups"
                      ,"TABLE users"
                      );
   $replac_arr = array("TABLE ".$_POST['db_tbl_prefix']."addressbook"
                      ,"TABLE ".$_POST['db_tbl_prefix']."month_lookup"
                      ,"TABLE ".$_POST['db_tbl_prefix']."group_list"
                      ,"TABLE ".$_POST['db_tbl_prefix']."address_in_groups"
                      ,"TABLE ".$_POST['db_tbl_prefix']."users"
                      );
   
   $sql_ddl_arr_pfx = str_replace($search_arr, $replac_arr, $sql_ddl_arr);
   $sql_ddl     = implode($sql_ddl_arr_pfx);
   $sql_ddl_arr = explode(";", $sql_ddl);
   
   foreach($sql_ddl_arr as $sql) {
   	 mysql_query($sql);
   };
   
   // Keep the variables for the first run :-)
   $dbserver     = $_POST['db_host'];
   $dbname       = $_POST['db_name'];
   $dbuser       = $_POST['db_user'];
   $dbpass       = $_POST['db_pass'];
   $table_prefix = $_POST['db_tbl_prefix'];
   $keep_history = !($_POST['db_hist'] == "");
   
}
if(!$db) {
 	   include ("include/format.inc.php");	
	   echo "<title>".ucfmsg("ADDRESS_BOOK")."</title>";
?>
  	</head>
  	<body>
  		<div id="container">
  			<div id="top"></div>
        <div id="header"><a href="."><img width="340" height="75" src="title_x2.png" title="%ADDRESS_BOOK%" alt="%ADDRESS_BOOK%" /></a></div>
  			<div id="nav"></div>
  			<div id="content">
  	      <form accept-charset="utf-8" method="post">
            <label>Host: </label><input name='db_host' value='<?= (isset($_POST['db_host']) ? $_POST['db_host'] : 'localhost'); ?>'><br>
            <label>Name: </label><input name='db_name' value='<?= (isset($_POST['db_name']) ? $_POST['db_name'] : 'test'     ); ?>'><br>
            <label>User: </label><input name='db_user' value='<?= (isset($_POST['db_user']) ? $_POST['db_user'] : 'root'     ); ?>'><br>
            <label>Pass: </label><input name='db_pass' value='<?= (isset($_POST['db_pass']) ? $_POST['db_pass'] : ''         ); ?>'><br>
            <label>Prefix: </label><input name='db_tbl_prefix' value='<?= (isset($_POST['db_tbl_prefix']) ? $_POST['db_tbl_prefix'] : ''); ?>'><br>
            <label>History: </label><input type=checkbox name='db_hist' <?= (isset($_POST['db_hist']) && $_POST['db_hist'] != '' ? 'checked=checked' : ''); ?>'><br>
            <input type='submit'>
          </form>
<?php
  die;
}
// Appendix cfg.db.php

// Apply addressbook.sql to Database

// Rename tables

?>