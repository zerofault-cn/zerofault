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

function confirmdel(file_type_id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="bt_delete_type.php?file_type_id="+file_type_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�Ѵ��ڵ�BT����</caption>
<tr bgcolor=white>
	<td align=center>��������</td>
	<td align=center>����</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from bt_file_type";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
?>
<tr bgcolor=white>
	<td align=center><?=$r["file_type_name"]?></td>
	<td align=center><input type=button onclick="window.open('bt_modify_type_name_1.php?file_type_id=<?=$r["file_type_id"]?>','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value=�޸�><input type=button onclick='confirmdel(<?=$r["file_type_id"]?>)' value=ɾ��></td>
</tr>
<?
}
?>
</table>
<form action="bt_add_type_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>����µķ���</caption>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=file_type_name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=file_type_descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
