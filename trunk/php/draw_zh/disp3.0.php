<?php
header ("Content-type: image/gif"); 
include 'draw3.0.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$red = imagecolorallocate ($im, 255, 0, 0);
$green = imagecolorallocate ($im, 0, 255, 0);
$string="中文123中文123";
drawer($im,$string,1,1,$green,2,2);
imagepng ($im); 
imagedestroy ($im);
?>