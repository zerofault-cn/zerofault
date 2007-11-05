<link rel="stylesheet" href="style.css" type="text/css">
<?
if($action=='register2')
{
	userRegister2();
}

function userRegister1()
{
	?>

<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br>
	<table width="90%" border=0 cellpadding=2 cellspacing=0 class=innertable>
	<caption align=left>新用户快速注册<span class=inputTips>(每一项都必须输入)</span></caption>
	<form action="user_register.php" method=post name=form1  ENCTYPE="multipart/form-data">
	<tr>
		<td colspan=2 align=center>
			<table width="90%">
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;建议使用自己所熟悉的号码，如手机号码,电话号码, 生日等做为网络电话号码. 由于号码资源有限, 请不要抢注不需要的号码.<br>&nbsp;&nbsp;&nbsp;&nbsp;注册是免费的!</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="20%" align=right valign=top><span style="color:red">*</span>申请号码:</td>
		<td><select size="1" name="user_account1" onChange="changeTips()">
			<option value="13" selected>中国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(13)</option>
			<option value="83">中国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(83)</option>
			<option value="90">台湾&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(90)</option>
			<option value="91">香港.澳门(91)</option>
			<option value="10">美国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(10)</option>
			<option value="11">加拿大&nbsp;&nbsp;&nbsp;&nbsp;(11)</option>
			<option value="19">印度&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(19)</option>
			<option value="40">法国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(40)</option>
			<option value="41">英国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(41)</option>
			<option value="42">德国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(42)</option>
			<option value="44">意大利&nbsp;&nbsp;&nbsp;&nbsp;(44)</option>
			<option value="50">日本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(50)</option>
			<option value="51">韩国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(51)</option>
			<option value="70">俄罗斯&nbsp;&nbsp;&nbsp;&nbsp;(70)</option>
			<option value="439">新西兰&nbsp;&nbsp;(439)</option>
			<option value="440">新加坡&nbsp;&nbsp;(440)</option>
			<option value="441">泰国&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(441)</option>
			<option value="442">越南&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(442)</option>
			</select>
			<script language="javascript" src="tips_change.js"></script>
			<input type=text name=user_account2 size=10 maxlength=9><br><span class=inputTips>请输入<span style="color:red" id=acc3>9</span>位数字</span>,且只能填入数字0-9,例如<span id=acc1>13</span><span style="color:red" id=acc2>123456789</span>
		</td>
	</tr>
	<tr>
		<td align=right valign=top><span style="color:red">*</span>密码:</td><td><input type=password name=user_password><br><span class=inputTips>6位以上,建议使用混合密码</span></td>
	</tr>
	<tr>
		<td align=right valign=top><span style="color:red">*</span>密码确认:</td><td><input type=password name=user_repassword><br><span class=inputTips>重新输入以便确认</span></td>
	</tr>
	<tr>
		<td align=right width="18%" valign=top>名字:</td>
		<td><input type=text name=user_name size=20 value="<?=$user_name?>"><br>可以使用中文,将显示在网站页面上</td>
	</tr>
	<tr>
		<td align=right>性别:</td>
		<td><input type=radio name="user_sex" value='男'
			<?
			if($user_sex=='男')
			{
				echo ' checked';
			}
			?>
			><img src="image/male.gif">帅哥&nbsp;
			<input type=radio name="user_sex" value='女'
			<?
			if($user_sex=='女')
			{
				echo ' checked';
			}
			?>
			><img src="image/female.gif">美女
		</td>
	</tr>
	
	<tr>
		<td colspan=2>
		<?
		advTable();
		?>
		</td>
	</tr>
	<tr>
		<td align=right></td><td><input type=hidden name=action value="register2"><input type=submit value="注册">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT id=advcheck name=advshow type=checkbox value=1 onclick="showadv()"><span id=advance>显示高级用户设置选项</span></td>
	</tr>
	<SCRIPT LANGUAGE="JavaScript">
	function showadv()
	{
		if (document.form1.advshow.checked == true)
		{
			document.getElementById("adv").style.display = "";
			document.getElementById("advance").innerText="关闭高级用户设置选项";
		}
		else
		{
			document.getElementById("adv").style.display = "none";
			document.getElementById("advance").innerText="显示高级用户设置选项";
		}
	}
	</SCRIPT>
	</form>
	</table>
	<br>
	</td>
</tr>
</table>
	<?
}

function advTable()
{
	?>
	<table width="100%" border=0 cellpadding=2 cellspacing=0 id=adv style="DISPLAY: none">
	<tr>
		<td colspan=2 bgcolor=#6e94b7>填写详细资料</td>
	</tr>
	<tr>
		<td align=right>生日:</td>
		<td><select name=user_year>
			<option value='0'>-年-</option>
		<?
		for($i=1970;$i<=2004;$i++)
		{
			$user_year=substr($user_birthday,0,4);
			echo '<option value='.$i;
			if(''!=$user_year &&  0!=$user_year && $i==$user_year)
				echo ' selected';
			echo '>'.$i.'</option>';
		}
		?></select>年 
		<select name=user_month>
		<option value='0'>月</option>
		<?
		for($i=1;$i<=12;$i++)
		{
			$user_month=substr($user_birthday,5,2);
			echo '<option value='.$i;
			if(''!=$user_month &&  0!=$user_month && $i==$user_month)
				echo ' selected';
			echo '>'.$i.'</option>';
		}
		?>
		</select>月
		<select name=user_day>
		<option value='0'>日</option>
		<?
		for($i=1;$i<=31;$i++)
		{
			$user_day=substr($user_birthday,8,2);
			echo '<option value='.$i;
			if(''!=$user_day &&  0!=$user_day && $i==$user_day)
				echo ' selected';
			echo '>'.$i.'</option>';
		}
		?>
		</select>日
		</td>
	</tr>
	<tr>
		<td align=right>国家:</td>
		<td><select name="user_from1" id="user_from1" onchange="countrychange(form1.user_from1.value)">
			<option selected="selected" value="0">请选择</option>
			<option value="中国">中国</option>
			<option value="中国其他">中国其他</option>
			<option value="其他国家">其他国家</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>省/直辖市:</td>
		<td><select name=user_from2>
			<option selected="selected" value="0">请选择</option>
			</select>
<script language="javascript" src="country_change.js"></script>
<script language="JavaScript">
var from1 = '<?=$user_from1?>';
var from2 = '<?=$user_from2?>';
if(from1 != '' && from2 != '')
{
	for(var i=0;i<document.all.user_from1.length;i++)
	{
		if(document.all.user_from1.options[i].text == from1)
		{
			document.all.user_from1.options[i].selected = true;
			break;
		}
	}
	countrychange(document.all.user_from1.options[i].value);
	for(var i=0;i<document.all.user_from2.length;i++)
	{
		if(document.all.user_from2.options[i].value == from2)
		{
			document.all.user_from2.options[i].selected = true;
			break;
		}
	}
}
</script>
		</td>
	</tr>
	<tr>
		<td align=right>城市:</td>
		<td><input name=user_from3 size=20 value="<?=$user_from3?>"></td>
	</tr>
	<tr>
		<td align=right>E_Mail:</td><td><input type=text name=user_email><span class=inputTips>这里必须是您的一个有效的E_mail地址</span></td>
	</tr>
	<tr>
		<td align=right>QQ:</td>
		<td><input name=user_qq size=12 value="<?=$user_qq?>"></td>
	</tr>
	<tr>
		<td align=right>Skype:</td>
		<td><input name=user_skype size=20 value="<?=$user_skype?>"></td>
	</tr>
	<tr>
		<td align=right>个人主页:</td>
		<td><input name=user_website size=30 value="<?=$user_website?>"></td>
	</tr>
	<tr>
		<td align=right>注册日期:</td>
		<td><?=$user_regdate?></td>
	</tr>
	<tr>
		<td align=right>头像:</td>
		<td>
		<?
		if(''==$user_avatar)
		{
			$user_avatar='no_avatar.gif';
		}
		?>
		<input type=radio name="avatarselect" value="system" <?if(''==$user_avatar || (''!=$user_avatar && substr($user_avatar,0,6)!='upload'))echo ' checked ';?> onclick="javascript:document.all.user_avatar.disabled=false;javascript:document.all.user_avatar_upload.disabled=true">从系统中选择一个:<br>
<?
	$facesdir="./avatars";
	$dir = opendir($facesdir);
	$contents = array();
	while ($contents[] = readdir($dir))
	{
		;
	}
	closedir($dir);
	$images = "";
	natcasesort ($contents);
	foreach ($contents as $line)
	{
		$filename = substr($line,0,(strlen($line)-strlen(strrchr($line,'.'))));
		$extension = substr(strrchr($line,'.'), 1);
		$checked = "";
		if (strcasecmp($extension,"gif")==0 || strcasecmp($extension,"jpg")==0 || strcasecmp($extension,"jpeg")==0 || strcasecmp($extension,"png")==0 )
		{
			if ($line == 'no_avatar.gif') 
			{
				$filename ='没有头像'; 
			}
			if($line==$user_avatar)
			{
				$checked=' selected';
			}
			$filename = str_replace("_", " ", $filename);
			$images .= '<option value="'.$line.'" '.$checked.'>'.$filename.'</option>\n';
		}
	}
?>
		<select name="user_avatar" size=9 onChange="showimage()">
		<?=$images?>
		</select>
		<script language="JavaScript" type="text/javascript">
        function showimage()
		{
       		document.images.icons.src="avatars/"+document.form1.user_avatar.options[document.form1.user_avatar.selectedIndex].value;
        }
        </script>
		<img src="<?=$facesdir?>/<?=$user_avatar?>" name="icons" border=0 alt="">
		<br>
		<input type=radio name=avatarselect value=upload onclick="javascript:document.all.user_avatar.disabled=true;javascript:document.all.user_avatar_upload.disabled=false">我要自己上传:<br><input type=file name=user_avatar_upload size=20><br>
		(只能上传gif,jpg或png格式的图片)</td>
		</td>
	</tr>
	<tr>
		<td align=right valign=center>个性签名:</td>
		<td><textarea name=user_signature rows=5 cols=40><?=unformat($user_signature)?></textarea></td>
	</tr>
	</table>
	<?
}

function userRegister2()
{
	include_once "functions.php";
	include_once "mysql_connect.php";
	global $HTTP_POST_VARS;
	$user_account1=$HTTP_POST_VARS['user_account1'];
	$user_account2=$HTTP_POST_VARS['user_account2'];
	$user_account=$user_account1.$user_account2;
	$user_password=$HTTP_POST_VARS['user_password'];
	$user_repassword=$HTTP_POST_VARS['user_repassword'];
	/***********************以下变量可能为空****************************************/
	$user_name=$HTTP_POST_VARS['user_name'];
	$user_sex=$HTTP_POST_VARS['user_sex'];
	$user_year=$HTTP_POST_VARS['user_year'];
	$user_month=$HTTP_POST_VARS['user_month'];
	$user_day=$HTTP_POST_VARS['user_day'];
	$user_birthday=$user_year.'-'.$user_month.'-'.$user_day;
	$user_from1=$HTTP_POST_VARS['user_from1'];
	$user_from2=$HTTP_POST_VARS['user_from2'];
	$user_from3=$HTTP_POST_VARS['user_from3'];
	$user_email=$HTTP_POST_VARS['user_email'];
	$user_qq=$HTTP_POST_VARS['user_qq'];
	$user_skype=$HTTP_POST_VARS['user_skype'];
	$user_website=$HTTP_POST_VARS['user_website'];
	$user_avatar=$HTTP_POST_VARS['user_avatar'];
	$user_signature=$HTTP_POST_VARS['user_signature'];
	/****************************************************************/
	$sql1="select * from user_info where user_account='".$user_account."'";
	$result1=mysql_query($sql1);
	$sql2="select * from user_info where user_email='".$user_email."'";
	$result2=mysql_query($sql2);
	$sql3="insert into user_info(user_account,user_password,user_name,user_sex,user_birthday,user_from1,user_from2,user_from3,user_email,user_qq,user_skype,user_website,user_regdate,user_lastlogin,user_avatar,user_signature) values('".$user_account."',password('".$user_password."'),'".$user_name."','".$user_sex."','".$user_birthday."','".$user_from1."','".$user_from2."','".$user_from3."','".$user_email."','".$user_qq."','".$user_skype."','".$user_website."',NOW(),NOW(),'".$user_avatar."','".$user_signature."')";
	if(''==$user_account2)
	{
		errorMsg("您没有输入您的号码!");
	}
	elseif(strlen($user_account)!=11)
	{
		errorMsg("您填写的号码长度不对,前后合起来应该是<span style='color:red'>11</span>位!");
	}
	elseif(!ereg("[0-9]{11}",$user_account))
	{
		errorMsg("您不能输入除数字0-9以外的其它字符!");
	}
	elseif($user_account2=='0')
	{
		errorMsg("您不能输入全'0'作为您的号码!");
	}
//	elseif(''==$user_email)
//	{
//		errorMsg("您必须输入E_Mail地址!");
//	}
	elseif(''!=$user_email && !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,4}$",$user_email))
	{
		errorMsg("您的E_Mail地址非法");
	}
	elseif(''==$user_password)
	{
		errorMsg("您必须输入密码");
	}
	elseif(strlen($user_password)<6)
	{
		errorMsg("密码必须在6位以上");
	}
	elseif($user_password!=$user_repassword)
	{
		errorMsg("密码前后不一致");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg("这个号码已被注册,请选择新的帐号!");
	}
//	elseif(mysql_fetch_array($result2))
//	{
//		errorMsg("这个E_mail地址已经有注册会员在使用,请另选一个!");
//	}
	elseif(mysql_query($sql3))
	{
		$user_id=mysql_insert_id();
		setcookie("cookie_user_id", $user_id);
		setcookie("cookie_user_account", $user_account);
		if(''!=$user_skype)
		{
			$msg="亲爱的用户,您好,您已经在我们的网站上注册了您的Skype号码,为了让更多人了解您现在的Skype状态,同时也为了让您有机会结识更多人,请在您的Skype中添加\"goldsoft01\"为好友,并且允许该用户在联机时看到您!";
			$sql4="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('goldsoft01','".$user_skype."','".$msg."',now(),0)";
			mysql_query($sql4);
		}
		okMsg("恭喜您,注册成功!<br><br>");
	}
	else
	{
		errorMsg("未知错误或用户注册已停止！");
	}
}
?>