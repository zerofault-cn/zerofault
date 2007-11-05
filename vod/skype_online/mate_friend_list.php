<?
function listFriend()
{
	?>
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outerTable>
<tr>
	<td align=center valign=top>
	<?
	global $labelTitle,$labelCaption;
	$labelTitle='好友列表';
	$labelCaption='这里是为了方便您快速得找到您的好友';
	topBanner();
	global $user_id,$user_account,$user_avatar,$user_skype,$user_name,$user_sex,$user_from,$user_regdate,$user_lastlogin,$user_email,$user_name,$user_website,$user_qq,$user_signature,$user_status,$user_status2;
	global $HTTP_GET_VARS,$friend_id,$action,$pageitem,$offset,$row_count;
	if(!isset($HTTP_GET_VARS['offset']) || ''==$HTTP_GET_VARS['offset'])
	{
		$offset=0;
	}
	else
	{
		$offset=$HTTP_GET_VARS['offset'];
	}
	$pageitem=6;
	if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
	{
		errorMsg("您尚未登录,或连接已超时,请重新<a href='?action=login1'>登录</a>");
	}
	else
	{
		$sql1="select * from user_friend,user_info where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=user_info.user_id";
		$result1=mysql_query($sql1);
		$row_count=mysql_num_rows($result1);
		$sql2="select user_info.* from user_friend,user_info where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=user_info.user_id order by user_info.user_status desc,user_info.user_id desc limit ".$offset.",".$pageitem;
		$result2=mysql_query($sql2);
		if(0==$row_count)
		{
			errorMsg("您还没有任何好友!");
		}
		else
		{
			userListNavigation1();
			?>
			<table width="85%" border=0 cellpadding=0 cellspacing=0 class=userTable>
			<tr bgcolor="#a5bede">
				<td width="13%" align=center>头像</td>
				<td width="12%" align=center>SKYPE</td>
				<td width="15%">EPN帐号</td>
				<td width="18%">名字</td>
				<td width="7%">性别</td>
				<td width="35%">&nbsp;&nbsp;入住时间</td>
			</tr>
			<?
			while($r2=mysql_fetch_array($result2))
			{
				$user_id		=$r2['user_id'];
				$user_account	=$r2['user_account'];
				$user_name		=$r2['user_name'];
				if(''==$user_name)
				{
					$user_name	=$user_account;
				}
				$user_sex=$r2['user_sex'];
				if('0'==$user_sex || ''==$user_sex)
				{
					$user_sex	='保密';
				}
				$user_from1		=$r2['user_from1'];
				$user_from2		=$r2['user_from2'];
				$user_from3		=$r2['user_from3'];
				$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
				if('  '==$user_from || '0 0 '==$user_from)
				{
					$user_from='保密';
				}
				$user_email		=$r2['user_email'];
				$user_qq		=$r2['user_qq'];
				$user_skype		=$r2['user_skype'];
				$user_website	=$r2['user_website'];
				$user_regdate	=$r2['user_regdate'];
				$user_lastlogin	=$r2['user_lastlogin'];
				$user_avatar	=$r2['user_avatar'];
				if(''==$user_avatar)
				{
					$user_avatar='no_avatar.gif';
				}
				$user_signature	=$r2['user_signature'];
				$user_status	=$r2['user_status'];
				if(''==$user_status)
				{
					$user_status='UNKNOWN';
				}
				userTable();
			}
			?>
			</table>
			<?
			userListNavigation2();
		}
	}
	?>
	</td>
</tr>
</table>
<?
}
function userTable()
{
	global $user_id,$user_account,$user_avatar,$user_skype,$user_name,$user_sex,$user_from,$user_regdate,$user_lastlogin,$user_email,$user_name,$user_website,$user_qq,$user_signature,$user_status,$user_status2;
	$sql1="select group_info.group_id,group_info.group_name from group_info,group_member where group_info.group_id=group_member.group_id and group_member.user_id=".$user_id;
	$result1=mysql_query($sql1);
	if(mysql_num_rows($result1)!=0)
	{
		while($r=mysql_fetch_array($result1))
		{
			$group_name.='<a href="?action=viewgroup&group_id='.$r[0].'">'.$r[1].'</a>|';
		}
	}
	else
	{
		$group_name='还未加入任何组';
	}
	?>

<tr>
	<td align=center>
	<?
	if(''!=$user_avatar)
	{
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
		<a href="callto://<?=$user_skype?>"><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0 alt="呼叫 <?=$user_name?> "></a>
		<?
	}
	?>
	</td>
	<td align=center>
		<img src="image/status_icon/<?=$user_status?>.gif" alt="用户 <?=$user_name?> 的SKYPE在线状态">&nbsp;</td>
	<!-- <td><?=$user_account?>&nbsp;</td> -->
	<td><b><a href="javascript:void(0)" onclick="window.open('user_info.php?user_id=<?=$user_id?>','','width=450,height=400,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="点击查看 <?=$user_name?> 的详细资料"><?=$user_name?></b></a>&nbsp;</td>
	<td>
	<?
	if($user_sex=='男')
	{
		echo '<img src="image/male.gif" alt="帅哥">';
	}
	elseif($user_sex=='女')
	{
		echo  '<img src="image/female.gif" alt="美女">';
	}
	else
	{
		echo $user_sex;
	}
	?>
	</td>
	<!-- <td>&nbsp;<?=substr($user_regdate,0,10)?></td> -->

	<?
}
?>