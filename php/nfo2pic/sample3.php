<?
// ���ΪͼƬ
// ����3
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "rorpda.nfo" );
$nfopic->nfo2pic("png","write");
echo "���Ϊ".$nfopic->config["pic_name"]."�ļ����";
?>