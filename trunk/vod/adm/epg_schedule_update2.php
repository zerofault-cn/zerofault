<?
//本程序只适用于央视网站已提供节目单的电视台
include_once "../include/mysql_connect.php";
//include_once "get_zip.php";
$monday_date=date("Ymd",mktime(0,0,0,date("m"),(date("d")-date("w")+1),date("Y")));
if(isset($station_id)&&$station_id!='')
{
	$ext=" and station_id='".$station_id."' ";
}
$sql1="select station_id,station_name,schedule_url from epg_station where del_flag=1 and type='tv' ".$ext." order by sort_id";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$tmp_station_id=$r[0];
	$station_name=$r[1];
	$schedule_file=$r[2];
	echo $station_name.':';
	echo "删除上月节目单:";
	$sql11="delete from epg_schedule where date<'".date("Ym").'01'."' and station_id=".$tmp_station_id;
	if(mysql_query($sql11))
	{
		echo "<span class=blue>ok</span>";
	}
	$sql2="select * from epg_schedule where station_id='".$tmp_station_id."' and date='".$monday_date."'";
	$result2=mysql_query($sql2);
	if(mysql_fetch_array($result2))
	{
		echo '......<span class=blue>本周节目单已经更新!</span><br>';
		continue;
	}
	else
	{
		$dir='节目单/';//初始化目录
		$schedule_file=$dir.$schedule_file;
		if(is_file($schedule_file)&&file_exists($schedule_file))
		{
			$fp=fopen($schedule_file,"r");
		//	echo $station_name.':';
			while($buffer=fgets($fp,4096))
			{
				if(trim($buffer)=='')
				{
					continue;
				}
				if(ereg("([0-9]{2})/([0-9]{2})/([0-9]{2})",$buffer))
				{
					$timestamp=mktime(0,0,0,substr($buffer,3,2),substr($buffer,6,2),('20'.substr($buffer,0,2)));
					$date=date("Ymd",$timestamp);
					$weekday=date("w",$timestamp);
					$sql1="insert into epg_schedule values('".$tmp_station_id."','".$date."','".$weekday."','".$schedule."')";
					if(mysql_query($sql1))
					{
						if(isset($station_id)&&$station_id!='')
						{
							echo ' updating...<br>'.date("Y-m-d",$timestamp)." updating...<br>";
						}
					}
					else
					{
						echo "<span class=red>ERROR!</span>";
					}
				}
				else
				{
					$sql2="update epg_schedule set program=concat(program,'".$buffer."','<br>') where station_id='".$tmp_station_id."' and date='".$date."'";
					if(mysql_query($sql2))
					{
						if(isset($station_id)&&$station_id!='')
						{
							echo substr($buffer,0,5).":<span class=blue>update ok</span><br>";
						}
					}
					else
					{
						echo "<span class=red>:ERROR!</span>";
					}
				}
			}
			fclose($fp);
			echo "......<span class=blue>本周节目单更新完成!</span><br>";
		}
		else
		{
			echo "<span class=red>不存在这个台的节目单源文件,或者检查节目单地址是否填正确!</span><br>";
		}
	}
}
?>
