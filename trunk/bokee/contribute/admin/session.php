<?
//session_start();

//if(!session_is_registered("admin"))
{
//	header("location:index.php");
}
$blogID=getBlogID();
$adminList = array('wuyanpeng','zengaizhi', 'flashtom','zerofault');
if(in_array($blogID, $adminList))
{
//	header("location:channel.php?sys_flag=1");
}
else
{
	echo 'дЗипн╢╣гб╪';
	exit;
}
?>