<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="../main.css" type="text/css">
</head>
<body>

<form action="readimage.php" method=post name=readdir>
请选择目录:
<select name=dir>

<?php
$handle=opendir('.');
while($dir=readdir($handle))
{
	if(is_dir($dir)&&$dir!='.'&&$dir!='..'&&$dir!='userupload'&&$dir!='personal'&&$dir!='yabbcn_upload')
		echo "<option value='".$dir."'>$dir</option>";
}
closedir($handle); 
?>
</select>
<INPUT TYPE="submit" value="进入目录">
<br><br>
<button name=upload onclick="javascript:window.location='userupload/send.php'">上传图片</button>&nbsp;&nbsp;
<button name=upload onclick="javascript:window.location='userupload/send.php'">查看上传图片</button>
</form>
<p>

<!-- <form method="post" action="readdir.php" enctype="multipart/form-data">
<p>有好看的图片,请帮我上传!<br>
<input type=file name=upfile>
<input type=hidden name=flag value=upload>
<INPUT TYPE="submit" name=submit value="上传">
</form>
<?php
if($flag=="upfile")
{
	$updir="/upload";
	$upflag=copy($upfile,"$updir/$upfile_name");
	if($upflag)
	{
		echo "<p>文件$upfile_name上传成功!";
	}
	else 
		echo "上传失败!";
}
?>
 -->
</body>
</html>