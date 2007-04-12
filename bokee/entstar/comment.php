<?
session_start();
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."functions.php");
$id=$_REQUEST['id'];
if(''==$id)
{
	header("location:index.php");
	exit;
}
//处理提交的留言
if(''!=$_POST['submit'])
{
	$username	= trim($_POST['username']);
	if(''==$username)
	{
		$username='匿名';
	}
	$content	= trim($_POST['content']);
	//判断是否刷屏
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('请不要重复留言！');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 0)
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
/*
	$sql0="select count(*) from mm_comment where addtime>(UNIX_TIMESTAMP()-60) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//同一IP留言时间间隔至少60秒
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
*/
	$sql1="insert into comment set username='".$username."',content='".format($content)."',addtime=".time().",user_id=".$id.",ip='".$client_ip."'";
	$sql2="update user_info set comm=comm+1,month_comm=month_comm+1 where id=".$id;
	if($db->sql_query($sql1))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//更新用户的留言计数
		}
		header("location:?".$_SERVER["QUERY_STRING"]);
	//	echo '<script>window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
	else
	{
		echo '<script>alert("有错误发生!请稍后再试，或者联系客服人员");window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
}
//提交留言处理完成
$curpage="comment";
include_once("header.php");//公共头部

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

//左侧明星照片
$sql1="select id,realname,blogurl,groupurl,photo,flower,egg from user_info where id=".$id;
assign_vars_by_sql($sql1);

$pageitem=6;
$sql="select username,FROM_UNIXTIME(addtime,'%y/%m/%d %H:%i:%s') as time,content from comment ";
if($id>0)
{
	$sql.=" where user_id=".$id;
}
$sql.=" order by id desc";

$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?id=".$id);
assign_block_vars_by_sql("comm_list",$sql." limit ".$offset.",".$pageitem);

$tpl->assign_vars(array(
	"PAGE" => $pagenav,
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
include_once("footer.php")//公共页脚
?>