<?
//�µ�ע�����
/**************************
����:
1,����Ҫ���û�ע��skype,��ȡ�����Լ���skype�ʺ�
2,ͨ��IM���û���skype������֤����,Ŀ����Ϊ����֤skype�ŵ���Ч��
3,�û��յ���֤������ע��,ϵͳ�������ָ��λ����EPN���������,�������ݿ�,ͬʱͨ��IM���͸��û�,
4,�û����ݴ�EPN�������¼,��Ҫ���û����Ƹ�������,���ע��
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
			<div align=center style="font-size:20px;color:#005177">��һ��(������)</div>
			<p>1) ��ȷ������Skype״̬Ϊ��<span class=tag>Skype Me</span>��,�������û��Skype�����<a href="setup/SkypeSetup-1.2.0.37.exe">����</a>���ذ�װ,���������ʾע�����С�
			<br>
			<br>
			<table border=0 width="100%" cellpadding=0 cellspacing=0>
			<tr>
				<td width=42></td>
				<td width=240 valign=center align=center>"Skype Me"��״̬ͼ��<img src="image/status_icon/SKYPEME.gif"></td>
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
			<p>2) ����������Skype�ʺţ�<input type=text name=user_skype>
			<table border=0 width="100%" cellpadding=0 cellspacing=0>
			<tr>
				<td width=42></td>
				<td><p>�����������һ������ϵͳ��ͨ����<span class=tag>goldsoft01</span>��������Skype����һ����ʱ��Ϣ��������Ϣ����һ��10λ���ֵ�ע����֤���룬��һ������Ҫ�������Ǹ���֤���롣</p></td>
			</tr>
			</table>
			</p>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=center>
			<input type=hidden name=action value="register1">
			<input type=submit name=submit value="��һ��">
			&nbsp;&nbsp;<input type=button onclick="javascript:window.history.go(-1)" name=back value="����">
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
	$msg="������Ϣ����www.SkyCall.cn��վ�����Ѿ����ע����̵ĵ�һ�����븴���������֤����(10λ)��ճ������վע���ҳ������Ӧλ�ã�������һ��ע��\r\n�����ע�����֤����->".$randVal;
	$sql1="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('skycall.cn','".$user_skype."','".$msg."',now(),0)";
	
	if(''==$user_skype)
	{
		errorMsg('��û����д����skype�ʺ�');
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
			if(confirm("�������������쳣����֤���뷢��ʧ�ܣ���ȷ�ϲ����ԣ�"))
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
			<div align=center style="font-size:20px;color:#005177">�ڶ���(������)</div>
			<br>
			<div style="margin-left:4em">
			�����������յ�����֤����(10λ)��<input type=text name=regCode><br><br>
			��鿴����Skype�����ԡ�<span class=tag>goldsoft01</span>���ļ�ʱ��Ϣ�����10���δ�յ����뷵������һ�Ρ�
			</div>
			</td>
		</tr>
		<tr>
			<td align=center>
			<br>
			<input type=hidden name=action value=register3><input type=submit name=submit value="��һ��">
			&nbsp;&nbsp;<input type=button onclick="javascript:window.history.go(-1)" name=back value="����">
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
	$msg="��ϲ��ע��ɹ���\r\n";
	$msg.="���˴�ע��󶨵�Skype�ʺţ�".$user_skype."\r\n";
	$msg.="���� EPN���룺".$user_account."\r\n";
	$msg.="����������룺".$user_password."\r\n";
	$msg.="Ϊȷ����ȫ��������������¼http://www.skycall.cn�޸��������롣\r\n";
	$sql3="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('skycall.cn','".$user_skype."','".$msg."',now(),0)";
	if($randVal!=$regCode)
	{
		errorMsg('��֤�������');
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
			okMsg('<span class=content>ע��ɹ��������뵽��EPN���뼰��Ӧ�����Ѿ����͵�����Skype�ϣ���ע��鿴��<br><br>ͬʱ���Ѿ��Զ���¼����������д��������<a href="community.php?p=user_profile">������Ϣ</a>����Ҳ��������<a href="community.php?p=modify_password">�޸��Լ�������</a>����<br><br></span>');
		}
		else
		{
			errorMsg('����ע����Ϣʧ�ܻ����ݿ����');
		}
	}
	else
	{
		erorMsg('���ݿ���󣬻�ע���ѱ�ֹͣ');
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