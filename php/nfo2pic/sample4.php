<?
// ���ΪͼƬ
// ����4
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "rorpda.nfo" );
$nfopic->nfo2pic("jpeg","write");
echo "���Ϊ".$nfopic->config["pic_name"]."�ļ����";
?>