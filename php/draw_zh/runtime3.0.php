<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();

header ("Content-type: image/gif");                       //httpͷ
include 'draw3.0.inc.php';
$im = imagecreate (400, 300); 
$black = imagecolorallocate ($im, 0, 0, 0);
$red = imagecolorallocate ($im, 255, 0, 0);
$string="����";
drawer($im,$string,100,100,$red,1,1);
imagepng ($im);                                       // ��png��ʽ���
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
