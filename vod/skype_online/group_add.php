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
		  <td width="20%" align=right>λ��:</td>
		  <td><?=cateNavigation($pid)?></td>
		</tr>
		<tr>
		  <td align=right><span style="color:red">*</span>������:</td>
		  <td><input type=text name=group_name></td>
		</tr>
		<tr>
			<td align=right>E_Mail:</td><td><input type=text name=group_email><span class=inputTips>�������������һ����Ч��E_mail��ַ</span></td>
		</tr>
		<tr>
			<td align=right><span style="color:red">*</span>���:</td>
			<td><textarea name=group_desc rows=4 cols=30></textarea></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=hidden name=category_id value="<?=$pid?>"><input type=submit name=submit value="���">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='category.php?pid=<?=$pid?>'" name=return value="����"></td>
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
		errorMsg2("<br>������������һ��!<br><br>");
	}
	elseif(''==$group_name)
	{
		errorMsg2("<br>��������������!<br><br>");
	}
	elseif(''!=$group_email && !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,4}$",$group_email))
	{
		errorMsg2("<br>����д��E_Mail��ַ�Ƿ�!<br><br>");
	}
	elseif(mysql_fetch_array($result2))
	{
		errorMsg2("<br>�Ѿ������������!<br><br>");
	}
//	elseif(mysql_fetch_array($result3))
//	{
//		errorMsg("���E_mail��ַ�Ѿ���ע���Ա��ʹ��,����ѡһ��!");
//	}
	elseif(mysql_query($sql4))
	{
		$sql5="insert into group_member(group_id,user_id) values(".mysql_insert_id().",".$user_id.")";
		if(mysql_query($sql5))
		{
			okMsg2('<br>��ӳɹ�!<br><br>������EPN������<span style="color:red">'.$group_account.'</span>,��Ǻô˺���!<br><br><a href="'.$_SERVER['REQUEST_URI'].'">��������</a><br><br>');
		}
		else
		{
			errorMsg2("<br>group_member���ݿ����!<br><br>");
		}
	}
	else
	{
		errorMsg2("<br>group_info���ݿ����!<br><br>");
	}
}
?>
