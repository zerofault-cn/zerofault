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
$pass=$_REQUEST['pass'];
if(''==$pass)
{
	$pass=1;
}
if($pass==1)//复活选手
{
	$sql="select * from mm_info where pass=1 order by allvote desc,id desc limit 10";
}
elseif($pass==2)//60强
{
	$sql="select * from mm_info where pass=2 order by allvote desc,id desc";
}
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$blogurl=$row['blogurl'];
	$blogname=$row['blogname'];
	$tmp_blogname=substr_cut($blogname,14);
	$photo=$row['photo'];
	$area=$row['area'];
	$tpl->assign_block_vars("list",array(
		"ID"=>sprintf("%04d",$id),
		"BLOGURL"=>$blogurl,
		"BLOGNAME"=>$blogname,
		"TMP_BLOGNAME"=>$tmp_blogname,
		"SMSPOLLWIDTH" => ($area==1)?'608':'608',
		"SMSPOLLHEIGHT" => ($area==1)?'520':'320',
		"PHOTO"=>$photo,
		"AREA"=>$area
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
