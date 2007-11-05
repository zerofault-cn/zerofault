<html>
<head>
<title>个人详细信息</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
</head>
<body bgcolor="#F4F8FF" topmargin=0>
<?
include_once "mysql_connect.php";
include_once "common_function.php";

$user_id=$HTTP_GET_VARS['user_id'];
$my_id=$HTTP_GET_VARS['my_id'];
$sql1="select * from user_info where user_id=".$user_id;
$result1=mysql_query($sql1);
$user_id		=mysql_result($result1,0,'user_id');
$user_account	=mysql_result($result1,0,'user_account');
$user_name		=mysql_result($result1,0,'user_name');
if(''==$user_name)
{
	$user_name	=$user_account;
}
$user_sex=mysql_result($result1,0,'user_sex');
if(0==$user_sex || ''==$user_sex)
{
	$user_sex	='保密';
}
$user_from1		=mysql_result($result1,0,'user_from1');
$user_from2		=mysql_result($result1,0,'user_from2');
$user_from3		=mysql_result($result1,0,'user_from3');
$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
if('  '==$user_from || '0 0 '==$user_from)
{
	$user_from='保密';
}
$user_from=str_replace('0 0 ','',str_replace('0 ','',$user_from));
$user_email		=mysql_result($result1,0,'user_email');
$user_qq		=mysql_result($result1,0,'user_qq');
$user_skype		=mysql_result($result1,0,'user_skype');
$user_website	=mysql_result($result1,0,'user_website');
$user_regdate	=mysql_result($result1,0,'user_regdate');
$user_lastlogin	=mysql_result($result1,0,'user_lastlogin');
$user_avatar	=mysql_result($result1,0,'user_avatar');
if(''==$user_avatar)
{
	$user_avatar='no_avatar.gif';
}
$user_signature	=mysql_result($result1,0,'user_signature');
$user_status	=mysql_result($result1,0,'user_status');
if(''==$user_status)
{
	$user_status='UNKNOWN';
}

$sql2="select group_info.group_id,group_info.group_name from group_info,group_member where group_info.group_id=group_member.group_id and group_member.user_id=".$user_id;
$result2=mysql_query($sql2);
if(mysql_num_rows($result2)!=0)
{
	while($r=mysql_fetch_array($result1))
	{
		$group_name.='<a href="javascript:void(0)" onclick="par_loc('.$r[0].')">'.$r[1].'</a> ';
	}
}
else
{
	$group_name='还未加入任何组';
}
if(!isset($action) || ''==$action)
{
	?>
<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 class=userTable>
<tr>
	<td width=110 align=center valign=top>
		<?
		$max_size=128;
		if(!file_exists('avatars/'.$user_avatar))
		{
			$user_avatar='no_avatar.gif';
		}
		$avatar_size=GetImageSize("avatars/".$user_avatar);
		$avatar_width=$avatar_size[0];
		$avatar_height=$avatar_size[1];
		if($avatar_width/(float)$avatar_height >=1)
		{
			if($avatar_width>$max_size)
			{
				$avatar_width=$max_size;
				$avatar_height=$max_size*$avatar_size[1]/(float)$avatar_size[0];
			}
		}
		else
		{
			if($avatar_height>$max_size)
			{
				$avatar_height=$max_size;
				$avatar_width=$max_size*$avatar_size[0]/(float)$avatar_size[1];
			}
		}
		?>
		<img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0><br>
		<a href="get_eCard.php?epn=<?=$user_account?>" title="点击打开eCard" target=_blank><img src="get_ecard_pic.php?s=<?=$user_skype?>" width=74 border=0></a><br>
		<a href="mailto:<?=$user_email?>"><img src="image/action/email1.gif" border=0 alt="发邮件给<?=$user_name?>"></a><br>
		<?
		if(strlen($user_website)>7)
		{
			?>
			<a href="<?=$user_website?>" target="_blank"><img src="image/action/www1.gif" border=0 alt="打开<?=$user_name?>的个人主页"><br>
			<?
		}
		if(''!=$user_qq)
		{
			?>
			<a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$user_qq?>&Exe=QQ&Site=im.qq.com&Menu=yes"><img src="http://wpa.qq.com/pa?p=1:<?=$user_qq?>:1" border=0></a><br>
			<?
		}
		if(''!=$user_skype && '0'!=$user_skype )
		{
			?>
			<a href="send_im.php?user_skype=<?=$user_skype?>"><img src="image/action/im1.gif" border=0></a><br>
			<a href="callto://<?=$user_skype?>"><img src="image/action/skypeme1.gif" border=0></a><br>
			<?
		}
		else
		{
			?>
			<img src="image/action/im2.gif" border=0><br>
			<img src="image/action/skypeme2.gif" border=0><br>
			<?
		}
		?>
		<!-- 服务组：<?=$group_name?> -->
	</td>
	<td width="5" height="100%" align=center>
		<table width=3 height="100%" border=0 cellpadding=0 cellspacing=0 background="image/hr-v.gif"><tr><td></td></tr></table><!-- 高度自动适应的竖直虚线 -->
	</td>
	<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0 class=content style="line-height:130%">
		<tr>
			<td colspan=2 align=center>
			</td>
		</tr>
		<tr>
			<td align=right>EPN：</td>
			<td><?=$user_account?></td>
		</tr>
		<tr>
			<td align=right>姓名：</td>
			<td><?=$user_name?></td>
		</tr>
		<tr>
			<td align=right>Skype：</td>
			<td><?=$user_skype?></td>
		</tr>
		<tr>
			<td align=right>性别：</td>
			<td><?=$user_sex?></td>
		</tr>
		<tr>
			<td align=right>来自：</td>
			<td><?=$user_from?></td>
		</tr>
		<tr>
			<td align=right>注册日期：</td>
			<td><?=$user_regdate?></td>
		</tr>
		<tr>
			<td align=right>上次登录：</td>
			<td><?=$user_lastlogin?></td>
		</tr>
		<tr>
			<td align=right valign=top>个人签名：</td>
			<td><?=$user_signature?></td>
		</tr>
		<tr>
			<td colspan=2><hr size=0.5 class=dotted></td>
		</tr>
		<tr>
			<td colspan=2 align=center>
			<?
			if(''!=$my_id)
			{
				setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
				$sql1="select * from user_friend,user_info where user_friend.user_id=".$my_id." and user_friend.friend_id=".$user_id;
				$result1=mysql_query($sql1);
				if(mysql_fetch_array($result1))
				{
					?>
					<input type=button onclick="javascript:window.location='?action=delFriend&my_id=<?=$my_id?>&user_id=<?=$user_id?>';" value="删除好友">
					<?
				}
				else
				{
					?>
					<input type=button onclick="javascript:window.location='?action=addFriend&my_id=<?=$my_id?>&user_id=<?=$user_id?>';" value="加为好友">
					<?
				}
			}
			?>&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close();" value=关闭窗口>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
	<?
}
elseif($action=='addFriend')
{
	addFriend();
}
elseif($action=='delFriend')
{
	delFriend();
}

function delFriend()
{
	global $HTTP_GET_VARS;
	$user_id=$HTTP_GET_VARS['user_id'];
	$my_id=$HTTP_GET_VARS['my_id'];
	$sql1="delete from user_friend where user_id=".$my_id." and friend_id=".$user_id;
	if(!isset($my_id) || ''==$my_id)
	{
		errorMsg2("<br>您尚未登录,或连接已超时,请重新登录<br><br><a href='javascript:window.close();'>关闭窗口</a><br><br>");
	}
	elseif(mysql_query($sql1))
	{
		okMsg2("<br>删除成功<br><br>您可以<a href='javascript:history.go(-1)'>返回</a>,或者<a href='javascript:window.close();window.opener.location.reload();'>关闭窗口</a><br><br>");
	}
	else
	{
		errorMsg2("<br>系统数据库错误!<br><br>");
	}
}

function addFriend()
{
	global $HTTP_GET_VARS;
	$user_id=$HTTP_GET_VARS['user_id'];
	$my_id=$HTTP_GET_VARS['my_id'];
	$sql1="select * from user_friend where user_id=".$my_id." and friend_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="select * from user_info where user_id=".$user_id;
	$result2=mysql_query($sql2);
	$sql3="insert into user_friend(user_id,friend_id,friend_addtime) values(".$my_id.",".$user_id.",NOW())";
	if(!isset($my_id) || ''==$my_id)
	{
		errorMsg2("<br>您尚未登录,或连接已超时,请重新登录<br><br><a href='javascript:window.close();'>关闭窗口</a><br><br>");
	}
	elseif($my_id==$user_id)
	{
		errorMsg2("<br>您不能加自己为好友!<br><br>");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg2("<br>您已经添加这个用户为好友了!<br><br>");
	}
	elseif(mysql_query($sql3))
	{
		okMsg2("<br>添加成功<br><br>您可以<a href='javascript:history.go(-1)'>返回</a>,或者<a href='javascript:window.close();window.opener.location.reload();'>关闭窗口</a><br><br>");
	}
	else
	{
		errorMsg2("<br>系统数据库错误!<br><br>");
	}
}
?>
</body>
</html>