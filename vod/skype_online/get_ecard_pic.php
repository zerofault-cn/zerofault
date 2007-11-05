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
if($user_status=='SKYPEME' || $user_status=='ONLINE')
{
	$pic='ecardonline.gif';
}
else
{
	$pic='ecardoffline.gif';
}
Header("Content-type:image/gif");
echo file_get_contents('image/'.$pic);
?>
