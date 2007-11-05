<html>
<head>
<meta http-equiv="refresh" content="60;">
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">>
body {
	
	scrollbar-face-color:		#6e94b7;
	scrollbar-highlight-color:	#E5F4FF;
	scrollbar-shadow-color:		#E5F4FF;
	scrollbar-3dlight-color:	#E5F4FF;
	scrollbar-arrow-color:		#E5F4FF;
	scrollbar-track-color:		#E5F4FF;
	scrollbar-darkshadow-color: #E5F4FF;
}
</style>
</head>
<body topmargin=0 leftmargin=0 style="background:transparent;overflow:auto">
<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0>
<?
if(''==$_COOKIE['cookie_user_id'])
{
	?>
<tr>
	<td>&nbsp;登录已超时</td>
</tr>
	<?
}
else
{
	include_once "mysql_connect.php";
	$sql1="select user_info.user_id,user_info.user_account,user_info.user_name,user_info.user_status,user_info.user_skype from user_friend,user_info where user_friend.user_id=".$_COOKIE['cookie_user_id']." and user_friend.friend_id=user_info.user_id and (user_info.user_status='ONLINE' or user_info.user_status='SKYPEME')";
	$result1=mysql_query($sql1);
	while($r1=mysql_fetch_array($result1))
	{
		$user_id=$r1[0];
		$user_account=$r1[1];
		$user_name=$r1[2];
		$user_status=$r1[3];
		$user_skype=$r1[4];
		if(''==$user_name)
		{
			$user_name=$user_account;
		}
		?>
<tr>
	<td height=30>&nbsp;<a href="CALLTO://<?=$user_skype?>" title="呼叫 <?=$user_name?>"><img src="image/status_icon/<?=$user_status?>.gif" border=0 align=absmiddle></a><a href="javascript:void(0)" onclick="window.open('user_info.php?my_id=<?=$_COOKIE['cookie_user_id']?>&user_id=<?=$user_id?>','','width=500,height=430,toolbar=no,status=no,scrollbars=yes,resizable=no');" title="点击查看 <?=$user_name?> 的详细资料"><?=$user_name?></a></td>
</tr>
		<?
	}
	if(''==$user_id)
	{
		?>
<tr>
	<td>&nbsp;没有在线好友</td>
</tr>
		<?
	}
}
?>
<tr>
	<td height="100%">&nbsp;</td>
</tr>
</table>
</body>