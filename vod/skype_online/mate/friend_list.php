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
		$sql0="select * from user_friend where user_id=".$_COOKIE['cookie_user_id'];
		$result0=mysql_query($sql0);
		$row_count=mysql_num_rows($result0);
		$sql1="select * from user_friend where user_id=".$_COOKIE['cookie_user_id']." order by friend_id desc limit ".$offset.",".$pageitem;
		$result1=mysql_query($sql1);
		if(0==$row_count)
		{
			errorMsg("您还没有任何好友!");
		}
		else
		{
			userListNavigation1();
			?>
			<table width="95%" border=0 cellpadding=0 cellspacing=0 class=userTable>
			<tr bgcolor="#a5bede">
				<td width="13%" align=center>头像</td>
				<td width="12%" align=center>SKYPE</td>
				<!-- <td width="15%">EPN帐号</td> -->
				<td width="18%">名字</td>
				<td width="7%">性别</td>
				<!-- <td width="35%">&nbsp;&nbsp;入住时间</td> -->
			</tr>
			<?
			while($r1=mysql_fetch_array($result1))
			{
				$friend_id=$r1['friend_id'];
				$sql2="select * from user_info where user_id=".$friend_id;
				$result2=mysql_query($sql2);
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
?>