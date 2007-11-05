<?
if(!isset($offset) || ''==$offset)
{
	$offset=0;
}
$col=3;
$row=4;
$pageitem=$col*$row;
if(''!=$key)
{
	if($exact==1)
	{
		$sql1="select count(*) from user_info where is_gw=0 and ".$type."='".$key."'";
		$sql2="select * from user_info where is_gw=0 and ".$type."='".$key."' order by user_status desc,user_id desc limit ".$offset.",".$pageitem;
	}
	else
	{
		$sql1="select count(*) from user_info where is_gw=0 and ".$type." like '%".$key."%'";
		$sql2="select * from user_info where is_gw=0 and ".$type." like '%".$key."%' order by user_status desc,user_id desc limit ".$offset.",".$pageitem;
	}
}
else
{
	$sql1="select count(*) from user_info where is_gw=0";
	$sql2="select * from user_info where is_gw=0 order by user_status desc,user_id desc limit ".$offset.",".$pageitem;
}
$row_count=mysql_result(mysql_query($sql1),0,0);
$result2=mysql_query($sql2);
?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/community_logo.gif"><img src="image/community_title.gif"></td>
	<td width=18><img src="image/table_top_right.gif"></td>
</tr>
<tr>
	<td rowspan=2 background="image/table_left.gif"></td>
	<td colspan=2></td>
	<td rowspan=2 background="image/table_right.gif"></td>
</tr>
<tr>
	<td>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td align=center>
		<?=userListNavigation1()?>
		<table width="99%" border=1 cellpadding=1 cellspacing=0 bgcolor=#b3cde4 bordercolor=#E5F4FF>
		<?
		$i=0;
		while($r2=mysql_fetch_array($result2))
		{
			$user_id		=$r2['user_id'];
			if($i%$col==0)
			{
				echo '<tr>';
			}
			?>
			<td width="33%" height=100 align=center valign=center>
			<?=userTable()?>
			</td>
			<?
			if($row_count<$col || $i%$col==($col-1))
			{
				echo '</tr>';
			}
			$i++;
		}
		if($i==0)
		{
			?>
		<tr>
			<td height=80 align=center bgcolor=#E5F4FF class=errormsg>
			没有找到符合您的搜索条件的用户
			</td>
		</tr>
			<?
		}
		?>
		</table>
		<?
		userListNavigation2();
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td><img src="image/table_bottom_left.gif"></td>
	<td colspan=2 background="image/table_bottom.gif"></td>
	<td><img src="image/table_bottom_right.gif"></td>
</tr>
</table>
