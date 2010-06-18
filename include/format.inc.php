<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" <?php if(is_right_to_left($lang)) echo "dir='rtl'"; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="PHP-Addressbook" />
	<meta name="Keywords" content="" />

	<style type="text/css">
<?php
// Thanks to "dustingreen" for the "th" color contribution:
switch($skin_color) {
  case 1:
  case "brown":
    $skin_mt_color = '#c59469';
    $skin_color    = 'brown';
    break;
  case 2:
  case "green":
    $skin_mt_color = '#66a749';
    $skin_color    = 'green';
    break;
  case 3:
  case "grey":
    $skin_mt_color = '#777777';
    $skin_color    = 'grey';
    break;
  case 4:
  case "pink":
    $skin_mt_color = '#a84989';
    $skin_color    = 'pink';
    break;
  case 5:
  case "purple":
    $skin_mt_color = '#5349a9';
    $skin_color    = 'purple';
    break;
  case 6:
  case "red":
    $skin_mt_color = '#b63a3a';
    $skin_color    = 'red';
    break;
  case 7:
  case "turquoise":
    $skin_mt_color = '#48a89d';
    $skin_color    = 'turquoise';
    break;
  case 8:
  case "yellow":
    $skin_mt_color = '#b4b43a';
    $skin_color    = 'yellow';
    break;
  case "blue":
  case 0:
  default:
    $skin_mt_color = '#739fce';
    $skin_color    = 'blue';
    break;
}
?>		
    body {background-image:url('./skins/header-<?php echo $skin_color; ?>.jpg');background-repeat:repeat-x;background-position:top left;}
    table#maintable th {text-align:center;border:1px solid #ccc;font-size:12px;background:<?php echo $skin_mt_color; ?>;color:#fff;}
	</style>
	<link rel="stylesheet" type="text/css" media="all" href="style.css" />
	<!--[if !IE]>-->
	<link media="only screen and (max-device-width: 480px)" rel="stylesheet" type="text/css" href="iphone.css"/>
	<!--<![endif]-->
	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />


	<link rel="icon" type="image/png" href="<?php echo $url_images; ?>icons/font.png" />
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
switch($skin_color) {
  case "blue":
    $skin_mt_color = '#739fce';
    break;
  case "brown":
    $skin_mt_color = '#c59469';
    break;
  case "green":
    $skin_mt_color = '#66a749';
    break;
  case "grey":
    $skin_mt_color = '#777777';
    break;
  case "pink":
    $skin_mt_color = '#a84989';
    break;
  case "purple":
    $skin_mt_color = '#5349a9';
    break;
  case "red":
    $skin_mt_color = '#b63a3a';
    break;
  case "turquoise":
    $skin_mt_color = '#48a89d';
    break;
  case "yellow":
    $skin_mt_color = '#b4b43a';
    break;
}
?>		
    body {background-image:url('./skins/header-<?php echo $skin_color; ?>.jpg');background-repeat:repeat-x;background-position:top left;}
    table#maintable th {text-align:center;border:1px solid #ccc;font-size:12px;background:<?php echo $skin_mt_color; ?>;color:#fff;}
	</style>
	<link rel="stylesheet" type="text/css" media="all" href="style.css" />
	<!--[if !IE]>-->
	<link media="only screen and (max-device-width: 480px)" rel="stylesheet" type="text/css" href="iphone.css"/>
	<!--<![endif]-->
	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />


	<link rel="icon" type="image/png" href="<?php echo $url_images; ?>icons/font.png" />
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