<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

session_start();

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$id=$_REQUEST['id'];
$ip_limit=50;
$client_ip=GetIP();
$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//今天开始时间戳记
$today_end=$today_start+86400;
$sql="select * from user_info where pass>0 and id=".$id;
if($db->sql_numrows($db->sql_query($sql))==0)
{
	echo "该用户还未通过审核，请等待通过审核后再留言!";
	exit;
}

$sql="select count(*) from ip_info where ip='".$client_ip."' and polltime>".$today_start;
$result=$db->sql_query($sql);
if($db->sql_numrows($result)>0)
{
	$count=$db->sql_fetchfield(0,0,$result);
}
else
{
	$count=0;
}
if($count>=$ip_limit || $_COOKIE['ipcount']>=$ip_limit)//每天限制投票
{
	echo '每天只能鲜花'.$ip_limit.'朵<br />';
	echo '您今天已经不能再献花了！<br />';
	echo '<a href="#" onclick="javascript:window.close()">关闭窗口</a>';
	exit;
}
if(true || ''!=$_REQUEST['submit'])
{
	if(true || $_REQUEST['vali_code']==substr(md5($_REQUEST['vali_key']),20,6))
	{
		$sql="update user_info set vote=(vote+1),monthvote=(monthvote+1) where id=".$id;
		$sql2="insert into ip_info set ip='".$client_ip."',user_id=".$id.",polltime=UNIX_TIMESTAMP()";
		if($db->sql_query($sql) && $db->sql_query($sql2))
		{
			setcookie("ipcount",$count+1,$today_end);//将投票次数存入cookie，期限为今天一天
			echo '<script>alert("献花成功，感谢您的支持！");window.opener=null;window.close();</script>';
			exit;
			echo '<div style="font-size:16px;text-align:center">';
			echo '献花成功，感谢您的支持！<br />';
			echo '<a href="#" onclick="javascript:window.close()">关闭窗口</a>';
			echo '</div>';
		}
		else
		{
			echo '出错了:'.$sql;
			echo '<br>'.$sql2;
		}
	}
	else
	{
		echo '验证码不一致!<br />';
		echo '<a href="?id='.$id.'">返回重试</a>';
	}
}
else
{
	$vali_key=rand();
	$_SESSION['validate_code'] = substr(md5($vali_key),20,6);
	echo '<div style="font-size:16px;text-align:center">';
	echo '<form name="form1" action="" method="post">';
	echo '感谢您对本次活动的关注和支持！<br />';
	echo '网络投票每天同一个IP限投'.$ip_limit.'票！<br />';
	echo '请输入图像中的验证码：<input type="text" name="vali_code" size="6" /><br />';
	echo '<img src="codeimg.php" />&nbsp;&nbsp;<a href="#" onclick="javascript:window.location.reload();">看不清？换一个</a><br /><br />';
	echo '<input type="hidden" name="vali_key" value="'.$vali_key.'" />';
	echo '<input type="hidden" name="id" value="'.$id.'" />';
	echo '<input type="submit" name="submit" value="提交">';
	echo '</form>';
	echo '</div>';
}
?>