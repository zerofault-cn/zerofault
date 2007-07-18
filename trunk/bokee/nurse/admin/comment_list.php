<?
include "session.php";
define('IN_MATCH', true);

$root_path = "./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

require_once($root_path."templates/admin/left.htm");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array(
			'body' => 'comment_list.htm')
		);


$pageitem=15;
$mark_arr=array('设为精彩','取消精彩');

$page=$_REQUEST["page"];
if(''!=$_REQUEST['submit'])
{
	$s_username=$_REQUEST["s_username"];
	$s_blogname=$_REQUEST['s_blogname'];
	if(''!=$s_username)//查询留言者的所有留言，留言对象待查询到mm_id后单独取出
	{
		$sql="select * from comment where username like '%".$s_username."%' order by id desc";
	}
	elseif(''!=$s_blogname)//这里假设mm_info表中仅有一条记录符合要求，先查出mm_id，再以此为关键字查询留言
	{
	//	$sql="select id,blogurl from user_info where binary blogname like '%".$s_blogname."%'";
	//	$result=$db->sql_query($sql);
	//	$user_id=$db->sql_fetchfield(0,0,$result);
	//	$blogurl=$db->sql_fetchfield(1,0,$result);
	//	$db->sql_freeresult();
	//	$sql="select *,'".$s_blogname."' as blogname,'".$blogurl."' as blogurl from comment where user_id=".$user_id." order by id desc";
		$sql="select comment.*,user_info.blogname,user_info.blogurl from comment,user_info where comment.user_id=user_info.id and binary user_info.blogname like '%".$s_blogname."%'";
	}
}
else
{
	$sql="select comment.*,user_info.blogname,user_info.blogurl from comment,user_info where comment.user_id=user_info.id order by comment.id desc";
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_username=".$s_username."&s_blogname=".$s_blogname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$i=($page-1)*$pageitem;//序号
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$t_blogname='';
	$t_blogurl='';
	$user_id=$row['user_id'];//取出的值不会为空，要么是0，要么是非0
	if(''!=$s_username && 0!=$t_user_id)//如果搜索关键字是留言人名，则留言对象必须单独从user_info表中取出
	{
		$t_blogname=getField($user_id,'blogname');
		$t_blogurl=getField($user_id,'blogurl');
	}
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $row['id'],
		"USER_ID" => $row['user_id'],
		"USERNAME" => (''==$row['username'])?'游客':$row['username'],
		"CONTENT" => $row["content"],
		"ADDTIME" => date("y/m/d H:i:s",$row["addtime"]),
		"MARK" => $mark_arr[$row['mark']],
		"BLOGNAME" => (''!=$t_blogname)?$t_blogname:((strlen($user_id)==1&&$user_id==0)?'所有人':$row['blogname']),
		"BLOGURL" => (''!=$t_blogurl)?$t_blogurl:((strlen($user_id)==1&&$user_id==0)?'#':$row['blogurl']),
		"BGCOLOR" => $bgcolor,//设置行的背景色交替
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>