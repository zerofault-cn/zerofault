<?php
define('IN_MATCH', true);
session_start();
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");

$id=$_REQUEST['id'];

include_once "header.php";
if(''==$id || 0==$id)
{
	include_once "comment_left.php";
}
else
{
	include_once "main.php";
}
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

$page=$_REQUEST["page"];

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
		if(time()-$_SESSION["lasttime"] < 30)
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
		echo "<script>alert('您的留言太短了！');history.back();</script>";
		exit;
	}
	include_once ("./filter.php");//引用屏蔽字符数组$filter_arr
	$strlen=strlen($content);
	//strlen(str_replace("http://","",$content))<$strlen || 
	if(strlen(eregi_replace("^[0-9]+[a-z]+$","",$content))<$strlen || strlen( str_replace($filter_arr,'',$content) ) < $strlen)//如果有字符被屏蔽，则新字符串比原字符串短，以此来判断是否含有脏字
	{
		header("location:?".$_SERVER["QUERY_STRING"]."&filter");
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
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo $sql;
	//	echo '<script>alert("有错误发生!请稍后再试，或者联系客服人员");parent.location.reload();</script>';
	}
}
/*处理留言介绍*/

if($id>0)
{
	$sql="select * from user_info where pass>0 and id=".$id;
	if($db->sql_numrows($db->sql_query($sql))==0)
	{
		echo "该用户还未通过审核，请等待通过审核后再留言!";

		exit;
	}
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$blogurl=$row['blogurl'];
}
/**
*右边留言列表
*/
$pageitem=20;
$sql="select * from comment";
if($id>0)
{
	$pageitem=16;
	$sql.=" where user_id=".$id;
}
$sql.=" order by id desc";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?id=".$id);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$class=('liulicon liuli'!=$class)?'liulicon liuli':'liulicon';
	$tpl->assign_block_vars("list", array(
		"ID"=>$row['id'],
		"CLASS"=>$class,
		"CONTENT" => (($id>0)?'':'对<a href="comment.php?id='.$row["user_id"].'">['.getField($row['user_id'],'blogname').']</a>的留言<br />').$row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'游客',
		"ADDTIME" => date("y/m/d H:i",$row['addtime'])
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav,
	"DISPLAY" => checkLogin($blogurl)?'':'none',
	"FORMDISPLAY"=>$id>0?'':'none'
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

require_once "templates/footer.htm";
?>