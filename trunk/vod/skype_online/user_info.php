<?
$this_file='user_info.php';
include_once "mysql_connect.php";
include_once "common_function.php";
$user_id=$HTTP_GET_VARS['user_id'];
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
$max_size=126;
if(!file_exists('avatars/'.$user_avatar))
{
	$user_avatar='no_avatar.gif';
}
$avatar_size=GetImageSize("avatars/".$user_avatar);
$avatar_width=$avatar_size[0];
$avatar_height=$avatar_size[1];
if($avatar_width>=$avatar_height)
{
//	if($avatar_width>$max_size)
	{
		$avatar_width=$max_size;
		$avatar_height=$max_size*$avatar_size[1]/(float)$avatar_size[0];
	}
}
else
{
//	if($avatar_height>$max_size)
	{
		$avatar_height=$max_size;
		$avatar_width=$max_size*$avatar_size[0]/(float)$avatar_size[1];
	}
}
/*查询用户所在组*/
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
<link rel="stylesheet" href="style.css" type="text/css">
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=3 background="image/table_top.gif" valign=bottom><img src="image/user_fullinfo_logo.gif"><img src="image/user_fullinfo_title.gif"></td>
	<td width=18><img src="image/table_top_right.gif"></td>
</tr>
<tr>
	<td rowspan=2 background="image/table_left.gif"></td>
	<td colspan=3></td>
	<td rowspan=2 background="image/table_right.gif"></td>
</tr>
<tr>
	<td width=152 valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=6></td>
		<td width=142 height=140 background="image/user_avatar_bg.gif" align=center><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0></td>
		<td width=4></td>
	</tr>
	</table>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td align=center>
		<a href="javascript:void(0)" onclick="window.open('get_ecardx.php?epn=<?=$user_account?>','','width=387,height=232,toolbar=no,status=no,scrollbars=no,resizable=no');" title="点击打开eCard"><img src="get_ecard_pic.php?s=<?=$user_skype?>" border=0></a>
		</td>
	</tr>
	<tr>
		<td align=center>
		<a href="mailto:<?=$user_email?>"><img src="image/email_icon.gif" border=0 alt="发邮件给<?=$user_name?>"></a>
		</td>
	</tr>
		<?
		if(strlen($user_website)>7)
		{
			?>
	<tr>
		<td align=center>
		<a href="<?=$user_website?>" target="_blank"><img src="image/www_icon.gif" border=0 alt="打开<?=$user_name?>的个人主页">
		</td>
	</tr>
			<?
		}
		if(''!=$user_qq)
		{
			?>
	<tr>
		<td align=center>
		<a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$user_qq?>&Exe=QQ&Site=im.qq.com&Menu=yes" target=_blank><img src="image/qq_icon.gif" border=0></a>
		</td>
	</tr>
			<?
		}
		if(''!=$user_skype && '0'!=$user_skype )
		{
			?>
	<tr>
		<td align=center>
		<a href="javascript:void(0)" onclick="window.open('send_im.php?user_skype=<?=$user_skype?>','','width=400,height=300,toolbar=no,status=no,scrollbars=no,resizable=no');"><img src="image/im_icon.gif" border=0></a>
		</td>
	</tr>
	<tr>
		<td align=center>
		<a href="callto:<?=$user_skype?>"><img src="image/skypeme_icon.gif" border=0></a></td>
	</tr>
			<?
		}
		?>
	</table>
	</td>
	<td width="8" height="100%" >
		<table width=3 height="100%" border=0 cellpadding=0 cellspacing=0 background="image/hr-v.gif"><tr><td></td></tr></table><!-- 高度自动适应的竖直虚线 -->
	</td>
	<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0 class=content style="line-height:130%">
		<tr>
			<td>EPN：</td>
			<td><?=$user_account?></td>
		</tr>
		<tr>
			<td>Skype：</td>
			<td><a href="callto:<?=$user_skype?>"><?=$user_skype?></a></td>
		</tr>
		<tr>
			<td>昵称：</td>
			<td><?=$user_name?></td>
		</tr>
		<tr>
			<td>性别：</td>
			<td><?=$user_sex?></td>
		</tr>
		<tr>
			<td>来自：</td>
			<td><?=$user_from?></td>
		</tr>
		<tr>
			<td>E_Mail：</td>
			<td><a href="mailto:<?=$user_email?>"><?=$user_email?></a></td>
		</tr>
		<tr>
			<td>个人主页：</td>
			<td><a href="<?=$user_website?>" target=_blank><?=$user_website?></a></td>
		</tr>
		<tr>
			<td>注册时间：</td>
			<td><?=$user_regdate?></td>
		</tr>
		<tr>
			<td>上次登录：</td>
			<td><?=$user_lastlogin?></td>
		</tr>
		<tr>
			<td valign=top>个人签名：</td>
			<td><?=$user_signature?></td>
		</tr>
		<tr>
			<td colspan=2><hr size=0.5 class=dotted></td>
		</tr>
		<tr>
			<td colspan=2 align=center>
			<?
			if(''!=$_COOKIE['cookie_user_id'])
			{
				setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
				$sql1="select * from user_friend,user_info where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=".$user_id;
				$result1=mysql_query($sql1);
				if(mysql_fetch_array($result1))
				{
					?>
					<input type=button onclick="javascript:window.location='?p=user_info&action=delFriend&my_id=<?=$_COOKIE['cookie_user_id']?>&user_id=<?=$user_id?>';" value="删除好友">
					<?
				}
				else
				{
					?>
					<input type=button onclick="javascript:window.location='?p=user_info&action=addFriend&my_id=<?=$_COOKIE['cookie_user_id']?>&user_id=<?=$user_id?>';" value="加为好友">
					<?
				}
			}
			?>&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.history.go(-1);" value=返回>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td><img src="image/table_bottom_left.gif"></td>
	<td colspan=3 background="image/table_bottom.gif"></td>
	<td><img src="image/table_bottom_right.gif"></td>
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
		errorMsg2("<br>您尚未登录,或连接已超时,请重新登录<br><br>");
	}
	elseif(mysql_query($sql1))
	{
		okMsg2("<br>删除成功<br><br>");
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
		errorMsg2("<br>您尚未登录,或连接已超时,请重新登录<br><br>");
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
		okMsg2("<br>添加成功<br><br>");
	}
	else
	{
		errorMsg2("<br>系统数据库错误!<br><br>");
	}
}
?>
