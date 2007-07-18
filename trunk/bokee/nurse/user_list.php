<?php
define('IN_MATCH', true);

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");

$tpl = new Template($root_path."templates");

$type=$_REQUEST['type'];
$area=$_REQUEST['area'];
$limit=$_REQUEST['limit'];
$page=$_REQUEST["page"];
if(''==$type)
{
	$type='new';
}
if(''==$area)
{
	$area=1;
}
if(''==$limit)
{
	$limit=18;
}
if($limit==2)//首页各分赛区前2名
{
	$tpl->set_filenames(array(
			'body' => 'index_top2.htm'));
}
elseif($limit==6)//首页最新注册
{
	$tpl->set_filenames(array(
			'body' => 'index_new6.htm'));
}
else//所有用户列表
{
	$tpl->set_filenames(array(
			'body' => 'user_list.htm'));
}

if($type=='hot')
{
	$sql="select * from user_info where area=".$area." and pass>0 order by netvote desc,id desc";
}
elseif($type=='new')
{
	if($limit==6)
	{
		$sql="select * from user_info where pass>0 order by id desc";
	}
	else
	{
		$sql="select * from user_info where area=".$area." and pass>0 order by id desc";
	}
}
$pageitem=$limit;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?area=".$area."&type=".$type."&limit=".$limit);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"ID" => sprintf("%05d",$row["id"]),
		"AREA"=>$row['area'],
		"AREA_NAME"=>$area_arr[$row['area']],
		"BLOGURL" => $row["blogurl"],
		"BLOGNAME0" => $row["blogname"],
		"BLOGNAME" => substr_cut($row["blogname"],14),
		"REALNAME"=>$row['realname'],
		"HOSPITAL"=>$row['hospital'],
		"PHOTO" => $row["photo"],
		"ADDTIME" => date("y/m/d",$row["addtime"]),
		));
}

$tpl->assign_vars(array(
	"CLASS"=>($area<=2)?'saiqu':'saiqu mtopb',
	"AREA"=>$area,
	"AREA_NAME"=>$area_arr[$area],
	"TYPE_NAME" => ($type=='hot')?'赛区票数排行':'赛区最新报名',
	"COUNT"=>$total,
	"LOGINFORM_DISPLAY"=>getBokie()?'none':'',
	"PAGE" => $pagenav
	));

//左边投票排行
$sql1="select * from user_info where area=".$area." order by smsvote desc limit 10";
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$tpl->assign_block_vars("tplist", array(
		"ID" => $row['id'],
		"BLOGNAME0" => $row['blogname'],
		"BLOGNAME" =>substr_cut($row["blogname"],16),
		"REALNAME"=>$row['realname'],
		"BLOGURL" => $row["blogurl"],
		"COUNT" =>$row["smsvote"]
		));
}
//左边献花排行
$sql2="select * from user_info where area=".$area." order by netvote desc limit 10";
$result2=$db->sql_query($sql2);
while($row=$db->sql_fetchrow($result2))
{
	$tpl->assign_block_vars("xhlist", array(
		"ID" => $row['id'],
		"BLOGNAME0" => $row['blogname'],
		"BLOGNAME" =>substr_cut($row["blogname"],16),
		"REALNAME"=>$row['realname'],
		"BLOGURL" => $row["blogurl"],
		"COUNT" =>$row["netvote"]
		));
}
//左边留言排行
$sql3="select * from user_info where area=".$area." order by comm_count desc limit 10";
$result3=$db->sql_query($sql3);
while($row=$db->sql_fetchrow($result3))
{
	$tpl->assign_block_vars("lylist", array(
		"ID" => $row['id'],
		"BLOGNAME0" => $row['blogname'],
		"BLOGNAME" =>substr_cut($row["blogname"],16),
		"REALNAME"=>$row['realname'],
		"BLOGURL" => $row["blogurl"],
		"COUNT" =>$row["comm_count"]
		));
}


$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>