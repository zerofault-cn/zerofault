<?
$file_file='modify_transfer.php';
if(''!=$submit)
{
	modify_transfer_2();
}
else
{
	modify_transfer_1();
}
function modify_transfer_1()
{
	$user_id=$_COOKIE['cookie_user_id'];
	if(''==$user_id)
	{
		errorMsg2('<br>����û�е�¼,���¼�ѳ�ʱ,��<a href="login.php">���µ�¼</a><br><br>');
	}
	else
	{
		$sql1="select * from user_info where user_id='".$_COOKIE['cookie_user_id']."'";
		$result1=mysql_query($sql1);
		$user_skype		=mysql_result($result1,0,'user_skype');
		$user_phone		=mysql_result($result1,0,'user_phone');
		$user_mobile	=mysql_result($result1,0,'user_mobile');
		$user_email		=mysql_result($result1,0,'user_email');
		$skycall_gw		=mysql_result($result1,0,'skycall_gw');
		$skycall_ext	=mysql_result($result1,0,'skycall_ext');
		$skycall_en_trans=mysql_result($result1,0,'skycall_en_trans');
		$skycall_en_msg	=mysql_result($result1,0,'skycall_en_msg');
		$skycall_msg	=mysql_result($result1,0,'skycall_msg');
		$skycall_fir	=mysql_result($result1,0,'skycall_fir');
		$skycall_sec	=mysql_result($result1,0,'skycall_sec');
		$skycall_thr	=mysql_result($result1,0,'skycall_thr');
		
	?>
<script language="javascript">
function check()
{
	if((document.form1.skycall_fir.value=="user_skype" || document.form1.skycall_sec.value=="user_skype" || document.form1.skycall_thr.value=="user_skype") && document.form1.user_skype.value=='')
	{
		alert("��ѡ����һ�ֽ�����ʽΪskype,������������������skype��");
		document.form1.user_skype.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="skycall_ext" || document.form1.skycall_sec.value=="skycall_ext" || document.form1.skycall_thr.value=="skycall_ext") && document.form1.skycall_ext.value=='')
	{
		alert("��ѡ����һ�ֽ�����ʽΪ�ֻ�,�����������������ķֻ���");
		document.form1.skycall_ext.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="user_phone" || document.form1.skycall_sec.value=="user_phone" || document.form1.skycall_thr.value=="user_phone") && document.form1.user_phone.value=='')
	{
		alert("��ѡ����һ�ֽ�����ʽΪ�绰,�����������������ĵ绰����");
		document.form1.user_phone.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="user_mobile" || document.form1.skycall_sec.value=="user_mobile" || document.form1.skycall_thr.value=="user_mobile") && document.form1.user_mobile.value=='')
	{
		alert("��ѡ����һ�ֽ�����ʽΪ�ֻ�,�������������������ֻ�����");
		document.form1.user_mobile.focus();
		return false;
	}
	return true;
}
</script>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/transset_logo.gif"><img src="image/transset_title.gif"></td>
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
	<form action="<?=$this_file?>" name=form1 id=form1 method=post onsubmit="return check()">
	<tr>
		<td align=right>������:</td>
		<td><select name=skycall_gw><option value=''>δע��������</option>
		<?
		$sql2="select * from group_info where is_gw=1 order by group_id";
		$result2=mysql_query($sql2);
		while($r2=mysql_fetch_array($result2))
		{
			$gw_group_id=$r2['group_id'];
			$gw_group_epn=$r2['group_account'];
			$gw_group_name=$r2['group_name'];
			if($gw_group_id==$skycall_gw)
			{
				$select_flag=' selected';
			}
			else
			{
				$select_flag=' ';
			}
			echo '<option value='.$gw_group_id.$select_flag.'>'.$gw_group_name.'</option>';
		}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td align=right valign=top>�Ƿ�ת��:</td>
		<td><input type=checkbox name=skycall_en_trans value=1 <?if($skycall_en_trans)echo 'checked'?> oonclick="javascript:if(document.form1.skycall_en_trans.checked==true){document.form1.skycall_en_msg.checked=false;}else{document.form1.skycall_en_msg.checked=true;document.form1.skycall_msg.disabled=false;document.form1.skycall_msg.focus();}"><br>���û�skype������ʱ�Ƿ�ת�Ƶ�����������ʽ</td>
	</tr>
	<tr>
		<td align=right valign=top>�Ƿ�����:</td>
		<td><input type=checkbox name=skycall_en_msg value=1 <?if($skycall_en_msg)echo 'checked'?> oonclick="javascript:if(document.form1.skycall_en_msg.checked==true){document.form1.skycall_en_trans.checked=false;document.form1.skycall_msg.disabled=false;document.form1.skycall_msg.focus();}else{document.form1.skycall_en_trans.checked=true;}"><br>
			<textarea name=skycall_msg rows=5 cols=18 wrap=hard <?if($skycall_en_msg==0)echo ' ddisabled'?>><?=$skycall_msg?></textarea></td>
	</tr>
	<tr>
		<td align=right valign=top>����˳��:</td>
		<td>��һ��<select name=skycall_fir>
				<option value=user_skype <?if($skycall_fir=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_fir=='skycall_ext')echo 'selected'?>>�ֻ�</option>
				<option value=user_phone <?if($skycall_fir=='user_phone')echo 'selected'?>>�̶��绰</option>
				<option value=user_mobile <?if($skycall_fir=='user_mobile')echo 'selected'?>>�ֻ�</option>
				<!-- <option value=user_email <?if($skycall_fir=='user_email')echo 'selected'?>>�����ʼ�</option> -->
				</select><br>
			�ڶ���<select name=skycall_sec>
				<option value=user_skype <?if($skycall_sec=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_sec=='skycall_ext')echo 'selected'?>>�ֻ�</option>
				<option value=user_phone <?if($skycall_sec=='user_phone')echo 'selected'?>>�̶��绰</option>
				<option value=user_mobile <?if($skycall_sec=='user_mobile')echo 'selected'?>>�ֻ�</option>
				<!-- <option value=user_email <?if($skycall_sec=='user_email')echo 'selected'?>>�����ʼ�</option> -->
				</select><br>
			������<select name=skycall_thr>
				<option value=user_skype <?if($skycall_thr=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_thr=='skycall_ext')echo 'selected'?>>�ֻ�</option>
				<option value=user_phone <?if($skycall_thr=='user_phone')echo 'selected'?>>�̶��绰</option>
				<option value=user_mobile <?if($skycall_thr=='user_mobile')echo 'selected'?>>�ֻ�</option>
				<!-- <option value=user_email <?if($skycall_thr=='user_email')echo 'selected'?>>�����ʼ�</option> -->
				</select>
		</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;�����ѡ����ĳ�ֽ�����ʽ����Ӧ��������Ӧ����д������</td>
	</tr>
	<tr>
		<td align=right>Skype:</td>
		<td><input name=user_skype size=18 value="<?=$user_skype?>"></td>
	</tr>
	<tr>
		<td align=right>�û��ֻ�:</td>
		<td><input type=text name=skycall_ext size=5 value="<?=$skycall_ext?>"></td>
	</tr>
	<tr>
		<td align=right>�̶��绰:</td>
		<td><input name=user_phone size=18 value="<?=$user_phone?>"></td>
	</tr>
	<tr>
		<td align=right>�ֻ�:</td>
		<td><input name=user_mobile size=18 value="<?=$user_mobile?>"></td>
	</tr>
	<!-- <tr>
		<td align=right>�ʼ���ַ:</td>
		<td><input name=user_email size=18 value="<?=$user_email?>"></td>
	</tr> -->
	<tr>
		<td></td>
		<td><input type=submit name=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset></td>
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
	<?
	}
}

function modify_transfer_2()
{
	global $HTTP_POST_VARS;
	$user_id=$_COOKIE['cookie_user_id'];
	$skycall_gw=$HTTP_POST_VARS['skycall_gw'];
	$skycall_ext=$HTTP_POST_VARS['skycall_ext'];
	$skycall_en_trans=$HTTP_POST_VARS['skycall_en_trans'];
	$skycall_en_msg=$HTTP_POST_VARS['skycall_en_msg'];
	$skycall_msg=$HTTP_POST_VARS['skycall_msg'];
	$skycall_fir=$HTTP_POST_VARS['skycall_fir'];
	$skycall_sec=$HTTP_POST_VARS['skycall_sec'];
	$skycall_thr=$HTTP_POST_VARS['skycall_thr'];
	$user_skype=$HTTP_POST_VARS['user_skype'];
	$user_phone=$HTTP_POST_VARS['user_phone'];
	$user_mobile=$HTTP_POST_VARS['user_mobile'];
	$user_email=$HTTP_POST_VARS['user_email'];
	$sql1="update user_info set skycall_gw='".$skycall_gw."',skycall_ext='".$skycall_ext."',skycall_en_trans='".$skycall_en_trans."',skycall_en_msg='".$skycall_en_msg."',skycall_msg='".$skycall_msg."',skycall_fir='".$skycall_fir."',skycall_sec='".$skycall_sec."',skycall_thr='".$skycall_thr."',user_skype='".$user_skype."',user_phone='".$user_phone."',user_mobile='".$user_mobile."',user_email='".$user_email."' where user_id='".$user_id."'";
	if(mysql_query($sql1))
	{
		okMsg2('<br>�޸ĳɹ�<br><br>');
	}
	else
	{
		errorMsg2('<br>ĳЩδ֪�������޸�����ʧ��!<br><br>');
	}
}
?>