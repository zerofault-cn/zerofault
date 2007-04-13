<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

//首页调用留言列表
$tpl = new Template($root_path."templates");

$type=$_GET['type'];//可选值：mark，new
if(''==$type)
{
	$type='new';
}
$tpl->set_filenames(array(
		'body' => 'comm_list.htm'));

if($type=='mark')
{
	$sql="select * from comment where mark=1 order by id desc limit 6";
}
elseif($type=='new')
{
	$sql="select * from comment order by id desc limit 6";
}
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"STYLE" => ($type=='mark')?'msgbox_l':'msgbox_r',
		"ID" => $row["user_id"],
		"BLOGNAME" => getField($row['user_id'],'blogname'),
		"CONTENT" => $row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'游客',
		"ADDTIME" => date("y/m/d H:i",$row['addtime'])
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();	
?>