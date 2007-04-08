<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>当前目录:<?=$dir?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?php
//*****************************************************************
//此文件设计为将某个目录下(包括子目录)的所有mp3自动列出以供发布
//*****************************************************************
if(!isset($dir)||$dir=='.')
{
	$dir='/dpfs/bod/server15_3/mp3';//初始化目录
}
$handle=opendir($dir);
?>
<font size=5>当前目录:<span class=blue><?=$dir?></span><br></font>
<?
if(strlen($dir)>24)
{
	?>
	<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">上级目录</button>
	<?
}
?>
<table border=0 width=760 cellspacing=0 cellpadding=0>
<tr><td align=left>

<ol>
<?
$i=0;
while($file=readdir($handle))
{
	if(is_dir($dir.'/'.$file)&&($file!='.')&&($file!='..'))
	{
		$subdir=$dir.'/'.$file;
		static $list_I=1;
		?>
		<li type=1 value='<?=$list_I++?>'>
		<form action='<?=$PHP_SELF?>' method=get name=readdir>
		进入子目录:<span class=blue><?=$subdir?></span>
		<input type=hidden name='dir' value='<?=$subdir?>'>
		<INPUT TYPE="submit" value="进入">
		</form>
		<?
	}
	elseif(is_file($dir.'/'.$file))//隐藏某些文件,也可设置成只显示某些后缀的文件
	{
		$filesize=filesize($dir.'/'.$file)/1024;
		$filesize=sprintf ('%.1f', $filesize);
		static $list_1=1;
		$tempdir=str_replace('+',' ',str_replace('%2F','/',urlencode($dir)));//首先url编码,然后转换特殊字符
		$tempfile=str_replace('+',' ',urlencode($file));
//流媒体方式
		$play_path1='rtsp://'.$_SERVER["SERVER_ADDR"].':555'.str_replace('/dpfs/','/',$tempdir).'/'.$tempfile;
//http方式
		$play_path2='http://'.$_SERVER["HTTP_HOST"].str_replace('/dpfs/','/',$tempdir).'/'.$tempfile;
		$play_list1[]=$play_path1;
		$play_list2[]=$play_path2;
		?>
		<span class=blue><?=$list_1++?>:</span><?=$file?>(<?=$filesize?> KB[<a href="<?=$play_path1?>">rtsp</a>/<a href="<?=$play_path2?>">http]</a><br>
		<?
		
	}
}
closedir($handle);
?>
<?
//其他功能
if($dir!='.')
{
	?>
	<br>
	<button onclick="javascript:history.go(-1)">后退</button>
	<?
}
if(sizeof($play_list1)>0)
{
	$str_play_list1=implode('|',$play_list1);
	?>
	<button onclick="javascript:window.location='playmp3.php?str_play_list=<?=$str_play_list1?>'">RTSP方式连续播放本页歌曲</button>
	<?
}
if(sizeof($play_list2)>0)
{
	$str_play_list2=implode('|',$play_list2);
	?>
	<button onclick="javascript:window.location='playmp3.php?str_play_list=<?=$str_play_list2?>'">HTTP方式连续播放本页歌曲</button>
	<?
}
?>
</td></tr>
</table>
<br>
<?
if(strlen($dir)>24)
{
	?>
	<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">上级目录</button>
	<?
}
?>
</body>
</html>
