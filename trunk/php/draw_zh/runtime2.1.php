<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();


header ("Content-type: image/gif");                       //http头
include 'draw2.1.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$green = imagecolorallocate ($im, 0, 255, 0);
$string="中文";                                    // 要绘制的汉字
drawer($im,$string,100,100,$green);                                  // 在$im上绘制字符串$string
imagepng ($im);                                       // 以png格式输出
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
