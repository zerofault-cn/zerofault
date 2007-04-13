<?
function getIpByPath($prog_path)
{
	$serverIP=array("server16"=>"221.10.222.92",
					"server15"=>"221.10.222.91",
					"server14"=>"221.10.222.90",
					"server13"=>"221.10.222.90",
					"server12"=>"221.10.222.91",
					"server11"=>"221.10.222.92");
	return $serverIP[substr($prog_path,4,8)];
}

function getServerIp()
{
	return $_SERVER["SERVER_ADDR"];
}

function getPlayPath($prog_path)
{
	$prog_ip=getIpByPath($prog_path);
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	if($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92)
	{
		$prog_ip=$server_ip;//服务器不是那6台时
		if(strrchr($prog_path,".")==".WMV"||strrchr($prog_path,".")==".wmv"||strrchr($prog_path,".")==".ASF"||strrchr($prog_path,".")==".asf")
		{
			$play_path="mms://".$prog_ip."/".$prog_path;
		}	
		if(strrchr($prog_path,".")==".mp4"||strrchr($prog_path,".")==".MP4"||strrchr($prog_path,".")==".rm"||strrchr($prog_path,".")==".RM"||strrchr($prog_path,".")==".rmvb"||strrchr($prog_path,".")==".RMVB"||strrchr($prog_path,".")==".MPG"||strrchr($prog_path,".")==".mpg")
		{
			$play_path="rtsp://".$prog_ip.":555/".$prog_path;
		}
	}
	else//遂宁的六台服务器
	{

		if(strrchr($prog_path,".")==".mp4"||strrchr($prog_path,".")==".MP4")
		{
			//用darwin时的播放路径
			$play_path="lrtsp://".$prog_path."?".$_SESSION['account']."&".$_SESSION['password'];
		}
		else
		{
			//用helix时的播放路径
			if(strrchr($prog_path,".")==".WMV"||strrchr($prog_path,".")==".wmv"||strrchr($prog_path,".")==".ASF"||strrchr($prog_path,".")==".asf")
			{
				$play_path="mms://".$prog_ip."/".$prog_path;
			}	
			if(strrchr($prog_path,".")==".rm"||strrchr($prog_path,".")==".RM"||strrchr($prog_path,".")==".rmvb"||strrchr($prog_path,".")==".RMVB")
			{
				$play_path="rtsp://".$prog_ip.":555/".$prog_path;
			}
		}
	}
	return $play_path;
}
function getLocate($prog_path)
{
	$server_ip=getServerIp();
	$prog_ip=getIpByPath($prog_path);
	$s_ip=substr(strrchr($server_ip,"."),1);
	$p_ip=substr(strrchr($prog_ip,"."),1);
	if(($s_ip==87&&($p_ip==87||$p_ip==88||$p_ip==89)) || ($s_ip==88&&($p_ip==87||$p_ip==88||$p_ip==89)) || ($s_ip==89&&($p_ip==87||$p_ip==88||$p_ip==89)) ||	($s_ip==90&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip==91&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip==92&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92) )
	{
		return 'local';
	}
	else
	{
		return 'remote';
	}
}

function getRealPath($prog_path)
{
	$prog_path=str_replace('bod/server14_1/','bod/server11_1/',$prog_path);
	$prog_path=str_replace('bod/server14_2/','bod/server11_2/',$prog_path);
	$prog_path=str_replace('bod/server15_1/','bod/server12_1/',$prog_path);
	$prog_path=str_replace('bod/server15_2/','bod/server12_2/',$prog_path);
	$prog_path=str_replace('bod/server16_1/','bod/server13_1/',$prog_path);
	$prog_path=str_replace('bod/server16_2/','bod/server13_2/',$prog_path);
	return $prog_path;
}
?>
