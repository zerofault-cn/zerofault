<?
if(!isset($action) || ''==$action)
{
	$sql1="select * from group_info where group_id=".$group_id;
	$result1=mysql_query($sql1);
	$group_name=mysql_result($result1,0,'group_name');
	$group_email=mysql_result($result1,0,'group_email');
	$group_desc=mysql_result($result1,0,'group_desc');
	$group_desc=mysql_result($result1,0,'group_desc');
	$group_avatar=mysql_result($result1,0,'group_avatar');
	if(''==$group_avatar)
	{
		$group_avatar='no_avatar.gif';
	}
	$group_createdate=mysql_result($result1,0,'group_createdate');
	$sql2="select user_info.user_id,user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id order by member_id";
	$result2=mysql_query($sql2);
	$r2=mysql_fetch_array($result2);
	$creator_id=$r2['user_id'];
	$creator_name=$r2['user_name'];

	$sql3="select user_info.user_id,user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id and user_info.user_status2=1 order by group_member.member_id";
	$result3=mysql_query($sql3);
	$epn_on_count=mysql_num_rows($result3);
	while($r3=mysql_fetch_array($result3))
	{
		$group_skype=$r3['user_skype'];
		$group_status=$r3['user_status'];
		if($group_status=='ONLINE' || $user_status=='SKYPEME')
		{
			break;
		}
		elseif($group_status=='BUSY')
		{
			$group_skype='';
			continue;
		}
	}
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/groupinfo_logo.gif"><img src="image/groupinfo_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width="50%" align=center>
				<table width="100%" border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td align=center><img src="avatars/<?=$group_avatar?>"></td>
				</tr>
				<tr>
					<td>�����ƣ�</td>
				</tr>
				<tr>
					<td bgcolor=#cFe6fB align=center><?=$group_name?></td>
				</tr>
				<tr>
					<td>�����ߣ�</td>
				</tr>
				<tr>
					<td bgcolor=#cFe6fB align=center><?=$creator_name?></td>
				</tr>
				<tr>
					<td>��������:</td>
				</tr>
				<tr>
					<td bgcolor=#cFe6fB align=center><?=$group_createdate?></td>
				</tr>
				<tr>
					<td>��E_mail:</td>
				</tr>
				<tr>
					<td bgcolor=#cFe6fB align=center><?=$group_email?></td>
				</tr>
				<tr>
					<td>���:</td>
				</tr>
				<tr>
					<td bgcolor=#cFe6fB><p><?=$group_desc?></p></td>
				</tr>
				</table>
			</td>
			<td width="1%" height="100%" align=center>
				<table width=3 height="100%" border=0 cellpadding=0 cellspacing=0 background="image/hr-v.gif"><tr><td></td></tr></table><!-- �߶��Զ���Ӧ����ֱ���� -->
			</td>
			<td width="49%" valign=top>
				<table width="100%" border=0 cellpadding=0 cellspacing=0>
				<?
				mysql_data_seek($result2,0);
				$epn_all_count=mysql_num_rows($result2);
				while($r2=mysql_fetch_array($result2))
				{
					$user_id=$r2['user_id'];
					$user_account=$r2['user_account'];
					$user_name=$r2['user_name'];
					$user_skype=$r2['user_skype'];
					$user_status=$r2['user_status'];
					$user_status2=$r2['user_status2'];
					if(''==$user_name)
					{
						$user_name=$user_account;
					}
					?>
				<tr>
					<td>
					<?
					if($_COOKIE['cookie_user_status2']==1 && ($user_status=='ONLINE' || $user_status=='SKYPEME'))
					{
						?>
						<a href="callto://<?=$user_skype?>"><img src="image/status_icon/<?=$user_status?>.gif" border=0 height=20 align=absmiddle></a>
						<?
					}
					else
					{
						?>
						<img src="image/status_icon/<?=$user_status?>.gif" border=0 height=20 align=absmiddle>
						<?
					}
					?>
					<img src="image/status_icon/<?=$user_status2?>.gif" align=absmiddle><a href="javascript:void(<?=$user_id?>)" onclick="window.open('user_info.php?user_id=<?=$user_id?>','','width=450,height=320,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="����鿴 <?=$user_name?> ����ϸ����"><?=$user_name?></a></td>
				</tr>
					<?
				}
				?>
				<caption align=left style="font-size:14px">EPN�ѵ�¼/δ��¼��<?=$epn_on_count?>/<?=$epn_all_count?></caption>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=3 align=center>
			<input type=button onclick="javascript:window.location='callto://<?=$group_skype?>';" value="���������" 
			<?
			if($group_skype=='')
			{
				echo ' disabled';
			}
			?>>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?
			if(''!=$_COOKIE['cookie_user_id'])
			{
				$sql3="select * from group_member where group_id=".$group_id." and user_id=".$_COOKIE['cookie_user_id'];
				$result3=mysql_query($sql3);
				if(mysql_fetch_array($result3))
				{
					?>
			<input type=button onclick="javascript:window.location='?action=leavegroup&group_id=<?=$group_id?>';" value="�˳������">
					<?
				}
				else
				{
					?>
			<input type=button onclick="javascript:window.location='?action=joingroup&group_id=<?=$group_id?>';" value="���������">
					<?
				}
			}
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=button onclick="javascript:window.location='category.php?pid=<?=$_COOKIE['cookie_cate_pid']?>';" value="�������б�">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?
			if($_COOKIE['cookie_user_id']==$creator_id)
			{
				?>
				<input type=button onclick="javascript:window.location='?action=delgroup&group_id=<?=$group_id?>';" value="ɾ�������">
				<?
			}
			?>
			</td>
		</tr>
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
elseif($action=='leavegroup')
{
	leaveGroup();
}
elseif($action=='joingroup')
{
	joinGroup();
}
elseif($action=='delgroup')
{
	delGroup();
}

function leaveGroup()
{
	global $group_id;
	$user_id=$_COOKIE['cookie_user_id'];
	$sql1="delete from group_member where user_id=".$user_id." and group_id=".$group_id;
	if(''==$user_id)
	{
		setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
		errorMsg2('<br>��û�е�¼���ߵ�¼�ѳ�ʱ,��<a href="login.php">���µ�¼</a><br><br>');
	}
	elseif($user_id==$creator_id)
	{
		errorMsg2("<br>���������Ĵ����ߣ���ֻ��ɾ������飬�����˳�����飡<br><br>");
	}
	elseif(mysql_query($sql1))
	{
		okMsg2("<br>�˳��ɹ�<br><br><a href='javascript:history.go(-1)'>ȷ��&����</a><br><br>");
	}
	else
	{
		errorMsg2("<br>ϵͳ���ݿ����!<br><br>");
	}
}

function joinGroup()
{
	global $group_id;
	$user_id=$_COOKIE['cookie_user_id'];
	$sql1="select * from group_member where group_id=".$group_id." and user_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="insert into group_member(group_id,user_id) values(".$group_id.",".$user_id.")";
	if(!isset($user_id) || ''==$user_id)
	{
		setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
		errorMsg2('<br>��û�е�¼���ߵ�¼�ѳ�ʱ,��<a href="login.php">���µ�¼</a><br><br>');
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg2("<br>���Ѿ��������ĳ�Ա��!<br><br>");
	}
	elseif(mysql_query($sql2))
	{
		okMsg2("<br>����ɹ�!<br><br><a href='javascript:history.go(-1)'>ȷ��&����</a><br><br>");
	}
	else
	{
		errorMsg2("<br>���ݿ������߸����ֹ���룡<br><br>");
	}
}
function delGroup()
{
	global $group_id;
	$user_id=$_COOKIE['cookie_user_id'];
	$sql1="delete from group_member where group_id=".$group_id;
	$sql2="delete from group_info where group_id=".$group_id;
	if(mysql_query($sql1) && mysql_query($sql2))
	{
		okMsg2("<br>ɾ�����!<br><br>");
	}
	else
	{
		errorMsg2("<br>���ݿ����<br><br>");
	}
}
?>
