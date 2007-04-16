<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");


$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'top60.htm')
		);
$sql="select * from mm_info where pass=1 order by allvote desc,id limit 10";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$blogurl=$row['blogurl'];
	$blogname=$row['blogname'];
	$tmp_blogname=substr_cut($blogname,14);
	$photo=$row['photo'];
	$area=$row['area'];
	$arr[$id]=array(
		"ID"=>sprintf("%04d",$id),
		"BLOGURL"=>$blogurl,
		"BLOGNAME"=>$blogname,
		"TMP_BLOGNAME"=>$tmp_blogname,
		"PHOTO"=>$photo,
		"AREA"=>$area
		);
//	$sql2="update mm_info set pass=2 where id=".$id;
//	$db->sql_query($sql2);
}
while(list($key,$val)=each($arr))
{
	$tpl->assign_block_vars("top60list", $val);
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
