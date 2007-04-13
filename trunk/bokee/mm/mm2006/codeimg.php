<?php
header ("Content-type: image/png");
@session_start();
$im = @imagecreate (76, 26) or die ("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate ($im, 200, 200, 200);

//ÉèÖÃ¸ÉÈÅÏñËØ£¬·ÀÖ¹±»OCR
for ($i=0;$i<=128;$i++)
{
$point_color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
imagesetpixel($im,rand(2,128),rand(2,38),$point_color);
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
imagepng ($im);
imagedestroy ($im);
?> 