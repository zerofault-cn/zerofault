<?php
  header ("Content-type: image/gif");                     //http头
include 'drawstatic.php';
  $image = imagecreate (400, 300);                        // 要画画，先要有花布不是？创建一个调色板图像
  $black = imagecolorallocate ($image, 0, 0, 0);          // 默认黑色背景
  $white = imagecolorallocate ($image, 255, 255, 255);          // 默认黑色背景
$string="1234中文";
drawer($image,$string,10,10,$white);
  imagepng ($image);                                      // 以png格式输出
                                                          // 也可以用imagejpeg($im);
                                                          // 或imagegif($im);
                                                          // 但后者，如果GD版本高于1.6，就不能用了。
  imagedestroy ($image);                                  // 结束，清楚所有占用的内存资源
?>