<?
define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$phone=$_REQUEST['phone'];
$passwd=$_REQUEST['passwd'];
$re_passwd=$_REQUEST['re_passwd'];
$mm_id=$_REQUEST['mm_id'];

if(''!=$_REQUEST['submit'] && $passwd==$re_passwd)
{
	//先检查此手机号是否已经给某个MM投过票
	$sql1="select count(*) from poll_sms1 where mm_id=".$mm_id." and status=1 and phone='".$phone."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_fetchfield(0,0,$result1)>0)//已投票
	{
		//再检查此手机号还没被用户注册
		$sql2="select count(*) from user_phone where phone='".$phone."'";
		$result2=$db->sql_query($sql2);
		if($db->sql_fetchfield(0,0,$result2)>0)//已注册
		{
			echo $phone.'已注册';
		}
		else
		{
			//添加手机到用户表
			$sql3="insert into poll_user set phone='".$phone."',passwd='".md5($passwd)."'";
			if($db->sql_query($sql3))
			{
				$uid=$db->sql_nextid();
				$sql4="insert into user_phone set uid=".$uid.",phone='".$phone."'";
				if($db->sql_query($sql4))
				{
					echo '注册ok,用户ID是'.$uid;
				}
			}
		}
	}
	else
	{
		echo $phone.'还未投过票';
		echo "<br>或者，";
		echo $phone.'未给'.$mm_id.'投过票';
	}
}
else
{
	?>
<form action="" method="post" name="form1">
手机号：<input type="text" name="phone"><br>
密码：<input type="password" name="passwd"><br>
密码确认：<input type="password" name="re_passwd"><br>
该手机已投票的美女博客ID：<input type="text" name="mm_id"><br>
<input type="submit" name="submit" value="提交">
</form>
	<?
}
?>