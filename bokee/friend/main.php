<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."profile.inc.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'main.htm'));
if(''!=getBokie())
{
	$tpl->assign_vars(array(
		"DISPLAY"=>'none'));
}
else
{
	$tpl->assign_vars(array(
		"DISPLAY"=>''));
}
switch(basename($_SERVER["PHP_SELF"],'.php')) 
{
	case 'info':
		$tpl->assign_vars(array(
			"INFO_CLASS"=>'zirli02',
			"REQUEST_CLASS"=>'zirli03',
			"COMMENT_CLASS"=>'zirli03'
		));
		break;
	case 'request':
		$tpl->assign_vars(array(
			"INFO_CLASS"=>'zirli03',
			"REQUEST_CLASS"=>'zirli02',
			"COMMENT_CLASS"=>'zirli03'
		));
		break;
	case 'comment':
		$tpl->assign_vars(array(
			"INFO_CLASS"=>'zirli03',
			"REQUEST_CLASS"=>'zirli03',
			"COMMENT_CLASS"=>'zirli06'
		));
		break;
}
$id=$_REQUEST['id'];

//用户头像等信息
$sql1="select * from user_info where pass>=0 and id =".$id;
$result1=$db->sql_query($sql1);
if($db->sql_numrows($result1)==0)
{
//	echo '<br /><br /><br /><center style="font-size:20px">此用户还未通过审核,请等待审核通过后再查看此页面!</center><br /><br /><br />';
//	exit;
}
$row1=$db->sql_fetchrow($result1);
$tpl->assign_vars(array(
	"ID" => sprintf("%04d",$id),
	"BLOGURL" => $row1["blogurl"],
	"BLOGID"=>substr($row1['blogurl'],7,strpos($row1['blogurl'],'.')-7),
	"BLOGNAME" => $row1["blogname"],
	"PHOTO" => "photo/".$row1["photo"],
	"ADDTIME" => date("y/m/d",$row1["addtime"]),
	"COMM_COUNT"=>$row1['comm_count'],
	"VOTE" => $row1["vote"]
	));
//留下脚印
//echo substr($row1['blogurl'],7,strpos($row1['blogurl'],'.')-7);
$blogID=getBokie('blogID');
$groupID=getBokie('groupID');
if(''!=$blogID && $id>0 && $blogID!=substr($row1['blogurl'],7,strpos($row1['blogurl'],'.')-7))
{
	$sql0="select id from visitor where user_id=".$id." and blogID='".$blogID."'";
	$result0=$db->sql_query($sql0);
	if($db->sql_numrows($result0)>0)
	{
		$row0=$db->sql_fetchrow($result0);
		$sql="update visitor set vTime=NOW(),count=count+1 where id=".$row0['id'];
	}
	else
	{
		$sql="insert into visitor set user_id=".$id.",blogID='".$blogID."',groupID=".$groupID.",vTime=NOW(),count=1";
	}
//	echo $sql;
	$db->sql_query($sql);
}

//访客列表
$sql2="select * from visitor where user_id=".$id." order by vTime desc limit 6";
$result2=$db->sql_query($sql2);
while($row2=$db->sql_fetchrow($result2))
{
	$tpl->assign_block_vars('visitor',array(
		"blogID"=>$row2['blogID']
		));
}
//推荐美女
$sql3="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info.sex,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.sex=1 and user_info.pass=2 and user_info.id=user_info_ext.id order by user_info.updatetime desc,user_info.id desc limit 1";
$result3=$db->sql_query($sql3);
$row3=$db->sql_fetchrow($result3);
$tpl->assign_vars(array(
	"ID1"=>sprintf("%04d",$row3['id']),
	"BLOGNAME10"=>$row3['blogname'],
	"BLOGNAME1"=>substr_cut($row3['blogname'],10),
	"BLOGURL1"=>$row3['blogurl'],
	"BLOGID1"=>substr($row3['blogurl'],7,strpos($row3['blogurl'],'.')-7),
	"PHOTO1" => "photo/".$row3["photo"],
	"INFO1"=>str_replace('-','',$row3['location']).' '.('0000-00-00'==$row3['birthday']?'':((date("Y")-substr($row3['birthday'],0,4)).'岁')),
	"INTRO1" => substr_cut(str_replace('<br />',' ',str_replace('&nbsp;','',$row3['intro'])),72).'...',
	"VOTE1"=>$row3['vote'],
	"COMM_COUNT1"=>$row3['comm_count']
	));

//推荐帅哥
$sql4="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info.sex,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.sex=2 and user_info.pass=2 and user_info.id=user_info_ext.id order by user_info.updatetime desc,user_info.id desc limit 1";
$result4=$db->sql_query($sql4);
$row4=$db->sql_fetchrow($result4);
$tpl->assign_vars(array(
	"ID2"=>sprintf("%04d",$row4['id']),
	"BLOGNAME20"=>$row4['blogname'],
	"BLOGNAME2"=>substr_cut($row4['blogname'],10),
	"BLOGURL2"=>$row4['blogurl'],
	"BLOGID2"=>substr($row4['blogurl'],7,strpos($row4['blogurl'],'.')-7),
	"PHOTO2" => "photo/".$row4["photo"],
	"INFO2"=>str_replace('-','',$row4['location']).' '.('0000-00-00'==$row4['birthday']?'':((date("Y")-substr($row4['birthday'],0,4)).'岁')),
	"INTRO2" => substr_cut(str_replace('<br />',' ',str_replace('&nbsp;','',$row4['intro'])),72).'...',
	"VOTE2"=>$row4['vote'],
	"COMM_COUNT2"=>$row4['comm_count']
	));
$tpl->pparse('body');
$tpl->destroy();

?>