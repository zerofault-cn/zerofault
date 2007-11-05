<?
if(!isset($offset) || ''==$offset)
{
	$offset=0;
}
$pageitem=6;
if((!isset($list) || $list=='') && $_COOKIE['cookie_agent']=='SkyMate')
{
	$list='friend';
}
if(!isset($_COOKIE['cookie_user_id']) || ''==$_COOKIE['cookie_user_id'])
{
	$list='user';
}
if($list=='user')
{
	$labelTitle='全部会员列表';
	$labelCaption='';
	$sql1="select count(*) from user_info where is_gw=0";
	$row_count=mysql_result(mysql_query($sql1),0,0);//全部会员数
	$sql11="select count(*) from user_info where is_gw=0 and (user_status='ONLINE' or user_status='SKYPEME')";
	$online_count=mysql_result(mysql_query($sql11),0,0);//在线数
	$sql2="select * from user_info where is_gw=0 order by user_status desc,user_id desc limit ".$offset.",".$pageitem;
	$result2=mysql_query($sql2);
}
elseif($list=='friend')
{
	$labelTitle='我的好友';
	$labelCaption='';
	$sql1="select count(*) from user_friend where user_id=".$_COOKIE['cookie_user_id'];
	$row_count=mysql_result(mysql_query($sql1),0,0);//全部好友数
	$sql11="select count(*) from user_info,user_friend where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=user_info.user_id and (user_info.user_status='ONLINE' or user_info.user_status='SKYPEME')";
	$online_count=mysql_result(mysql_query($sql11),0,0);//好友在线数
	$sql2="select * from user_info,user_friend where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_info.user_id=user_friend.friend_id order by user_status desc,user_friend.friend_id desc limit ".$offset.",".$pageitem;
	$result2=mysql_query($sql2);
}
?>
<table width="100%" height=300 border=0 cellpadding=0 cellspacing=0 bgcolor=#ffffff background="image/minibg.gif" style="border:#7392d7 1px solid;background-position: center;background-repeat: no-repeat;background-attachment: fixed" valign=top>
<tr>
	<td colspan=3 height=3></td>
</tr>
<tr style="border-bottom:0px;">
	<td width=10 height=23 align=right><img src="image/top_blue_left.gif"></td>
	<td width="100%" background="image/top_blue_banner.gif" align=center style="background-repeat:repeat;font-size:13px;color:white;font-weight:bold"><?=$labelTitle?>(<span id=online><?=$online_count?></span>/<span id=all><?=$row_count?></span>)</td>
	<td  width=10><img src="image/top_blue_right.gif"></td>
</tr>
<tr>
	<td colspan=3 valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=5 height=3>
	</tr>
	<?
	$online=0;
	while($r2=mysql_fetch_array($result2))
	{
		$user_id		=$r2[0];
		$user_account	=$r2['user_account'];
		$user_name		=$r2['user_name'];
		if(''==$user_name)
		{
			$user_name	=$user_account;
		}
		$user_skype		=$r2['user_skype'];
		$user_avatar	=$r2['user_avatar'];
		if(''==$user_avatar)
		{
			$user_avatar='no_avatar.gif';
		}
		$user_status	=$r2['user_status'];
		if(''==$user_status)
		{
			$user_status='UNKNOWN';
		}
		?>
	<tr>
		<td width=10>
		<td width=80>
		<?
		$max_size=32;
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
		<table border=1 cellpadding=0 cellspacing=0 bordercolor=#5077cd style="border-collapse:collapse" width=<?=$max_size?> height=<?=$max_size?>>
		<tr><td align=center><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" align=center></td></tr></table>
		</td>
		<td width=200><a href="javascript:void(0)" onclick="window.open('user_info.php?my_id=<?=$_COOKIE['cookie_user_id']?>&user_id=<?=$user_id?>','','width=500,height=430,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="点击查看 <?=$user_name?> 的详细资料"><b><?=$user_name?></b></a>
		</td>
		<td align=right>
			<a href="callto://<?=$user_skype?>"><img src="image/status_icon/<?=$user_status?>.gif"  border=0 alt="呼叫 <?=$user_name?> " align=center></a>
		</td>
		<td width=10></td>
	</tr>
	<tr>
		<td></td>
		<td colspan=3 width="90%" height=8 background="image/hr_h.gif" style="background-position: center;background-repeat:repeat-x;">
		</td>
		<td></td>
	</tr>
		<?
	}
	if(''==$user_id)
	{
		echo '<tr><td colspan=5 align=center class=text20 style="color:red">您还没有添加任何好友,请点<a href="index.php?list=user">这里</a>查找添加</td></tr>';
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td colspan=3 valign=bottom>
	<?
	userListNavigation2_2();
	?>
	</td>
</tr>
</table>

