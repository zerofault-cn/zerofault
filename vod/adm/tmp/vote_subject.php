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
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>����</td>
	<td align=center>��ʼ����</td>
	<td align=center>��������</td>
	<td align=center>ѡ��ʽ</td>
	<td>��Ʊ��</td>
	<td align=center>����</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from vote_subject order by id desc";
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
	$subject_id=$r['id'];
	$title=$r["title"];
	$begin_date=$r["begin_date"];
	$end_date=$r["end_date"];
	$mode=$r['mode'];
	$all_count=0;
	$sql2="select count from vote_item where subject_id='".$subject_id."' order by id";
	$result2=mysql_query($sql2);
	while($r=mysql_fetch_array($result2))
	{
		$all_count+=$r['count'];
	}	
	?>
	<tr bgcolor=<?=$bgcolor?>>
		<td align=center><?=$i?></td>
		<td><a href=# onclick="window.open('vote_view.php?subject_id=<?=$subject_id?>','','width=500,height=300,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title='�鿴��ϸͶƱ���'><?=$title?></a></td>
		<td><?=$begin_date?></td>
		<td><?=$end_date?></td>
		<td align=center>
		<?
		if($mode=='checkbox')
		{
			echo '��ѡ';
		}
		if($mode=='radio')
		{
			echo '��ѡ';
		}
		?>
		<td align=center><?=$all_count?></td>
		<td><input type=button onclick="window.open('vote_modify_1.php?subject_id=<?=$subject_id?>','','width=500,height=340,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value='�޸�'></td>
	</tr>
	<?
}
?>
<tr bgcolor=white>
	<td colspan=7 align=center><a href="?content=vote_add_1">����µ�ͶƱ����</a></td>
</tr>
<caption>����ͨͶƱ��Ŀ�������<span class=small style="color:blue">(����<?=$i?>��)</span></caption>
</table>