<script language="javascript">
function check()
{
	
	if(window.document.add.channel_name.value=="")
	{
		alert("您忘了输入分类名");
		document.add.channel_name.focus();
		return false;
	}
	if(window.document.add.channel_description.value=="")
	{
		alert("您忘了简介");
		document.add.channel_description.focus();
		return false;
	}
	return true;
}
function del(id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="rss_delete_channel.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>栏目名称</td>
	<td align=center>简介</td>
	<td align=center>有效标志</td>
	<td align=center>操作</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from rss_channel order by id";
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
	<td align=center><a href='index.php?content=rss_news&channel=<?=$r["id"]?>'><?=$r["channel_name"]?></a></td>
	<td><?=$r["channel_description"]?></td>
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
	<td align=center><input type=button onclick="window.open('rss_modify_channel_1.php?id=<?=$r["id"]?>','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='del(<?=$r["id"]?>)' value='删除'></td></tr>
	<?
}
?>
<caption>RSS新闻已有分类<span class=small style="color:blue">(共<?=$i?>个)</span></caption>
</table>
<form action="rss_add_channel_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>添加新的分类</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>分类名称:</td>
	<td><input name=channel_name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>简短介绍:</td>
	<td><input type=text name=channel_description size=50></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
