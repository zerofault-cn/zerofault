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

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

$page=$_REQUEST["page"];
$id=$_REQUEST['id'];//此id为mm_info表的id,即comment表里的mm_id
if(''==$id)
{
	$id=0;
}
if($id>0)
{
	$sql="select * from mm_info where pass=1 and id=".$id;
	if($db->sql_numrows($db->sql_query($sql))==0)
	{
		echo "此用户还未通过审核,请等待审核通过后才能查看此页面!";
		exit;
	}
}
$area_arr = array(
	1 => '中部赛区',
	2 => '南部赛区',
	3 => '北部赛区');

if($id>0)
{
	$sql="select id,area from mm_info where pass=1 order by allvote desc,id";
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$order[intval($row['area'])]++;
		if($id==$row['id'])
		{
			break;
		}
	}
	$db->sql_freeresult();
	$sql="select * from mm_info where id=".$id;
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$tpl->assign_vars(array(
		"ID" => sprintf("%04d",$id),
		"BLOGURL" => $row['blogurl'],
		"AREA_NAME" => $area_arr[$row['area']].'：'.$row['blogname'],
		"BLOGNAME" => $row['blogname'],
		"PHOTOIMG" => '<a href="'.$row['blogurl'].'" target="_blank"><img src="photo/'.$row['area'].'/'.$row['photo'].'" width="210" height="210" border="0" /></a>',
		"POLL" => "poll.php?type=net&id=".$row["id"],
		"COMMENT" => "?id=".$row["id"],
		"SMSPOLL" => "poll.php?type=sms&area=".$row['area']."&id=".$row["id"],
		"SMSPOLLWIDTH" => ($row['area']==1)?'630':'630',
		"SMSPOLLHEIGHT" => ($row['area']==1)?'530':'322',
		"DATE" => date("y/m/d",$row['addtime']),
		"ALLVOTE" => $row['allvote'],
		"ORDER" => '赛区排名：第'.$order[$row['area']].'名',
		"FLASHOUTSIDEID" => 'flash_outside_spec',
		"LOGINDISPLAY" => "display:none"
		));
}
else
{
	$tpl->assign_vars(array(
		"AREA_NAME" => '所有人',
		"PHOTOIMG" => '<a href="http://mm.bokee.com/2007/signup_1.html#top"><img src="http://images.bokee.com/mm/2007/index/2006-12-18/UDVJ0PEgK3QEsK3n.jpg" alt="报名参赛第二届美女博客大赛" /></a>',
		"FLASHOUTSIDEID" => 'flash_outside',
		"INFODISPLAY" => "display:none"
		));
}
$username	= trim($_POST['username']);
$content	= trim($_POST['content']);
if(''!=$_POST['submit'])
{
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
	if(strlen($content)<2)
	{
		echo "<script>alert('您的留言也太短了吧！');history.back();</script>";
		exit;
	}
	include_once ("./filter.php");//引用屏蔽字符数组$filter_arr
	if(strlen( str_replace($filter_arr,'',$content) ) < strlen($content) )//如果有字符被屏蔽，则新字符串比原字符串短，以此来判断是否含有脏字
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	$client_ip=GetIP();
	if(strpos($client_ip,',')>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	$sql0="select count(*) from mm_comment where addtime>(UNIX_TIMESTAMP()-60) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//同一IP留言时间间隔至少60秒
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	$sql="insert into mm_comment set username='".$username."',content='".format($content)."',addtime=".time().",mm_id=".$id.",ip='".$client_ip."'";
	$sql2="update mm_info set comm_count=comm_count+1 where id=".$id;
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

/**
*右边留言列表
*/
$pageitem=8;
$sql="select * from mm_comment ";
if($id>0)
{
	$sql.=" where mm_id=".$id;
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
		"TIME" => date("Y-m-d H:i",$row['addtime'])
		));
}

$tpl->assign_vars(array(
	"PAGE" => $pagenav,
	"DISPLAY" => checkLogin($row['blogurl'])?'':'none'
));
echo $row['blogurl'];
echo checkLogin($row['blogurl']);
/**
*左边留言排行列表
*/
$sql="SELECT * FROM mm_info order by comm_count desc limit 20";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("commList",array(
		"BLOGNAME" => substr_cut($row['blogname'],10),
		"TITLE" => $row['blogname'],
		"BLOGURL" => $row['blogurl'],
		"COUNT" => $row['comm_count'],
		"COMMENT" => '?id='.$row['id']
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
