<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>当前目录:<?=$dir?></title>
<link rel="stylesheet" href="../main.css" type="text/css">
</head>
<script language="JavaScript" type="text/javascript">
function bbimg(o)
{
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;
	if (zoom>0) o.style.zoom=zoom+'%';return false;
}
</script>
<body>
<?php
//*****************************************************************
//此文件设计为自动换行列举图片，每行5幅
//已经修改图片表格宽度为160,希望可以缓解页面载入时消耗大量系统资源
//中文目录或文件名问题终于解决!
//*****************************************************************
if(!isset($dir)||$dir=='.')
{
	$dir='.';//初始化目录
	echo '一个文件完成所有的功能!有可能造成页面格式上的不一致!<BR><br>';
}

$handle=opendir($dir);
?>
<font size=5>当前目录:<span class=blue><?=$dir?></span><br></font>
<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">上级目录</button>
<table border=0 width=770 cellspacing=0 cellpadding=0>
<tr><td align=left>

<ol>
<table border=1 cellspacing=1 cellpadding=1 bordercolor=white wrap=auto>
<?
$i=0;
$table_width=160;
while($file=readdir($handle))
{
	if($dir!='.'&&($i-2)%5==0)
		echo '<tr>';
	if($dir!='.'&&$i!=0&&$i!=1)
		echo '<td width='.$table_width.'>';
	if(is_dir($dir.'/'.$file)&&($file!='.')&&($file!='..')&&$file!='pic_upload'&&$file!='ico'&&$file!='personal'&&$file!='yabbcn_upload')//隐藏某些目录
	{
		$subdir=$dir.'/'.$file;
		static $list_I=1;
		?>
		<li type=I value='<?=$list_I++?>'>
		<form action='<?=$PHP_SELF?>' method=get name=readdir>
		进入子目录:<span class=blue><?=$subdir?></span>
		<input type=hidden name='dir' value='<?=$subdir?>'>
		<INPUT TYPE="submit" value="进入">
		</form>
		<?
	}
	elseif(is_file($dir.'/'.$file)&&strrchr($file,'.')!='.php'&&strrchr($file,'.')!='.txt'&&$file!='Thumbs.db'&&$file!='thumbs.db'&&$file!='desktop.ini'&&$file!='Desktop.ini'&&$file!='.'&&$file!='..')//隐藏某些文件,也可设置成只显示某些后缀的文件
	{
		$filesize=filesize($dir.'/'.$file)/1024;
		$filesize=sprintf ('%.1f', $filesize);
		static $list_1=1;
		$imgsize= GetImageSize($dir.'/'.$file);
		$realsize=$imgsize[0].'×'.$imgsize[1];
		if($imgsize[0]>=$table_width)
			$width=$table_width;
		else
			$width=$imgsize[0];
		$tempdir=str_replace('+',' ',str_replace('%2F','/',urlencode($dir)));//首先url编码,然后转换特殊字符
		$tempfile=str_replace('+',' ',urlencode($file));
		?>
		<table border=0 width='<?=$table_width?>' cellspacing=0 cellpadding=0>
		<tr><td valign=top align=center><span class=blue><?=$list_1++?></span><br><?=$file?></td></tr>
		<tr><td valign=top align=center>
			<?
			if($imgsize[0]>=$table_width)
			{
				?>
				<a href='<?=$tempdir?>/<?=$tempfile?>' target=_blank>
				<img src='<?=$tempdir?>/<?=$tempfile?>' border=0 alt='在新窗口中打开原大小图片' width='<?=$width?>' onmousewheel='return bbimg(this)'></a>
				<?
			}
			else
			{
				?>
				<img src='<?=$tempdir?>/<?=$tempfile?>' border=0 alt='<?=$realsize?>' width='<?=$width?>' onmousewheel='return bbimg(this)'>
				<?
			}
			?>
			</td></tr>
		<tr><td width=<?=$table_width?>>文件大小:<?=$filesize?> KB<br>图片尺寸:<?=$realsize?></td></tr>
		</table>
		<?
	}
	if($dir!='.'&&$i!=0&&$i!=1)
		echo '</td>';
	if($dir!='.'&&($i-2)%5==4)
		echo '</tr>';
	$i++;
}
closedir($handle);
?>
</table>
<?
//其他功能
if($dir=='.')
{
	?>
	<br>
	<button name=upload  style="border:1px solid #000000; font-size:14px; background-color:#EBEADB;" onclick="javascript:window.location='pic_upload/index.php'">上传图片</button>&nbsp;&nbsp;
	<button name=upload style="border:1px solid #000000; font-size:14px; background-color:#EBEADB;" onclick="javascript:window.location='pic_upload/index.php'">查看上传图片</button>
	<br>
	<a href='/phpbbs/utilities/show_source.php'>本页源代码</a><br>
	<?
}
else
{
	?>
	<br>
	<button onclick="javascript:history.go(-1)">后退</button>
	<?
}
?>

</td></tr>
</table>
<br>
<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">上级目录</button>
<br>
</body>
</html>
