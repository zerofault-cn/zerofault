<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="../main.css" type="text/css">
</head>
<body>

<form action="readimage.php" method=post name=readdir>
��ѡ��Ŀ¼:
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
<INPUT TYPE="submit" value="����Ŀ¼">
<br><br>
<button name=upload onclick="javascript:window.location='userupload/send.php'">�ϴ�ͼƬ</button>&nbsp;&nbsp;
<button name=upload onclick="javascript:window.location='userupload/send.php'">�鿴�ϴ�ͼƬ</button>
</form>
<p>

<!-- <form method="post" action="readdir.php" enctype="multipart/form-data">
<p>�кÿ���ͼƬ,������ϴ�!<br>
<input type=file name=upfile>
<input type=hidden name=flag value=upload>
<INPUT TYPE="submit" name=submit value="�ϴ�">
</form>
<?php
if($flag=="upfile")
{
	$updir="/upload";
	$upflag=copy($upfile,"$updir/$upfile_name");
	if($upflag)
	{
		echo "<p>�ļ�$upfile_name�ϴ��ɹ�!";
	}
	else 
		echo "�ϴ�ʧ��!";
}
?>
 -->
</body>
</html>