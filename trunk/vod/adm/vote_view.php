<table border=0 cellpadding=0 cellspacing=1 width=480 bgcolor=black>
<?
include_once "../include/mysql_connect.php";
$today=date("Y-m-d");
$sql1="select * from vote_subject where id='".$subject_id."'";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$title=$r[1];
	$begin_date=$r[2];
	$end_date=$r[3];
	?>
	<caption class=style32b><?=$title?></caption>
	<tr bgcolor=white>
		<td>编号</td>
		<td>选项</td>
		<td>结果</td>
	</tr>
	<?
	$i=0;
	$sql2="select * from vote_item where subject_id='".$subject_id."' order by id";
	$result2=mysql_query($sql2);
	while($r=mysql_fetch_array($result2))
	{
		$item_id=$r[0];
		$item_title[$i]=$r[2];
		$item_count[$i]=$r[3];
		$all_count+=$item_count[$i];
		$i++;
	}
	if($all_count==0)
	{
		?>
		<tr height=30 bgcolor=white>
			<td colspan=3>暂时无人投票</td>
		</tr>
		<?
	}
	else
	{
		for($i=0; $i<count($item_title);$i++)  
		{
			//计算百分比  
			$percent[$i]=($item_count[$i]*100)/$all_count;  
			?>
			<tr height=30 bgcolor=white>
				<td width=36 align=center><?=$i?></td>
				<td width=150><?=$item_title[$i]?>(<?=$item_count[$i]?>票)</td>
				<td>
					<table border=0 cellpadding=0 cellspacing=0><tr><td bgcolor=blue width="<?=$percent[$i]*260/100?>" height=25></td><td><?=printf("%.1f", $percent[$i])?>%</td></tr></table></td>
				
			</tr>
			<?
		}
	}
}
?>
<tr bgcolor=white>
	<td></td>
	<td>总投票数：<?=$all_count?></td>
	<td align=right><a href="javascript:window.close();">【关闭窗口】</a></td>
</tr>
</table>

