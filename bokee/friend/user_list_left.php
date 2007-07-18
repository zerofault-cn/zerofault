<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'user_list_left.htm'));


//鲜花月排行-女
$sql="select * from user_info where sex=1 order by monthvote desc,id limit 15";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars('list1',array(
		"I"=>sprintf("%02d",$i),
		"ID"=>sprintf("%04d",$row['id']),
		"BLOGNAME0"=>$row['blogname'],
		"BLOGNAME"=>substr_cut($row['blogname'],10),
		"BLOGURl"=>$row['blogurl'],
		"MONTHVOTE" => $row["monthvote"]
		));
}
//鲜花月排行-男
$sql="select * from user_info where sex=2 order by monthvote desc,id limit 15";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars('list2',array(
		"I"=>sprintf("%02d",$i),
		"ID"=>sprintf("%04d",$row['id']),
		"BLOGNAME0"=>$row['blogname'],
		"BLOGNAME"=>substr_cut($row['blogname'],10),
		"BLOGURl"=>$row['blogurl'],
		"MONTHVOTE" => $row["monthvote"]
		));
}
$tpl->pparse('body');
$tpl->destroy();
?>