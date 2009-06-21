<?
// 直接显示转换后的图片
// 例子5
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "sosnav8.nfo" );
//$nfopic->nfo2pic("png","write");
$nfopic->nfo2pic("png");
//echo $nfopic->color_total;
?>