<?
	include_once "mysql_connect.php";
	$send_from=$HTTP_POST_VARS['send_from'];
	$send_to=$HTTP_POST_VARS['send_to'];
	$message=$HTTP_POST_VARS['message'];
	$user_flag=$HTTP_POST_VARS['user_flag'];
	$sql2="insert into im_info(send_from,send_to,message_info,send_time,user_flag) values('".$send_from."','".$send_to."','".$message."',now(),'".$user_flag."')";
	if(mysql_query($sql2))
	{
		sleep(8);
		$last_im_id=mysql_insert_id();
		$sql3="select send_flag from im_info where message_send_ID=".$last_im_id;
		$result=mysql_result(mysql_query($sql3),0,0);
		if($result==1)
		{
			echo "发送成功!";
		}
		else
		{
			echo "发送失败!";
		}
	}
	else
	{
		echo "数据库错误!";
	}
?>