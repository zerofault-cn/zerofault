<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
$tpl = new Template($root_path."templates");

$type=$_GET['type'];
$limit=$_GET['limit'];
$page=$_GET["page"];
if(''==$type)
{
	$type='new';
}
if(''==$limit)
{
	$limit=12;
}
if($limit<=8)//提供给CMS调用的部分用户列表
{
	$tpl->set_filenames(array(
			'body' => 'user_list.htm'));
}
else//所有用户列表
{
	$tpl->set_filenames(array(
			'body' => 'user_list2.htm'));
}

if($type=='hot')
{
	$sql="select * from user_info order by monthvote desc,id desc";
}
elseif($type=='new')
{
	$sql="select * from user_info order by id desc";
}
$pageitem=$limit;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?type=".$type."&limit=".$limit);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"ID" => sprintf("%04d",$row["id"]),
		"BLOGURL" => $row["blogurl"],
		"BLOGNAME0" => $row["blogname"],
		"BLOGNAME" => substr_cut($row["blogname"],14),
		"REALNAME" => $row["realname"],
		"PHOTO" => "photo/".$row["photo"],
		"POLL" => "poll.php?id=".$row['id'],
		"LIUYAN" => "comment.php?id=".$row["id"],
		"ADDTIME" => date("y/m/d",$row["addtime"]),
		"COMMNUM" => $row['comm_count'],
		"MONTHVOTE" => $row['monthvote'],
		"VOTE" => $row["vote"]
		));
}

$sql="select * from user_info where blogname!='' order by vote desc,id desc limit 0,33";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("tplist", array(
		"POLL" => "poll.php?id=".$row['id'],
		"TITLE" => $row['blogname'],
		"BLOGNAME" =>substr_cut($row["blogname"],8),
		"BLOGURL" => $row["blogurl"],
		"COUNT" =>$row["vote"]
		));
}

$tpl->assign_vars(array(
	"SUBTITLE" => ($type=='hot')?'鲜花排行':'最新加盟宝贝',
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>