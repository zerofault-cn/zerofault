<html>
<head>
<title>remote skype</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="refresh" content="300;">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard 网络名片 电子名片 语音留言 自动答录 电子名片">
</head>
<body topmargin=0 leftmargin=0 background="image/minibg.gif" style="background-position: center;background-repeat:no-repeat;background-attachment: fixed;background:transparent;overflow:auto">
<?
function searchTable()
{
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 style="border:#7392d7 1px solid;">
	<form action="<?=$PHP_SELF?>" method=post name=form2>
	<tr>
		<td height=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		模糊搜索：<input type=text name=key value="<?=$key?>" size=10>&nbsp;&nbsp;<input type=hidden name=list value=search><input type=submit name=submit value="搜索"></input>&nbsp;&nbsp;<a href="?list=user">全部列出</a>
		</td>
	</tr>
	</form>
	</table>
	<?
}
include_once "mysql_connect.php";

$my_id='7';//本地7,深圳54
$key=$HTTP_POST_VARS['key'];
if($list=='search')
{
	$labelTitle='搜索结果';
	$link='<a href='.$PHP_SELF.'>我的好友列表</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='.$PHP_SELF.'?list=user>所有用户列表</a>';
	$sql1="select count(*) from user_info where (user_name like '%".$key."%' or user_realname like '%".$key."%') and (user_status='ONLINE' or user_status='SKYPEME')";
	$online_count=mysql_result(mysql_query($sql1),0,0);//结果中的在线用户数
	$sql2="select * from user_info where (user_name like '%".$key."%' or user_realname like '%".$key."%') order by user_status desc,user_id desc";
	$result2=mysql_query($sql2);
	$row_count=mysql_num_rows($result2);//结果中的所有用户数
	setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
	searchTable();
}
elseif($list=='user')
{
	$labelTitle='所有用户';
	$link='<a href='.$PHP_SELF.'>我的好友列表</a>';
	$sql1="select count(*) from user_info where is_gw=0 and (user_status='ONLINE' or user_status='SKYPEME')";
	$online_count=mysql_result(mysql_query($sql1),0,0);//在线用户数
	$sql2="select * from user_info where is_gw=0 order by user_status desc,user_id desc";
	$result2=mysql_query($sql2);
	$row_count=mysql_num_rows($result2);//所有用户数
	setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
	searchTable();
}
else
{
	$labelTitle='我的好友';
	$link='<a href='.$PHP_SELF.'?list=user>所有用户列表</a>';
	$sql1="select count(*) from user_info,user_friend where user_info.is_gw=0 and user_friend.user_id=".$my_id." and user_friend.friend_id=user_info.user_id and (user_info.user_status='ONLINE' or user_info.user_status='SKYPEME')";
	$online_count=mysql_result(mysql_query($sql1),0,0);//好友在线数
	$sql2="select * from user_info,user_friend where user_info.is_gw=0 and user_friend.user_id=".$my_id." and user_info.user_id=user_friend.friend_id order by user_status desc,user_friend.friend_id desc";
	$result2=mysql_query($sql2);
	$row_count=mysql_num_rows($result2);
}

?>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<?
$i=0;
while($r2=mysql_fetch_array($result2))
{
	$user_id		=$r2[0];
	$user_account	=$r2['user_account'];
	$user_name		=$r2['user_name'];
	if(''==$user_name)
	{
		$user_name	=$user_account;
	}
	$user_skype		=$r2['user_skype'];
	$user_avatar	=$r2['user_avatar'];
	if(''==$user_avatar)
	{
		$user_avatar='no_avatar.gif';
	}
	$user_status	=$r2['user_status'];
	if(''==$user_status)
	{
		$user_status='UNKNOWN';
	}
	$skycall_ext	=$r2['skycall_ext'];
	$skycall_en_msg	=$r2['skycall_en_msg'];
	$skycall_msg	=$r2['skycall_msg'];
	$max_size=48;
	if(!file_exists('avatars/'.$user_avatar))
	{
		$user_avatar='no_avatar.gif';
	}
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
<tr id="<?=$i?>">
	<td style="padding:2px" onclick="clicki(<?=$i?>);" onMouseOver='this.style.backgroundColor="#c7e0ff"' onMouseOut='this.style.backgroundColor=""'><span id='s_user_id_<?=$i?>' style="display:none"><?=$user_id?></span><span id='s_user_skype_<?=$i?>' style="display:none"><?=$user_skype?></span><span id="mini<?=$i?>" style="margin-left:2px;"><img src="image/status_icon2/<?=$user_status?>.gif"  border=0 alt="呼叫 <?=$user_name?> " align=absmiddle>
	<?
	if(''!=$key)
	{
		echo eregi_replace($key,'<span style="color:red">'.$key.'</span>',$user_name);
	}
	else
	{
		echo $user_name;
	}
	?></span><span id="full<?=$i?>" style="margin-left:2px;display=none"><img src="image/status_icon2/<?=$user_status?>.gif"  border=0 alt="呼叫 <?=$user_name?> " align=top> <img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" align=top > <b><?=$user_name?></b></span></td>
</tr>
	<?
	$i++;
}
?>
</table>
</body>
<script>
var n=<?=$row_count?>;
function reset()
{
	for(var i=0;i<n;i++)
	{
		document.getElementById(i).style.backgroundColor="";
		document.getElementById("mini"+i).style.display="";
		document.getElementById("full"+i).style.display="none";
	}
}
function show(i)
{
	document.getElementById(i).style.backgroundColor="#c7e0ff";
	document.getElementById("mini"+i).style.display="none";
	document.getElementById("full"+i).style.display="";
}
function clicki(i)
{
	document.getElementById('s_i').innerHTML=i;
	document.getElementById('s_user_id').innerHTML=document.getElementById('s_user_id_'+i).innerHTML;
	document.getElementById('s_user_skype').innerHTML=document.getElementById('s_user_skype_'+i).innerHTML;
	document.getElementById('s_user_info').innerHTML=document.getElementById('full'+i).innerHTML;
	reset();
	show(i);
}
</script>
<span style="display:none" id=s_i></span>
<span style="display:none" id=s_user_id></span>
<span style="display:none" id=s_user_skype></span>
<span style="display:none" id=s_user_info></span>
</html>
