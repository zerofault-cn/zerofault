<?
function viewGroup()
{
	global $HTTP_GET_VARS;
	$group_id=$HTTP_GET_VARS['group_id'];
	$sql1="select * from group_info where group_id=".$group_id;
	$result1=mysql_query($sql1);
	$group_name=mysql_result($result1,0,'group_name');
	$group_email=mysql_result($result1,0,'group_email');
	$group_desc=mysql_result($result1,0,'group_desc');
	$group_desc=mysql_result($result1,0,'group_desc');
	$group_avatar=mysql_result($result1,0,'group_avatar');
	if(''==$group_avatar)
	{
		$group_avatar='flower.jpg';
	}
	$group_createdate=mysql_result($result1,0,'group_createdate');
	$sql2="select user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id order by member_id";
	$result2=mysql_query($sql2);
	$r2=mysql_fetch_array($result2);
	$group_creator=$r2['user_name'];

	$sql3="select user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id and user_info.user_status2=1 order by group_member.member_id";
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
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br>
	<table width="90%" border=0 cellpadding=5 cellspacing=0 class=innertable>
	<caption align=left>组信息</caption>
	<tr>
		<td width="50%" align=center>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center><img src="avatars/<?=$group_avatar?>"></td>
			</tr>
			<tr>
				<td>组名称:</td>
			</tr>
			<tr>
				<td bgcolor=#cFe6fB align=center><?=$group_name?></td>
			</tr>
			<tr>
				<td>创建者:</td>
			</tr>
			<tr>
				<td bgcolor=#cFe6fB align=center><?=$group_creator?></td>
			</tr>
			<tr>
				<td>创建日期:</td>
			</tr>
			<tr>
				<td bgcolor=#cFe6fB align=center><?=$group_createdate?></td>
			</tr>
			<tr>
				<td>组E_mail:</td>
			</tr>
			<tr>
				<td bgcolor=#cFe6fB align=center><?=$group_email?></td>
			</tr>
			<tr>
				<td>简介:</td>
			</tr>
			<tr>
				<td bgcolor=#cFe6fB>&nbsp;&nbsp;&nbsp;&nbsp;<?=$group_desc?></td>
			</tr>
			</table>
		</td>
		<td>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>
			<?
			mysql_data_seek($result2,0);
			$epn_all_count=mysql_num_rows($result2);
			while($r2=mysql_fetch_array($result2))
			{
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
					<a href="callto://<?=$user_skype?>"><img src="image/status_icon/<?=$user_status?>.gif" border=0 height=20></a>
					<?
				}
				else
				{
					?>
					<img src="image/status_icon/<?=$user_status?>.gif" border=0 height=20>
					<?
				}
				?>
				<img src="image/status_icon/<?=$user_status2?>.gif"><?=$user_name?></td>
			</tr>
				<?
			}
			?>
			<caption align=left style="font-size:10pt">EPN已登录/未登录:<?=$epn_on_count?>/<?=$epn_all_count?></caption>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=button onclick="javascript:window.location='callto://<?=$group_skype?>';" value="呼叫这个组" 
		<?
		if($group_skype=='')
		{
			echo 'disabled';
		}
		?>>&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='?action=joingroup&group_id=<?=$group_id?>';" value="加入这个组"></td>
	</tr>
	</table>
	<br>
	</td>
</tr>
</table>
	<?
}

function joinGroup()
{
	global $HTTP_GET_VARS;
	$group_id=$HTTP_GET_VARS['group_id'];
	$user_id=$_COOKIE['cookie_user_id'];
	$sql1="select * from group_member where group_id=".$group_id." and user_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="insert into group_member(group_id,user_id) values(".$group_id.",".$user_id.")";
	if(!isset($user_id) || ''==$user_id)
	{
		errorMsg("您没有登录或者登录已超时,请<a href='?action=login1'>重新登录</a>");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg("您已经是这个组的成员了!");
	}
	elseif(mysql_query($sql2))
	{
		okMsg("加入成功!");
	}
	else
	{
		errorMsg("数据库错误或者改组禁止加入");
	}
}
?>