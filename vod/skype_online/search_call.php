<html>
<head>
<title>����/ת��</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard ������Ƭ ������Ƭ �������� �Զ���¼ ������Ƭ">
</head>
<body background="image/minibg.gif" style="background-position: center;background-repeat: no-repeat;background-attachment: fixed">
<center>
<?
include_once "mysql_connect.php";
include_once "common_function.php";
if(!isset($_COOKIE['cookie_user_id']) || ''==$_COOKIE['cookie_user_id'])
{
	setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
	loginTable();
}
else
{
	$key=$HTTP_POST_VARS['key'];
	if(''!=$key)
	{
		$labelTitle='�������';
		$link='<a href='.$PHP_SELF.'>�ҵĺ����б�</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='.$PHP_SELF.'?list=user>�����û��б�</a>';
		$sql1="select count(*) from user_info where is_gw=0 and (user_name like '%".$key."%' or user_realname like '%".$key."%') and (user_status='ONLINE' or user_status='SKYPEME')";
		$online_count=mysql_result(mysql_query($sql1),0,0);//����е������û���
		$sql2="select * from user_info where is_gw=0 and (user_name like '%".$key."%' or user_realname like '%".$key."%') order by user_status desc,user_id desc";
		$result2=mysql_query($sql2);
		$row_count=mysql_num_rows($result2);//����е������û���
	}
	elseif($list=='user')
	{
		$labelTitle='�����û�';
		$link='<a href='.$PHP_SELF.'>�ҵĺ����б�</a>';
		$sql1="select count(*) from user_info where is_gw=0 and (user_status='ONLINE' or user_status='SKYPEME')";
		$online_count=mysql_result(mysql_query($sql1),0,0);//�����û���
		$sql2="select * from user_info where is_gw=0 order by user_status desc,user_id desc";
		$result2=mysql_query($sql2);
		$row_count=mysql_num_rows($result2);//�����û���
	}
	else
	{
		$labelTitle='�ҵĺ���';
		$link='<a href='.$PHP_SELF.'?list=user>�����û��б�</a>';
		$sql1="select count(*) from user_info,user_friend where user_info.is_gw=0 and user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=user_info.user_id and (user_info.user_status='ONLINE' or user_info.user_status='SKYPEME')";
		$online_count=mysql_result(mysql_query($sql1),0,0);//����������
		$sql2="select * from user_info,user_friend where user_info.is_gw=0 and user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_info.user_id=user_friend.friend_id order by user_status desc,user_friend.friend_id desc";
		$result2=mysql_query($sql2);
		$row_count=mysql_num_rows($result2);
	}
?>
<a name=top></a>
<table width="500" border=0 cellpadding=0 cellspacing=0 style="border:#7392d7 1px solid;" valign=top>
<form action="<?=$PHP_SELF?>" method=post name=form2>
<tr>
	<td height=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	���ı������أ�<select name=local_gw><option value=''>δע��������</option>
		<?
		$sql3="select * from user_info where user_id='".$_COOKIE['cookie_user_id']."'";
		$result3=mysql_query($sql3);
		$send_from=mysql_result($result3,0,'send_from');
		$local_gw=mysql_result($result3,0,'skycall_gw');
		$sql4="select * from group_info where is_gw=1 order by group_id";
		$result4=mysql_query($sql4);
		while($r4=mysql_fetch_array($result4))
		{
			$gw_group_id=$r4['group_id'];
			$gw_group_epn=$r4['group_account'];
			$gw_group_name=$r4['group_name'];
			if($gw_group_id==$local_gw)
			{
				$select_flag=' selected';
			}
			else
			{
				$select_flag=' ';
			}
			echo '<option value='.$gw_group_id.$select_flag.'>'.$gw_group_epn.'('.$gw_group_name.')</option>';
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td height=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	�������ƣ�<input type=text name=key value=<?=$key?>>&nbsp;&nbsp;<input type=submit name=submit value="����">(����ģ������)
	</td>
</tr>
</form>
</table>
<table width="500" border=0 cellpadding=0 cellspacing=0 style="border:#7392d7 1px solid;" valign=top>
<tr>
	<td colspan=3 height=3></td>
</tr>
<tr style="border-bottom:0px;">
	<td width=10 height=23 align=right><img src="image/top_blue_left.gif"></td>
	<td width="100%" background="image/top_blue_banner.gif" align=center style="background-repeat:repeat;font-size:13px;color:white;font-weight:bold"><?=$labelTitle?>(<span id=online><?=$online_count?></span>/<span id=all><?=$row_count?></span>)&nbsp;&nbsp;<a href="<?=$PHP_SELF?>">ˢ��</a></td>
	<td  width=10><img src="image/top_blue_right.gif"></td>
</tr>
<tr>
	<td colspan=3 valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=5></td>
	</tr>
	<tr class=normalTitle>
		<td></td>
		<td>�û�ͷ��</td>
		<td>�û��ǳ�</td>
		<td width=70 align=center>����״̬</td>
		<td>�ֻ�</td>
		<td width=50 align=center>������</td>
		<td width=50 align=right>ת��</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td colspan=6><hr class=dotted size="0.4"></td>
		<td></td>
	</tr>
	<?
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
		$skycall_ext	=$r2['skycall_ext'];
		$skycall_en_msg	=$r2['skycall_en_msg'];
		$skycall_msg	=$r2['skycall_msg'];
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
	<tr >
		<td width=10>
		<td width=80>
		<table border=1 cellpadding=0 cellspacing=0 bordercolor=#5077cd style="border-collapse:collapse" width=<?=$max_size?> height=<?=$max_size?>>
		<tr><td align=center><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" align=center></td></tr></table>
		</td>
		<td width=200><a href="javascript:void(0)" onclick="window.open('user_info.php?my_id=<?=$_COOKIE['cookie_user_id']?>&user_id=<?=$user_id?>','','width=500,height=430,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="����鿴 <?=$user_name?> ����ϸ����"><b>
		<?
		if(''!=$key)
		{
			echo eregi_replace($key,'<span style="color:red">'.$key.'</span>',$user_name);
		}
		else
		{
			echo $user_name;
		}
		?></b></a>
		</td>
		<td align=center>
		<a href="callto:<?=$user_skype?>"><img src="image/status_icon/<?=$user_status?>.gif"  border=0 alt="���� <?=$user_name?> " align=absmiddle></a>
		</td>
		<td><?=$skycall_ext?></td>
		<td align=center>
		<?
		if($skycall_en_msg)
		{
			?>
			<a href="javascript:void(0)" onclick="window.open('send_im.php?send_from=<?=$send_from?>&user_skype=<?=$user_skype?>','','width=400,height=300,toolbar=no,status=no,scrollbars=no,resizable=no');" title="<?=$skycall_msg?>"><img src="image/bubble_R_20x16.gif" border=0 height=22></a>
			<?
		}
		?>
		</td>
		<td align=right>
			<a style="font-size:14px;border:#5077cd 1px solid;background-color:#eee;padding:1" href="send_im.php?action=trans&user_id=<?=$user_id?>&my_id=<?=$_COOKIE['cookie_user_id']?>" target=ifm_send>ת��</a>
		</td>
		<td width=10></td>
	</tr>
	<tr>
		<td></td>
		<td colspan=6 width="90%" height=8 background="image/hr_h.gif" style="background-position: center;background-repeat:repeat-x;">
		</td>
		<td></td>
	</tr>
		<?
	}
	
	?>
	</table>
	</td>
</tr>
<tr>
	<td colspan=8 align=center>
	<?=$link?>
	</td>
</tr>
</table>

<?
}
?>
<div style="display:none"><iframe id="ifm_send" name="ifm_send" width="0" height="0" src=""></iframe></div>
</center>
</body>
</html>
