<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");

$area=$_GET['area'];
$limit=$_GET['limit'];
if(''==$area)
{
	$area=1;
}
if(''==$limit)
{
	$limit=4;
}
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'mm_hot.htm')
		);
$sql="select * from mm_info where area=".$area." and pass=1 order by allvote desc,id desc limit 0,".$limit;
$i=0;
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$i++;
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
		"ID"		=> sprintf("%04d",$id),
		"BLOGURL"	=> $blogurl,
		"TITLE"		=> $row['blogname'],
		"BLOGNAME"	=> substr_cut($row["blogname"],14),
		"PHOTO"		=> "photo/".$area.'/'.$row["photo"],
		"POLL"		=> "poll.php?type=net&id=".$id,
		"COMMENT"	=> "comment.php?id=".$id,
		"SMSPOLL"	=> "poll.php?type=sms&area=".$area."&id=".$id,
		"SMSPOLLWIDTH" => ($area==1)?'630':'630',
		"SMSPOLLHEIGHT" => ($area==1)?'530':'322',
		"VOTES" 	=> "votes.php?id=".$id,
		"ORDER"		=> '',//'赛区排名：第'.$i.'名',
		"INFO"		=> '报名时间：'.date("m-d",$row['addtime']),
		"BOBOIMG" => $boboimg,
		"BOBOIMGALT" => (1==$bobo_flag)?'欣赏视频':'上传视频',
		"BOBOLINK" => (1==$bobo_flag)?$viewurl:$uploadurl
		));
}
$db->sql_close();
$tpl->assign_vars(array("AREA" => $area));
$tpl->pparse('body');
$tpl->destroy();
?>
