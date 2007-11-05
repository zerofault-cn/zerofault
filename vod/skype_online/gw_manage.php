<html>
<head>
<title>网关信息</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard 网络名片 电子名片 语音留言 自动答录 电子名片">
</head>
<body background="image/minibg.gif" style="background-position: center;background-repeat: no-repeat;background-attachment: fixed">
<center>
<table border=1 cellpadding=1 cellspacing=0 bgcolor=#b3cde4 bordercolor=#d5e4FF>
<tr bgcolor=white>
	<td colspan=9 align=center>网关信息管理&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$PHP_SELF?>">刷新</a></td>
</tr>
<tr>
	<td>ID</td>
	<td>EPN</td>
	<td align=center>组(按Ctrl复选)</td>
	<td>名称</td>
	<td>Skype</td>
	<td>分机号</td>
	<td>SkypeOut</td>
	<td>状态</td>
	<td align=center>操作</td>
</tr>
<?
include_once "mysql_connect.php";
if($action=='update')
{
	$gw_id=$HTTP_POST_VARS['gw_id'];
	$gw_name=$HTTP_POST_VARS['gw_name'];
	$gw_skype=$HTTP_POST_VARS['gw_skype'];
	$gw_ext=$HTTP_POST_VARS['gw_ext'];
	$skypeout=$HTTP_POST_VARS['skypeout'];
	$sql11="update user_info set user_name='".$gw_name."',user_skype='".$gw_skype."',skycall_ext='".$gw_ext."',skypeout='".$skypeout."' where user_id='".$gw_id."'";
	if(mysql_query($sql11))
	{
		for($i=0;$i<sizeof($gw_group);$i++)
		{
			if(''!=$gw_group[$i])
			{
				$sql12="select * from group_member where group_id='".$gw_group[$i]."' and user_id='".$gw_id."'";
				if(!mysql_fetch_array(mysql_query($sql12)))
				{
					$sql13="insert into group_member (group_id,user_id) values('".$gw_group[$i]."','".$gw_id."')";
					if(mysql_query($sql13))
					{
						echo '更新成功';
					}
				}
			}
		}
		echo '更新成功';
		
	}

}


$sql22="select * from user_info where is_gw=1 order by user_account";
$result22=mysql_query($sql22);
while($r22=mysql_fetch_array($result22))
{
	$gw_id=$r22['user_id'];
	$gw_epn=$r22['user_account'];
	$gw_name=$r22['user_name'];
	$gw_skype=$r22['user_skype'];
	$gw_ext=$r22['skycall_ext'];
	$skypeout=$r22['skypeout'];
	$gw_status=$r22['user_status2'];
	$sql21="select * from group_info where is_gw=1 order by group_id";
	$result21=mysql_query($sql21);
	$group_row=mysql_num_rows($result21);
	$group_row++;
	$gw_group_str='<select name="gw_group[]" multiple=true size='.$group_row.'><option value="">不加入任何组</option>';
	while($r21=mysql_fetch_array($result21))
	{
		$gw_group_id=$r21['group_id'];
		$gw_group_epn=$r21['group_account'];
		$gw_group_name=$r21['group_name'];
		$sql23="select * from group_member where group_id='".$gw_group_id."' and user_id='".$gw_id."'";
		$result23=mysql_query($sql23);
		if(mysql_fetch_array($result23))
		{
			$select_flag=' selected';
		}
		else
		{
			$select_flag='';
		}
		$gw_group_str.='<option value='.$gw_group_id.$select_flag.'>'.$gw_group_name.'</option>';
	}
	$gw_group.='</select>';

	?>
<form action="?action=update" name=form1 method=post>
<tr bgcolor=white>
	<td><?=$gw_id?></td>
	<td><?=$gw_epn?></td>
	<td><?=$gw_group_str?></td>
	<td align=center><input type=text name=gw_name value="<?=$gw_name?>" size=12></td>
	<td><input type=text name=gw_skype value="<?=$gw_skype?>" size=12></td>
	<td><input type=text name=gw_ext value="<?=$gw_ext?>" size=12></td>
	<td align=center><input type=checkbox name=skypeout value=1 <?if($skypeout)echo 'checked'?>></td>
	<td align=center><img src="image/gw_<?=$gw_status?>.gif"></td>
	<td><input type=hidden name=gw_id value=<?=$gw_id?>><input type=submit value="提交更新"><input type=button onclick="javascript:location='?action=del&gw_id=<?=$gw_id?>';" value="删除"></td>
</tr>
</form>
	<?
}

?>
</table>
</center>
</body>
</html>
