<?
// 另存为图片
// 例子4
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "rorpda.nfo" );
$nfopic->nfo2pic("jpeg","write");
echo "另存为".$nfopic->config["pic_name"]."文件完成";
?>