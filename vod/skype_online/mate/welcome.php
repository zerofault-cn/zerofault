<?
function welcome()
{
	global $labelTitle;
	?>

<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outerTable>
<tr>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 class=userTable>
	<tr><td width="55%" valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td><span style="font-size:24px;color:#6394bd;">�����SKYPE��������,������������</span></td>
		</tr>
		<tr>
			<td><span style="font-size:24px;color:#6394bd;">SkypeMate</span><br>
			</td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>USBͨ���ֱ�<br></td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>USB��ͨ�绰������<br></td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>��VOIP���ع��ܵ�Skype�绰������<br></td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>�绰����<br></td>
		</tr>
		</table>
		<table cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td align=middle height=10><font color=#6394bd>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</font></td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td><hr align=left width="95%" size='0.6' noshade></td>
		</tr>
		<tr>
			<td align=center>
			<table width="95%" border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td colspan=3 align=center>
				<span style="color:#6394bd;font-size:14px;font-weight:bold">�¼����˧��&��Ů</span>
				</td>
			</tr>
			<tr>
				<td colspan=3><hr width="95%" size='0.6' noshade></td>
			</tr>
			<tr>
				<td width="50%">
				<?
				newUser('��');
				?>
				</td>
				<td width=3 height="100%">
					<table width=1 height="100%" border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td width=1 height="100%" bgcolor="#a5bede"></td>
					</tr>
					</table>
				</td>
				<td width="50%">
				<?
				newUser('Ů');
				?>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</td>
		
		<td width=5 height="100%">
			<table width=1 height="100%" border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td width=1 height="100%" bgcolor="#a5bede"></td>
			</tr>
			</table>
		</td>
		
		<td valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<?
			if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
			{
				include_once "user_login.php";
				userLogin1();
			}
			else
			{
			//	$action='listuser';
			}
			?>
			</td>
		</tr>
		<tr>
			<td align=center>
			<table border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><a href="http://www.skype.com/go/getskype"><img src="image/tom/index_down4.gif" alt="��SKYPE�ٷ���վ�������°汾" border=0></a></td>
			</tr>
			<tr>
				<td><span style="font-size:18px;font-weight:bold"><a href="setup/SkypeMate.rar">��������Skype</a></span>(�汾:1.1.0.79)</td>
			</tr>
			<tr>
				<td><a href="setup/SkypeMate.rar"><span style="font-size:18px;font-weight:bold">��������SkypeMate</a></span>(SkypeMate���)</td>
			</tr>
			<tr>
				<td>�����汾:<span style="font-size:18px;font-weight:bold"><a href="setup/skype-1.0.0.7-suse.i586.rpm">Linux</a> | <a href="setup/Skype_1.0.0.0.dmg">MacOS</a> | <a href="setup/SkypeForPocketPC.exe">Pocket PC</a></span></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align=center>
			<hr size='0.6' noshade>
			<table border=0 width="90%" cellpadding=0 cellspacing=0>
			<tr>
				<td height=32><span style="font-size:24px;color:#6394bd;">Ϊʲôʹ��SKYPE</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r2.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=28><a href="">����������</a></td>
				</tr>
				<tr>
					<td>���Ƚ���p2p��������ѽ���<span style="color:red">�ȵ绰��Ҫ����</span>�������Ի������ӳ١�����</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=middle height=8><span style="color:#6394bd">- - - - - - - - - - - - - - - - - - - - - - - -</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0  border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r3.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=28><a href="">��͸����ǽ</a></td>
				</tr>
				<tr>
					<td>��ǿ��͸�������������칤�߲����������ӵ�ʱ��tom-skype�Կ�����ʹ��</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=middle height=8><span style="color:#6394bd">- - - - - - - - - - - - - - - - - - - - - - - -</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0  border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r4.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=28><a href="">ȫ����ͨ��</a></td>
				</tr>
				<tr>
					<td>ȫ������Ŀ¼�������ֲ�ѯ���ã�����ȫ��skype�û�������������������</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=middle height=8><span style="color:#6394bd">- - - - - - - - - - - - - - - - - - - - - - - -</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0  border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r5.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=30><a href="">�������ļ�</a></td>
				</tr>
				<tr>
					<td>�Ƚ���p2p�����ṩ���٣���ȫ���ܣ������������������Ƶ��ļ�����</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=middle height=8><span style="color:#6394bd">- - - - - - - - - - - - - - - - - - - - - - - -</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0  border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r6.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=28><a href="">���ӳ���Ϣ</a></td>
				</tr>
				<tr>
					<td>skype���Ը���ȫ����ѷ������ӳٵ��ı���Ϣ����ͨ���Ӽ��׷���</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=middle height=8><span style="color:#6394bd">- - - - - - - - - - - - - - - - - - - - - - - -</span></td>
			</tr>
			<tr>
				<td>
				<table cellspacing=0 cellpadding=0  border=0>
				<tr>
					<td rowspan=2 align=middle width=80 height=75><img src="image/tom/index_r7.gif" border=0></td>
					<td rowspan=2 width=10>&nbsp;</td>
					<td height=28><a href="">��ƽ̨ʹ��</a></td>
				</tr>
				<tr>
					<td>��������windows��ƻ��ϵͳ��linuxϵͳ�ͱ�Я�豸�ϣ���ƽ̨����ͬ������</td>
				</tr>
				</table>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
<?
}

function newUser($sex)
{
	
	$sql1="select * from user_info where user_sex='".$sex."' order by user_id desc limit 0,1";
	$result1=mysql_query($sql1);
	while($r1=mysql_fetch_array($result1))
	{
		$user_id		=$r1['user_id'];
		$user_account	=$r1['user_account'];
		$user_name		=$r1['user_name'];
		if(''==$user_name)
		{
			$user_name	=$user_account;
		}
		$user_sex=$r1['user_sex'];
		if(0==$user_sex || ''==$user_sex)
		{
			$user_sex	='����';
		}
		$user_from1		=$r1['user_from1'];
		$user_from2		=$r1['user_from2'];
		$user_from3		=$r1['user_from3'];
		$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
		if('  '==$user_from || '0 0 '==$user_from)
		{
			$user_from='����';
		}
		$user_email		=$r1['user_email'];
		$user_qq		=$r1['user_qq'];
		$user_skype		=$r1['user_skype'];
		$user_website	=$r1['user_website'];
		$user_regdate	=$r1['user_regdate'];
		$user_lastlogin	=$r1['user_lastlogin'];
		$user_avatar	=$r1['user_avatar'];
		if(''==$user_avatar)
		{
			$user_avatar='flower.jpg';
		}
		$user_signature	=$r2['user_signature'];
		$user_status	=$r2['user_status'];
		if(''==$user_status)
		{
			$user_status='UNKNOWN';
		}
	}
	?>
	
	<table width="100%" border=0 cellpadding=0 cellspacing=0 class=userTable>
	<tr>
		<td width="40%" align=right>
			<?
			if(''!=$user_avatar)
			{
				$max_size=96;
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
				<img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0>
				<?
			}
			?>
		</td>
		<td width="3%">&nbsp;</td>
		<td valign=top>
			<?
			if('0'!=$user_skype && ''!=$user_skype)
			{
				echo '<img src="image/status_icon/'.$user_status.'.gif">';
			}
			else
			{
				echo '<span style="color:red;font-weight:bold">No Skype!</span>';
			}
			?>
			<a href="callto://<?=$user_skype?>"><img src="image/action/skypeme1.gif" border=0></a><br>
			<b><a href="javascript:void(0)" onclick="window.open('user_info.php?user_id=<?=$user_id?>','','width=450,height=230,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="����鿴 <?=$user_name?> ����ϸ����"><?=$user_name?></b></a><br>
			<?
			if($user_sex=='��')
			{
				echo '<img src="image/male.gif">˧��';
			}
			elseif($user_sex=='Ů')
			{
				echo '<img src="image/female.gif">��Ů';
			}
			?>
			<div style="text-indent:2em"><?=$user_signature?></div>
		</td>
	</tr>
	</table>
<?
}
?>