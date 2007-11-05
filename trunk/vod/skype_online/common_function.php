<?
function contectUs($group_name)
{
//	$group_name='家易通在线';
	$sql1="select * from group_info where group_name='".$group_name."'";
	$result1=mysql_query($sql1);
	$group_id=mysql_result($result1,0,'group_id');
	$group_email=mysql_result($result1,0,'group_email');
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
			$group_skype='goldsoft-lifeng';
			continue;
		}
	}
	if(''==$group_skype)
	{
		$group_skype='goldsoft-lifeng';
	}
	?>
	<table width="100%" border=0 cellpadding=5 cellspacing=0>
	<tr>
		<td align=center valign=center style="font-size:14pt">快速联系我们
		<a href="mailto://<?=$group_email?>"><img src="image/action/email1.gif" border=0 alt="发邮件给<?=$group_name?>"></a>
			<a href="javascript:void(0)" onclick="window.open('send_im.php?user_skype=<?=$group_skype?>','','width=450,height=340,toolbar=no,status=no,scrollbars=yes,resizable=no');"><img src="image/action/im1.gif" border=0></a>
			<a href="callto://<?=$group_skype?>"><img src="image/action/skypeme1.gif" border=0>
		</td>
	</tr>
	</table>
	<?
}

function userListNavigation1()
{
	global $action,$action2,$row_count,$pageitem,$offset,$list;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td colspan=2 align=center class=topPageIndex>
		<?
		$allPage=ceil($row_count/$pageitem);
		$tmp_offset=0;
		for($i=0;$i<$allPage;$i++)
		{
			if($offset==$tmp_offset)
			{
				echo $i+1;
			}
			else
			{
				?>
				<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$tmp_offset?>&list=<?=$list?>"><?=$i+1?></a>
				<?
			}
			$tmp_offset+=$pageitem;
		}
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;<?=$offset+1?>-<?=min(($offset+$pageitem),$row_count)?> <span style="color:#000066">of</span> <?=$row_count?>
	</td>
</tr>
</table>
	<?
}

function userListNavigation2()
{
	global $action,$action2,$row_count,$pageitem,$offset,$list;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td align=right class=bottomPageIndex>
	<?
	if($offset!=0)
	{
		$preoffset=max(($offset-$pageitem),0);
		?>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=0&list=<?=$list?>">首页</a>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$preoffset?>&list=<?=$list?>">上一页</a>
		<?
	}
	else
	{
		echo '首页&nbsp;上一页&nbsp;';
	}
	if(($offset+$pageitem)<$row_count)
	{
		$nextoffset=$offset+$pageitem;
		$endpage=$row_count-$pageitem;
		?>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$nextoffset?>&list=<?=$list?>">下一页</a>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$endpage?>&list=<?=$list?>">尾页</a>
		<?
	}
	else
	{
		echo '下一页&nbsp;尾页&nbsp;';
	}
	echo '页码:'.(ceil(($offset+1)/$pageitem)).'/'.ceil($row_count/$pageitem);
	?>
	</td>
</tr>
</table>
	<?
}

function userListNavigation2_2()
{
	global $action,$action2,$row_count,$pageitem,$offset,$list;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 style="COLOR: #5077cd;font-weight:bold">
<tr>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="community.php" target=_blank><img src="image/user_minilogo.gif" border=0 alt="添加好友"></a>
	<a href="password.php"><img src="image/password_minilogo.gif" border=0 alt="修改密码"></a>
	<a href="transfer.php"><img src="image/transfer_minilogo.gif" border=0 alt="转移设置"></a>
	</td>
	<td align=right>
	<?
	if($offset!=0)
	{
		$preoffset=max(($offset-$pageitem),0);
		?>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=0&list=<?=$list?>"><img src="image/first.gif" border=0 align=center></a>&nbsp;&nbsp;
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$preoffset?>&list=<?=$list?>"><img src="image/previous.gif" border=0 align=center></a>&nbsp;&nbsp;
		<?
	}
	else
	{
		echo '<img src="image/first_na.gif" border=0 align=center>&nbsp;&nbsp;<img src="image/previous_na.gif" border=0 align=center>&nbsp;&nbsp;';
	}
	if(($offset+$pageitem)<$row_count)
	{
		$nextoffset=$offset+$pageitem;
		$endpage=$row_count-$pageitem;
		?>
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$nextoffset?>&list=<?=$list?>"><img src="image/next.gif" border=0 align=center></a>&nbsp;&nbsp;
		<a href="?action=<?=$action?>&action2=<?=$action2?>&offset=<?=$endpage?>&list=<?=$list?>"><img src="image/last.gif" border=0 align=center></a>&nbsp;&nbsp;
		<?
	}
	else
	{
		echo '<img src="image/next_na.gif" border=0 align=center>&nbsp;&nbsp;<img src="image/last_na.gif" border=0 align=center>&nbsp;&nbsp;';
	}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;'.(ceil(($offset+1)/$pageitem)).'/'.ceil($row_count/$pageitem).' 页';
	?>&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
</tr>
</table>
	<?
}

function cateNavigation($pid)
{
	global $level;
	static $navi='';
	if($pid!=0)
	{
		$sql1="select category_pid,category_name from category_info where category_id=".$pid;
		$result1=mysql_query($sql1);
		$category_pid=mysql_result($result1,0,0);
		$category_name=mysql_result($result1,0,1);
		$navi='<a href="?pid='.$pid.'">'.$category_name.'</a> >> '.$navi;
		$level++;
		return	cateNavigation($category_pid);
	}
	else
	{
		return '<a href="?pid='.$pid.'">Home</a> >> '.$navi;
	}
}

function okMsg($msgStr)
{
	$returnUrl=$_COOKIE['cookie_returnUrl'];
	if(''==$returnUrl)
	{
		$returnUrl='index.php';
	}
	?>
<center>
<table width="770" height="63%" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/msg_logo.gif"><img src="image/okMsg_title.gif"></td>
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
			<td align=center><span class=okmsg><?=$msgStr?></span></td>
		</tr>
		<tr>
			<td align=center><a href="<?=$returnUrl?>">返回</a></td>
		</tr>
		</table>
		<br><br>
		</td>
	</tr>
	<tr>
		<td><img src="image/table_bottom_left.gif"></td>
		<td colspan=2 background="image/table_bottom.gif"></td>
		<td><img src="image/table_bottom_right.gif"></td>
	</tr>
	</table>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}

function errorMsg($msgStr)
{
	?>
<center>
<table width="770" height="63%" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/msg_logo.gif"><img src="image/errMsg_title.gif"></td>
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
			<td align=center><span class=errormsg><?=$msgStr?></span></td>
		</tr>
		<tr>
			<td align=center><a href="javascript:history.go(-1)">返回</a></td>
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
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}

function okMsg2($msgStr)
{
	$returnUrl=$_COOKIE['cookie_returnUrl'];
	if(''==$returnUrl)
	{
		$returnUrl='index.php';
	}
	?>
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/msg_logo.gif"><img src="image/okMsg_title.gif"></td>
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
		<td align=center><span class=okmsg><?=$msgStr?></span></td>
	</tr>
	<tr>
		<td align=center><a href="<?=$returnUrl?>">返回</a></td>
	</tr>
	</table>
	<br><br>
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

function errorMsg2($msgStr)
{
	?>
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/msg_logo.gif"><img src="image/errMsg_title.gif"></td>
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
		<td align=center><span class=errormsg><?=$msgStr?></span></td>
	</tr>
	<tr>
		<td align=center><a href="javascript:history.go(-1)">返回</a></td>
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

function loginTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/login_logo.gif"><img src="image/login_title.gif"></td>
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
		<form action="login.php" name=form1 method=post>
		<tr>
			<td width=300 align=right>&nbsp;EPN:</td>
			<td><input type=text name=user_account size=13></td>
		</tr>
		<tr>
			<td align=right>密码:</td>
			<td><input type=password name=user_password size=13></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=submit name=submit value="登录">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='register.php'" value="注册"></td>
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

function infoTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/user_info_logo.gif"><img src="image/user_info_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=5 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=5 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td colspan=2>您的EPN:</td>
	</tr>
	<tr>
		<td colspan=2 align=right><b><?=$_COOKIE['cookie_user_account']?></b></td>
	</tr>
	<tr>
		<td><a href="community.php?p=user_profile">基本信息</a></td>
		<td><a href="community.php?p=modify_password">修改密码</a></td>
	</tr>
	<tr>
		<td><a href="community.php?p=modify_transfer">转移设置</a></td>
		<td><a href="logout.php">注销</a></td>
	</tr>
	<tr>
		<td><img src="image/table_bottom_left.gif"></td>
		<td colspan=2 background="image/table_bottom.gif"></td>
		<td><img src="image/table_bottom_right.gif"></td>
	</tr>
	</table>
	<?
}

function newsTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 style="line-height:130%" bgcolor="#E5F4FF">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/favorite_logo.gif"><img src="image/news_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td colspan=2>
		<div style="margin-left:1em">
		<?
		$sql1="select topic_id,topic_title from phpbb_topics where forum_id=1 order by topic_id desc limit 0,5";
		$result1=mysql_db_query('phpbb2',$sql1);
		while($r=mysql_fetch_array($result1))
		{
			$id=$r[0];
			$title=$r[1];
			?>
		<li><a href="http://forum.skycall.cn/viewtopic.php?t=<?=$id?>" target=_blank><?=$title?></a></li>
			<?
		}
		?>
		</div>
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

function downloadTable()
{
	if($fp=@fopen("update/update.ini","r"))
	{
		$s_name=fgets($fp,4096);
		$s_ver=fgets($fp,4096);
		$f_name=substr(trim($s_name),1,-1);
		$f_ver=substr(trim($s_ver),8);
	}
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 style="line-height:130%" bgcolor="#E5F4FF">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/download_logo.gif"><img src="image/download_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td colspan=2>
		<div style="margin-left:1em">
		<a href="setup/SkyMate_Setup.exe"><?=$f_name?></a>&nbsp;(版本<?=$f_ver?>)<br>
		<a href="setup/SkypeSetup-1.2.0.37.exe">Skype</a>&nbsp;(版本1.2.0.37)
		</div>
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

function contactTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 style="line-height:130%" bgcolor="#E5F4FF">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/contact_logo.gif"><img src="image/contact_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td colspan=2>
		<div style="margin-left:1em">
		呼叫我：<a href="callto://goldsoft-lifeng"><img src="image/skypeme_purple.gif" border=0></a><br>
		eCard：<a href="javascript:void(0)" onclick="window.open('get_ecardx.php?epn=13823147901','','width=387,height=232,toolbar=no,status=no,scrollbars=no,resizable=no');" title="点击打开eCard"><img src="get_ecard_pic.php?s=goldsoft-lifeng" border="0"></a>
		</div>
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

function onlineTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/friend_online_logo.gif"><img src="image/friend_online_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td>
		<iframe src="friend_online.php" frameborder=0 width="100%" height="90" allowTransparency="true"></iframe>
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
	
function searchTable()
{
	global $type,$key,$exact;
	?>
		
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<script language="javascript">
	function check()
	{
		if(window.document.search.key.value=="")
		{
			alert("您没有输入关键字!");
			document.search.key.focus();
			return false;
		}
		return true;
	}
	</script>
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/search_logo.gif"><img src="image/search_title.gif"></td>
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
		<form name=search action="?" method=post onsubmit="return check();">
		<tr>
			<td>
			在<select name=type>
				<option value="user_account"
				<?
				if($type=='user_account')echo ' selected';?>>EPN号</option>
				<option value="user_name"
				<?
				if($type=='user_name')echo ' selected';?>>昵称</option>
				<option value="user_skype"
				<?
				if($type=='user_skype')echo ' selected';?>>Skype</option>
				</select>中，搜索关键字为<input type=text name=key value="<?=$key?>" size=13><br>
			<input type=radio name=exact value=1 style="BACKGROUND-COLOR:transparent;"
			<?
			if($exact==1)echo ' checked';?>>精确<input type=radio name=exact value=0 style="BACKGROUND-COLOR:transparent;"
			<?
			if(''==$exact || $exact==0)echo ' checked';?>>模糊
			<input type=submit name=submit value="搜索">
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
	<?
}

function otherLinkTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
	<tr>
		<td width=20 height=30><img src="image/table_top_left.gif"></td>
		<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/otherlink_logo.gif"><img src="image/otherlink_title.gif"></td>
		<td width=18><img src="image/table_top_right.gif"></td>
	</tr>
	<tr>
		<td rowspan=2 background="image/table_left.gif"></td>
		<td colspan=2></td>
		<td rowspan=2 background="image/table_right.gif"></td>
	</tr>
	<tr>
		<td><a href="community.php">所有会员</a></td>
		<td><a href="category.php">用户群组</a></td>
	</tr>
	<tr>
		<td><img src="image/table_bottom_left.gif"></td>
		<td colspan=2 background="image/table_bottom.gif"></td>
		<td><img src="image/table_bottom_right.gif"></td>
	</tr>
	</table>
	<?
}

function userTable()
{
	global $user_id;
	$sql1="select * from user_info where user_id='".$user_id."'";
	$result1=mysql_query($sql1);
	$user_account	=mysql_result($result1,0,'user_account');
	$user_name		=mysql_result($result1,0,'user_name');
	if(''==$user_name)
	{
		$user_name	=$user_account;
	}
	$user_sex		=mysql_result($result1,0,'user_sex');
	if('0'==$user_sex || ''==$user_sex)
	{
		$user_sex	='保密';
	}
	$user_from1		=mysql_result($result1,0,'user_from1');
	$user_from2		=mysql_result($result1,0,'user_from2');
	$user_from3		=mysql_result($result1,0,'user_from3');
	$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
	if('  '==$user_from || '0 0 '==$user_from)
	{
		$user_from='保密';
	}
	$user_email		=mysql_result($result1,0,'user_email');
	$user_qq		=mysql_result($result1,0,'user_qq');
	$user_skype		=mysql_result($result1,0,'user_skype');
	$user_website	=mysql_result($result1,0,'user_website');
	$user_regdate	=mysql_result($result1,0,'user_regdate');
	$user_lastlogin	=mysql_result($result1,0,'user_lastlogin');
	$user_avatar	=mysql_result($result1,0,'user_avatar');
	if(''==$user_avatar)
	{
		$user_avatar='no_avatar.gif';
	}
	$user_signature	=mysql_result($result1,0,'user_signature');
	$user_status	=mysql_result($result1,0,'user_status');
	if(''==$user_status)
	{
		$user_status='UNKNOWN';
	}
	$max_size=84;
	if(!file_exists('avatars/'.$user_avatar))
	{
		$user_avatar='no_avatar.gif';
	}
	$avatar_size=GetImageSize("avatars/".$user_avatar);//格式化图片尺寸
	$avatar_width=$avatar_size[0];
	$avatar_height=$avatar_size[1];
	if($avatar_width/(float)$avatar_height >=1)
	{
//		if($avatar_width>$max_size)
		{
			$avatar_width=$max_size;
			$avatar_height=$max_size*$avatar_size[1]/(float)$avatar_size[0];
		}
	}
	else
	{
//		if($avatar_height>$max_size)
		{
			$avatar_height=$max_size;
			$avatar_width=$max_size*$avatar_size[0]/(float)$avatar_size[1];
		}
	}
	?>
	<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 bgcolor=white>
	<tr>
		<td  height=102 align=center background="image/avatar_bg.gif" style="background-position: bottom;background-repeat: no-repeat;"><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0>
		</td>
	</tr>
	<tr>
		<td valign=top>
		<span style="margin-left:1em"><?
		if('0'!=$user_skype && ''!=$user_skype)
		{
			echo '<a href="callto://'.$user_skype.'"><img src="image/status_icon/'.$user_status.'.gif" border=0 height=22 align=absmiddle></a>';
		}
		?>
		&nbsp;<a class=userName href="?p=user_info&user_id=<?=$user_id?>" title="点击查看 <?=$user_name?> 的详细资料"><?=$user_name?></a></span>
		</td>
	</tr>
	</table>
<?
}

function userFullTable()
{
	global $user_id,$user_account,$user_avatar,$user_skype,$user_name,$user_sex,$user_from,$user_regdate,$user_lastlogin,$user_email,$user_name,$user_website,$user_qq,$user_signature,$user_status,$user_status2,$user_ip;
	$sql1="select group_info.group_id,group_info.group_name from group_info,group_member where group_info.group_id=group_member.group_id and group_member.user_id=".$user_id;
	$result1=mysql_query($sql1);
	if(mysql_num_rows($result1)!=0)
	{
		while($r=mysql_fetch_array($result1))
		{
			$group_name.='<a href="?action=viewgroup&group_id='.$r[0].'">'.$r[1].'</a>|';
		}
	}
	else
	{
		$group_name='还未加入任何组';
	}
	?>

<tr>
	<td align=center>
	<?
	if(''!=$user_avatar)
	{
		$max_size=32;
		$avatar_size=GetImageSize("avatars/".$user_avatar);
		$avatar_width=$avatar_size[0];
		$avatar_height=$avatar_size[1];
		if($avatar_width/(float)$avatar_height >=1)
		{
			if($avatar_width>$max_size)
			{
				$avatar_width=$max_size;
				$avatar_height=$max_size*$avatar_size[1]/(float)$avatar_size[0];
			}
		}
		else
		{
			if($avatar_height>$max_size)
			{
				$avatar_height=$max_size;
				$avatar_width=$max_size*$avatar_size[0]/(float)$avatar_size[1];
			}
		}
		?>
		<a href="callto://<?=$user_skype?>"><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0 alt="呼叫 <?=$user_name?> "></a>
		<?
	}
	?>
	</td>
	<td align=center>
		<img src="image/status_icon/<?=$user_status?>.gif" alt="用户 <?=$user_name?> 的SKYPE在线状态">&nbsp;<a href="callto://<?=$user_skype?>"><img src="image/action/skypeme1.gif" alt="呼叫 <?=$user_name?>" border=0></a>&nbsp;</td>
	<td><?=$user_account?>&nbsp;</td>
	<td><b><a href="javascript:void(0)" onclick="window.open('user_info.php?user_id=<?=$user_id?>','','width=450,height=400,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="点击查看 <?=$user_name?> 的详细资料"><?=$user_name?></b></a>&nbsp;</td>
	<td>
	<?
	if($user_sex=='男')
	{
		echo '<img src="image/male.gif" alt="帅哥">';
	}
	elseif($user_sex=='女')
	{
		echo  '<img src="image/female.gif" alt="美女">';
	}
	else
	{
		echo $user_sex;
	}
	?>
	</td>
	<td>&nbsp;<?=substr($user_regdate,0)?></td>

	<?
}

function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}

?>