<?php
define('IN_MATCH', true);
$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");

$type=$_REQUEST['type'];
$limit=$_REQUEST['limit'];
$sex=$_REQUEST["sex"];
$pass=$_REQUEST['pass'];
$page=$_REQUEST["page"];
$search=$_REQUEST["search"];
if(''==$type)
{
	$type='new';
}
if(''==$limit)
{
	$limit=16;
}
if(16==$limit)
{
	include_once "header.php";
	include_once "user_list_left.php";
}

$tpl = new Template($root_path."templates");
if($limit!=16)
{
	$tpl->set_filenames(array(
		'body' => 'index_export.htm'));
}
else
{
	$tpl->set_filenames(array(
		'body' => 'user_list.htm'));
}
if(''==$sex)
{
	$sex='1';
}
//setcookie('c_sex',$sex,time()+24*60*60);
if(''==$pass)
{
	$pass=1;
}
if($pass==1)
{
	$subtitle_arr=array('new'=>'最新注册','hot'=>'最有魅力');
	$tpl->assign_vars(array(
		"SUBTITLE0"=>(1==$sex?$subtitle_arr[$type].'美女':'<a href="?type='.$type.'&sex=1">'.$subtitle_arr[$type].'美女</a>'),
		"SUBTITLE1"=>(2==$sex?$subtitle_arr[$type].'帅哥':'<a href="?type='.$type.'&sex=2">'.$subtitle_arr[$type].'帅哥</a>'),
		));
}
if($pass==2)
{
	$tpl->assign_vars(array(
		"SUBTITLE0"=>(1==$sex?'推荐美女':'<a href="?pass=2&sex=1">推荐美女</a>'),
		"SUBTITLE1"=>(2==$sex?'推荐帅哥':'<a href="?pass=2&sex=2">推荐帅哥</a>'),
		));
}
if(1==$search)
{
	$tpl->assign_vars(array(
		"SUBTITLE0"=>'搜索结果',
		"SUBTITLE1"=>''
		));
}
if($type=='hot')//每月鲜花排行
{
	$sql="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.pass>=".$pass." and user_info.id=user_info_ext.id and user_info.sex='".$sex."' order by monthvote desc,id desc";
}
if($type=='new')
{
	$sql="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.pass>=".$pass." and user_info.id=user_info_ext.id and user_info.sex='".$sex."' order by id desc";
}
if($pass==2)
{
	$sql="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.pass>=".$pass." and user_info.id=user_info_ext.id and user_info.sex='".$sex."' order by updatetime desc,id desc";
}
if(1==$search)
{
	$age1=$_REQUEST['age1'];
	$age2=$_REQUEST['age2'];
	$location=conv($_REQUEST['location']);
	if($age1=='')
	{
		$age1=18;
	}
	if($age2=='')
	{
		$age2=25;
	}
	$sql_ext=" and YEAR(NOW())-YEAR(user_info_ext.birthday)>".$age1." and YEAR(user_info_ext.birthday)-YEAR(NOW())<".$age2;
	if($location!='')
	{
		$sql_ext.=" and user_info_ext.location like '%".$location."%'";
	}
	$sql="select user_info.id,user_info.blogurl,user_info.blogname,user_info.photo,user_info.vote,user_info.comm_count,user_info_ext.birthday,user_info_ext.location,user_info_ext.intro from user_info,user_info_ext where user_info.pass>=".$pass." and user_info.id=user_info_ext.id and user_info.sex='".$sex."'".$sql_ext." order by monthvote desc,id desc";
}
$pageitem=$limit;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?type=".$type."&sex=".$sex."&pass=".$pass."&search=".$search."&age1=".$age1."&age2=".$age2."&location=".$location."&limit=".$limit);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	if($limit!=16)//首页调用
	{
		if($class=='qunlay2 renqibg')//交替变换行背景色
		{
			$class='qunlay2';
		}
		else
		{
			$class='qunlay2 renqibg';
		}
	}
	else
	{
		if($class=='newmm')//交替变换行背景色
		{
			$class='newmm mltb';
		}
		else
		{
			$class='newmm';
		}
	}
	$tpl->assign_block_vars("list", array(
		"CLASS"=>$class,
		"ID" => sprintf("%04d",$row["id"]),
		"BLOGNAME0"=>$row['blogname'],
		"BLOGNAME"=>substr_cut($row['blogname'],10),
		"BLOGURL" => $row["blogurl"],
		"BLOGID"=>substr($row['blogurl'],7,strpos($row['blogurl'],'.')-7),
		"PHOTO" => "photo/".$row["photo"],
		"INFO"=>str_replace('-','',$row['location']).' '.(('0000'==substr($row['birthday'],0,4))?'':((date("Y")-substr($row['birthday'],0,4)).'岁')),
		"INTRO" => substr_cut(str_replace('<br />',' ',str_replace('&nbsp;','',$row['intro'])),72).'...',
		"VOTE" => $row["vote"],
		"COMM_COUNT"=>$row['comm_count']
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
	));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

if($limit==16)
{
	require_once "templates/footer.htm";
}
?>