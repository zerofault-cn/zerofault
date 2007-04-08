<?
include_once "../include/mysql_connect.php";
$admin_account=$_REQUEST["admin_account"];
$admin_pass=$_REQUEST["admin_pass"];
$sql1="select * from admin_info where admin_account ='".$admin_account."'";
$result1=mysql_query($sql1);
if(!mysql_fetch_array($result1))
{
	setcookie("login_msg","不存在的用户名!");
	header("location:index.php?content=login_1");
	exit;
}
else
{
	$sql2="select admin_id,admin_account from admin_info where admin_account='".$admin_account."' and admin_pass=md5('".$admin_pass."')";
	$result2=mysql_query($sql2);
	if(!$r=mysql_fetch_array($result2))
	{
		setcookie("login_msg","密码错误,请重新输入");
		header("location:index.php?content=login_1");
		exit;
	}
	else
	{
		$admin_id=$r[0];
	echo	$sql3="select dict_entry.dentry_describe from dict_entry,admin_priority where dict_entry.del_flag=1 and dict_entry.dtype_id=70 and dict_entry.dentry_id=admin_priority.limittype and admin_priority.limitflag=1 and admin_priority.admin_id='".$admin_id."'";
		$result3=mysql_query($sql3);
		$i=0;
		while($r=mysql_fetch_array($result3))
		{
			setcookie("admin_limit[".$i++."]",$r[0]);
		}
		setcookie("goldsoft_admin",$admin_account);
		setcookie("login_msg","");
		header("location:index.php");
		exit;
	}
}
?>


