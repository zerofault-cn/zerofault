<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");

$tpl = new Template($root_path."templates");
$area_arr = array(
	1 => '中部赛区',
	2 => '南部赛区',
	3 => '北部赛区',);
$type_arr = array(
	"new" => '最新报名：',
	"hot" => '票数排行：');
$area=$_GET['area'];
$type=$_GET['type'];
$limit=$_GET['limit'];
$page=$_GET["page"];
if(''==$area)
{
	$area=1;
}
if(''==$type)
{
	$type='new';
}
if(''==$limit)
{
	$limit=20;
}
if($limit<=8)//提供给CMS调用的部分用户列表
{
	$tpl->set_filenames(array(
			'body' => 'mm_list.htm'));
}
else//各赛区所有用户列表
{
	$tpl->set_filenames(array(
			'body' => 'mm_list2.htm'));
}
if($type=='new')//按报名顺序
{
	$sql="select * from mm_info where pass=1 and area=".$area." order by id desc";
}
elseif($type=='hot')//按票数顺序
{
	$sql="select * from mm_info where pass=1 and area=".$area." order by allvote desc,id desc";
}
elseif($type=='hbhot')//湖北用户票数排序
{
	$sql="select * from mm_info where pass=1 and blogurl like '%home.hb.vnet.cn%' order by allvote desc,id desc";
}
$pageitem=$limit;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?area=".$area."&type=".$type."&limit=".$limit);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$order=($page-1)*$pageitem;//用于排名计数
while($row=$db->sql_fetchrow($result))
{
	$order++;
	$id=$row['id'];
	$blogurl=$row['blogurl'];
	$bokeeurl=substr($blogurl,7);
	if(strpos($bokeeurl,'/')>0)
	{
		$bokeeurl=substr($bokeeurl,0,strpos($bokeeurl,'/'));
	}
	$bobo_flag=$row['bobo_flag'];
	$boboimg='http://my.bobo.com.cn/bokee/changepic.php?userid='.$id;
	$viewurl='http://my.bobo.com.cn/bokee/zhong.php?flag=view&userid='.$id.'&bokeeURL='.$bokeeurl;
	$uploadurl=checkLogin($blogurl)?'http://my.bobo.com.cn/bokee/zhong.php?flag=up&userid='.$id.'&bokeeURL='.$bokeeurl:'http://reg.bokee.com/account/LoginCtrl.b';
	$tpl->assign_block_vars("list", array(
		"ID" => sprintf("%04d",$id),
		"BLOGURL" => $blogurl,
		"TITLE"		=> $row['blogname'],
		"BLOGNAME" => substr_cut($row["blogname"],14),
		"PHOTO" => "photo/".$area.'/'.$row["photo"],
		"POLL" => "poll.php?type=net&id=".$id,
		"COMMENT" => "comment.php?id=".$id,
		"SMSPOLL" => "poll.php?type=sms&area=".$area."&id=".$id,
		"SMSPOLLWIDTH" => ($area==1)?'608':'608',
		"SMSPOLLHEIGHT" => ($area==1)?'480':'320',
		"ORDER" =>'',// ($type=='hot')?('赛区排名：第'.$order.'名'):'',
		"INFO" => '报名时间：'.date("y/m/d",$row['addtime']),
		"BOBOIMG" => $boboimg,
		"BOBOIMGALT" => (1==$bobo_flag)?'欣赏视频':'上传视频',
		"BOBOLINK" => (1==$bobo_flag)?$viewurl:$uploadurl,
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"AREA" => $area,
	"TITLE" => ($type=='hbhot')?'湖北星空家园票数排行':($area_arr[$area].$type_arr[$type]),//显示某某地区最新注册或人气排行
	"TOTAL" => $total,
	"PAGE" => $pagenav
	));


/**
*左边投稿排行列表
*/
/*
$db2 = new sql_db('localhost', 'root', '10y9c2U5', 'contributedb', false);
if($db2->db_connect_id)
{
$subjectType=11;//博客大赛的投稿器id
	$validTime = time() - intval(30 * 86400);//取最近30天
	$sql="SELECT blogName, blogLink, count(*) as count FROM subject where subjectType = ".$subjectType." and subjectTime > ".$validTime." group by blogName order by count desc limit 40";
	$result=$db2->sql_query($sql);
	while($row=$db2->sql_fetchrow($result))
	{
		$tpl->assign_block_vars("tgList",array(
			"BLOGNAME" => substr_cut($row['blogName'],10),
			"TITLE" => $row['blogName'],
			"BLOGLINK" => $row['blogLink'],
			"TOUGAO" => 'http://media.bokee.com/contribute/subject.php?subjectID=11',
			"COUNT" => $row['count']
			));
	}
	$db2->sql_close();
}
else
{
	$tpl->assign_block_vars("tgList",array(
		"BLOGNAME" => "无法连接投稿数据库",
		"BLOGLINK" => '#',
		"COUNT" => 0
		));
}
*/

/**
*左边票数排行列表
*/
$sql="SELECT * FROM mm_info order by allvote desc,id limit 75";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$i++;//显示排名
	$tpl->assign_block_vars("orderList",array(
		"I" => $i,
		"TITLE" => $row['blogname'],
		"BLOGNAME" => substr_cut($row['blogname'],10),
		"BLOGURL" => $row['blogurl'],
		"COMMENT" => 'comment.php?id='.$row['id']
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>