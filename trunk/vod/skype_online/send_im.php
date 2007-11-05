<?
include_once "mysql_connect.php";
if($action=='trans')
{
	sendMsgGw();
}
elseif($action=='send')
{
	sendMsg();
}
else
{
	inputMsg();
}

function inputMsg()
{
	global $HTTP_GET_VARS;
	$send_to=$HTTP_GET_VARS['user_skype'];
	if(''!=$_COOKIE['cookie_user_id'])
	{
		$sql1="select user_skype from user_info where user_id=".$_COOKIE['cookie_user_id'];
		$send_from=mysql_result(mysql_query($sql1),0,0);
	}
	?>
<html>
<head>
<title>发送IM</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<script>
function wordLeft()
{
	maxLen=500;
	if (document.form1.message.value.length > maxLen)
	{
		document.form1.message.value = document.form1.message.value.substring(0, maxLen);
	}
	else
	{
		document.getElementById('wordLeft').innerHTML=maxLen - document.form1.message.value.length;
	}
}
</script>
</head>
<body bgcolor="#F4F8FF" topmargin=0>
<!-- <div style="display:none"><iframe id="ifm_send" name="ifm_send" width="0" height="0" src=""></iframe></div> -->
<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/info_logo2.gif"><img src="image/sendim_title.gif"></td>
	<td width=18><img src="image/table_top_right.gif"></td>
</tr>
<tr>
	<td rowspan=2 background="image/table_left.gif"></td>
	<td colspan=2></td>
	<td rowspan=2 background="image/table_right.gif"></td>
</tr>
<tr>
	<td>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 class=formTable>
	<form name=form1 action="?action=send" method=post>
	<tr>
		<td align=right>发送人:</td><td><input name=send_from value="<?=$send_from?>">
		<?
		if(''==$send_from)
		{
			echo '<span style="color:red">请填入您的Skype号</span>';
		}
		?></td>
	</tr>
	<tr>
		<td align=right>接收人:</td><td><input name=send_to value="<?=$send_to?>" readonly></td>
	</tr>
	<tr>
		<td valign=top align=right>内容:</td><td><textarea name=message rows=6 cols=40 class=scroll onKeyUp="wordLeft();" onKeyDown="wordLeft();"></textarea><br>
		限500字，现在还剩<span id=wordLeft style="color:red">500</span>字。</td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=submit name=submit value="发送">&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消发送"></td>
	</tr>
	</form>
	</table>
	</td>
</tr>
<tr>
	<td height=20><img src="image/table_bottom_left.gif"></td>
	<td colspan=2 background="image/table_bottom.gif"></td>
	<td><img src="image/table_bottom_right.gif"></td>
</tr>
</table>
</body>
</html>
	<?
}

function sendMsg()
{
	global $HTTP_POST_VARS;
	$send_from=$HTTP_POST_VARS['send_from'];
	$send_from_name=$HTTP_POST_VARS['send_from_name'];
	$phonenum=$HTTP_POST_VARS['phonenum'];
	$send_to=$HTTP_POST_VARS['send_to'];
	$message=$HTTP_POST_VARS['message'];
	$reply=$HTTP_POST_VARS['reply'];
	if(''!=$send_from_name)
	{
		$msg.=$send_from_name.' 通过您的eCard给您发送这条消息\r\n\r\n';
	}
	else
	{
		$msg.="这条消息来自SkyCall网站\r\n\r\n";
	}
	$msg.="发送者的SkypeID为: ".$send_from."\r\n\r\n";
	if(''!=$reply)
	{
		$msg.='他希望您 '.$reply.' 回复他\r\n\r\n';
	}
	$msg.="您可以点这里呼叫他: callto://".$send_from."\r\n";
	if(''!=$phonenum)
	{
	}
	$msg.="下面是原文信息:\r\n";
	$msg.="--------------------------------------------------------\r\n";
	$msg.=$message."\r\n";
	$msg.="--------------------------------------------------------\r\n";
	$sql2="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('".$send_from."','".$send_to."','".$msg."',now(),0)";
	if(mysql_query($sql2))
	{
		sleep(5);
		$last_im_id=mysql_insert_id();
		$sql3="select send_flag from skype_im where id=".$last_im_id;
		$r=mysql_result(mysql_query($sql3),0,0);
		if($r==1)
		{
			?>
			<script>
				alert("发送成功!");
				window.close();
			</script>
			<?
		}
		else
		{
			?>
			<script>
				alert("发送失败!");
				window.history.go(-1);
			</script>
			<?
		}
	}
	else
	{
		?>
		<script>
			alert("数据库错误!");
			window.history.go(-1);
		</script>
		<?
	}
}
function sendMsgGw()
{
	global $HTTP_GET_VARS;
//	print_r($HTTP_GET_VARS);
	$user_id=$HTTP_GET_VARS['user_id'];
	//取得被呼用户信息
	$sql1="select * from user_info where user_id='".$user_id."'";
	$result1=mysql_query($sql1);
	$user_skype		=mysql_result($result1,0,'user_skype');
	$user_status	=mysql_result($result1,0,'user_status');
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
	$gw_str=findUsableGw('',$skycall_gw);//查找用户注册的可用网关
	$gw_skype=substr($gw_str,0,strpos($gw_str,'|'));
	//取得本地网关信息
	$my_id=$_COOKIE['cookie_user_id'];
	if(''==$my_id)
	{
		$my_id=$HTTP_GET_VARS['my_id'];
	}
	$sql2="select * from user_info where user_id='".$my_id."'";
	$result2=mysql_query($sql2);
	$local_gw_str=findUsableGw('',mysql_result($result2,0,'skycall_gw'));
	$local_gw_skype=substr($local_gw_str,0,strpos($local_gw_str,'|'));
	$local_gw_ext=substr($local_gw_str,strpos($local_gw_str,'|')+1);
	$send_to=$local_gw_skype;
	//开始转接判断
	if($skycall_en_trans==0)//用户设置不转接
	{	
		if($user_status=='ONLINE' || $user_status=='SKYPEME')
		{
			if(''==$local_gw_skype)
			{
				?>
				<script>
					alert("本地没有可用的网关!");
				</script>
				<?
			}
			else
			{
				$comm_msg='SKYCALL '.$user_skype;//直接呼叫skype
			}
		}
		else//skype不在线
		{
			?>
			<script>
				alert("您所呼叫得用户现在无法接通!");
			</script>
			<?
		}
	}
	else//用户设置转接
	{
		if($skycall_fir=='user_skype')
		{
			if($user_status=='ONLINE' || $user_status=='SKYPEME')//skype在线时，本地转呼skype
			{
				if(''==$local_gw_skype)
				{
					?>
					<script>
						alert("本地没有可用的网关!");
					</script>
					<?
				}
				else
				{
					$comm_msg='SKYCALL '.$user_skype;//直接呼叫skype
				}
			}
			else//skype不在线
			{	
				if($skycall_sec=='user_skype')//第二方式为skype
				{
					//转第三
					if($skycall_thr=='user_skype')//第三方式为skype
					{
						?>
						<script>
							alert("您所呼叫得用户现在无法接通!");
						</script>
						<?
					}
					elseif($skycall_thr=='skycall_ext')//第三方式为分机
					{
						if($gw_skype==$local_gw_skype)//用户在本地时
						{
							?>
							<script>
								alert("您可以直接拨用户分机“<?=$skycall_ext?>”!");
							</script>
							<?
						}
						elseif(''==$local_gw_skype)
						{
							?>
							<script>
								alert("本地没有可用的网关!");
							</script>
							<?
						}
						elseif(''==$gw_skype)
						{
							?>
							<script>
								alert("远程没有可用的网关!");
							</script>
							<?
						}
						else
						{
							$comm_msg='SKYREMOTEL '.$gw_skype.' '.$skycall_ext;
						}
					}
					else//第三方式为电话或手机
					{
						if(''==$local_gw_skype)
						{
							?>
							<script>
								alert("本地没有可用的网关!");
							</script>
							<?
						}
						elseif($gw_skype==$local_gw_skype)//用户在本地时
						{
							$comm_msg='SKYTEL '.${$skycall_thr};
						}
						elseif(''==$gw_skype)
						{
							?>
							<script>
								alert("远程没有可用的网关!");
							</script>
							<?
						}
						else//用户在远程
						{
							$comm_msg='SKYREMOTEL '.$gw_skype.' '.${$skycall_thr};
						}
					}
				}
				elseif($skycall_sec=='skycall_ext')//第二方式为分机
				{
					if($gw_skype==$local_gw_skype)//用户在本地时
					{
						?>
						<script>
							alert("您可以直接拨用户分机“<?=$skycall_ext?>”!");
						</script>
						<?
					}
					elseif(''==$local_gw_skype)
					{
						?>
						<script>
							alert("本地没有可用的网关!");
						</script>
						<?
					}
					elseif(''==$gw_skype)
					{
						?>
						<script>
							alert("远程没有可用的网关!");
						</script>
						<?
					}
					else
					{
						$comm_msg='SKYREMOTEL '.$gw_skype.' '.$skycall_ext;
					}
				}
				else//第三方式为电话或手机
				{
					if(''==$local_gw_skype)
					{
						?>
						<script>
							alert("本地没有可用的网关!");
						</script>
						<?
					}
					elseif($gw_skype==$local_gw_skype)//用户在本地时
					{
						$comm_msg='SKYTEL '.${$skycall_sec};
					}
					elseif(''==$gw_skype)
					{
						?>
						<script>
							alert("远程没有可用的网关!");
						</script>
						<?
					}
					else//用户在远程
					{
						$comm_msg='SKYREMOTEL '.$gw_skype.' '.${$skycall_sec};
					}
				}
			}
		}
		elseif($skycall_fir=='skycall_ext')//第一方式为分机
		{
			if($gw_skype==$local_gw_skype)//用户在本地时
			{
				?>
				<script>
					alert("您可以直接拨用户分机“<?=$skycall_ext?>”!");
				</script>
				<?
			}
			elseif(''==$local_gw_skype)
			{
				?>
				<script>
					alert("本地没有可用的网关!");
				</script>
				<?
			}
			elseif(''==$gw_skype)
			{
				?>
				<script>
					alert("远程没有可用的网关!");
				</script>
				<?
			}
			else
			{
				$comm_msg='SKYREMOTEL '.$gw_skype.' '.$skycall_ext;
			}
		}
		else//第一方式为电话或手机
		{
			if(''==$local_gw_skype)
			{
				?>
				<script>
					alert("本地没有可用的网关!");
				</script>
				<?
			}
			elseif($gw_skype==$local_gw_skype)//用户在本地时
			{
				$comm_msg='SKYTEL '.${$skycall_fir};
			}
			elseif(''==$gw_skype)
			{
				?>
				<script>
					alert("远程没有可用的网关!");
				</script>
				<?
			}
			else//用户在远程
			{
				$comm_msg='SKYREMOTEL '.$gw_skype.' '.${$skycall_fir};
			}
		}
	}
	$sql3="insert into skype_im(send_from,send_to,message,addtime,send_flag) values('".$user_skype."','".$send_to."','".$comm_msg."',now(),0)";
	if(''!=$comm_msg)
	{
		if(mysql_query($sql3))
		{
			sleep(5);
			$last_im_id=mysql_insert_id();
			$sql4="select send_flag from skype_im where id=".$last_im_id;
			$send_flag=mysql_result(mysql_query($sql4),0,'send_flag');
			if($send_flag==1)
			{
				?>
				<script>
					alert("转呼成功!\r\n您需要拨打分机号“*<?=$local_gw_ext?>”");
				</script>
				<?
			}
			else
			{
				?>
				<script>
					alert("转呼命令发送失败!");
				</script>
				<?
			}
		}
		else
		{
			?>
			<script>
				alert("数据库错误!");
			</script>
			<?
		}
	}
}

function findUsableGw($gw_group_name,$gw_group_id)
{
	if(''!=$gw_group_name)
	{
		$sql1="select * from group_info where group_name='".$gw_group_name."'";
	}
	elseif(''!=$gw_group_id)
	{
		$sql1="select * from group_info where group_id='".$gw_group_id."'";
	}
	$result1=mysql_query($sql1);
	$group_id=mysql_result($result1,0,'group_id');
	$sql2="select user_info.user_id,user_account,user_name,user_skype,user_status,user_status2,skycall_ext from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id order by user_info.user_id";
	$result2=mysql_query($sql2);
	$epn_on_count=mysql_num_rows($result2);
	while($r2=mysql_fetch_array($result2))
	{
		$group_skype=$r2['user_skype'];
		$group_ext=$r2['skycall_ext'];
		$group_status2=$r2['user_status2'];
		if($group_status2==1)
		{
			break;
		}
		else
		{
			$group_skype='';
			$group_ext='';
			continue;
		}
	}
	return $group_skype.'|'.$group_ext;
}
?>