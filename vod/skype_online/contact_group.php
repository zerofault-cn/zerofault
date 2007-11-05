<?
contectUs();
function contectUs()
{
$group_name='家易通在线';
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
?>