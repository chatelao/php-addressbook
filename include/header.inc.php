<?php
 header('Content-Type:text/html; charset=UTF-8');
?>
	</head>
	<body>
		<div id="container">
			<div id="top">

<?php if(isset($userlist) /* && !(isset($iplist) && hasRoleFromIP($iplist))*/) { ?>
<form name="logout" method="post" class="header">
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
				<a href="."><img src="<?php echo $url_images; ?>title_x2.png" width=340 height=75 title="Addressbook" alt="Addressbook" id="logo" /></a>
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
