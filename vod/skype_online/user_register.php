<?
//新的注册过程
/**************************
步骤:
1,首先要求用户注册skype,即取得他自己的skype帐号
2,通过IM向用户的skype发送验证号码,目的是为了验证skype号的有效性
3,用户收到验证码后继续注册,系统随机生成指定位数的EPN号码和密码,填入数据库,同时通过IM发送给用户,
4,用户根据此EPN和密码登录,并要求用户完善个人资料,完成注册
**************************/
session_start();

if($action=='register1')
{
	userRegister1();
}
elseif($action=='register2')
{
	userRegister2();
}
elseif($action=='register3')
{
	userRegister3();
}
else
{
?>
<center>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/login_logo.gif"><img src="image/register_title.gif"></td>
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
		<form action="register.php" method=post name=form1>
		<tr>
			<td colspan=2 class=content>
			<div align=center style="font-size:20px;color:#005177">第一步(共三步)</div>
			<p>1) 请确认您的Skype状态为“<span class=tag>Skype Me</span>”,如果您还没有Skype，请点<a href="setup/SkypeSetup-1.2.0.37.exe">这里</a>下载安装,并按软件提示注册运行。
			<br>
			<br>
			<table border=0 width="100%" cellpadding=0 cellspacing=0>
			<tr>
				<td width=42></td>
				<td width=240 valign=center align=center>"Skype Me"的状态图标<img src="image/status_icon/SKYPEME.gif"></td>
				<td><img src="image/reg_skypeme.jpg"></td>
			</tr>
			</table>
			</p>
			</td>
		</tr>
		<tr>
			<td height=16></td>
		</tr>
		<tr>
			<td>
			<p>2) 请输入您的Skype帐号：<input type=text name=user_skype>
			<table border=0 width="100%" cellpadding=0 cellspacing=0>
			<tr>
				<td width=42></td>
				<td><p>当您点击“下一步”后，系统会通过“<span class=tag>goldsoft01</span>”向您的Skype发送一条即时消息，此条消息带有一个10位数字的注册认证号码，下一步中需要您输入那个认证号码。</p></td>
			</tr>
			</table>
			</p>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=center>
			<input type=hidden name=action value="register1">
			<input type=submit name=submit value="下一步">
			&nbsp;&nbsp;<input type=button onclick="javascript:window.history.go(-1)" name=back value="返回">
			<br>
			<br>
			</td>
		</tr>
		</form>
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="image/table_bottom_left.gif"></td>
		<td colspan=2 background="image/table_bottom.gif"></td>
		<td><img src="image/table_bottom_right.gif"></td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}

function userRegister1()
{
	global $aaa,$user_skype,$randVal;
	session_register('user_skype');
	session_register('randVal');
	global $HTTP_POST_VARS;
	$user_skype=$HTTP_POST_VARS['user_skype'];
	mt_srand((double)microtime()*1000000);
	$randVal = mt_rand();
	$msg="此条消息发自www.SkyCall.cn网站，您已经完成注册过程的第一步，请复制下面的认证号码(10位)，粘贴到网站注册的页面上相应位置，继续下一步注册\r\n您这次注册的认证号码->".$randVal;
	$sql1="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('skycall.cn','".$user_skype."','".$msg."',now(),0)";
	
	if(''==$user_skype)
	{
		errorMsg('您没有填写您的skype帐号');
	}
	elseif(mysql_query($sql1))
	{
		sleep(5);
		$last_im_id=mysql_insert_id();
		$sql2="select send_flag from skype_im where id=".$last_im_id;
		$result2=mysql_result(mysql_query($sql2),0,0);
		if($result2==1)
		{
			header("location:register.php?submit=1&action=register2");
		}
		else
		{
			?>
			<script>
			if(confirm("服务器或网络异常，认证号码发送失败，请确认并重试！"))
			{
				location.reload();
			}
			else
			{
				location="register.php";
			}
			</script>
			<?
		}
	}
}

function userRegister2()
{
	?>
<center>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/login_logo.gif"><img src="image/register_title.gif"></td>
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
		<form action="register.php" method=post name=form1>
		<tr>
			<td>
			<div align=center style="font-size:20px;color:#005177">第二步(共三步)</div>
			<br>
			<div style="margin-left:4em">
			请填入您接收到的认证号码(10位)：<input type=text name=regCode><br><br>
			请查看您的Skype上来自“<span class=tag>goldsoft01</span>”的即时消息，如果10秒后还未收到，请返回重试一次。
			</div>
			</td>
		</tr>
		<tr>
			<td align=center>
			<br>
			<input type=hidden name=action value=register3><input type=submit name=submit value="下一步">
			&nbsp;&nbsp;<input type=button onclick="javascript:window.history.go(-1)" name=back value="返回">
			<br>
			<br>
			</td>
		</tr>
		</form>
		</table>
		<br>
		</td>
	</tr>
	<tr>
		<td><img src="image/table_bottom_left.gif"></td>
		<td colspan=2 background="image/table_bottom.gif"></td>
		<td><img src="image/table_bottom_right.gif"></td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}

function userRegister3()
{
	global $randVal,$user_skype;
	global $HTTP_POST_VARS;
	$regCode=$HTTP_POST_VARS['regCode'];
	$sql1="select max(user_account) from user_info where length(user_account)=5";
	$user_account=mysql_result(mysql_query($sql1),0,0);
	$user_account++;
	$user_password=randPass();
	$sql2="insert into user_info(user_account,user_password,user_name,user_sex,user_birthday,user_from1,user_from2,user_from3,user_email,user_qq,user_skype,user_website,user_regdate,user_lastlogin,user_avatar,user_signature) values('".$user_account."',password('".$user_password."'),'','0','','','','','','','".$user_skype."','',NOW(),NOW(),'no_avatar.gif','')";
	$msg="恭喜您注册成功！\r\n";
	$msg.="您此次注册绑定的Skype帐号：".$user_skype."\r\n";
	$msg.="您的 EPN号码：".$user_account."\r\n";
	$msg.="您的随机密码：".$user_password."\r\n";
	$msg.="为确保安全，建议您立即登录http://www.skycall.cn修改您的密码。\r\n";
	$sql3="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('skycall.cn','".$user_skype."','".$msg."',now(),0)";
	if($randVal!=$regCode)
	{
		errorMsg('认证号码错误');
	}
	elseif(mysql_query($sql3))
	{
		sleep(5);
		$last_im_id=mysql_insert_id();
		$sql4="select send_flag from skype_im where id=".$last_im_id;
		$result4=mysql_result(mysql_query($sql4),0,0);
		if($result4==1 && mysql_query($sql2))
		{
			$user_id=mysql_insert_id();
			setcookie("cookie_user_id", $user_id);
			setcookie("cookie_user_account", $user_account);
			okMsg('<span class=content>注册成功，您申请到的EPN号码及对应密码已经发送到您的Skype上，请注意查看。<br><br>同时您已经自动登录，建议您填写完整您的<a href="community.php?p=user_profile">个人信息</a>，您也可以立即<a href="community.php?p=modify_password">修改自己的密码</a>，并<br><br></span>');
		}
		else
		{
			errorMsg('发送注册信息失败或数据库错误！');
		}
	}
	else
	{
		erorMsg('数据库错误，或注册已被停止');
	}
	session_unset();
}


function randPass($length=6) 
{
	mt_srand((double)microtime()*1000000*getmypid());
	$charactors = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz"; 
	$string = ""; 
	while(strlen($string)<$length) 
	{ 
		$string .= substr($charactors,(mt_rand() % strlen($charactors)),1); 
	} 
	return($string); 
}
?>