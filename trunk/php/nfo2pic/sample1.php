<?
// 获取 html 标签
// 例子1
include "class.NFOPiC.php";
$nfopic = new NFOPiC( "rorpda.nfo" );
$nfopic->setvar("nfo_name", "Norman.Virus.Control.v5.50.R4.Polish.WinAll-UnderPl.nfo");
$nfopic->nfo2pic("png","gentag");
echo $nfopic->image_tag;
?>