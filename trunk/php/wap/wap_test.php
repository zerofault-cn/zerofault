<?PHP 
Header("Content-type: image/vnd.wap.wbmp"); 
$im = ImageCreate(50, 50); 
$white = ImageColorAllocate($im,255,255,255); 
$black = ImageColorAllocate($im,0,0,0); 
ImageRectangle($im, 5, 5, 20, 20, $black); 
ImageWBMP($im);
ImageDestroy($im); 
?> 
