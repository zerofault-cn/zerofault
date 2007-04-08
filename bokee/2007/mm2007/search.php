<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
/*
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'search.htm')
		);
*/
$type=$_REQUEST['type'];
$value=conv($_REQUEST['value']);
if($type=='id')
{
	$sql="select * from mm_info where id=".$value;
}
elseif($type=='blogname')
{
	$sql="select * from mm_info where binary ".$type." LIKE '%".$value."%' order by id desc";
}
else
{
	$sql="select * from mm_info order by id desc";
}
$result=$db->sql_query($sql);
if($row=$db->sql_fetchrow($result))
{
	header("location:comment.php?id=".$row['id']);
	exit;
}
else
{
	echo '<script>alert("没有搜索到您想要要的结果!");history.back()</script>';
}
/*
while($row=$db->sql_fetchrow($result))
{
	$tpl->assign_block_vars("list", array(
		"ID" => $row["id"],
		"BLOGNAME" => $row['blogname'],
		"BLOGURL" => $row['blogurl'],
		"POLL"	=> "poll.php?type=net$id=".$row["id"],
		"COMMENT"	=> "comment.php?id=".$row["id"],
		"SMSPOLL"	=> 'poll.php?type=sms$id=".$row["id"],
		"TIME"		=> date("y-m-d H:i",$row['addtime'])
		));
}
*/
/*
$db->sql_close();
$tpl->assign_vars(array("AREA" => $area));
$tpl->pparse('body');
$tpl->destroy();	
*/
?>