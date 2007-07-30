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

//处理提交留言的表单
$username	= trim($_POST['username']);
$content	= trim($_POST['content']);
if(''!=$_POST['submit'])
{
	//判断是否刷屏
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('请不要重复留言！');parent.clearForm();</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 0)
		{
			echo "<script>alert('您的留言频率也太快了！');</script>";
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
		echo "<script>alert('您的留言太短了！');</script>";
		exit;
	}
	include_once ("./filter.php");//引用屏蔽字符数组$filter_arr
	$strlen=strlen($content);
	if(strlen(str_replace("href=","",$content))<$strlen || strlen(eregi_replace("^[[[0-9]{1,4}]+[[a-z]{1,4}]+]+$","",$content))<$strlen || strlen( str_replace($filter_arr,'',$content) ) < $strlen)//如果有字符被屏蔽，则新字符串比原字符串短，以此来判断是否含有脏字
	{
		echo "<script>alert('您的留言含有敏感字符!');parent.clearForm();</script>";
		exit;
	}
	$client_ip=GetIP();
	$sql0="select count(*) from comment where addtime>(UNIX_TIMESTAMP()-0) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//同一IP留言时间间隔至少60秒
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		echo "<script>alert('您的留言频率也太快了！！');</script>";
		exit;
	}
	$sql="insert into comment set username='".htmlspecialchars($username)."',content='".format($content)."',addtime=".time().",user_id='".$id."',ip='".$client_ip."'";
	$sql2="update user_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//更新留言计数
		}
		echo "<script>parent.location.reload();</script>";
		exit;
	}
	else
	{
		echo '<script>alert("有错误发生!请稍后再试，或者联系客服人员");</script>';
		exit;
	}
}
//处理提交留言结束

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

if($id>0)
{
	$sql="select * from user_info where pass>0 and id=".$id;
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)==0)
	{
		echo "此用户还未通过审核,请等待审核通过后才能查看此页面!";
		exit;
	}
	$row=$db->sql_fetchrow($result);
	$pass=$row['pass'];//标记是否通过审核，以及是否进入复赛，决赛，通过为1，复赛为2，决赛为3
	//获取排名
	$sql2="select id from user_info where pass=".$pass." order by smsvote desc,id";
	$result2=$db->sql_query($sql2);
	while($row2=$db->sql_fetchrow($result2))
	{
		$order++;//总排名
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
		"ORDER" => ((3==$pass)?'决赛票数排行：第'.$order.'名':''),
		));
}
else
{
	echo "未指定选手id!";
	exit;
}

/**
*中间留言列表
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
		"USERNAME" => (''!=$row['username'])?$row['username']:'游客',
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
*左边留言排行
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
*右边票数排行
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
