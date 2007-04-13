<?
include_once "session.php";
define('IN_MATCH', true);

$root_path ="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//一些参数
$pageitem=10;//每页显示个数

$page=$_REQUEST["page"];//页码

//搜索表单中的变量
$s_id=$_REQUEST["s_id"];
$s_blogname=$_REQUEST['s_blogname'];
$s_realname=$_REQUEST['s_realname'];
$s_area=$_REQUEST['s_area'];


if(''!=$_REQUEST['submit'])
{
	$sql="select * from user_info where 0";
	if(''!=$s_id)
	{
		$sql.=" or id=".$s_id;
	}
	if(''!=$s_blogname)
	{
		$sql.= " or blogname like '%".$s_blogname."%'";
	}
	if(''!=$s_realname)
	{
		$sql.=" or realname like '%".$s_realname."%'";
	}
	$sql.=" order by id desc";
}
else
{
	$sql="select * from user_info order by id desc";
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_id=".$s_id."&s_blogname=".$s_blogname."&s_realname=".$s_realname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);

$i=($page-1)*$pageitem;//序号
while($row=$db->sql_fetchrow($result))
{
	$i++;
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
		"ID" => $row["id"],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['photo'],
		"BLOGURL" => substr($row["blogurl"],7),
		"ADDTIME" => date("y/m/d H:i",$row["addtime"]),
		"VOTE" => $row['vote'],
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