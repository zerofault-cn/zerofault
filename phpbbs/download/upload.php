<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>�ϴ����</title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<?php
if($flag=="")
{
	?>
<form method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
<p>ע��:�ļ����ܴ���8M!<br>
<input type=hidden name=flag value=up>
�ļ�·��:<input type=file name=upfile size=50><br>
&nbsp;&nbsp;�����:<input type=text name=filename size=50><br>
&nbsp;&nbsp;&nbsp;&nbsp;����:<select name="type">
	<option>ѡ��</option>
	<option value=��������>��������</option>
	<option value=�������>�������</option>
	<option value=���Ӵʵ�>���Ӵʵ�</option>
	<option value=ý�岥��>ý�岥��</option>
	<option value=��Ļ����>��Ļ����</option>
	<option value=��������>��������</option>
	<option value=���뷨>���뷨</option>
	<option value=ͼ��ͼ��>ͼ��ͼ��</option>
	<option value=���繤��>���繤��</option>
	<option value=��ҳ����>��ҳ����</option>
	<option value=�ı��༭>�ı��༭</option>
	<option value=ϵͳ����>ϵͳ����</option>
	<option value=ϵͳ���>ϵͳ���</option>
	<option value=�������>�������</option>
	<option value=��Ϸ����>��Ϸ����</option>
	<option value=Դ����>Դ����</option></select><br>
���˵��:<textarea name=info rows=15 cols=56></textarea><br>
<INPUT TYPE="submit" name=submit value="�ϴ�">
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
	$upflag1=copy($upfile,"$updir/$upfile_name");//�����ļ���musicĿ¼��
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
		���ݿ����Ѿ�������ͬ·��!
		<button onclick="javascript:history.go(-1)">����</button>
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
			echo "<p>�ļ�".$upfile_name."�ϴ��ɹ�!";
			echo '<button name=button1 onclick="javascript:history.go(-1);">�����ϴ�</button><br>';
		}
	}

}
?>


</body>
</html>