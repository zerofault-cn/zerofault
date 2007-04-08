<script language="javascript">
function check()
{
	
	if(window.document.add.file_type_name.value=="")
	{
		alert("您忘了输入分类名");
		document.add.file_type_name.focus();
		return false;
	}
	return true;
}

function confirmdel(file_type_id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="bt_delete_type.php?file_type_id="+file_type_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>已存在的BT分类</caption>
<tr bgcolor=white>
	<td align=center>分类名称</td>
	<td align=center>操作</td>
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
	<td align=center><input type=button onclick="window.open('bt_modify_type_name_1.php?file_type_id=<?=$r["file_type_id"]?>','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value=修改><input type=button onclick='confirmdel(<?=$r["file_type_id"]?>)' value=删除></td>
</tr>
<?
}
?>
</table>
<form action="bt_add_type_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加新的分类</caption>
<tr bgcolor=white>
	<td align=right>分类名称:</td>
	<td><input name=file_type_name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=file_type_descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
