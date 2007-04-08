<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//设置投票时间段，根据不同时间段，将数据保存到不同的表

//$id_arr=array(1364,1310,1269,1251,1165,1080,1036,1421,192,381,685,854,15);
$id=1253;
//foreach($id_arr as $id)
{
	$client_ip=intval(substr($id,-4,2)).'.'.intval(substr($id,-2)).'.'.substr(time(),-4,2).'.'.substr(time(),-2);
	$sql1="insert into ".$ip_table." set ip='".$client_ip."',user_agent='".getenv("HTTP_USER_AGENT")."',mm_id=".$id.",polltime=UNIX_TIMESTAMP()";
	$sql2="update mm_info set netvote=(netvote+1),allvote=(allvote+1) where id=".$id;
	if($db->sql_query($sql1) && $db->sql_query($sql2))
	{
		echo $id."ok\r\n";
	}
	else
	{
		echo '出错了:'.$sql1;
	}
}

$db->sql_close();
?>
