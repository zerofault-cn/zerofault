<?php
header ("Content-type: image/gif");
include 'drawx.inc.php';
$im = imagecreate (400, 300);

$black = imagecolorallocate ($im, 0, 0, 0);
$white = imagecolorallocate ($im, 255, 255, 25);
$red = imagecolorallocate ($im, 255, 0, 0);
$blue = imagecolorallocate ($im, 0, 0, 255);
$green = imagecolorallocate ($im, 0, 255, 0);

$string="中文";

drawer($im,$string,0,0,$red,8,8);//外框红色，大小是8×8
drawer($im,$string,2,2,$blue,3,3);//内部蓝色，大小是3×3

imagepng ($im);
imagedestroy ($im);
?>