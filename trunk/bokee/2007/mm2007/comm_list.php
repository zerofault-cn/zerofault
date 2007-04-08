<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");

$limit=$_GET['limit'];
if(''==$limit)
{
	$limit=5;
}
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'comm_list.htm')
		);

$sql="select * from mm_comment where mark=1 order by id desc limit 0,".$limit;
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$mm_id=$row['mm_id'];
	$tpl->assign_block_vars("list", array(
		"ID" => $row["id"],
		"COMMENT" => (''!=$mm_id && 0!=$mm_id)?'mm2007/comment.php?id='.$mm_id:'#',
		"BLOGNAME" => (''!=$mm_id && 0!=$mm_id)?getField($mm_id,'blogname'):'所有人',
		"CONTENT" => $row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'游客',
		"TIME" => date("Y-m-d H:i",$row['addtime'])
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();	
?>