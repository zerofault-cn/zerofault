<?
function editProfile()
{
	$user_id=$_COOKIE['cookie_user_id'];
	if(''==$user_id)
	{
		errorMsg('����û�е�¼,���¼�ѳ�ʱ,�뷵�����µ�¼');
		exit;
	}
	$user_account=$_COOKIE['cookie_user_account'];
	$sql1="select * from user_info where user_id=".$user_id;
	$result1=mysql_query($sql1);
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
	$user_website	=mysql_result($result1,0,'user_website');
	$user_regdate	=mysql_result($result1,0,'user_regdate');
	$user_lastlogin	=mysql_result($result1,0,'user_lastlogin');
	$user_avatar	=mysql_result($result1,0,'user_avatar');
	$user_signature	=mysql_result($result1,0,'user_signature');
	$user_status	=mysql_result($result1,0,'user_status');
	?>
<br>

<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br>
	<table width="80%" border=0 cellpadding=5 cellspacing=0 class=innertable>
	<form action="?action=profile2" name=form1 id=form1 method=post ENCTYPE="multipart/form-data">
	<caption align=left><img src="image/profile_sm.gif">�޸ĸ�������----<?=$user_account?></caption>
	<tr>
		<td align=right>����:</td>
		<td><input type=text name=user_name size=20 value="<?=$user_name?>"></td>
	</tr>
	<tr>
		<td align=right>�Ա�:</td>
		<td><select name="user_sex">
			<option value="��"
			<?
			if($user_sex=='��')
			{
				echo ' selected';
			}
			?>
			>��</option>
			<option value="Ů"
			<?
			if($user_sex=='Ů')
			{
				echo ' selected';
			}
			?>
			>Ů</option>
			<option value="0"
			<?
			if(''==$user_sex||0==$user_sex)
			{
				echo ' seleced';
			}
			?>
			>����</option>
			</select>
		</td>
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
		<td><select name="user_from1" onchange="countrychange(form1.user_from1.value)">
			<option value="0">��ѡ��</option>
			<option value="�й�">�й�</option>
			<option value="�й�����">�й�����</option>
			<option value="��������">��������</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>ʡ/ֱϽ��:</td>
		<td><select name=user_from2>
			<option value="0">��ѡ��</option>
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
		<td align=right>����:</td>
		<td><input name=user_from3 size=20 value="<?=$user_from3?>"></td>
	</tr>
	<tr>
		<td align=right>E_Mail:</td>
		<td><input name=user_email size=30 value="<?=$user_email?>"></td>
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
		<td align=right>ͷ��:</td>
		<td>
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
		<script language="JavaScript1.2" type="text/javascript">
        function showimage()
		{
       		document.images.icons.src="avatars/"+document.form1.user_avatar.options[document.form1.user_avatar.selectedIndex].value;
        }
        </script>
		<img src="<?=$facesdir?>/<?=$user_avatar?>" name="icons" width=64 border=0 alt="">
		<br>
		<input type=radio name=avatarselect value=upload onclick="javascript:document.all.user_avatar.disabled=true;javascript:document.all.user_avatar_upload.disabled=false">��Ҫ�Լ��ϴ�:<br><input type=file name=user_avatar_upload size=20><br>
		(�Լ��ϴ���ͼƬ������gif,jpg,png��bmp��ʽ)</td>
	</tr>
	<tr>
		<td align=right valign=center>����ǩ��:</td>
		<td><textarea name=user_signature rows=5 cols=40><?=unformat($user_signature)?></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type=hidden name=user_id value="<?=$user_id?>">
			<input type=hidden name=user_avatar_old value="<?=$user_avatar?>">
			<input type=submit value=�����޸�></td>
	</tr>
	</form>
	</table>
	<br>
	</td>
</tr>
</table>
	<?
}

function saveProfile()
{
	global $HTTP_POST_VARS;
//	print_r($HTTP_POST_VARS);
	global $user_avatar_upload,$user_avatar_upload_name,$user_avatar_upload_size,$user_avatar_upload_type;
	$user_id=$HTTP_POST_VARS['user_id'];
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
	$user_avatar_old=$HTTP_POST_VARS['user_avatar_old'];
	$user_signature=$HTTP_POST_VARS['user_signature'];
	$avatarselect=$HTTP_POST_VARS['avatarselect'];
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
	$sql1="update user_info set user_name='".$user_name."',user_sex='".$user_sex."',user_birthday='".$user_birthday."',user_from1='".$user_from1."',user_from2='".$user_from2."',user_from3='".$user_from3."',user_email='".$user_email."',user_qq='".$user_qq."',user_skype='".$user_skype."',user_website='".$user_website."',user_avatar='".$user_avatar."',user_signature='".format($user_signature)."' where user_id=".$user_id;
	if(mysql_query($sql1))
	{
		okMsg('�������ϱ���ɹ�!');
	}
	else
	{
		errorMsg('ĳЩδ֪�������޸�����ʧ��!');
	}
}

?>