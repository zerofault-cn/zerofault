<?php
header ("Content-type: image/gif");                       //httpͷ
include 'draw1.0.inc.php';
$im = imagecreate (400, 300);                         // Ҫ��������Ҫ�л������ǣ�����һ����ɫ��ͼ��
$black = imagecolorallocate ($im, 0, 0, 0);           // Ĭ�Ϻ�ɫ����
$string="����";                                       // Ҫ���Ƶĺ���
drawer($im,$string);                                  // ��$im�ϻ����ַ���$string
imagepng ($im);                                       // ��png��ʽ���
                                                      // Ҳ������imagejpeg($im);
                                                      // ��imagegif($im);
                                                      // �����ߣ����GD�汾����1.6���Ͳ������ˡ�
imagedestroy ($im);                                   // �������������ռ�õ��ڴ���Դ
?>