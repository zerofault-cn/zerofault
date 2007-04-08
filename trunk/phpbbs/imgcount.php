<?php
$countdata=$_REQUEST['countdata'];
function imgcount($countdata)
{
	header("content-type:image/png");
	while(strlen($countdata)<6)
		$countdata="0".$countdata;
	$im=imagecreate(50,13);
	$bgcolor=imagecolorallocate($im,208,220,224);
	$textcolor=imagecolorallocate($im,100,100,255);
	imagecolortransparent($im,$bg);
	imagestring($im,4,0,0,$countdata,$textcolor);
	imageinterlace($im,1);
	imagepng($im);
}
imgcount($countdata);
?>