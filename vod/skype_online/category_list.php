<?
setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
if(!isset($pid) || ''==$pid)
{
	$pid=0;
}
$level=0;
?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/category_logo.gif"><img src="image/category_title.gif"></td>
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
		<td align=center valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=60 style="color:red">����λ��:</td>
			<td valign=top><?=catenavigation($pid)?></td>
		</tr>
		</table>
		<hr class=dotted size='0.6' noshade>
		<?
		categoryTable();
		?>
		<hr class=dotted size='0.6' noshade>
		<?
		categoryFunc();
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


<?
function categoryTable()
{
	global $pid,$level;
	$sql1="select * from category_info where category_pid=".$pid." order by category_id";
	$result1=mysql_query($sql1);
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=categoryTable>
<tr>
	<td align=center>
	<table width="90%" border=0 cellpadding=0 cellspacing=0 class=categoryTable>
	<?
	$i=0;
	if($level==0)
	{
		$subCategoryLimit=3;//Ԥȡcategroy��
	}
	else
	{
		$subCategoryLimit=0;
	}
	while($r1=mysql_fetch_array($result1))
	{
		$category_id		=$r1['category_id'];
		$category_pid		=$r1['category_pid'];
		$category_name		=$r1['category_name'];
		$sql2="select count(distinct group_info.group_id) from group_info,category_info as a,category_info as b where group_info.is_gw=0 and ((group_info.category_id=a.category_id and a.category_pid=b.category_id and b.category_pid=".$category_id.") or (group_info.category_id=a.category_id and a.category_pid=".$category_id.") or group_info.category_id=".$category_id.") order by group_createdate";//��ѯ�˷����µ�����
		$result2=mysql_query($sql2);
		$groupCount=mysql_result($result2,0,0);
		$sql3="select * from category_info where category_pid=".$category_id;//��ѯ�˷����µ��ӷ���
		$result3=mysql_query($sql3);
		$subCategoryCount=mysql_num_rows($result3);
		if($i%2==0)
		{
			echo '<tr>';
		}
		echo '<td><a href="?pid='.$category_id.'">'.$category_name.'</a> ('.$groupCount.')<br>';
		$j=0;
		while($subCategoryCount!=0 && $j<$subCategoryLimit && $r3=mysql_fetch_array($result3))
		{
			$category_id		=$r3['category_id'];
			$category_pid		=$r3['category_pid'];
			$category_name		=$r3['category_name'];
			if($j==($subCategoryLimit-1))
			{
				$category_name=substr($category_name,0,6).'...';
			}
			echo '<a href="?pid='.$category_id.'">'.$category_name.'</a>, ';
			$j++;
		}
		if($j!=0)
		{
			echo '<br>';
		}
		echo '<br></td>';
		if($i%2==1)
		{
			echo '</tr>';
		}
		$i++;
	}
	if($i==0 && $level!=3)//��ʱ��ȡ����
	{
		echo '��ʱû�з���';
	}
	if($level==3)
	{	//��ʱ��ȡgroup
		$sql4="select * from group_info where is_gw=0 and category_id=".$pid;
		$result4=mysql_query($sql4);
		$group_count=mysql_num_rows($result4);
		if($group_count==0)
		{
			echo '��ʱû�г�Ա��';
		}
		else
		{
			?>
	<tr>
		<td>
		<table width="90%" cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td width="25%" align=center>����</td>
			<td width="12%">��Ա��</td>
			<td width="25%" align=center>��������</td>
			<td>���</td>
		</tr>
			<?
			while($r4=mysql_fetch_array($result4))
			{
				$group_id=$r4['group_id'];
				$group_name=$r4['group_name'];
				$group_cdate=$r4['group_createdate'];
				$group_desc=$r4['group_desc'];
				$sql5="select count(*) from group_member where group_id=".$group_id;
				$group_mem_count=mysql_result(mysql_query($sql5),0,0);
				?>
		<tr>	
			<td colspan=4 height=1><img src="image/linepoint.gif" height=1 width="100%">
		</tr>
		<tr>
			<td valign=top><a href="group.php?cate_pid=<?=$pid?>&group_id=<?=$group_id?>"><?=$group_name?></a></td>
			<td align=center valign=top><?=$group_mem_count?></td>
			<td valign=top><?=$group_cdate?></td>
			<td valign=top><?=$group_desc?></td>
		</tr>
				<?
			}
			?>
		</table>
		</td>
	</tr>
			<?
		}
	}
	?>
	</table>
	</td>
</tr>
</table>
	<?
}

function categoryFunc()
{
	global $pid,$level;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=categoryFunc>
<tr>
	<td align=center>
	<?
	if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
	{
		setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
		echo '��û��<a href="login.php">��¼</a>,������ӷ������';
	}
	else
	{
		if($level==3)
		{
			echo '<span style="color:gray">��������</span> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="?p=group_add&pid='.$pid.'">������</a>';
		}
		else
		{
			echo '<a href="?p=category_add&pid='.$pid.'">��������</a> &nbsp;&nbsp;|&nbsp;&nbsp;<span style="color:gray">������</span>';
		}
	}
	?>
	<br><br>
	</td>
</tr>
</table>
	<?
}
?>