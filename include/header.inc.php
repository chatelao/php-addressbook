<?php
 header('Content-Type:text/html; charset=UTF-8');
?>
	</head>
	<body>
		<div id="container">
			<div id="top">
<!--
<?php
  $lang_cnt = 0;
  //
  // Filter the displayed languages:
  // - Default if exists
  // - Others if selected (All minus Default)
  // - All if nothing is defined
  //
	if( count($default_languages) > 0) {
		if( !isset($_GET["more_langs"]) || $_GET["more_langs"] == "") {
			$loop_langs = $default_languages;
			?>[<a title="other languages" href="?more_langs=yes">+</a>] | <?php
		} else {
			$loop_langs = array_diff($supported_langs, $default_languages);
		}
	} else {
		$loop_langs = $supported_langs;
	}
	foreach($loop_langs as $supp_lang) {
		if($supp_lang != $lang)
	{
		if($lang_cnt++ > 0)
			echo " | ";
      echo "<a href='?lang=$supp_lang'><img title='".ucfmsg($supp_lang)."' alt='".ucfmsg($supp_lang)."' src='${url_images}icons/".get_flag($supp_lang).".gif'/></a>";
    }
  }    

  if(  ! ((!isset($_GET["more_langs"]) || $_GET["more_langs"] == "") && count($default_languages) > 0) ) {
    ?> | [<a title='default languages' href='?more_langs='> - </a>]<?php
  }
?> | 

<a href="preferences<?php echo $page_ext_qry; ?>from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo ucfmsg('PREFERENCES'); ?></a>
-->
<?php if(isset($userlist) && !(isset($iplist) && hasRoleFromIP($iplist))) { ?>
<form name="logout" method="post" class=header>
<input type="hidden" name="logout" value="yes" />
<?php if(isset($username)) echo "<b>(".$username.")</b> "; ?>
<a href="#" onClick="document.logout.submit();"><?php echo ucfmsg("LOGOUT"); ?></a>
</form>
<?php } else { ?>
<?php echo "<b>(".$_SERVER['REMOTE_ADDR'].")</b>"; ?>
<?php } ?>
			</div>
			<div id="header">
				<h1><a href=".">Address Book</a></h1>
				<a href="."><img src="<?php echo $url_images; ?>title.png" title="Addressbook" alt="Addressbook" id="logo" /></a>
			</div>
			<div id="nav">
      			<?php include("include/nav.inc.php"); ?>
			</div>
			<div id="content">

<?php 
	if($group_name != "") {  
		$sql="SELECT * FROM $table_groups WHERE group_name = '$group_name'";
		$result = mysql_query($sql);
		$group_myrow = mysql_fetch_array($result);
		echo $group_myrow['group_header'];
	}
?>
