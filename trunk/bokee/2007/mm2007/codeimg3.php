<?php
session_start();
$img_width=90;
$img_height=30;
$img = imagecreate($img_width,$img_height);
ImageColorAllocate($img,255,255,255);
$black = ImageColorAllocate($img,0,0,0);
ImageRectangle($img,0,0,$img_width-1,$img_height-1,$black);

for ($i=0; $i<100; $i++)
{
	imageString($img,1,mt_rand(1,$img_width),mt_rand(1,$img_height),"*",imageColorAllocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
}

for ($i=0; $i<2; $i++)
{
	imageline($img,mt_rand(1,$img_width),mt_rand(1,$img_height),mt_rand(1,$img_width),mt_rand(1,$img_height),$black);
}

for ($i=0; $i<6; $i++)
{
	$display_string =$_SESSION['validate_code']{$i};
	imagettftext($img,15,mt_rand(-10,10),$i*$img_width/6+mt_rand(1,5)-2,mt_rand($img_height-14,$img_height-3),imageColorAllocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)),"georgia.ttf",$display_string);
//	imageString($img,5,$i*$img_width/6+mt_rand(1,10),mt_rand(1,$img_height/2),$display_string,imageColorAllocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
}

/*debug
$img_tar = imagecreate(240,80);
ImageCopyResized($img_tar,$img,0,0,0,0,240,80,$img_height,$img_width);
ImagePng($img_tar);
*/
Header("Content-type: image/jpeg");
Imagejpeg($img);
ImageDestroy($img);
?> 