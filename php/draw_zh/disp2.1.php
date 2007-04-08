<?php
header ("Content-type: image/gif"); 
include 'draw2.1.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$red = imagecolorallocate ($im, 255, 0, 0);
$green = imagecolorallocate ($im, 0, 255, 0);
$string="中文中文123";
drawer($im,$string,100,100,$green);
imagepng ($im); 
imagedestroy ($im);
?>