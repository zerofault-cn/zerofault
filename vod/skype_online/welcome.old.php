<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td align=center valign=top>
	<table width="90%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td>
		<img src="javascript:nextAd()" name=imgInit  border=0 style="FILTER: revealTrans(duration=1,transition=5)"><br>
		<span id=focustext></span>
		</td>
		<td class=content>
			<div class=bigTitle>SkyMate����</div>
			<div align=right class=normalTitle>��Skype������ǿ�ĺð���</div>
			<br>
			<div class=contentCaption>��Ҫ�ص㣺</div>
			<li>רΪSkype��Ƶ�һ��������¼��</li>
			<li>�����Զ���¼,�������Թ���</li>
			<li>���е绰¼������,��¼��˫��ͨ������</li>
			<li>��Ƕweb�����,�ṩ��ҳ����</li>
			<li>web�����ͬʱ��������ͨѶ��</li>
			<li>����USB�绰�ֱ�����</li>
			<li>��װ����,��ɫ���,��ѹ��������</li>
			<br>
			<br>
			<div class=contentCaption><a href="product.php#1">��ϸ����>></a></div>
			<br>
			<div class=contentCaption><a href="download.php">��������>></a></div>
		</td>
	</tr>
	</table>
	<hr class=dotted align=left width="95%" size='0.6' noshade>
	<table width="90%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td><span class=bigTitle>eCard</span><span class=normalTitle>�������������緽��ع�ͨ</span></td>
	</tr>
	<tr>
		<td class=content>
		<p><span class=tag>eCard</span>(������:�׿�)����������Ƭ���Ǳ����������ϵ�һ����Ƭ�����ȴ�ͳ����Ƭ�����㡣ֻҪ������վ��ע�ᣬȡ������<span class=tag>EPN</span>(Electronic Personal Number)���룬����ӵ����һ������ȫ����ĸ��˵�����Ƭ����ֻ��Ҫ������<span class=tag>EPN</span>������ߺ��ѣ��Ժ�һ��������ϵ��Ϣ�����䶯��ֻҪ�����ǵ���վ�ϸ���һ�����ĸ������ϼ��ɣ�����һһ֪ͨ���ĺ��ѣ����Ƕ���ͨ������֪����������ϵ��ʽ�����<a href="http://www.skype.com">Skype</a>ʹ�ã������ṩ<a href="http://www.skype.com">Skype</a>״̬��ʱ��ʾ��������Ҫ��������ѣ�֪�����������ϵ���㡣��<a href="register.php">����</a>��ʼע�ᡣ</p>
		<p>��ֻ��Ҫ����ҳ����̳��Ƕ��һ�δ��룬��δ��뽫��ʾһ��<span class=tag>eCard</span>�ձ꣬����ձ�ȿ������ӵ�����<span class=tag>eCard</span>��ͬʱ������ʾ������<a href="http://www.skype.com">Skype</a>������״̬����������ߵ�����ͼ�꣬��������<span class=tag>eCard</span>����<a href="eCard_intro.php">����</a>��ʼʹ������<span class=tag>eCard</span>��</p>
		<p>Ч����ʾ��<a href="eCard.php?epn=13123456789" title="�����eCard" target=_blank><img src="get_ecard_pic.php?s=goldsoft-zerofault" border="0" align=top></a>
		</td>
	</tr>
	</table>

	</td>
</tr>
</table>
<?
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
		if('0'==$user_sex || ''==$user_sex)
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
			$user_avatar='no_avatar.gif';
		}
		$user_signature	=$r2['user_signature'];
		$user_status	=$r1['user_status'];
		if(''==$user_status)
		{
			$user_status='UNKNOWN';
		}
	}
	?>
	
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width="40%" align=right>
			<?
			if(''!=$user_avatar)
			{
				$max_size=96;
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
				<img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0>
				<?
			}
			?>
		</td>
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