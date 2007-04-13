<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

//投票排行
//留言排行
//最新报名
$tpl = new Template($root_path."templates");

$type=$_GET['type'];//可选值：vote,msg,new
if(''==$type)
{
	$type='new';
}
$tpl->set_filenames(array(
		'body' => 'ph_list.htm'));

if($type=='vote')
{
	$sql="select *,vote as count from user_info order by vote desc,id desc limit 20";
}
elseif($type=='monthvote')
{
	$sql="select *,monthvote as count from user_info order by monthvote desc,id desc limit 20";
}
elseif($type=='msg')
{
	$sql="select *,comm_count as count from user_info order by comm_count desc,id desc limit 20";
}
elseif($type=='new')
{
	$sql="select * from user_info order by id desc limit 20";
}
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"LINK" => ($type=='msg')?'comment.php?id='.$row["id"]:'poll.php?id='.$row["id"],
		"TEXT" =>($type=='msg')?'留言':'献花',
		"BLOGURL" => $row["blogurl"],
		"TITLE" => $row['blogname'],
		"BLOGNAME" => substr_cut($row["blogname"],8),
		"COUNT" => $row["count"]
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>