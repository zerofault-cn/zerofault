<?php
  header ("Content-type: image/gif");                     //httpͷ
include 'drawstatic.php';
  $image = imagecreate (400, 300);                        // Ҫ��������Ҫ�л������ǣ�����һ����ɫ��ͼ��
  $black = imagecolorallocate ($image, 0, 0, 0);          // Ĭ�Ϻ�ɫ����
  $white = imagecolorallocate ($image, 255, 255, 255);          // Ĭ�Ϻ�ɫ����
$string="1234����";
drawer($image,$string,10,10,$white);
  imagepng ($image);                                      // ��png��ʽ���
                                                          // Ҳ������imagejpeg($im);
                                                          // ��imagegif($im);
                                                          // �����ߣ����GD�汾����1.6���Ͳ������ˡ�
  imagedestroy ($image);                                  // �������������ռ�õ��ڴ���Դ
?>