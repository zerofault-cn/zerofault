<?
include_once "config.php";
$refer=$_REQUEST['refer'];
$admin=trim($_REQUEST['admin']);
$passwd=trim($_REQUEST['passwd']);
for($i=0;$i<count($adminArr);$i++)
{
	if($adminArr[$i][0]==$admin && $adminArr[$i][1]==$passwd)
	{
		$_SESSION['boardadmin']=$admin;
	}
}
if(''!=$refer)
{
	header("location:".$refer);
	exit;
}
header("location:index.php");
exit;
?>