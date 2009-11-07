<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title>Preferences | <?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>

	<h1><?php echo ucfmsg('PREFERENCES'); ?></h1> 
		<form method="post" action="<?php echo urldecode($_GET['from']); ?>">
				<!--  	
					<label><?php echo ucfmsg("LANGUAGE") ?>:</label>
					<select name="language" onchange="">
						<?php
							echo "<option value='auto'>".ucfmsg('auto')."</option>\n";
							foreach($supported_langs as $supp_lang) {
							echo "<option value='$supp_lang'>".ucfmsg($supp_lang)."</option>\n";
						} ?>
					</select><br /><br />
				-->				<label><?php echo ucfmsg("MAIL_CLIENT") ?>:</label>
				<select name="mailer">
					<?php
						foreach($mailers as $mailer => $url) {
						echo "<option value='$mailer'>".ucfirst($mailer)."</option>\n";
					} ?>
				</select>
				<input type="submit" name="update" value="<?php echo ucfmsg("UPDATE") ?>" />
		</form>
<?php include ("include/footer.inc.php"); ?>
