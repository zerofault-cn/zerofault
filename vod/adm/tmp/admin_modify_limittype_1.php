<html>
<head>
<title>�޸�Ȩ�������Ϣ-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from dict_entry where dentry_id='".$dentry_id."'";
$result1=mysql_query($sql1);
$dtype_id		=mysql_result($result1,0,"dtype_id");
$dentry_name	=mysql_result($result1,0,"dentry_name");
$dentry_describe=mysql_result($result1,0,"dentry_describe");
$del_flag		=mysql_result($result1,0,"del_flag");
?>
<form action="admin_modify_limittype_2.php" method=post name=modify>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�޸ķ�����Ϣ</caption>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input name=dentry_id value="<?=$dentry_id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ͱ��:</td>
	<td><input name=dtype_id value="<?=$dtype_id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=dentry_name value="<?=$dentry_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ч��־:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>��Ч</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>��Ч</option></select><span class=small></span></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><input name=dentry_describe value="<?=$dentry_describe?>"></td>
</tr>

<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>