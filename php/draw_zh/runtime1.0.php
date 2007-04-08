<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();

include 'draw1.0.inc.php';
header ("Content-type: image/gif");                       //http头
$im = imagecreate (400, 300);                         // 要画画，先要有花布不是？创建一个调色板图像
$black = imagecolorallocate ($im, 0, 0, 0);           // 默认黑色背景
$string="中文";                                       // 要绘制的汉字
drawer($im,$string);                                  // 在$im上绘制字符串$string
imagepng ($im);                                       // 以png格式输出
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
