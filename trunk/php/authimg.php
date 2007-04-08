<?php
/**
*
* Filename: authimg.php 
* Author: hutuworm 
* Date: 2003-04-28 
* @Copyleft hutuworm.org 
*/ 
//生成验证码图片 
Header("Content-type: image/PNG"); 
srand((double)microtime()*1000000); 
$im = imagecreate(58,28);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200);
imagefill($im,68,30,$gray);
//将四位整数验证码绘入图片
imagestring($im, 5, 10, 8, $_REQUEST['authnum'].'dc3se', $white);
for($i=0;$i<50;$i++)
//加入干扰象素
{
	imagesetpixel($im, rand()%70 , rand()%30 , $black);
}
ImagePNG($im);
ImageDestroy($im);
?>