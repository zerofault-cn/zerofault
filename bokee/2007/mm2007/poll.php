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
include_once($root_path."dbtable.php");//����ͶƱʱ��Σ����ݲ�ͬʱ��Σ������ݱ��浽��ͬ�ı�

$ip_limit=30;//ÿ��ÿIP��Ͷ30Ʊ
$id=$_REQUEST['id'];
$type=$_REQUEST['type'];
$area=$_REQUEST['area'];
if(''==$type)
{
	$type='net';
}
if($type=='net')
{
	//����������Ƿ�֧��cookie
	echo '<script>if(!navigator.cookieEnabled)location="nocookie.html";</script>';
	$client_ip=GetIP();
	if(strpos($client_ip,',')>0)
	{
		echo 'ͶƱʧ�ܣ�';
		exit;
	}
	checkIP($client_ip);
	$client_ip2=substr($client_ip,0,strrpos($client_ip,'.'));
	$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//���쿪ʼʱ�����
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
		echo '����ͶƱÿ��ͬһ��IP��Ͷ'.$ip_limit.'Ʊ<br />';
		echo '�������Ѿ������ٲ���ͶƱ�ˣ�<br />';
		echo '<a href="#" onclick="javascript:window.close()">�رմ���</a>';
		echo '</div>';
		echo '</body>';
		exit;
	}
	
	if(''!=$_POST['submit'])
	{
		if(''!=$_POST['vali_code'] && $_POST['vali_code']==substr(md5($_POST['vali_key']),20,6))
		{
		
			$sql0="select count(id) from ".$ip_table." where polltime>(UNIX_TIMESTAMP()-8) and ip='".$client_ip."'";//����ͶƱ���Ϊ5��
			$result0=$db->sql_query($sql0);
			if($db->sql_fetchfield(0,0,$result0)>0)
			{
			//	echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
			//	echo '<br /><br /><div style="font-size:16px;text-align:center;font-weight:bold">';
			//	echo '����ͶƱʱ����̫�̣�����������!<br />';
			//	echo '<a href="#" onclick="javascript:window.close()">�رմ���</a>';
			//	echo '</div>';
			//	echo '</body>';
				header("HTTP/1.1 404 Not Found");
		exit;	
			}
		
			$sql1="insert into ".$ip_table." set ip='".$client_ip."',user_agent='".getenv("HTTP_USER_AGENT").session_id()."',mm_id=".$id.",polltime=UNIX_TIMESTAMP()";
			$sql2="update mm_info set netvote=(netvote+1),allvote=(allvote+1) where id=".$id;
			if($db->sql_query($sql1) && $db->sql_query($sql2))
			{
				setcookie("ipcount",$count+1,$today_end);//��ͶƱ��������cookie������Ϊ����һ��
				$mm_netvote=getField($id,'netvote');
				echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
				echo '<br /><br /><div style="font-size:16px;text-align:center;font-weight:bold">';
				echo 'ͶƱ�ɹ�����л����ͶƱ��<br /><br />';
				echo '���<span style="color:#fff">'.sprintf("%04d",$id).'</span>ѡ�ֵ�����Ʊ��Ϊ<span style="color:#fff">'.$mm_netvote.'</span>Ʊ��<br /><br />';
				echo '<a href="#" onclick="javascript:window.close()">�رմ���</a>';
				echo '</div>';
				echo '<script>alert("ͶƱ�ɹ�!\r\n���'.sprintf("%04d",$id).'ѡ�ֵ�����Ʊ��Ϊ'.$mm_netvote.'Ʊ");window.close();</script>';
				echo '</body>';
				exit;
				
			}
			else
			{
				echo '������:'.$sql1;
			}
		}
		else
		{
			echo '��֤�벻һ��!<br />';
			echo '<a href="?type='.$type.'&id='.$id.'">��������</a>';
		}
	}
	else
	{
		$vali_key=rand();
		$_SESSION['validate_code'] = substr(md5($vali_key),20,6);
		echo '<body topmargin="0" leftmargin="0" bgcolor="#ffcc70">';
		echo '<form name="form1" action="" method="post">';
		echo '<div style="font-size:16px;text-align:center;font-weight:bold">';
		echo '�װ����û����ã�<br />��л���Ա��λ�Ĺ�ע��֧�֣�<br />';
		echo '</div><br />';
		echo '<div style="font-size:14px;text-align:center;">';
		echo '����ͶƱÿ��ͬһ��IP��Ͷ'.$ip_limit.'Ʊ��<br />';
		echo '������ͼ���е���֤�룺<input type="text" name="vali_code" size="6" maxlength="6" /><br />';
		echo '<img src="codeimg.php" />&nbsp;&nbsp;<a href="#" onclick="javascript:window.location.reload();">�����壿��һ��</a><br /><br />';
		echo '<input type="hidden" name="vali_key" value="'.$vali_key.'" />';
		echo '<input type="hidden" name="type" value="'.$type.'" />';
		echo '<input type="hidden" name="id" value="'.$id.'" />';
		echo '<input type="submit" name="submit" value="�ύ">';
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
		echo '<div style="position:absolute;left:240px;top:70px;width:14px;font-size:14px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">�ֻ�����ͶƱ  30ƱӮ��</a></div>';
		echo '<div style="position:absolute;left:218px;top:295px;font-size:12px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">�鿴��ϸ</a></div>';
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
		echo '<div style="position:absolute;left:240px;top:70px;width:14px;font-size:14px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">�ֻ�����ͶƱ  30ƱӮ��</a></div>';
		echo '<div style="position:absolute;left:218px;top:295px;font-size:12px;line-height:140%;"><a style="color:#00f;text-decoration:none;" href="../choujiang.shtml" target="_blank">�鿴��ϸ</a></div>';
		echo '<div style="position:absolute;left:489px;top:103px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:482px;top:147px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:191px;">'.sprintf("%04d",$id).'</div>';
		echo '<div style="position:absolute;left:475px;top:235px;">'.sprintf("%04d",$id).'</div>';
		echo '</body>';
	}
}

$db->sql_close();
?>
