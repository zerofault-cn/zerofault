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

$page=$_REQUEST["page"];
$id=intval($_REQUEST['id']);//此id为mm_info表的id,即comment表里的mm_id
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
		echo "<script>alert('您的留言也太短了！');history.back();</script>";
		exit;
	}
	include_once ("./filter.php");//引用屏蔽字符数组$filter_arr
	$slen=strlen($content);
	//
	if(strlen(str_replace("href=","",$content))<$strlen || strlen(eregi_replace("^[[[0-9]{1,4}][[a-z]{1,4}]+]+$","",$content))<$strlen || strlen( str_replace($filter_arr,'',$content) ) < $slen)//如果有字符被屏蔽，则新字符串比原字符串短，以此来判断是否含有脏字
	{
		header("location:?".$_SERVER["QUERY_STRING"]."&filter");
		exit;
	}
	$client_ip=GetIP();
	if(ereg("^((123.112.102.102)|(124.116.2.21))$",$client_ip))
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	if(strpos($client_ip,',')>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	$sql0="select count(*) from mm_comment where addtime>(UNIX_TIMESTAMP()-60) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//同一IP留言时间间隔至少60秒
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]."&time");
		exit;
	}
	$sql="insert into mm_comment set username='".format2($username)."',content='".format($content)."',addtime=".time().",mm_id='".$id."',ip='".$client_ip."'";
	$sql2="update mm_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//更新留言计数
		}
		header("location:?".$_SERVER["QUERY_STRING"]."&ok");
	//	echo '<script>window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
	else
	{
		echo '<script>alert("有错误发生!请稍后再试，或者联系客服人员");window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
}
//处理提交留言结束

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

if($id>0)
{
	$sql="select * from mm_info where (pass=1 or pass=2) and id=".$id;
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
	$sql="select * from mm_info where id=".$id;
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$pass=$row['pass'];
	//获取排名
	$sql2="select id from mm_info where pass=".$pass." order by allvote desc,id desc";
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
	$bokeeurl=substr($blogurl,7);
	if(strpos($bokeeurl,'/')>0)
	{
		$bokeeurl=substr($bokeeurl,0,strpos($bokeeurl,'/'));
	}
	$viewurl='http://my.bobo.com.cn/bokee/zhong.php?flag=view&userid='.$id.'&bokeeURL='.$bokeeurl;
	$uploadurl=checkLogin($blogurl)?'http://my.bobo.com.cn/bokee/zhong.php?flag=up&userid='.$id.'&bokeeURL='.$bokeeurl:'http://reg.bokee.com/account/LoginCtrl.b';
//	$uploadurl='http://my.bobo.com.cn/bokee/zhong.php?flag=up&userid=3&bokeeURL=dede0616.bokee.com';
	$boboimg='http://my.bobo.com.cn/bokee/changepic.php?userid='.$id;
	$tpl->assign_vars(array(
		"ID" => sprintf("%04d",$id),
		"BLOGURL" => $blogurl,
		"AREA_NAME" => $area_arr[$row['area']].'：'.$row['blogname'],
		"BLOGNAME" => $row['blogname'],
		"PHOTOIMG" => '<a href="'.$row['blogurl'].'" target="_blank"><img src="photo/'.$row['area'].'/'.$row['photo'].'" width="210" height="210" border="0" /></a>',
		"POLL" => "poll.php?type=net&id=".$row["id"],
		"COMMENT" => "?id=".$row["id"],
		"SMSPOLL" => "poll.php?type=sms&area=".$row['area']."&id=".$row["id"],
		"SMSPOLLWIDTH" => ($row['area']==1)?'630':'630',
		"SMSPOLLHEIGHT" => ($row['area']==1)?'530':'322',
		"BOBOIMG" => $boboimg,
		"BOBOIMGALT" => 'BOBO视频',
		"BOBOLINK" => (strlen(file_get_contents($boboimg))==711)?$viewurl:$uploadurl,
		"DATE" => date("y/m/d",$row['addtime']),
		"ALLVOTE" => getField($id,'allvote','mm_info_0418'),
		"ORDER" => ((1==$pass)?'复活选手排名':'60强排名').'：第'.$order.'名',
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
	"DISPLAY" => checkLogin($blogurl)?'':'none'
));

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
