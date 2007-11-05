<?
if(''==$group_name)
{
	?>

	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/addgroup_logo.gif"><img src="image/addgroup_title.gif"></td>
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
		  <td width="20%" align=right>位置:</td>
		  <td><?=cateNavigation($pid)?></td>
		</tr>
		<tr>
		  <td align=right><span style="color:red">*</span>组名称:</td>
		  <td><input type=text name=group_name></td>
		</tr>
		<tr>
			<td align=right>E_Mail:</td><td><input type=text name=group_email><span class=inputTips>这里必须是您的一个有效的E_mail地址</span></td>
		</tr>
		<tr>
			<td align=right><span style="color:red">*</span>简介:</td>
			<td><textarea name=group_desc rows=4 cols=30></textarea></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=hidden name=category_id value="<?=$pid?>"><input type=submit name=submit value="添加">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='category.php?pid=<?=$pid?>'" name=return value="返回"></td>
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
	$sql0="select max(group_account) from group_info";
	$group_account=mysql_result(mysql_query($sql0),0,0);
	if(''==$group_account || '0'==$group_account)
	{
		$group_account='8000280000';
	}
	$group_account++;
	$user_id=$_COOKIE['cookie_user_id'];
	$category_id=$HTTP_POST_VARS['category_id'];
	$group_name=$HTTP_POST_VARS['group_name'];
	$group_email=$HTTP_POST_VARS['group_email'];
	$group_desc=$HTTP_POST_VARS['group_desc'];
	$sql1="select * from category_info where category_pid=".$category_id;
	$result1=mysql_query($sql1);
	$sql2="select * from group_info where category_id=".$category_id." and group_name='".$group_name."'";
	$result2=mysql_query($sql2);
	$sql3="select * from group_info where group_email='".$group_email."'";
	$result3=mysql_query($sql3);
	$sql4="insert into group_info(category_id,group_account,group_name,group_email,group_creator_id,group_createdate,group_desc) values(".$category_id.",'".$group_account."','".$group_name."','".$group_email."','".$user_id."',CURDATE(),'".format($group_desc)."')";
	if(mysql_fetch_array($result1))
	{
		errorMsg2("<br>您还得往下走一层!<br><br>");
	}
	elseif(''==$group_name)
	{
		errorMsg2("<br>您忘了填组名称!<br><br>");
	}
	elseif(''!=$group_email && !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,4}$",$group_email))
	{
		errorMsg2("<br>您填写的E_Mail地址非法!<br><br>");
	}
	elseif(mysql_fetch_array($result2))
	{
		errorMsg2("<br>已经存在这个组了!<br><br>");
	}
//	elseif(mysql_fetch_array($result3))
//	{
//		errorMsg("这个E_mail地址已经有注册会员在使用,请另选一个!");
//	}
	elseif(mysql_query($sql4))
	{
		$sql5="insert into group_member(group_id,user_id) values(".mysql_insert_id().",".$user_id.")";
		if(mysql_query($sql5))
		{
			okMsg2('<br>添加成功!<br><br>您的组EPN号码是<span style="color:red">'.$group_account.'</span>,请记好此号码!<br><br><a href="'.$_SERVER['REQUEST_URI'].'">继续创建</a><br><br>');
		}
		else
		{
			errorMsg2("<br>group_member数据库错误!<br><br>");
		}
	}
	else
	{
		errorMsg2("<br>group_info数据库错误!<br><br>");
	}
}
?>
