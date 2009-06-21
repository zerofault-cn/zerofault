<?
// 另存为图片
// 例子3
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "rorpda.nfo" );
$nfopic->nfo2pic("png","write");
echo "另存为".$nfopic->config["pic_name"]."文件完成";
?>