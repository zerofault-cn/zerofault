<?php
session_start();
header ("Content-type: image/jpeg");
$img_width=80;
$img_height=28;
$im = @imagecreate ($img_width, $img_height) or die ("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate ($im, 240, 240, 240);

//ÉèÖÃ¸ÉÈÅÏñËØ£¬·ÀÖ¹±»OCR
//for ($i=0;$i<=128;$i++)
{
//	$point_color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
//	imagesetpixel($im,rand(2,128),rand(2,38),$point_color);
}
for ($i=0; $i<50; $i++)
{
	imageString($im,1,mt_rand(1,$img_width),mt_rand(1,$img_height),"*",imageColorAllocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
}

for ($i=0; $i<2; $i++)
{
	$text_color = imagecolorallocate ($im, rand(0,255), rand(0,128), rand(0,255));
	imageline($im,mt_rand(1,$img_width),mt_rand(1,$img_height),mt_rand(1,$img_width),mt_rand(1,$img_height),$text_color);
}

//Öð¸ö»­ÉÏÑéÖ¤Âë×Ö·û
for ($i=0;$i<6;$i++)
{
	$text_color = imagecolorallocate ($im, rand(0,255), rand(0,128), rand(0,255));
	$x = 4 + $i * 12;
	$y = rand(0,12);
	imagechar ($im, 5, $x, $y,$_SESSION['validate_code']{$i}, $text_color);
}

//Êä³öPNGÍ¼Ïñ
imagejpeg ($im);
imagedestroy ($im);
?> 