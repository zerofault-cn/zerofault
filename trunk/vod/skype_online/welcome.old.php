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
			<div class=bigTitle>SkyMate——</div>
			<div align=right class=normalTitle>让Skype功能增强的好伴侣</div>
			<br>
			<div class=contentCaption>主要特点：</div>
			<li>专为Skype设计的一款语音答录机</li>
			<li>具有自动答录,语音留言功能</li>
			<li>具有电话录音功能,能录下双方通话数据</li>
			<li>内嵌web浏览器,提供黄页功能</li>
			<li>web浏览器同时可作个人通讯薄</li>
			<li>内置USB电话手柄驱动</li>
			<li>安装简易,绿色软件,解压即可运行</li>
			<br>
			<br>
			<div class=contentCaption><a href="product.php#1">详细介绍>></a></div>
			<br>
			<div class=contentCaption><a href="download.php">立即下载>></a></div>
		</td>
	</tr>
	</table>
	<hr class=dotted align=left width="95%" size='0.6' noshade>
	<table width="90%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td><span class=bigTitle>eCard</span><span class=normalTitle>——让您与世界方便地沟通</span></td>
	</tr>
	<tr>
		<td class=content>
		<p><span class=tag>eCard</span>(中文名:易卡)，即电子名片，是保存在网络上的一种名片，它比传统的名片更方便。只要您在网站上注册，取得您的<span class=tag>EPN</span>(Electronic Personal Number)号码，您就拥有了一张漫游全世界的个人电子名片，您只需要把您的<span class=tag>EPN</span>号码告诉好友，以后一旦您的联系信息发生变动，只要在我们的网站上更新一下您的个人资料即可，不必一一通知您的好友，他们都能通过它获知您的最新联系方式；配合<a href="http://www.skype.com">Skype</a>使用，我们提供<a href="http://www.skype.com">Skype</a>状态即时显示，让马上要找你的朋友，知道现在如何联系到你。点<a href="register.php">这里</a>开始注册。</p>
		<p>您只需要在网页或论坛中嵌入一段代码，这段代码将显示一个<span class=tag>eCard</span>徽标，这个徽标既可以链接到您的<span class=tag>eCard</span>，同时它还显示出您的<a href="http://www.skype.com">Skype</a>的在线状态，如果访问者点击这个图标，将打开您的<span class=tag>eCard</span>。点<a href="eCard_intro.php">这里</a>开始使用您的<span class=tag>eCard</span>。</p>
		<p>效果演示：<a href="eCard.php?epn=13123456789" title="点击打开eCard" target=_blank><img src="get_ecard_pic.php?s=goldsoft-zerofault" border="0" align=top></a>
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
			$user_sex	='保密';
		}
		$user_from1		=$r1['user_from1'];
		$user_from2		=$r1['user_from2'];
		$user_from3		=$r1['user_from3'];
		$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
		if('  '==$user_from || '0 0 '==$user_from)
		{
			$user_from='保密';
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
			<b><a href="javascript:void(0)" onclick="window.open('user_info.php?user_id=<?=$user_id?>','','width=450,height=230,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="点击查看 <?=$user_name?> 的详细资料"><?=$user_name?></b></a><br>
			<?
			if($user_sex=='男')
			{
				echo '<img src="image/male.gif">帅哥';
			}
			elseif($user_sex=='女')
			{
				echo '<img src="image/female.gif">美女';
			}
			?>
			<div style="text-indent:2em"><?=$user_signature?></div>
		</td>
	</tr>
	</table>
<?
}
?>