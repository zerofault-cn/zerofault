<?php
define('IN_MATCH', true);
session_start();
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

$page=$_REQUEST["page"];
$id=$_REQUEST['id'];//��idΪmm_info���id,��comment�����mm_id

$username	= $_POST['username'];
$content	= $_POST['content'];
if(''!=$_POST['submit'])
{
	$ip=GetIP();
	//�ж��Ƿ�ˢ��
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('���Բ�Ҫ������һ�䰡��');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 60)
		{
			echo "<script>alert('������Ƶ��Ҳ̫���˰ɣ�');location='?".$_SERVER["QUERY_STRING"]."';</script>";
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
	if(strlen(trim($content))<2)
	{
		echo "<script>alert('��������Ҳ̫���˰ɣ�');history.back();</script>";
		exit;
	}
	$sql="insert into comment set username='".$username."',content='".format(trim($content))."',addtime=UNIX_TIMESTAMP(),ip='".$ip."',user_id=".$id;
	$sql2="update user_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//�������Լ���
		}
		header("location:?".$_SERVER["QUERY_STRING"]);
	//	echo '<script>window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
	else
	{
		echo '<script>alert("�д�����!���Ժ����ԣ�������ϵ�ͷ���Ա");window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
}

if($id>0)
{
	$sql="select * from user_info where id=".$id;
	if($db->sql_numrows($db->sql_query($sql))==0)
	{
		echo "�����ڴ��û������ʵ!";
		exit;
	}
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$tpl->assign_vars(array(
		"ID" => sprintf("%04d",$id),
		"BLOGURL" => $row['blogurl'],
		"BLOGNAME" => $row['blogname'],
		"PHOTO" => $row['photo'],
		"POLL" => "poll.php?type=net&id=".$row["id"],
		"ADDTIME" => date("y/m/d",$row["addtime"]),
		"COMMNUM" => $row['comm_count'],
		"VOTE" => $row['vote'],
		"MONTHVOTE" => $row['monthvote'],
		"INFODISPLAY0" =>"",
		"INFODISPLAY1" =>"display:none"
		));
}
else
{
	$tpl->assign_vars(array(
		"BLOGNAME" => '��������',
		"INFODISPLAY0" =>"display:none",
		"INFODISPLAY1" =>"",
		"FORMDISPLAY" =>"display:none"
	));
}
/**
*�ұ������б�
*/
$pageitem=8;
$sql="select * from comment";
if($id>0)
{
	$pageitem=6;
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
		"CONTENT" => (($id>0)?'':'��<a href="comment.php?id='.$row["user_id"].'">['.getField($row['user_id'],'blogname').']</a>������<br />').$row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'�ο�',
		"ADDTIME" => date("y/m/d H:i",$row['addtime'])
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
));

/**
*������������б�
*/
$sql="SELECT * FROM user_info order by comm_count desc limit 20";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("phList",array(
		"ID" => $row['id'],
		"TITLE" => $row['blogname'],
		"BLOGNAME" => substr_cut($row['blogname'],8),
		"BLOGURL" => $row['blogurl'],
		"COUNT" => $row['comm_count']
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>