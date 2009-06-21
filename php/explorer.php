<?
error_reporting("E_ALL & ~E_NOTICE");
$action=$_REQUEST['action'];
$dir=$_REQUEST['dir'];
$filepath=$_REQUEST['filepath'];//全路径文件名
switch($action)
{
	case 'del':
	{
		if($filepath!='')
		{
			unlink($filepath);
			header("location:?dir=".substr($filepath,0,strrpos($filepath,'/')));
		}
		break;
	}
	case 'ren':
		break;
	case 'edit':
	{
		header("location:file_edit.php?file=".$filepath);
		break;
	}
}
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>当前目录:<?=$dir?></title>
</head>
<script type="text/javascript" language="javascript">
function delfile(filepath)
{
	if(confirm('确定删除'+filepath+'?'))
	{
		window.location="?action=del&filepath="+filepath;
	}
	else
	{
		return;
	}
}
</script>
<body>
<center>
<?php
$dir || $dir='.';//dirname(__FILE__);
$updir=substr($dir,0,strrpos(substr($dir,0,-1),'/'));
$handle=opendir($dir.'/');
?>
<TABLE border="0" cellPadding="0" cellSpacing="1" width="760" bgcolor="black">
<tr bgcolor="white">
	<td colspan="5"><input type="button" onclick="javascript:window.location='?dir=<?=$updir?>'" value="../上级目录">
	当前目录:<?=$dir?>
	</td>
</tr>
<tr style="border:1px solid #000000; font-size:12px; background-color:#EBEADB;">
	<td>名称</td>
	<td align="right">大小</td>
	<td>修改时间</td>
	<td>类型</td>
	<td>功能</td>
</tr>
<?
while($file=readdir($handle))
{
	if(is_dir($subdir=$dir.'/'.$file) && $file!=".")//目录
	{
		?>
<tr bgcolor="white">
	<td>[<a href="?dir=<?='..'==$file?$updir:$subdir?>"><?=$file?></a>]</td>
	<td>&nbsp;</td>
	<td><?=date("Y-m-d H:i",filemtime($subdir))?></td>
	<td>文件夹</td>
	<td><a href="?action=ren&file=<?=$subdir?>">重命名</a>&nbsp;</td>
</tr>
		<?
	}
	elseif(is_file($filename=$dir.'/'.$file))//普通文件
	{
		$filesize=filesize($dir.'/'.$file)/1024;
		$filesize=sprintf ("%.1f", $filesize);
		$tempdir=str_replace('+',' ',str_replace('%2F','/',urlencode($dir)));//首先url编码,然后转换特殊字符
		$tempfile=str_replace('+',' ',urlencode($file));
		$filetype=substr($file,strrpos($file,'.')+1);
		?>
<tr bgcolor="white">
	<td>&nbsp;<a href="<?=$tempdir.'/'.$tempfile?>"><?=$file?></a></td>
	<td align="right"><?=$filesize?>KB</td>
	<td><?=date("Y-m-d H:i",filemtime(realpath($filename)))?></td>
	<td><?=$filetype?>文件</td>
	<td><a href="?action=ren&file=<?=$tempdir.'/'.$tempfile?>">重命名</a>&nbsp;<a href="#" onclick="delfile('<?=$tempdir.'/'.$tempfile?>')" >删除</a>&nbsp;<a target="editfrm" href="?action=edit&filepath=<?=$tempdir.'/'.$tempfile?>">编辑</a></td>
</tr>
		<?
	}
}
closedir($handle);
?>
</table>
</center>
</body>
</html>