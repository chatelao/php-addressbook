<?php
/*

displays base64_decode($_GET['text']); - useful for email addresses

example usage:
<img src="email.php?r=255&g=0&b=0&text=cHVyZW1hbmdvLmNvLnVrQGdtYWlsLmNvbQ==">

*/

header("Content-Type: image/png");

// get amounts and titles from session.
$text = base64_decode($_GET['text']);

// calculate required width and height of image
$pic_width = strlen($text)*6;
$pic_height = 12;

// create image
$pic = ImageCreate($pic_width+1,$pic_height+1);

// allocate colours
$white = ImageColorAllocate($pic,255,255,255);
$grey  = ImageColorAllocate($pic,200,200,200);
$lt_grey  = ImageColorAllocate($pic,210,210,210);
$black = ImageColorAllocate($pic,0,0,0);
$trans_temp = ImageColorAllocate($pic,254,254,254);
$transparent = ImageColorTransparent($pic,$trans_temp);

// using isset not !empty, as values could=0, therefore "empty"
if(isset($_GET['r']) && isset($_GET['g']) && isset($_GET['b']))
{
	$user = ImageColorAllocate($pic,intval($_GET['r']),intval($_GET['g']),intval($_GET['b']));
} else {
	$user = $black;
}

// transparent fill for background 
ImageFilledRectangle($pic,0,0,$pic_width,$pic_height,$trans_temp);

// draw text
ImageString($pic,2,0,0,$text,$user);

// output image
ImagePNG($pic);

// remove image from memory
ImageDestroy($pic);
?>