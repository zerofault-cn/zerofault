<html>
<head>
<meta http-equiv="refresh" ccontent="60;">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body topmargin=0 leftmargin=0 style="background:transparent;overflow:auto">
<?
include_once "mysql_connect.php";
$sql1="insert into control_info(cDevice,cControlCode,dDate) values('".$device."','".$code."',now())";
if(''!=$device && ''!=$code)
{
	if(mysql_query($sql1))
	{
		$last_control_id=mysql_insert_id();
		if($code=='1250')
		{
			if(strpos($para2,'|'))
			{
				$send_info=str_replace('|',', ',$para2);
			}
		echo	$sql11="insert into im_info(cControlID,send_from,send_info,send_time) values('".$last_control_id."','".$para1."','".$send_info."',now())";
			mysql_query($sql11);
		}
		sleep(5);
		$sql2="select siDealedStatus,vError from control_info where cControlID='".$last_control_id."'";
		$dealStatus=mysql_result(mysql_query($sql2),0,0);
		$dealInfo=mysql_result(mysql_query($sql2),0,1);
		if($dealStatus==0)
		{
			echo 'Î´Ö´ÐÐ!';
		}
		else
		{
			echo $dealInfo;
		}
		/*
		$sql2="select cDeviceID,siDealed from status_log where cControlID='".$last_control_id."'";
		$result2=mysql_query($sql2);
		if(mysql_num_rows($result2))
		{
			$deviceId=mysql_result($result2,0,0);
			$isDealed=mysql_result($result2,0,1);
			if($isDealed)
			{
				$sql3="select cGWStatus from status_info where cDeviceID='".$deviceId."'";
				$GwStatus=mysql_result($mysql_query($sql3),0,0);
				if(''!=$GwStatus)
				{
					echo $GwStatus;
				}
			}
			else
			{
				echo 'Not Dealed';
			}
		}
		else
		{
			echo 'Not Dealed';
		}
		*/
	}
	else
	{
		echo 'SQL ERROR';
	}
}
?>
</body>
</html>