<?
include_once "../include/mysql_connect.php";
$sql1="select * from bt_file_type where file_type_id='".$file_type_id."'";
$result1=mysql_query($sql1);
$file_type_name=mysql_result($result1,0,"file_type_name");
$file_type_descr=mysql_result($result1,0,"file_type_descr");
?>
<HTML>
<HEAD>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<title>modify_file_type_name</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="javascript">
function check()
{
	
	if(window.document.add.file_type_name.value=="")
	{
		alert("���������������");
		document.add.file_type_name.focus();
		return false;
	}
	return true;
}
</script>
</HEAD>
<body >

<form action="bt_modify_type_name_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�޸�BT������</caption>
<tr bgcolor=white>
	<td align=right>�·�����:</td>
	<td><input name=file_type_name size=30 maxlength=30 value=<?=$file_type_name?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=file_type_descr cols=40 rows=4><?=$file_type_descr?></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right></td>
	<td><input type=submit value="�ύ�޸�">&nbsp;<input type=button onclick="javascript:window.close()" value="������"></td>
</tr>
</table>
<input type=hidden name=file_type_id value=<?=$file_type_id?>>
</form>
</body>
</html>
