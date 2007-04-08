<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
		'body' => 'new_list.htm'));

$sql="select * from mm_info where pass=1 order by id desc limit 10";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$area=$row['area'];
	if($i<=5)
	{
		$tpl->assign_block_vars("list1", array(
			"ID" => sprintf("%04d",$row["id"]),
			"BLOGURL" => $row["blogurl"],
			"TITLE"		=> $row['blogname'],
			"BLOGNAME" => substr_cut($row["blogname"],10),
			"PHOTO" => "/2007/mm2007/photo/".$area.'/'.$row["photo"],
			"LINK" => "/2007/mm2007/comment.php?id=".$row["id"]
			));
	}
	else
	{
		$tpl->assign_block_vars("list2", array(
			"ID" => sprintf("%04d",$row["id"]),
			"BLOGURL" => $row["blogurl"],
			"TITLE"		=> $row['blogname'],
			"BLOGNAME" => substr_cut($row["blogname"],10),
			"PHOTO" => "/2007/mm2007/photo/".$area.'/'.$row["photo"],
			"LINK" => "/2007/mm2007/comment.php?id=".$row["id"]
			));
	}
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>