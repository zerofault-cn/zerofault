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
	$sql="select user_id,count(*) as count from comment where addtime>(UNIX_TIMESTAMP()-30*24*3600) group by user_id order by count desc limit 20";
}
elseif($type=='new')
{
	$sql="select * from user_info order by id desc limit 20";
}
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	if($type=='msg')
	{
		$link='comment.php?id='.$row["id"];
		$text='留言';
		$blogurl=getField($row['user_id'],'blogurl');
		$blogname0=getField($row['user_id'],'blogname');
		$blogname=substr_cut($blogname,10);
	}
	else
	{
		$link='poll.php?id='.$row["id"];
		$text='献花';
		$blogurl=$row["blogurl"];
		$blogname0=$row['blogname'];
		$blogname=substr_cut($blogname,8);
	}
	$tpl->assign_block_vars("list", array(
		"LINK" => $link,
		"TEXT" =>$text,
		"BLOGURL" => $blogurl,
		"BLOGNAME0" => $blogname0,
		"BLOGNAME" => $blogname,
		"COUNT" => $row["count"]
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>