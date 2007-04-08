<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

//投票排行
//留言排行
$tpl = new Template($root_path."templates");

$type=$_GET['type'];//可选值：msg,hot
$area=$_REQUEST['area'];//赛区标记，1：中，2：南，3：北
if(''==$type)
{
	$type='msg';
}
if($type=='hot' && ''==$area)
{
	$area=1;
}
$tpl->set_filenames(array(
		'body' => 'ph_list.htm'));

if($type=='msg')
{
	$sql="select * from mm_info order by comm_count desc,id desc limit 10";
}
elseif($type=='hot')
{
	$sql="select * from mm_info where area=".$area." order by allvote desc limit 10";
}
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$tpl->assign_block_vars("list", array(
		"BLOGURL" => $row["blogurl"],
		"TITLE" => $row['blogname'],
		"BLOGNAME" => substr_cut($row["blogname"],10),
		"COUNT" => ($type=='msg')?($row["comm_count"].'篇'):('第'.$i.'名'),
		"LINK" => '/2007/mm2007/comment.php?id='.$row["id"],
		"TEXT" =>($type=='msg')?'留言':'投票',
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>