<?
include_once "mysql_connect.php";
include_once "functions.php";

$sql2="select * from user_info where user_id=".$user_id;
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
	if(0==$user_sex || ''==$user_sex)
	{
		$user_sex	='����';
	}
	$user_from1		=$r2['user_from1'];
	$user_from2		=$r2['user_from2'];
	$user_from3		=$r2['user_from3'];
	$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
	if('  '==$user_from || '0 0 '==$user_from)
	{
		$user_from='����';
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
	userFullInfo();
}

function userFullInfo()
{
	global $mySkypeCom;
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
		$group_name='��δ�����κ���';
	}
	?>
<link rel="stylesheet" href="style.css" type="text/css">
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=userTable>
<tr>
	<td width="24%" align=center valign=top>
		<?=$user_account?>
		<br>
		<?
		if(''!=$user_avatar)
		{
			$avatar_size=GetImageSize("avatars/".$user_avatar);
			$avatar_width=$avatar_size[0];
			$avatar_height=$avatar_size[1];
			if($avatar_width/(float)$avatar_height >=1)
			{
				if($avatar_width>128)
				{
					$avatar_width=128;
					$avatar_height=128*$avatar_size[1]/(float)$avatar_size[0];
				}
			}
			else
			{
				if($avatar_height>128)
				{
					$avatar_height=128;
					$avatar_width=128*$avatar_size[0]/(float)$avatar_size[1];
				}
			}
			?>
			<img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>">
			<?
		}
		?>
		<br>
		<?
		if('0'!=$user_skype && ''!=$user_skype)
		{
		//	$status=$mySkypeCom->MyF3("get user ".$user_skype." onlinestatus");//ͨ��COM�����ȡ״̬
		//	$user_status=substr($status,strrpos($status,' ')+1);
			switch($user_status)
			{
				case "UNKNOWN":
				//	echo '<img src="image/status/offline.png">';
					echo 'δ֪';
					break;
				case "ONLINE":
					echo '<img src="image/status/online.png">';
				//	echo '����';
					break;
				case "SKYPEME":
					echo '<img src="image/status/online.png">';
				//	echo 'SKYPE ME';
					break;
				case "OFFLINE":
					echo '<img src="image/status/offline.png">';
				//	echo '������';
					break;
				case "AWAY":
					echo '<img src="image/status/away.png">';
				//	echo '�뿪';
					break;
				case "NA":
					echo '<img src="image/status/offline.png">';
				//	echo 'δ֪';
					break;
				case "DND":
					echo '<img src="image/status/dnd.png">';
				//	echo '�������';
					break;
				case "INVISIBLE":
					echo '<img src="image/status/offline.png">';
				//	echo '����';
					break;
				case "LOGGEDOUT":
					echo '<img src="image/status/offline.png">';
				//	echo '��ע��';
					break;
				case "SKYPEOUT":
					echo '<img src="image/status/offline.png">';
				//	echo '����';
					break;
				default:
					;
			}
		}
		else
		{
			echo 'No Skype!';
		}
		?>
	</td>
	<td width="40%" valign=top>
		����:<b><?=$user_name?></b><br>
		�Ա�:<b><?=$user_sex?></b><br>
		����:<b><?=$user_from?></b><br>
		ע������:<b><?=$user_regdate?></b><br>
		�ϴε�¼:<b><?=$user_lastlogin?></b><br>
		<?
		if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
		{
		//	echo '��Ϊ���� | �鿴��ϸ����';
		}
		else
		{
			echo '<a href="friend_add.php?user_id='.$user_id.'">��Ϊ����</a>';
		}
		?>
	</td>
	<td width="40%" valign=top>
		������:<?=$group_name?><br>
		<a href="mailto:<?=$user_email?>"><img src="image/action/email1.gif" border=0 alt="���ʼ���<?=$user_name?>"></a><br>
		<?
		if(strlen($user_website)>7)
		{
			?>
			<a href="<?=$user_website?>" target="_blank"><img src="image/action/www1.gif" border=0 alt="��<?=$user_name?>�ĸ�����ҳ"><br>
			<?
		}
		if(''!=$user_qq)
		{
			?>
			<a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$user_qq?>&Exe=QQ&Site=im.qq.com&Menu=yes"><img src="http://wpa.qq.com/pa?p=1:<?=$user_qq?>:1" border=0></a><br>
			<?
		}
		if(''!=$user_skype && '0'!=$user_skype && ''!=$_COOKIE['cookie_user_account'])
		{
			?>
			<a href="#"
			
onclick="window.open('send_im.php?user_skype=<?=$user_skype?>','���ͼ�ʱ��Ϣ','width=450,height=300,toolbar=no,status=no,scrollbars=auto,resizable=yes');"><img src="image/action/im1.gif" border=0></a><br>
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
		<?=$user_signature?>
	</td>
</tr>
<tr>
	<td colspan=3 align=center><a href="javascript:window.close();">�رմ���</a></td>
</tr>
</table>
	<?
}

?>