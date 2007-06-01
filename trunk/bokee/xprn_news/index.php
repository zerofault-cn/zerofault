<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
$tpl = new Template($root_path."templates");

$tpl->set_filenames(array('body' => 'article_list.htm'));

$pageitem=20;

$sql="select * from article order by id desc";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"");
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	if($i<5)
	{
		$tpl->assign_block_vars("list1", array(
			"ID" =>$row["id"],
			"DATETIME"=>$row['datetime'],
			"TITLE"=>$row['title'],
			"SUBTITLE"=>substr_cut($row['content'],200)
			));
	}
	else
	{
		$tpl->assign_block_vars("list2", array(
			"ID" =>$row["id"],
			"DATETIME"=>$row['datetime'],
			"TITLE"=>$row['title'],
			));
	}
	$i++;
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>