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
	<caption align=left>���û�����ע��<span class=inputTips>(ÿһ���������)</span></caption>
	<form action="user_register.php" method=post name=form1  ENCTYPE="multipart/form-data">
	<tr>
		<td colspan=2 align=center>
			<table width="90%">
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;����ʹ���Լ�����Ϥ�ĺ��룬���ֻ�����,�绰����, ���յ���Ϊ����绰����. ���ں�����Դ����, �벻Ҫ��ע����Ҫ�ĺ���.<br>&nbsp;&nbsp;&nbsp;&nbsp;ע������ѵ�!</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="20%" align=right valign=top><span style="color:red">*</span>�������:</td>
		<td><select size="1" name="user_account1" onChange="changeTips()">
			<option value="13" selected>�й�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(13)</option>
			<option value="83">�й�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(83)</option>
			<option value="90">̨��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(90)</option>
			<option value="91">���.����(91)</option>
			<option value="10">����&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(10)</option>
			<option value="11">���ô�&nbsp;&nbsp;&nbsp;&nbsp;(11)</option>
			<option value="19">ӡ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(19)</option>
			<option value="40">����&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(40)</option>
			<option value="41">Ӣ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(41)</option>
			<option value="42">�¹�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(42)</option>
			<option value="44">�����&nbsp;&nbsp;&nbsp;&nbsp;(44)</option>
			<option value="50">�ձ�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(50)</option>
			<option value="51">����&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(51)</option>
			<option value="70">����˹&nbsp;&nbsp;&nbsp;&nbsp;(70)</option>
			<option value="439">������&nbsp;&nbsp;(439)</option>
			<option value="440">�¼���&nbsp;&nbsp;(440)</option>
			<option value="441">̩��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(441)</option>
			<option value="442">Խ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(442)</option>
			</select>
			<script language="javascript" src="tips_change.js"></script>
			<input type=text name=user_account2 size=10 maxlength=9><br><span class=inputTips>������<span style="color:red" id=acc3>9</span>λ����</span>,��ֻ����������0-9,����<span id=acc1>13</span><span style="color:red" id=acc2>123456789</span>
		</td>
	</tr>
	<tr>
		<td align=right valign=top><span style="color:red">*</span>����:</td><td><input type=password name=user_password><br><span class=inputTips>6λ����,����ʹ�û������</span></td>
	</tr>
	<tr>
		<td align=right valign=top><span style="color:red">*</span>����ȷ��:</td><td><input type=password name=user_repassword><br><span class=inputTips>���������Ա�ȷ��</span></td>
	</tr>
	<tr>
		<td align=right width="18%" valign=top>����:</td>
		<td><input type=text name=user_name size=20 value="<?=$user_name?>"><br>����ʹ������,����ʾ����վҳ����</td>
	</tr>
	<tr>
		<td align=right>�Ա�:</td>
		<td><input type=radio name="user_sex" value='��'
			<?
			if($user_sex=='��')
			{
				echo ' checked';
			}
			?>
			><img src="image/male.gif">˧��&nbsp;
			<input type=radio name="user_sex" value='Ů'
			<?
			if($user_sex=='Ů')
			{
				echo ' checked';
			}
			?>
			><img src="image/female.gif">��Ů
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
		<td align=right></td><td><input type=hidden name=action value="register2"><input type=submit value="ע��">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT id=advcheck name=advshow type=checkbox value=1 onclick="showadv()"><span id=advance>��ʾ�߼��û�����ѡ��</span></td>
	</tr>
	<SCRIPT LANGUAGE="JavaScript">
	function showadv()
	{
		if (document.form1.advshow.checked == true)
		{
			document.getElementById("adv").style.display = "";
			document.getElementById("advance").innerText="�رո߼��û�����ѡ��";
		}
		else
		{
			document.getElementById("adv").style.display = "none";
			document.getElementById("advance").innerText="��ʾ�߼��û�����ѡ��";
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
		<td colspan=2 bgcolor=#6e94b7>��д��ϸ����</td>
	</tr>
	<tr>
		<td align=right>����:</td>
		<td><select name=user_year>
			<option value='0'>-��-</option>
		<?
		for($i=1970;$i<=2004;$i++)
		{
			$user_year=substr($user_birthday,0,4);
			echo '<option value='.$i;
			if(''!=$user_year &&  0!=$user_year && $i==$user_year)
				echo ' selected';
			echo '>'.$i.'</option>';
		}
		?></select>�� 
		<select name=user_month>
		<option value='0'>��</option>
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
		</select>��
		<select name=user_day>
		<option value='0'>��</option>
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
		</select>��
		</td>
	</tr>
	<tr>
		<td align=right>����:</td>
		<td><select name="user_from1" id="user_from1" onchange="countrychange(form1.user_from1.value)">
			<option selected="selected" value="0">��ѡ��</option>
			<option value="�й�">�й�</option>
			<option value="�й�����">�й�����</option>
			<option value="��������">��������</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>ʡ/ֱϽ��:</td>
		<td><select name=user_from2>
			<option selected="selected" value="0">��ѡ��</option>
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
		<td align=right>����:</td>
		<td><input name=user_from3 size=20 value="<?=$user_from3?>"></td>
	</tr>
	<tr>
		<td align=right>E_Mail:</td><td><input type=text name=user_email><span class=inputTips>�������������һ����Ч��E_mail��ַ</span></td>
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
		<td align=right>������ҳ:</td>
		<td><input name=user_website size=30 value="<?=$user_website?>"></td>
	</tr>
	<tr>
		<td align=right>ע������:</td>
		<td><?=$user_regdate?></td>
	</tr>
	<tr>
		<td align=right>ͷ��:</td>
		<td>
		<?
		if(''==$user_avatar)
		{
			$user_avatar='no_avatar.gif';
		}
		?>
		<input type=radio name="avatarselect" value="system" <?if(''==$user_avatar || (''!=$user_avatar && substr($user_avatar,0,6)!='upload'))echo ' checked ';?> onclick="javascript:document.all.user_avatar.disabled=false;javascript:document.all.user_avatar_upload.disabled=true">��ϵͳ��ѡ��һ��:<br>
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
				$filename ='û��ͷ��'; 
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
		<input type=radio name=avatarselect value=upload onclick="javascript:document.all.user_avatar.disabled=true;javascript:document.all.user_avatar_upload.disabled=false">��Ҫ�Լ��ϴ�:<br><input type=file name=user_avatar_upload size=20><br>
		(ֻ���ϴ�gif,jpg��png��ʽ��ͼƬ)</td>
		</td>
	</tr>
	<tr>
		<td align=right valign=center>����ǩ��:</td>
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
	/***********************���±�������Ϊ��****************************************/
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
		errorMsg("��û���������ĺ���!");
	}
	elseif(strlen($user_account)!=11)
	{
		errorMsg("����д�ĺ��볤�Ȳ���,ǰ�������Ӧ����<span style='color:red'>11</span>λ!");
	}
	elseif(!ereg("[0-9]{11}",$user_account))
	{
		errorMsg("���������������0-9����������ַ�!");
	}
	elseif($user_account2=='0')
	{
		errorMsg("����������ȫ'0'��Ϊ���ĺ���!");
	}
//	elseif(''==$user_email)
//	{
//		errorMsg("����������E_Mail��ַ!");
//	}
	elseif(''!=$user_email && !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,4}$",$user_email))
	{
		errorMsg("����E_Mail��ַ�Ƿ�");
	}
	elseif(''==$user_password)
	{
		errorMsg("��������������");
	}
	elseif(strlen($user_password)<6)
	{
		errorMsg("���������6λ����");
	}
	elseif($user_password!=$user_repassword)
	{
		errorMsg("����ǰ��һ��");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg("��������ѱ�ע��,��ѡ���µ��ʺ�!");
	}
//	elseif(mysql_fetch_array($result2))
//	{
//		errorMsg("���E_mail��ַ�Ѿ���ע���Ա��ʹ��,����ѡһ��!");
//	}
	elseif(mysql_query($sql3))
	{
		$user_id=mysql_insert_id();
		setcookie("cookie_user_id", $user_id);
		setcookie("cookie_user_account", $user_account);
		if(''!=$user_skype)
		{
			$msg="�װ����û�,����,���Ѿ������ǵ���վ��ע��������Skype����,Ϊ���ø������˽������ڵ�Skype״̬,ͬʱҲΪ�������л����ʶ������,��������Skype�����\"goldsoft01\"Ϊ����,����������û�������ʱ������!";
			$sql4="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('goldsoft01','".$user_skype."','".$msg."',now(),0)";
			mysql_query($sql4);
		}
		okMsg("��ϲ��,ע��ɹ�!<br><br>");
	}
	else
	{
		errorMsg("δ֪������û�ע����ֹͣ��");
	}
}
?>