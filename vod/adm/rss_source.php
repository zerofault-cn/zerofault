<script language="javascript">
function delsource(id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="rss_delete_source.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>��Դ����</td>
	<td align=center>��Ч���</td>
	<td align=center>Ԥȡ����</td>
	<td align=center>����</td>
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
			<span style=color:blue>��Ч</span>
			<?
		}
		else
		{
			?>
			<span style=color:red>��Ч</span>
			<?
		}
		?>
		</td>
		<td align=center>
		<?
		if($prefetch==1)
		{
			?>
			<span style=color:blue>��Ҫ</span>
			<?
		}
		else
		{
			?>
			<span style=color:red>����Ҫ</span>
			<?
		}
		?>
		</td>
	<td><input type=button onclick="window.open('rss_modify_1.php?id=<?=$id?>','','width=400,height=200,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='delsource(<?=$id?>)' value='ɾ��'></td></tr>
	<?
}
?>
<caption>�Ѵ�����Դ�б�<span class=small style="color:blue">(��<?=$i?>��)</span></caption>
</table>
<?
include_once "rss_add_source_1.php";
?>