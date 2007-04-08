<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();

header ("Content-type: image/gif");
include 'drawx.inc.php';
$im = imagecreate (400, 300);
$black = imagecolorallocate ($im, 0, 0, 0);
$red = imagecolorallocate ($im, 255, 0, 0);
$blue = imagecolorallocate ($im, 0, 0, 255);
$string="中文";
drawer($im,$string,0,0,$red,8,8);//外框红色，大小是8×8
drawer($im,$string,2,2,$blue,3,3);//内部蓝色，大小是3×3
imagepng ($im);                                       // 以png格式输出
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
