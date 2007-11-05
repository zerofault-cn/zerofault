<?
include "mysql_connect.php";
$sql="select user_status from user_info where user_skype='".$s."'";
$result=mysql_query($sql);
if(mysql_fetch_array($result))
{
	$user_status=mysql_result($result,0,0);
}
else
{
	$user_status='';
}
if($user_status=='SKYPEME' || $user_status=='ONLINE' || $user_status=='AWAY' || $user_status=='BUSY' || $user_status=='DND' || $user_status=='OFFLINE' || $user_status=='LOGGEDOUT')
{
	if($user_status=='LOGGEDOUT')
	{
		$user_status='OFFLINE';
	}
}
else
{
	$user_status='NA';
}
echo file_get_contents('image/status_small/'.$user_status.'.gif');

?>
