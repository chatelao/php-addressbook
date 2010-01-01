<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" <?php if(is_right_to_left($lang)) echo "dir='rtl'"; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="PHP-Addressbook" />
	<meta name="Keywords" content="" />

	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
	<!--[if !IE]>-->
	<link media="only screen and (max-device-width: 480px)" rel="stylesheet" type="text/css" href="iphone.css"/>
	<!--<![endif]-->
	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />


	<link rel="icon" type="image/png" href="<?php echo $url_images; ?>icons/font.png" />
    <script type="text/javascript" src="js/addressbook.js"></script>
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<?php if(is_right_to_left($lang)) { ?>
	<style type="text/css">
		<!--
		/* CSS for right to left */
		label {margin-left:0.5em;float:right;text-align:right;}
		#content,#right,.right {float:left;}
		#nav,#left,.left {float:right;}
		-->
	</style>
	<?php } else {} ?>
