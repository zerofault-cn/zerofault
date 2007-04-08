<?php
header ("Content-type: image/gif");                       //http头
include 'draw1.0.inc.php';
$im = imagecreate (400, 300);                         // 要画画，先要有花布不是？创建一个调色板图像
$black = imagecolorallocate ($im, 0, 0, 0);           // 默认黑色背景
$string="中文";                                       // 要绘制的汉字
drawer($im,$string);                                  // 在$im上绘制字符串$string
imagepng ($im);                                       // 以png格式输出
                                                      // 也可以用imagejpeg($im);
                                                      // 或imagegif($im);
                                                      // 但后者，如果GD版本高于1.6，就不能用了。
imagedestroy ($im);                                   // 结束，清除所有占用的内存资源
?>