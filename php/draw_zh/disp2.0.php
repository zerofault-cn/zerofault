<?php
header ("Content-type: image/gif"); 
include 'draw2.0.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$string="中文中文123";
drawer($im,$string,100,100);
imagepng ($im); 
imagedestroy ($im);
?>