<?php
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$time_start = getmicrotime();

include 'draw1.0.inc.php';
header ("Content-type: image/gif");                       //httpͷ
$im = imagecreate (400, 300);                         // Ҫ��������Ҫ�л������ǣ�����һ����ɫ��ͼ��
$black = imagecolorallocate ($im, 0, 0, 0);           // Ĭ�Ϻ�ɫ����
$string="����";                                       // Ҫ���Ƶĺ���
drawer($im,$string);                                  // ��$im�ϻ����ַ���$string
imagepng ($im);                                       // ��png��ʽ���
imagedestroy ($im); 

$time_end = getmicrotime();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds";

?>
