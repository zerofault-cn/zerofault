<?
$this_file='user_profile.php';
if(''!=$submit)
{
	saveProfile();
}
else
{
	editProfile();
}
function editProfile()
{
	$user_id=$_COOKIE['cookie_user_id'];
	if(''==$user_id)
	{
		errorMsg2('<br>您还没有登录,或登录已超时,请<a href="login.php">重新登录</a><br><br>');
	}
	else
	{
	$sql1="select * from user_info where user_id=".$user_id;
	$result1=mysql_query($sql1);
//	$user_account	=mysql_result($result1,0,'user_account');
	$user_name		=mysql_result($result1,0,'user_name');
	$user_sex		=mysql_result($result1,0,'user_sex');
	if(''==$user_sex)
	{
		$user_sex	='0';
	}
	$user_birthday	=mysql_result($result1,0,'user_birthday');
	$user_from1		=mysql_result($result1,0,'user_from1');
	$user_from2		=mysql_result($result1,0,'user_from2');
	$user_from3		=mysql_result($result1,0,'user_from3');
	$user_email		=mysql_result($result1,0,'user_email');
	$user_qq		=mysql_result($result1,0,'user_qq');
	$user_skype		=mysql_result($result1,0,'user_skype');
	$user_mobile	=mysql_result($result1,0,'user_mobile');
	$user_website	=mysql_result($result1,0,'user_website');
	$user_regdate	=mysql_result($result1,0,'user_regdate');
	$user_lastlogin	=mysql_result($result1,0,'user_lastlogin');
	$user_avatar	=mysql_result($result1,0,'user_avatar');
	$user_signature	=mysql_result($result1,0,'user_signature');
	$user_status	=mysql_result($result1,0,'user_status');
	?>
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
	<form action="<?=$this_file?>" name=form1 id=form1 method=post ENCTYPE="multipart/form-data">
	<tr>
		<td align=right valign=top>昵称:</td>
		<td><input type=text name=user_name size=20 value="<?=$user_name?>"><br>
		<input type=checkbox name=mode value=reg_to_forum 
		<?if(''==$user_name)echo 'checked';?> onclick="showadv()">同时以这个昵称自动注册系统论坛<br>
		<SCRIPT LANGUAGE="JavaScript">
		function showadv()
		{
			if (document.form1.mode.checked == true)
			{
				document.getElementById("adv").style.display = "";
			}
			else
			{
				document.getElementById("adv").style.display = "none";
			}
		}
		</SCRIPT>
		<table width="100%" border=0 cellpadding=5 cellspacing=0 id=adv style="DISPLAY:<?if(''!=$user_name)echo 'none';?>">
		<tr>
			<td>论坛密码：<input type=password name=forum_pass ><br>
			确认密码：<input type=password name=forum_repass ></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align=right>性别:</td>
		<td><select name="user_sex">
			<option value="男"
			<?
			if($user_sex=='男')
			{
				echo ' selected';
			}
			?>
			>男</option>
			<option value="女"
			<?
			if($user_sex=='女')
			{
				echo ' selected';
			}
			?>
			>女</option>
			<option value="0"
			<?
			if(''==$user_sex||0==$user_sex)
			{
				echo ' seleced';
			}
			?>
			>保密</option>
			</select>
		</td>
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
		?></select>年<select name=user_month>
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
		</select>月<select name=user_day>
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
		<td><select name="user_from1" onchange="countrychange(form1.user_from1.value)">
			<option value="0">请选择</option>
			<option value="中国">中国</option>
			<option value="中国其他">中国其他</option>
			<option value="其他国家">其他国家</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>省/直辖市:</td>
		<td><select name=user_from2>
			<option value="0">请选择</option>
			</select>
<script language="javascript" src="country_change.js"></script>
<script language="JavaScript">
var from1 = '<?=$user_from1?>';
var from2 = '<?=$user_from2?>';
if(from1 != '' && from1!='0' && from2 != ''&& from2 !='0')
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
		<td align=right>E_Mail:</td>
		<td><input name=user_email size=25 value="<?=$user_email?>"></td>
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
		<td align=right>手机号:</td>
		<td><input name=user_mobile size=15 value="<?=$user_mobile?>"></td>
	</tr>
	<tr>
		<td align=right>个人主页:</td>
		<td><input name=user_website size=25 value="<?=$user_website?>"></td>
	</tr>
	<tr>
		<td align=right>头像:</td>
		<td>
	<?
	if(''==$user_avatar || (''!=$user_avatar && substr($user_avatar,0,6)!='upload'))
	{
		$system=1;
		$upload=0;
	}
	else
	{
		$system=0;
		$upload=1;
	}
	?>
		<input type=radio name="avatarselect" value="system" <?=$system?' checked ':''?> onclick="javascript:document.all.user_avatar.disabled=false;javascript:document.all.user_avatar_upload.disabled=true">从系统中选择一个:<br>
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
		<select name="user_avatar" size=9 onChange="showimage()" <?=$system?'':' disabled '?>>
		<?=$images?>
		</select>
		<script language="JavaScript1.2" type="text/javascript">
		function showimage()
		{
			document.images.icons.src="avatars/"+document.form1.user_avatar.options[document.form1.user_avatar.selectedIndex].value;
		}
		</script>
		<img src="<?=$facesdir?>/<?=$user_avatar?>" name="icons" width=64 border=0 alt="">
		<br>
		<input type=radio name=avatarselect value=upload <?=$upload?' checked ':''?> onclick="javascript:document.all.user_avatar.disabled=true;javascript:document.all.user_avatar_upload.disabled=false">我要自己上传:<br><input type=file name=user_avatar_upload size=14 <?=$upload?'':' disabled '?>><br>
		(支持gif,jpg,png或bmp格式)</td>
	</tr>
	<tr>
		<td align=right valign=center>个性签名:</td>
		<td><textarea name=user_signature rows=5 cols=24 wrap=hard><?=unformat($user_signature)?></textarea><br>限100汉字(200英文字符)</td>
	</tr>
	<tr>
		<td></td>
		<td><input type=hidden name=user_id value="<?=$user_id?>">
			<input type=hidden name=user_avatar_old value="<?=$user_avatar?>">
			<input type=submit name=submit value=提交修改>&nbsp;&nbsp;&nbsp;&nbsp;<input type=reset name=reset value=重置></td>
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
	
	<?
	}
}

function saveProfile()
{
	global $HTTP_POST_VARS;
	global $user_avatar_upload;
	global $user_avatar_upload_name;
	global $user_avatar_upload_size;
	global $user_avatar_upload_type;
	$user_id=$HTTP_POST_VARS['user_id'];
	$user_name=$HTTP_POST_VARS['user_name'];
	$forum_pass=$HTTP_POST_VARS['forum_pass'];
	$forum_repass=$HTTP_POST_VARS['forum_repass'];
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
	$user_mobile=$HTTP_POST_VARS['user_mobile'];
	$user_website=$HTTP_POST_VARS['user_website'];
	$user_avatar=$HTTP_POST_VARS['user_avatar'];
	$user_avatar_old=$HTTP_POST_VARS['user_avatar_old'];
	$user_signature=$HTTP_POST_VARS['user_signature'];
	$avatarselect=$HTTP_POST_VARS['avatarselect'];
	$mode=$HTTP_POST_VARS['mode'];
	if($avatarselect=='upload' && ''!=$user_avatar_upload)
	{
		$avatar_file_name=date("YmdHis").strrchr($user_avatar_upload_name,".");
		if(copy($user_avatar_upload,"avatars/upload/".$avatar_file_name))
		{
			$user_avatar='upload/'.$avatar_file_name;
		}
	}
	if(''==$avatarselect || (''==$user_avatar && ''==$user_avatar_upload))
	{
		$user_avatar=$user_avatar_old;
	}
	$sql2="update user_info set user_name='".$user_name."',user_sex='".$user_sex."',user_birthday='".$user_birthday."',user_from1='".$user_from1."',user_from2='".$user_from2."',user_from3='".$user_from3."',user_email='".$user_email."',user_qq='".$user_qq."',user_skype='".$user_skype."',user_mobile='".$user_mobile."',user_website='".$user_website."',user_avatar='".$user_avatar."',user_signature='".format($user_signature)."' where user_id=".$user_id;
	if(mysql_query($sql2))
	{
		if($mode=='reg_to_forum' && ''!=$user_name)
		{
			$sql3="select * from phpbb_users where username='".$user_name."'";

			$sql4="select max(user_id) from phpbb_users";
			$phpbb_user_id=mysql_result(mysql_db_query('phpbb2',$sql4),0,0)+1;
			$sql5="INSERT INTO phpbb_users(	user_id,	user_active,			username,		user_password,		user_session_time,		user_session_page,		user_lastvisit,	 user_regdate,		user_level,				user_posts,				user_timezone,		user_style,			user_lang,				user_dateformat,		user_new_privmsg,	user_unread_privmsg,user_last_privmsg,		user_emailtime,			user_viewemail, user_attachsig,		user_allowhtml,			user_allowbbcode,		user_allowsmile,	user_allowavatar,	user_allow_pm,			user_allow_viewonline,	user_notify,	user_notify_pm,		user_popup_pm,			user_rank,				user_avatar,	user_avatar_type,	user_email,				user_icq,				user_website,		user_from,			user_sig,				user_sig_bbcode_uid,	user_aim,			user_yim,			user_skype,				user_msnm,				user_occ,	user_interests,		user_actkey,			user_newpasswd)									VALUES ('".$phpbb_user_id."',	1,	'".$user_name."',	'".md5($forum_pass)."',	0,		0,	0,	UNIX_TIMESTAMP(),	0,	0,	8,	1,	'chinese_simplified',	'D M d, Y g:i a',	0,	0,	0,	NULL,				0,	1,	0,	1,	1,	1,	1,	1,	0,	1,	1,	0,	'',	0,	'".$user_email."',	'".$user_qq."',	'".$user_website."',	'".$user_from1." ".$user_from2." ".$user_from3."',	'',	'',	'',	'',	'".$user_skype."',	'',	'',	'',	'',	'')";
			$sql6="select max(group_id) from phpbb_user_group";
			$phpbb_group_id=mysql_result(mysql_db_query('phpbb2',$sql6),0,0)+1;
			$sql7="INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES ('".$phpbb_group_id."', '".$phpbb_user_id."', 0)";
			$msg='<br>个人资料修改成功!<br><br>';
			if(''==$user_pass)
			{
				$msg.='您选择了自动注册系统论坛，但是您忘了设置论坛密码，请确认重试！<br><br>';
			}
			elseif($forum_pass!=$forum_repass)
			{
				$msg.='您选择了自动注册系统论坛，但是您两次输入的密码不一致，请确认重试！<br><br>';
			}
			elseif(mysql_fetch_array(mysql_db_query('phpbb2',$sql3)))
			{
				$msg.='您选择了自动注册系统论坛，但是您选择的昵称已被他人注册，请确认重试！<br><br>';
			}
			elseif(mysql_db_query('phpbb2',$sql5) && mysql_db_query('phpbb2',$sql7))
			{
				$msg.='同时您已经自动成为SkyCall论坛的成员,用您刚才设置的昵称和密码可以<a href="/phpBB2/login.php" title="登录SkyCall论坛">登录</a><br><br>';
			}
			okMsg2($msg);
		}
		else
		{
			okMsg2('<br>个人资料修改成功!<br><br>');
		}
	}
	else
	{
		errorMsg2('<br>某些未知错误导致修改资料失败!<br><br>');
	}
}

?>