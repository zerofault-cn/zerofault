<script language="javascript">
function check()
{
	if(window.document.add.type_name.value=="")
	{
		alert("您忘了输入分类名");
		document.add.type_name.focus();
		return false;
	}
	return true;
}
function deltype(type_id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="flash_delete_type.php?id="+type_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>分类名</td>
	<td align=center>简介</td>
	<td align=center>有效标志</td>
	<td align=center>操作</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from flash_type order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	?>
	<tr bgcolor=<?=$bgcolor?>>
	<td><?=$r["type_name"]?></td>
	<td><?=$r["descr"]?></td>
	<td align=center>
	<?
	$del_flag=$r["del_flag"];
	if($del_flag==1)
	{
		$k++;
		?>
		<span style=color:blue>有效</span>
		<?
	}
	else
	{
		?>
		<span style=color:red>无效</span>
		<?
	}
	?></td>
	<td align=center><input type=button onclick="window.open('flash_modify_type_1.php?id=<?=$r["id"]?>','','width=400,height=270,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='deltype(<?=$r["id"]?>)' value='删除'></td></tr>
	<?
}
?>
<caption>已有flash分类<span class=small style="color:blue">(共<?=$i?>个)</span></caption>
</table>
<form action="flash_add_type_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>添加新的分类</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>分类名称:</td>
	<td><input name=type_name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
