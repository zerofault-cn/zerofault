<script language="javascript">
function delsource(id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="rss_delete_source.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>序号</td>
	<td align=center>资源名称</td>
	<td align=center>有效标记</td>
	<td align=center>预取缓存</td>
	<td align=center>操作</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from rss_source order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$id=$r['id'];
	$rss_name=$r["rss_source_name"];
	$rss_url=$r["rss_source_url"];
	$del_flag=$r['del_flag'];
	$prefetch=$r['prefetch'];
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
		<td align=center><?=$i?></td>
		<td><a href="<?=$rss_url?>" target=_blank><?=$rss_name?></td>
		<td align=center>
		<?
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
		?>
		</td>
		<td align=center>
		<?
		if($prefetch==1)
		{
			?>
			<span style=color:blue>需要</span>
			<?
		}
		else
		{
			?>
			<span style=color:red>不需要</span>
			<?
		}
		?>
		</td>
	<td><input type=button onclick="window.open('rss_modify_1.php?id=<?=$id?>','','width=400,height=200,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='delsource(<?=$id?>)' value='删除'></td></tr>
	<?
}
?>
<caption>已存在资源列表<span class=small style="color:blue">(共<?=$i?>个)</span></caption>
</table>
<?
include_once "rss_add_source_1.php";
?>