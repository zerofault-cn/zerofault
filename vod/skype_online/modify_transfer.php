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
		errorMsg2('<br>您还没有登录,或登录已超时,请<a href="login.php">重新登录</a><br><br>');
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
		alert("您选择了一种接听方式为skype,但是您忘了输入您的skype号");
		document.form1.user_skype.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="skycall_ext" || document.form1.skycall_sec.value=="skycall_ext" || document.form1.skycall_thr.value=="skycall_ext") && document.form1.skycall_ext.value=='')
	{
		alert("您选择了一种接听方式为分机,但是您忘了输入您的分机号");
		document.form1.skycall_ext.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="user_phone" || document.form1.skycall_sec.value=="user_phone" || document.form1.skycall_thr.value=="user_phone") && document.form1.user_phone.value=='')
	{
		alert("您选择了一种接听方式为电话,但是您忘了输入您的电话号码");
		document.form1.user_phone.focus();
		return false;
	}
	if((document.form1.skycall_fir.value=="user_mobile" || document.form1.skycall_sec.value=="user_mobile" || document.form1.skycall_thr.value=="user_mobile") && document.form1.user_mobile.value=='')
	{
		alert("您选择了一种接听方式为手机,但是您忘了输入您的手机号码");
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
		<td align=right>网关组:</td>
		<td><select name=skycall_gw><option value=''>未注册网关组</option>
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
		<td align=right valign=top>是否转移:</td>
		<td><input type=checkbox name=skycall_en_trans value=1 <?if($skycall_en_trans)echo 'checked'?> oonclick="javascript:if(document.form1.skycall_en_trans.checked==true){document.form1.skycall_en_msg.checked=false;}else{document.form1.skycall_en_msg.checked=true;document.form1.skycall_msg.disabled=false;document.form1.skycall_msg.focus();}"><br>即用户skype不在线时是否转移到其它接听方式</td>
	</tr>
	<tr>
		<td align=right valign=top>是否留言:</td>
		<td><input type=checkbox name=skycall_en_msg value=1 <?if($skycall_en_msg)echo 'checked'?> oonclick="javascript:if(document.form1.skycall_en_msg.checked==true){document.form1.skycall_en_trans.checked=false;document.form1.skycall_msg.disabled=false;document.form1.skycall_msg.focus();}else{document.form1.skycall_en_trans.checked=true;}"><br>
			<textarea name=skycall_msg rows=5 cols=18 wrap=hard <?if($skycall_en_msg==0)echo ' ddisabled'?>><?=$skycall_msg?></textarea></td>
	</tr>
	<tr>
		<td align=right valign=top>接听顺序:</td>
		<td>第一：<select name=skycall_fir>
				<option value=user_skype <?if($skycall_fir=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_fir=='skycall_ext')echo 'selected'?>>分机</option>
				<option value=user_phone <?if($skycall_fir=='user_phone')echo 'selected'?>>固定电话</option>
				<option value=user_mobile <?if($skycall_fir=='user_mobile')echo 'selected'?>>手机</option>
				<!-- <option value=user_email <?if($skycall_fir=='user_email')echo 'selected'?>>语音邮件</option> -->
				</select><br>
			第二：<select name=skycall_sec>
				<option value=user_skype <?if($skycall_sec=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_sec=='skycall_ext')echo 'selected'?>>分机</option>
				<option value=user_phone <?if($skycall_sec=='user_phone')echo 'selected'?>>固定电话</option>
				<option value=user_mobile <?if($skycall_sec=='user_mobile')echo 'selected'?>>手机</option>
				<!-- <option value=user_email <?if($skycall_sec=='user_email')echo 'selected'?>>语音邮件</option> -->
				</select><br>
			第三：<select name=skycall_thr>
				<option value=user_skype <?if($skycall_thr=='user_skype')echo 'selected'?>>Skype</option>
				<option value=skycall_ext <?if($skycall_thr=='skycall_ext')echo 'selected'?>>分机</option>
				<option value=user_phone <?if($skycall_thr=='user_phone')echo 'selected'?>>固定电话</option>
				<option value=user_mobile <?if($skycall_thr=='user_mobile')echo 'selected'?>>手机</option>
				<!-- <option value=user_email <?if($skycall_thr=='user_email')echo 'selected'?>>语音邮件</option> -->
				</select>
		</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;如果您选择了某种接听方式，则应将下列相应项填写完整！</td>
	</tr>
	<tr>
		<td align=right>Skype:</td>
		<td><input name=user_skype size=18 value="<?=$user_skype?>"></td>
	</tr>
	<tr>
		<td align=right>用户分机:</td>
		<td><input type=text name=skycall_ext size=5 value="<?=$skycall_ext?>"></td>
	</tr>
	<tr>
		<td align=right>固定电话:</td>
		<td><input name=user_phone size=18 value="<?=$user_phone?>"></td>
	</tr>
	<tr>
		<td align=right>手机:</td>
		<td><input name=user_mobile size=18 value="<?=$user_mobile?>"></td>
	</tr>
	<!-- <tr>
		<td align=right>邮件地址:</td>
		<td><input name=user_email size=18 value="<?=$user_email?>"></td>
	</tr> -->
	<tr>
		<td></td>
		<td><input type=submit name=submit value=提交修改>&nbsp;&nbsp;<input type=reset></td>
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
		okMsg2('<br>修改成功<br><br>');
	}
	else
	{
		errorMsg2('<br>某些未知错误导致修改资料失败!<br><br>');
	}
}
?>