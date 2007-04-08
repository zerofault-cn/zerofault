<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

//ͶƱ����
//��������
$tpl = new Template($root_path."templates");

$type=$_GET['type'];//��ѡֵ��msg,hot
$area=$_REQUEST['area'];//������ǣ�1���У�2���ϣ�3����
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
		"COUNT" => ($type=='msg')?($row["comm_count"].'ƪ'):('��'.$i.'��'),
		"LINK" => '/2007/mm2007/comment.php?id='.$row["id"],
		"TEXT" =>($type=='msg')?'����':'ͶƱ',
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>