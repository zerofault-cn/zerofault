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

$referer=$_SERVER["HTTP_REFERER"];
if(substr($referer,0,strrpos($referer,'/'))!='http://ent.bokee.com')
{
//	exit;
}
$id=$_REQUEST['id'];
$flower=$_REQUEST['flower'];
$egg=$_REQUEST['egg'];
$ip_limit=100;
$client_ip=GetIP();
if(strpos($client_ip,',')>0)
{
	header("location:?".$_SERVER["QUERY_STRING"]);
	exit;
}
$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//���쿪ʼʱ�����
$today_end=$today_start+86400;
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
if($count>=$ip_limit || $_COOKIE['ipcount']>=$ip_limit)//ÿ������ͶƱ
{
	echo 'ÿ��ͬһ��IP��'.$ip_limit.'��<br />';
	echo '�������Ѿ��������׻������Ӽ����ˣ�<br />';
	echo '<a href="#" onclick="javascript:window.close()">�رմ���</a>';
	exit;
}
$sql="update user_info set ";
if(1==$flower)
{
	$sql.=" flower=(flower+1),month_flower=(month_flower+1) ";
	$alert="�ʻ��ɹ�";
}
elseif(1==$egg)
{
	$sql.=" egg=(egg+1),month_egg=(month_egg+1) ";
	$alert="�������ӳ�";
}
else
{
	exit;
}
$sql.=" where id=".$id;
$sql2="insert into ip_info set ip='".$client_ip."',user_id=".$id.",polltime=UNIX_TIMESTAMP()";
if($db->sql_query($sql) && $db->sql_query($sql2))
{
	setcookie("ipcount",$count+1,$today_end);//��ͶƱ��������cookie������Ϊ����һ��
	
	echo '<script>alert("'.$alert.'����л����֧�֣�");window.opener=null;window.close();</script>';
	exit;
}
else
{
	echo '������:'.$sql;
	echo '<br>'.$sql2;
}

?>