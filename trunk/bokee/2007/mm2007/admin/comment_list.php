<?
include "session.php";
define('IN_MATCH', true);
$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array(
			'body' => 'comment_list.htm')
		);


$pageitem=15;
$mark_arr=array('设为精彩','取消精彩');

$page=$_REQUEST["page"];
$mm_id=$_REQUEST['mm_id'];

if(!session_is_registered('mm_id'))
{
	session_register('mm_id');//判断留言对象的radio使用
}
$_SESSION['mm_id']=$mm_id;
if(''!=$_REQUEST['submit'])
{
	$s_username=$_REQUEST["s_username"];
	$s_blogname=$_REQUEST['s_blogname'];
	if(''!=$s_username)//查询留言者的所有留言，留言对象待查询到mm_id后单独取出
	{
		$sql="select * from mm_comment where username like '%".$s_username."%' order by id desc";
	}
	elseif(''!=$s_blogname)//这里假设mm_info表中仅有一条记录符合要求，先查出mm_id，再以此为关键字查询留言
	{
		$sql="select id,blogurl from mm_info where binary blogname like '%".$s_blogname."%'";
		$result=$db->sql_query($sql);
		$mm_id=$db->sql_fetchfield(0,0,$result);
		$blogurl=$db->sql_fetchfield(1,0,$result);
		$db->sql_freeresult();
		$sql="select *,'".$s_blogname."' as blogname,'".$blogurl."' as blogurl from mm_comment where mm_id=".$mm_id." order by id desc";
	}
}
else
{
	if(''==$mm_id)//普通两表连接查询，无法避免
	{
		$sql="select mm_comment.*,mm_info.blogname,mm_info.blogurl from mm_comment,mm_info where mm_comment.mm_id=mm_info.id order by mm_comment.id desc";
	}
	else
	{
		$sql="select * from mm_comment where mm_id=0 order by id desc";
	}
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?mm_id=".$mm_id."&submit=".$_REQUEST['submit']."&s_username=".$s_username."&s_blogname=".$s_blogname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$t_blogname='';
	$t_blogurl='';
	$t_mm_id=$row['mm_id'];//取出的值不会为空，要么是0，要么是非0
	if(''!=$s_username && 0!=$t_mm_id)//如果搜索关键字是留言人名，则留言对象必须单独从mm_info表中取出
	{
		$t_blogname=getField($t_mm_id,'blogname');
		$t_blogurl=getField($t_mm_id,'blogurl');
	}
	if($t_mm_id==0)//当取出mm_id为0时，表示此留言是对所有人的
	{
		$mm_id=0;
	}
	$tpl->assign_block_vars("list", array(
		"ID" => $row['id'],
		"MM_ID" => $row['mm_id'],
		"USERNAME" => (''==$row['username'])?'游客':$row['username'],
		"CONTENT" => $row["content"],
		"ADDTIME" => date("y/m/d H:i:s",$row["addtime"]),
		"MARK" => $mark_arr[$row['mark']],
		"BLOGNAME" => (''!=$t_blogname)?$t_blogname:((strlen($mm_id)==1&&$mm_id==0)?'所有人':$row['blogname']),
		"BLOGURL" => (''!=$t_blogurl)?$t_blogurl:((strlen($mm_id)==1&&$mm_id==0)?'#':$row['blogurl']),
		"IP" => $row['ip'],
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"MM_ID" => $mm_id,
	"BTNFN" => $btnfn,//对于仅有查看权限的用户，仅用所有表单和按钮
	"CHECK0" => (strlen($mm_id)==1&&$mm_id==0)?' checked':'',
	"CHECK1" => (strlen($mm_id)==1&&$mm_id==0)?'':' checked',
//	"DELBTNFN" => (strlen($mm_id)==1&&$mm_id==0)?'':' disabled',//可以批量对所有人的留言
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

?>