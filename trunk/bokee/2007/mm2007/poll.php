<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

session_start();
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//设置投票时间段，根据不同时间段，将数据保存到不同的表

$ip_limit=30;//每天每IP限投30票
$id=$_REQUEST['id'];
$type=$_REQUEST['type'];
$area=$_REQUEST['area'];
if(''==$type)
{
	$type='net';
}
if($type=='net')
{
	//检验浏览器是否支持cookie
	echo '<script>if(!navigator.cookieEnabled)location="nocookie.html";</script>';
	$client_ip=GetIP();
	if(strpos($client_ip,',')>0)
	{
		echo '投票失败！';
		exit;
	}
	checkIP($client_ip);
	$client_ip2=substr($client_ip,0,strrpos($client_ip,'.'));
	$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//今天开始时间戳记
	$today_end=$today_start+86400;

	$sql="select count(id) from ".$ip_table." where polltime>".$today_start." and ip='".$client_ip."'";
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)>0)
	{
		$count=$db->sql_fetchfield(0,0,$result);
	}
	else
	{
		$count=0;
	}
	$sql01="select count(id) from ".$ip_table." where polltime>".$today_start." and ip like '".$client_ip2."%'";
	$result=$db->sql_query($sql01);
	if($db->sql_numrows($result)>0)
	{
		$count01=$db->sql_fetchfield(0,0,$result);
	}
	if($count01>=$ip_limit)
	{
		header("HTTP/1.1 404 Not Found");
		exit;	
	}

	
	if($count>=$ip_limit || $_COOKIE['ipcount']>=$ip_limit)
	{
		echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
		echo '<br /><br /><div style="font-size:16px;text-align:center;font-weight:bold">';
		echo '网络投票每天同一个IP限投'.$ip_limit.'票<br />';
		echo '您今天已经不能再参与投票了！<br />';
		echo '<a href="#" onclick="javascript:window.close()">关闭窗口</a>';
		echo '</div>';
		echo '</body>';
		exit;
	}
	
	if(''!=$_POST['submit'])
	{
		if(''!=$_POST['vali_code'] && $_POST['vali_code']==substr(md5($_POST['vali_key']),20,6))
		{
		
			$sql0="select count(id) from ".$ip_table." where polltime>(UNIX_TIMESTAMP()-8) and ip='".$client_ip."'";//限制投票间隔为5秒
			$result0=$db->sql_query($sql0);
			if($db->sql_fetchfield(0,0,$result0)>0)
			{
			//	echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
			//	echo '<br /><br /><div style="font-size:16px;text-align:center;font-weight:bold">';
			//	echo '两次投票时间间隔太短，有作弊嫌疑!<br />';
			//	echo '<a href="#" onclick="javascript:window.close()">关闭窗口</a>';
			//	echo '</div>';
			//	echo '</body>';
				header("HTTP/1.1 404 Not Found");
		exit;	
			}
		
			$sql1="insert into ".$ip_table." set ip='".$client_ip."',user_agent='".getenv("HTTP_USER_AGENT").session_id()."',mm_id=".$id.",polltime=UNIX_TIMESTAMP()";
			$sql2="update mm_info set netvote=(netvote+1),allvote=(allvote+1) where id=".$id;
			if($db->sql_query($sql1) && $db->sql_query($sql2))
			{
				setcookie("ipcount",$count+1,$today_end);//将投票次数存入cookie，期限为今天一天
				$mm_netvote=getField($id,'netvote');
				echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
				echo '<br /><br /><div style="font-size:16px;text-align:center;font-weight:bold">';
				echo '投票成功，感谢您的投票！<br /><br />';
				echo '编号<span style="color:#fff">'.sprintf("%04d",$id).'</span>选手的网络票数为<span style="color:#fff">'.$mm_netvote.'</span>票。<br /><br />';
				echo '<a href="#" onclick="javascript:window.close()">关闭窗口</a>';
				echo '</div>';
				echo '<script>alert("投票成功!\r\n编号'.sprintf("%04d",$id).'选手的网络票数为'.$mm_netvote.'票");window.close();</script>';
				echo '</body>';
				exit;
				
			}
			else
			{
				echo '出错了:'.$sql1;
			}
		}
		else
		{
			echo '验证码不一致!<br />';
			echo '<a href="?type='.$type.'&id='.$id.'">返回重试</a>';
		}
	}
	else
	{
		$vali_key=rand();
		$_SESSION['validate_code'] = substr(md5($vali_key),20,6);
		echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
		echo '<form name="form1" action="" method="post">';
		echo '<div style="font-size:16px;text-align:center;font-weight:bold">';
		echo '亲爱的用户您好，<br />感谢您对本次活动的关注和支持！<br />';
		echo '</div><br />';
		echo '<div style="font-size:14px;text-align:center;">';
		echo '网络投票每天同一个IP限投'.$ip_limit.'票！<br />';
		echo '请输入图像中的验证码：<input type="text" name="vali_code" size="6" maxlength="6" /><br />';
		echo '<img src="codeimg.php" />&nbsp;&nbsp;<a href="#" onclick="javascript:window.location.reload();">看不清？换一个</a><br /><br />';
		echo '<input type="hidden" name="vali_key" value="'.$vali_key.'" />';
		echo '<input type="hidden" name="type" value="'.$type.'" />';
		echo '<input type="hidden" name="id" value="'.$id.'" />';
		echo '<input type="submit" name="submit" value="提交">';
		echo '</div>';
		echo '</form>';
		echo '</body>';
	}
}
elseif($type=='sms')
{
	if($area==1)
	{
		echo '<body style="margin:0;background:#ffcc70 url(images/smsbg2_hb.gif) no-repeat top left;font-size:14px;color:#00f;font-weight:bold;">';
		echo '<div style="position:absolute;left:240px;top:70px;width:14px;font-size:14px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">手机短信投票  30票赢大奖</a></div>';
		echo '<div style="position:absolute;left:218px;top:295px;font-size:12px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">查看详细</a></div>';
		echo '<div style="position:absolute;left:489px;top:103px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:482px;top:147px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:191px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:235px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:314px;top:372px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:327px;top:396px;">'.sprintf("%04d",$id).'</div>';
		echo '</body>';
	}
	else
	{
		echo '<body style="margin:0;background:#ffcc70 url(images/smsbg2.gif) no-repeat top left;font-size:14px;color:#00f;font-weight:bold;">';
		echo '<div style="position:absolute;left:240px;top:70px;width:14px;font-size:14px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">手机短信投票  30票赢大奖</a></div>';
		echo '<div style="position:absolute;left:218px;top:295px;font-size:12px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">查看详细</a></div>';
		echo '<div style="position:absolute;left:489px;top:103px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:482px;top:147px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:191px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:235px;">'.sprintf("%04d",$id).'</div>';
		echo '</body>';
	}
}

$db->sql_close();
?>
