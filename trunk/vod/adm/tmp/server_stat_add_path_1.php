<script language="javascript">
function check()
{
	
	if(window.document.add.name.value=="")
	{
		alert("您忘了计数项目名");
		document.add.name.focus();
		return false;
	}
	return true;
}
function del(id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="server_stat_delete_path.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>统计项目名称</td>
	<td align=center>路径</td>
	<td align=center>简介</td>
	<td align=center>有效标志</td>
	<td align=center>操作</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from server_stat_path order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$path=$r["path"];
	if(strpos($path,'?'))
	{
		$tmp_path=substr($path,0,strpos($path,'?'));
	}
	else
	{
		$tmp_path=$path;
	}
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
	<td align=center><a href='index.php?content=server_stat&id=<?=$r["id"]?>'><?=$r["name"]?></a></td>
	<td><a title='<?=urldecode($path)?>'><?=$tmp_path?></a></td>	
	<td><?=$r["descr"]?></td>
	<td align=center>
	<?
	$id=$r["id"];
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
	<td align=center><input type=button onclick="window.open('','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改" disabled><input type=button onclick='del(<?=$id?>)' value='删除'></td></tr>
	<?
}
?>
<caption>系统统计项目列表<span class=small style="color:blue">(共<?=$i?>个)</span></caption>
</table>
<form action="server_stat_add_path_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>添加新的统计项目</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>项目名称:</td>
	<td><input name=name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>对应路径:</td>
	<td><input name=path size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;"></td>
</tr>
<tr  bgcolor=white>
	<td colspan=2>
	提示：<br>
	1.项目名称可以随便取.<br>
	2.路径需要填入对应页面(或内容)的url,如要统计主菜单(http://sntx.169ol.com:8088/menu_1.php)的访问量,只需要填入menu_1.php就可以了.<br>
	</td>
</tr>
</table>
</form>
