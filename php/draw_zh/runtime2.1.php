<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();


header ("Content-type: image/gif");                       //httpͷ
include 'draw2.1.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$green = imagecolorallocate ($im, 0, 255, 0);
$string="����";                                    // Ҫ���Ƶĺ���
drawer($im,$string,100,100,$green);                                  // ��$im�ϻ����ַ���$string
imagepng ($im);                                       // ��png��ʽ���
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
