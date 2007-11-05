<?
ob_start();
$site_title="SkyCall Product";
$page='eCard';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";

if(''!=$submit)
{
	saveProfile();
}
elseif(''!=$_COOKIE['cookie_user_id'])
{
	editProfile();
}
else
{
	setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
	header("location:login.php");
}
function editProfile()
{
	global $HTTP_GET_VARS,$mode,$p;
	$facesdir="./avatars";
	$sql1="select * from user_info where user_id='".$_COOKIE['cookie_user_id']."'";
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
	$user_avatar	=mysql_result($result1,0,'user_avatar');
	$user_signature	=mysql_result($result1,0,'user_signature');
	if(''==$user_avatar)
	{
		$user_avatar='no_avatar.gif';
	}
	?>
<center>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	<tr>
		<td valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/profile_logo.gif"><img src="image/profile_title.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td>
			<table width="100%" border=0 cellpadding=0 cellspacing=0 class=formtable>
			<form action="<?=$PHP_SELF?>" name=form1 id=form1 method=post ENCTYPE="multipart/form-data">
			<tr>
				<td align=right valign=top><span style="color:red">*</span>姓名：</td>
					<td><input type=text name=user_realname size=25 value="<?=$user_realname?>"><span class=smallTips>&lt;-您的真实姓名，<span style="color:red">必填</span></span></td>
			</tr>
			<tr>
				<td align=right><span style="color:red">*</span>单位：</td>
				<td><input name=user_company size=25 value="<?=$user_company?>"><span class=smallTips>&lt;-您的工作单位，<span style="color:red">必填</span></span></td>
			</tr>
			<tr>
				<td align=right>职位：</td>
				<td><input name=user_duty size=25 value="<?=$user_duty?>"><span class=smallTips>&lt;-您的职位，可不填</span></td>
			</tr>
			<tr>
				<td align=right>电话：</td>
				<td><input name=user_phone size=25 value="<?=$user_phone?>"><span class=smallTips>&lt;-您的联系电话，如果不填将不显示</span></td>
			</tr>
			<tr>
				<td align=right>传真：</td>
				<td><input name=user_fax size=25 value="<?=$user_fax?>"><span class=smallTips>&lt;-您的传真号码，如果不填将不显示</span></td>
			</tr>
			<tr>
				<td align=right>手机：</td>
				<td><input name=user_mobile size=25 value="<?=$user_mobile?>"><span class=smallTips>&lt;-您的手机号码，如果不填将不显示</span></td>
			</tr>
			<tr>
				<td align=right>地址：</td>
				<td><input name=user_address size=25 value="<?=$user_address?>"><span class=smallTips>&lt;-您的联系地址，如果不填将不显示</span></td>
			</tr>
			<tr>
				<td align=right>E_Mail：</td>
				<td><input name=user_email size=25 value="<?=$user_email?>"><span class=smallTips>&lt;-您的E_Mail，如果不填将不显示</span></td>
			</tr>
			<!-- <tr>
				<td align=right>QQ：</td>
				<td><input name=user_qq size=12 value="<?=$user_qq?>"></td>
			</tr> -->
			<tr>
				<td align=right><span style="color:red">*</span>Skype：</td>
				<td><input name=user_skype size=25 value="<?=$user_skype?>"><span class=smallTips>&lt;-您的Skype，<span style="color:red">必填</span></span></td>
			</tr>
			<!-- <tr>
				<td align=right>个人主页：</td>
				<td><input name=user_website size=25 value="<?=$user_website?>"></td>
			</tr> -->
			<tr>
				<td align=right valign=top>个人照片：</td>
				<td><img src="<?=$facesdir?>/<?=$user_avatar?>" name="icons" width=64 border=0 alt="" align=center><td>
			</tr>
			<tr>
				<td align=right valign=top>重新上传：</td>
				<td><input type=file name=user_avatar_upload size=15><br>
				(支持gif,jpg,png或bmp格式)
				</td>
			</tr>
			<tr>
				<td align=right  valign=top>个性签名：</td>
				<td><textarea name=user_signature rows=5 cols=25 wrap=hard><?=unformat($user_signature)?></textarea><br>限100汉字(200英文字符)</td>
			</tr>
			<tr>
				<td></td>
				<td><input type=hidden name=user_account value="<?=$user_account?>">
					<input type=hidden name=user_avatar_old value="<?=$user_avatar?>">
					<input type=submit name=submit value=提交修改><span style="margin-left:2em"></span><input type=reset name=reset value=重置></td>
			</tr>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td><img src="image/table_bottom_left.gif"></td>
			<td colspan=2 background="image/table_bottom.gif"></td>
			<td><img src="image/table_bottom_right.gif"></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}

function saveProfile()
{
	global $HTTP_POST_VARS;
	global $user_avatar_upload,$user_avatar_upload_name,$user_avatar_upload_size,$user_avatar_upload_type;
	$user_account	=$HTTP_POST_VARS['user_account'];
	$user_realname	=$HTTP_POST_VARS['user_realname'];
	$user_address	=$HTTP_POST_VARS['user_address'];
	$user_company	=$HTTP_POST_VARS['user_company'];
	$user_duty		=$HTTP_POST_VARS['user_duty'];
	$user_email		=$HTTP_POST_VARS['user_email'];
	$user_phone		=$HTTP_POST_VARS['user_phone'];
	$user_fax		=$HTTP_POST_VARS['user_fax'];
	$user_mobile	=$HTTP_POST_VARS['user_mobile'];
	$user_qq		=$HTTP_POST_VARS['user_qq'];
	$user_skype		=$HTTP_POST_VARS['user_skype'];
	$user_website	=$HTTP_POST_VARS['user_website'];
	$user_avatar_old=$HTTP_POST_VARS['user_avatar_old'];
	$user_signature	=$HTTP_POST_VARS['user_signature'];
	$avatarselect	=$HTTP_POST_VARS['avatarselect'];
	if(''!=$user_avatar_upload)
	{
		$avatar_file_name=date("YmdHis").strrchr($user_avatar_upload_name,".");
		if(copy($user_avatar_upload,"avatars/upload/".$avatar_file_name))
		{
			$user_avatar='upload/'.$avatar_file_name;
		}
	}
	else
	{
		$user_avatar=$user_avatar_old;
	}
	$sql2="update user_info set user_realname='".$user_realname."',user_address='".$user_address."',user_company='".$user_company."',user_duty='".$user_duty."',user_email='".$user_email."',user_phone='".$user_phone."',user_fax='".$user_fax."',user_mobile='".$user_mobile."',user_qq='".$user_qq."',user_skype='".$user_skype."',user_website='".$user_website."',user_avatar='".$user_avatar."',user_signature='".format($user_signature)."',user_update=now() where user_id=".$_COOKIE['cookie_user_id'];
	if(mysql_query($sql2))
	{
		okMsg('<br>联系资料修改成功!<br><br><a href="eCard.php?epn='.$user_account.'" target=_blank>查看eCard</a><br><br>');
	}
	else
	{
		errorMsg('<br>某些未知错误导致修改资料失败!<br><br>');
	}
}

?>
<?
include_once "footer.php";
ob_end_flush();
?>
