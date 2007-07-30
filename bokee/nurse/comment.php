<?php
define('IN_MATCH', true);
session_start();
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");

$page=$_REQUEST["page"];
$id=intval($_REQUEST['id']);
if(''==$id)
{
	$id=0;
}

//�����ύ���Եı�
$username	= trim($_POST['username']);
$content	= trim($_POST['content']);
if(''!=$_POST['submit'])
{
	//�ж��Ƿ�ˢ��
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('�벻Ҫ�ظ����ԣ�');parent.clearForm();</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 0)
		{
			echo "<script>alert('��������Ƶ��Ҳ̫���ˣ�');</script>";
			exit;
		}
		else
		{
			$_SESSION['lasttime']=time();
			$_SESSION['lastcontent']=$content;
		}
	}
	else
	{
		$_SESSION['lasttime']=time();
		$_SESSION['lastcontent']=$content;
	}
	if(strlen($content)<2)
	{
		echo "<script>alert('��������̫���ˣ�');</script>";
		exit;
	}
	include_once ("./filter.php");//���������ַ�����$filter_arr
	$strlen=strlen($content);
	if(strlen(str_replace("href=","",$content))<$strlen || strlen(eregi_replace("^[[[0-9]{1,4}]+[[a-z]{1,4}]+]+$","",$content))<$strlen || strlen( str_replace($filter_arr,'',$content) ) < $strlen)//������ַ������Σ������ַ�����ԭ�ַ����̣��Դ����ж��Ƿ�������
	{
		echo "<script>alert('�������Ժ��������ַ�!');parent.clearForm();</script>";
		exit;
	}
	$client_ip=GetIP();
	$sql0="select count(*) from comment where addtime>(UNIX_TIMESTAMP()-0) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//ͬһIP����ʱ��������60��
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		echo "<script>alert('��������Ƶ��Ҳ̫���ˣ���');</script>";
		exit;
	}
	$sql="insert into comment set username='".htmlspecialchars($username)."',content='".format($content)."',addtime=".time().",user_id='".$id."',ip='".$client_ip."'";
	$sql2="update user_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//�������Լ���
		}
		echo "<script>parent.location.reload();</script>";
		exit;
	}
	else
	{
		echo '<script>alert("�д�����!���Ժ����ԣ�������ϵ�ͷ���Ա");</script>';
		exit;
	}
}
//�����ύ���Խ���

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

if($id>0)
{
	$sql="select * from user_info where pass>0 and id=".$id;
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)==0)
	{
		echo "���û���δͨ�����,��ȴ����ͨ������ܲ鿴��ҳ��!";
		exit;
	}
	$row=$db->sql_fetchrow($result);
	$pass=$row['pass'];//����Ƿ�ͨ����ˣ��Լ��Ƿ���븴����������ͨ��Ϊ1������Ϊ2������Ϊ3
	//��ȡ����
	$sql2="select id from user_info where pass=".$pass." order by smsvote desc,id";
	$result2=$db->sql_query($sql2);
	while($row2=$db->sql_fetchrow($result2))
	{
		$order++;//������
		if($id==$row2['id'])
		{
			break;
		}
	}
	$blogurl=$row['blogurl'];
	$tpl->assign_vars(array(
		"ID" => sprintf("%05d",$id),
		"BLOGURL" => $blogurl,
		"AREA"=>$row['area'],
		"AREA_NAME" => $area_arr[$row['area']],
		"BLOGNAME" => $row['blogname'],
		"REALNAME" => $row['realname'],
		"HOSPITAL"=>$row['hospital'],
		"PHOTO" => $row['photo'],
		"ADDTIME" => date("y/m/d",$row['addtime']),
		"ORDER" => ((3==$pass)?'����Ʊ�����У���'.$order.'��':''),
		));
}
else
{
	echo "δָ��ѡ��id!";
	exit;
}

/**
*�м������б�
*/
$pageitem=8;
$sql="select * from comment ";
if($id>0)
{
	$sql.=" where user_id=".$id;
}
$sql.=" order by id desc";

$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?id=".$id);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"ID" => $row['id'],
		"CONTENT" => $row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'�ο�',
		"ADDTIME" => date("Y-m-d H:i:s",$row['addtime'])
		));
}

$tpl->assign_vars(array(
	"PAGE" => $pagenav,
	"DISPLAY" => checkLogin($blogurl)?'':'none',
	"LOGINFORM_DISPLAY"=>getBokie()?'none':'',
	"BLOGID"=>getBokie()
));

/**
*�����������
*/
$sql="SELECT * FROM user_info order by comm_count desc limit 20";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars("commList",array(
		"I"=>sprintf("%02d",$i),
		"ID"=>$row['id'],
		"BLOGNAME0" => $row['blogname'],
		"BLOGNAME" => substr_cut($row['blogname'],18),
		"BLOGURL" => $row['blogurl'],
		"COUNT" => $row['comm_count'],
		));
}
/**
*�ұ�Ʊ������
*/
$sql="SELECT * FROM user_info order by smsvote desc limit 30";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars("tplist",array(
		"I"=>sprintf("%02d",$i),
		"ID"=>$row['id'],
		"BLOGNAME0" => $row['blogname'],
		"BLOGNAME" => substr_cut($row['blogname'],18),
		"BLOGURL" => $row['blogurl'],
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
