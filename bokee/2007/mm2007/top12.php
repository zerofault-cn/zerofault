<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'top12.htm')
		);
$pass=$_REQUEST['pass'];
$sql="select * from mm_info where pass=3 order by allvote desc,id desc";
$i=0;
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$id=$row['id'];
	$blogurl=$row['blogurl'];
	$blogname=$row['blogname'];
	$tmp_blogname=substr_cut($blogname,14);
	$photo=$row['photo'];
	$area=$row['area'];
	$tpl->assign_block_vars("list",array(
		"ORDER"=>$i,
		"ID"=>sprintf("%04d",$id),
		"BLOGURL"=>$blogurl,
		"BLOGNAME"=>$blogname,
		"TMP_BLOGNAME"=>$tmp_blogname,
		"SMSPOLLWIDTH" => ($area==1)?'608':'608',
		"SMSPOLLHEIGHT" => ($area==1)?'520':'320',
		"PHOTO"=>$photo,
		"DATE"=>date("m-d",$row['addtime']),
		"AREA"=>$area
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
