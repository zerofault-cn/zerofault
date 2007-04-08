<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>上传软件</title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<?php
if($flag=="")
{
	?>
<form method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
<p>注意:文件不能大于8M!<br>
<input type=hidden name=flag value=up>
文件路径:<input type=file name=upfile size=50><br>
&nbsp;&nbsp;软件名:<input type=text name=filename size=50><br>
&nbsp;&nbsp;&nbsp;&nbsp;类型:<select name="type">
	<option>选择</option>
	<option value=服务器类>服务器类</option>
	<option value=编程语言>编程语言</option>
	<option value=电子词典>电子词典</option>
	<option value=媒体播放>媒体播放</option>
	<option value=屏幕保护>屏幕保护</option>
	<option value=驱动程序>驱动程序</option>
	<option value=输入法>输入法</option>
	<option value=图形图像>图形图像</option>
	<option value=网络工具>网络工具</option>
	<option value=网页制作>网页制作</option>
	<option value=文本编辑>文本编辑</option>
	<option value=系统测试>系统测试</option>
	<option value=系统软件>系统软件</option>
	<option value=虚拟光驱>虚拟光驱</option>
	<option value=游戏娱乐>游戏娱乐</option>
	<option value=源代码>源代码</option></select><br>
软件说明:<textarea name=info rows=15 cols=56></textarea><br>
<INPUT TYPE="submit" name=submit value="上传">
</form>
<?
}
?>	
<?php
if($flag=="up")
{
	if(!file_exists("/download/$type"))
		mkdir("/download/$type",0700);
	$updir="/download/$type";
	$upflag1=copy($upfile,"$updir/$upfile_name");//复制文件到music目录下
	$name=addslashes($filename);
	$size=filesize($upfile);
	$path="http://211.83.118.100/download/$type/$upfile_name";
	$path=addslashes($filepath);
	$info=addslashes($info);
	$time=date("Y/m/d");
	$ip=$REMOTE_ADDR;
	$db_conn=mysql_connect("localhost","root","");
	mysql_select_db("download");
	$sql1="select * from software where path='$path'";
	$sql2="insert into software(name,path,size,info,time,type,upload_ip) values('$name','$path','$size','$info','$time','$type','$ip')";
	$result1=mysql_query($sql1);
	if(mysql_num_rows($result1))
	{
		?>
		数据库中已经存在相同路径!
		<button onclick="javascript:history.go(-1)">后退</button>
		<?
	}
	else
	{
		if(!mysql_query($sql2))
		{
			echo "error:$sql2";
		}
		else
		{
			echo "<p>文件".$upfile_name."上传成功!";
			echo '<button name=button1 onclick="javascript:history.go(-1);">继续上传</button><br>';
		}
	}

}
?>


</body>
</html>