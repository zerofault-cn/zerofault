<?
$action=$_REQUEST['action'];
if('del'==$action)
{
	unlink($_REQUEST['file']);
	header("location:?".time());
	exit;
}
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>ͼƬĿ¼:<?=$dir?></title>
</head>
<style>
li{float:left;width:200px;height:200px;border:1px dotted #333;padding:3px;margin-left:30px;margin-bottom:10px;}
li img{width:100%;height:75%;}
</style>
<body>

<?php

$dir='.';
$handle=opendir($dir);
echo "��ǰĿ¼:$dir";
echo "<ol>";
while($file=readdir($handle))
{
	if(is_file($dir."/".$file)&&strrchr($file,".")=='.jpg')
	{
		$filesize=filesize($dir."/".$file)/1024;
		$filesize=sprintf ("%.1f", $filesize);
		static $livalue_1=1;
		echo '<li type=1 value='.$livalue_1++.'>[�ļ���:'.$file;
		echo '&nbsp;&nbsp;�ļ���С:';
		echo "$filesize KB";
		$imgfile=str_replace(" ","%20",$file);
		$imgsize = GetImageSize($dir."/".$file);
		$imgsize=str_replace("width=\"","",$imgsize[3]);
		$imgsize=str_replace("\" height=\"","��",$imgsize);
		$imgsize=str_replace("\"","",$imgsize);
		echo "&nbsp;&nbsp;ͼƬ��С:$imgsize]<br><img src=$dir/$imgfile><br /><a href='?action=del&file=".$dir."/".$file."'>ɾ��</a></li>";
		clearstatcache();
	}
}
closedir($handle);
?>

</body>
</html>