<?php
header ("Content-type: image/gif");                       //httpͷ
include 'draw1.1.inc.php';
$im = imagecreate (400, 300);                         // Ҫ��������Ҫ�л������ǣ�����һ����ɫ��ͼ��
$black = imagecolorallocate ($im, 0, 0, 0);           // Ĭ�Ϻ�ɫ����
$string="������������1234�������";                                       // Ҫ���Ƶĺ���
drawer($im,$string);                                  // ��$im�ϻ����ַ���$string
imagepng ($im);                                       // ��png��ʽ���

imagedestroy ($im);                                   // �������������ռ�õ��ڴ���Դ
?>
�������ַ�������Ӣ�Ļ���֧��