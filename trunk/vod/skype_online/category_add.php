<?
if(''==$category_name)
{
	?>

	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/addcate_logo.gif"><img src="image/addcate_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 class=formtable>
		<form action="<?=$_SERVER['REQUEST_URI']?>" method=post name=form1>
		<tr>
		  <td width="25%" align=right>位置:</td>
		  <td><?=cateNavigation($pid)?></td>
		</tr>
		<tr>
		  <td align=right><span style="color:red">*</span>分类名:</td>
		  <td><input type=text name=category_name></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=hidden name=pid value="<?=$pid?>"><input type=submit name=submit value="添加">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='category.php?pid=<?=$pid?>'" name=return value="返回"></td>
		</tr>
		</form>
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
}
else
{
	$pid=$HTTP_POST_VARS['pid'];
	$category_name=$HTTP_POST_VARS['category_name'];
	if(''==$category_name)
	{
		errorMsg2("<br>您应该填写分类名称!<br><br>");
	}
	else
	{
		$sql1="select * from category_info where category_pid=".$pid." and category_name='".$category_name."'";
		$result1=mysql_query($sql1);
		if(mysql_fetch_array($result1))
		{
			errorMsg2("<br>已经存在这个分类了!<br><br>");
		}
		else
		{
			$sql2="insert into category_info(category_pid,category_name) values('".$pid."','".$category_name."')";
			if(mysql_query($sql2))
			{
				okMsg2('<br>添加成功!<br><br><a href="'.$_SERVER['REQUEST_URI'].'">继续添加</a><br><br>');
			}
			else
			{
				errorMsg2("<br>未知错误或此功能已禁止！<br><br>");
			}
		}
	}
}

?>

