<?
if( (!isset($s) || ''==$s) && (!isset($epn) || ''==$epn))
{
	echo '非法引用！';
	exit;
}
include_once "mysql_connect.php";
if(''!=$epn)
{
	$sql1="select * from user_info where user_account='".$epn."'";
}
elseif(''!=$s)
{
	$sql1="select * from user_info where user_skype='".$s."'";
}
$result1=mysql_query($sql1);
$user_account	=mysql_result($result1,0,'user_account');
$user_realname	=mysql_result($result1,0,'user_realname');
$user_address	=mysql_result($result1,0,'user_address');
$user_company	=mysql_result($result1,0,'user_company');
$user_duty		=mysql_result($result1,0,'user_duty');
$user_email		=mysql_result($result1,0,'user_email');
$user_phone		=mysql_result($result1,0,'user_phone');
$user_mobile	=mysql_result($result1,0,'user_mobile');
$user_fax		=mysql_result($result1,0,'user_fax');
$user_qq		=mysql_result($result1,0,'user_qq');
$user_skype		=mysql_result($result1,0,'user_skype');
$user_website	=mysql_result($result1,0,'user_website');
$user_update	=mysql_result($result1,0,'user_update');
$user_avatar	=mysql_result($result1,0,'user_avatar');
$user_signature	=mysql_result($result1,0,'user_signature');
$user_status	=mysql_result($result1,0,'user_status');
if(''==$user_avatar)
{
	$user_avatar='no_avatar.gif';
}
if(''==$user_status)
{
	$user_status='UNKNOWN';
}

//重定义头像大小
$max_size=120;
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
<HTML>
<HEAD>
<TITLE><?=$user_realname?>的eCard</TITLE>
<meta http-equiv=content-type content="text/html; charset=gb2312">
<style>
body
{
	color:#222;
	font-size:13px;
}
td
{
	color:#222;
	font-size:12px;
	line-height:130%;
}
a:link 
{
	color:#222;
	TEXT-DECORATION: none;
	border-bottom:1px dotted;
}
a:visited 
{
	color:#222;
	TEXT-DECORATION: none;
	border-bottom:1px dotted;
}
a:active,
a:hover
{
	color:#222;
	TEXT-DECORATION:none;
	border-bottom:1px solid;
}
.company
{
	font-size:22px;
	font-family:黑体;
	border-bottom:1px red solid;
	
}
.name
{
	font-size:20px;
}
.duty
{
	font-size:16px;
}
.var
{
	font-family:Courier narrow;
	margin-left: 20px;
}
.sign
{
	margin-left:2em;
}
hr
{
	COLOR: #a5bede; 
	BACKGROUND-COLOR: transparent;
}
hr.dotted
{
	COLOR: #a5bede; 
	BACKGROUND-COLOR: transparent;
	border-style:dotted;
}

</style>
<script language="JavaScript">
function msg_send(user_skype,width,height)
{
	showMyModalDialog('send_im.php?user_skype='+user_skype, width, height);
}
function showMyModalDialog(url, width, height)
{
	showModalDialog(url, '', 'dialogWidth:' + width + 'px;dialogHeight:' + height + 'px;center:yes;status:no;scroll:no;help:no');
}
</script>
</HEAD>
<body>
<center>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign=top>
	<?
	if(''==$user_realname || ''==$user_company || ''==$user_skype)
	{
		echo '<span style="color:red">提示：此人的联系信息不完整，请尽快更新</span>';
	}
	?>
	<table width="440" border=0 cellpadding=0 cellspacing=0 bgcolor="#d9e8f7">
	<tr>
		<td height=30 colspan=3 background="image/table_BB_Top.gif"></td>
	</tr>
	<tr>
		<td width=20 rowspan=1 background="image/table_BB_Left.gif"></td>
		<td valign=top><!-- card正文 -->
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=130 align=center valign=top>
			<table width="100%" height=180 border=0 cellpadding=0 cellspacing=0><!-- 左边照片 -->
			<tr>
				<td valign=top align=center>
				<img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0>
				</td>
			</tr>
			<tr valign=bottom align=right>
				<td><!-- Skype状态： --><!-- <img src="image/status_icon/<?=$user_status?>.gif"> -->
				</td>
			</tr>
			</table>
			</td>
			<td width=270 valign=top>
			<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0><!-- 右边联系方式 -->
			<tr>
				<td class=company height=30 align=center valign=bottom><?=$user_company?></td>
			</tr>
			<tr>
				<td class=name height=40 align="center" valign=bottom><?=$user_realname?>&nbsp;&nbsp;&nbsp;&nbsp;<span class=duty><?=$user_duty?></span></td>
			</tr>
			<tr>
				<td valign=bottom class=content>
				<?
				if(''!=$user_address)
				{
					echo '<span class=var>地 址：</span>'.$user_address.'<br>';
				}
				if(''!=$user_phone)
				{
					echo '<span class=var>电 话：</span>'.$user_phone.'<br>';
				}
				if(''!=$user_fax)
				{
					echo '<span class=var>传 真：</span>'.$user_fax.'<br>';
				}
				if(''!=$user_mobile)
				{
					echo '<span class=var>手 机：</span>'.$user_mobile.'<br>';
				}
				if(''!=$user_email)
				{
					echo '<span class=var>Email：</span><a href="mailto:'.$user_email.'">'.$user_email.'</a><br>';
				}
				if(''!=$user_skype)
				{
					echo '<span class=var>Skype：</span><a href="callto:'.$user_skype.'">'.$user_skype.'</a><img src="image/status_small/'.$user_status.'.gif" align=center height=16>';
				}
				?>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</td>
		<td width=20 rowspan=1 background="image/table_BB_Right.gif"></td>
	</tr>
	<tr>
		<td height=20 colspan=3 background="image/table_BB_Bottom.gif"></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
	<hr class=dotted width="30%" align=left size="0.6">
	个人签名：<br>
	<div class=sign><?=$user_signature?></div>
	<hr class=dotted width="30%" align=left size="0.6">
	</td>
</tr>
<tr>
	<td>
	更新时间：<?=$user_update?>
	<hr class=dotted width="30%" align=left size="0.6">
	</td>
</tr>
<tr>
	<td height=60></td>
</tr>
<tr>
	<td>
	<a href="javascript:void(0)" onclick="window.open('send_im.php?user_skype=<?=$user_skype?>','','width=400,height=300,toolbar=no,status=no,scrollbars=no,resizable=no');">给<?=$user_realname?>发消息</a>&nbsp;&nbsp;<a href="callto://<?=$user_skype?>">呼叫<?=$user_realname?></a>&nbsp;&nbsp;<a href="eCard_intro.php">申请eCard</a>&nbsp;&nbsp;<a href="eCard_profile.php">个人管理</a>
	<hr width="60%" align=left size="0.6">
	POWERED BY <a href="http://www.SkyCall.cn">www.SkyCall.cn</a>
	</td>
</tr>
</table>
</BODY>
</HTML>
