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
$id=$_REQUEST['id'];//此id为mm_info表的id,即comment表里的mm_id

$username	= $_POST['username'];
$content	= $_POST['content'];
if(''!=$_POST['submit'])
{
	$ip=GetIP();
	//判断是否刷屏
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('留言不要老是那一句啊！');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 60)
		{
			echo "<script>alert('您留言频率也太快了吧！');location='?".$_SERVER["QUERY_STRING"]."';</script>";
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
		echo "<script>alert('您的留言也太短了吧！');history.back();</script>";
		exit;
	}
	$sql="insert into comment set username='".$username."',content='".format(trim($content))."',addtime=UNIX_TIMESTAMP(),ip='".$ip."',user_id=".$id;
	$sql2="update user_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//更新留言计数
		}
		header("location:?".$_SERVER["QUERY_STRING"]);
	//	echo '<script>window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
	else
	{
		echo '<script>alert("有错误发生!请稍后再试，或者联系客服人员");window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
}

if($id>0)
{
	$sql="select * from user_info where id=".$id;
	if($db->sql_numrows($db->sql_query($sql))==0)
	{
		echo "不存在此用户，请核实!";
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
		"BLOGNAME" => '给所有人',
		"INFODISPLAY0" =>"display:none",
		"INFODISPLAY1" =>"",
		"FORMDISPLAY" =>"display:none"
	));
}
/**
*右边留言列表
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
		"CONTENT" => (($id>0)?'':'对<a href="comment.php?id='.$row["user_id"].'">['.getField($row['user_id'],'blogname').']</a>的留言<br />').$row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'游客',
		"ADDTIME" => date("y/m/d H:i",$row['addtime'])
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
));

/**
*左边留言排行列表
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