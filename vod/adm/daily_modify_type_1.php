<html>
<head>
<title>�޸ĵ�Ӱ�����Ϣ-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from daily_type where id='".$id."'";
$result1=mysql_query($sql1);
$type_name	=mysql_result($result1,0,"type_name");
$type_descr	=mysql_result($result1,0,"type_descr");
$del_flag	=mysql_result($result1,0,"del_flag");
?>
<form action="daily_modify_type_2.php" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�޸ķ�����Ϣ</caption>
<tr bgcolor=white>
	<td align=right>����ID:</td>
	<td><input name=id value="<?=$id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=type_name value="<?=$type_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=type_descr cols=30 rows=4><?=$type_descr?></textarea></td>
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
		>��Ч</option></select></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>