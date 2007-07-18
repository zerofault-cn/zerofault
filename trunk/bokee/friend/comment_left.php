<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'comment_left.htm'));


//аТятеепп
$sql="select * from user_info order by comm_count desc,id limit 30";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars('list0',array(
		"I"=>sprintf("%02d",$i),
		"ID"=>sprintf("%04d",$row['id']),
		"BLOGNAME0"=>$row['blogname'],
		"BLOGNAME"=>substr_cut($row['blogname'],10),
		"BLOGURl"=>$row['blogurl'],
		"COMM_COUNT" => $row["comm_count"]
		));
}

$tpl->pparse('body');
$tpl->destroy();
?>