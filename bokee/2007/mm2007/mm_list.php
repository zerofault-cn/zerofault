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
	1 => '�в�����',
	2 => '�ϲ�����',
	3 => '��������',);
$type_arr = array(
	"new" => '���±�����',
	"hot" => 'Ʊ�����У�');
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
if($limit<=8)//�ṩ��CMS���õĲ����û��б�
{
	$tpl->set_filenames(array(
			'body' => 'mm_list.htm'));
}
else//�����������û��б�
{
	$tpl->set_filenames(array(
			'body' => 'mm_list2.htm'));
}
if($type=='new')//������˳��
{
	$sql="select * from mm_info where pass=1 and area=".$area." order by id desc";
}
elseif($type=='hot')//��Ʊ��˳��
{
	$sql="select * from mm_info where pass=1 and area=".$area." order by allvote desc,id desc";
}
elseif($type=='hbhot')//�����û�Ʊ������
{
	$sql="select * from mm_info where pass=1 and blogurl like '%home.hb.vnet.cn%' order by allvote desc,id desc";
}
$pageitem=$limit;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?area=".$area."&type=".$type."&limit=".$limit);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$order=($page-1)*$pageitem;//������������
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
		"ORDER" =>'',// ($type=='hot')?('������������'.$order.'��'):'',
		"INFO" => '����ʱ�䣺'.date("y/m/d",$row['addtime']),
		"BOBOIMG" => $boboimg,
		"BOBOIMGALT" => (1==$bobo_flag)?'������Ƶ':'�ϴ���Ƶ',
		"BOBOLINK" => (1==$bobo_flag)?$viewurl:$uploadurl,
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"AREA" => $area,
	"TITLE" => ($type=='hbhot')?'�����ǿռ�԰Ʊ������':($area_arr[$area].$type_arr[$type]),//��ʾĳĳ��������ע�����������
	"TOTAL" => $total,
	"PAGE" => $pagenav
	));


/**
*���Ͷ�������б�
*/
/*
$db2 = new sql_db('localhost', 'root', '10y9c2U5', 'contributedb', false);
if($db2->db_connect_id)
{
$subjectType=11;//���ʹ�����Ͷ����id
	$validTime = time() - intval(30 * 86400);//ȡ���30��
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
		"BLOGNAME" => "�޷�����Ͷ�����ݿ�",
		"BLOGLINK" => '#',
		"COUNT" => 0
		));
}
*/

/**
*���Ʊ�������б�
*/
$sql="SELECT * FROM mm_info order by allvote desc,id limit 75";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$i++;//��ʾ����
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