<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."profile.inc.php");
$limit=$_REQUEST['limit'];
$type=$_REQUEST['type'];
if(''==$limit)
{
	$limit=20;
}
if($type=='vote' ||$type=='comm')//mm首页右上角调用
{
	if($type=='vote')//每天投票排行
	{
		$sql="select user_id,count(id) as count from ip_info where polltime>(UNIX_TIMESTAMP()-86400) group by user_id order by count desc limit 6";
	}
	else//每月留言排行
	{
		$sql="select user_id,count(id) as count from comment where addtime>(UNIX_TIMESTAMP()-30*86400) group by user_id order by count desc limit 6";
	}
	$result=$db->sql_query($sql);
	$i=0;
	while($row=$db->sql_fetchrow($result))
	{
		$i++;
		$id=$row['user_id'];
		$blogname0=getField($id,'blogname');
		$blogname=substr_cut($blogname0,10);
		$blogurl=getField($id,'blogurl');
		echo '<li><a href="friend/mm_friend/info.php?id='.$id.'" target="_blank" title="'.$blogname0.'">'.$blogname.'</a></li>';
	}
}
else
{
	$sql="select user_id,count(id) as count from ip_info where polltime>".(mktime(0,0,0,date("m"),date("d"),date("Y"))-86400)." and polltime<".mktime(0,0,0,date("m"),date("d"),date("Y"))." group by user_id order by count desc,id desc limit ".$limit;
	$result=$db->sql_query($sql);
	$i=0;
	while($row=$db->sql_fetchrow($result))
	{
		$i++;
		$id=$row['user_id'];
		$count=$row['count'];
		$user_info_arr=getUserInfo($id);
		$blogname0=$user_info_arr['blogname'];
		$blogname1=substr_cut($user_info_arr['blogname'],16);
		$blogname2=substr_cut($user_info_arr['blogname'],14);
		$blogurl=$user_info_arr['blogurl'];
		$photo=$user_info_arr['photo'];
		$info=str_replace('-','',$user_info_arr['location']).' '.('0000-00-00'==$user_info_arr['birthday']?'':((date("Y")-substr($user_info_arr['birthday'],0,4)).'岁'));
		$sex=$sex_arr[$user_info_arr['sex']];
		$birthday=$user_info_arr['birthday'];
		$age=date("Y")-substr($birthday,0,4);
		if($age==date("Y"))
		{
			$age=99;
		}
		if($limit==20)//friend首页20个魅力排行
		{
			echo '<li class="t'.sprintf("%02d",$i).'"><span class="xbie"><a href="mm_friend/info.php?id='.$id.'" title="'.$blogname0.'">'.$blogname1.'</a></span> '.$sex.' <a href="javascript:void(0)" onclick="window.open(\'mm_friend/poll.php?id={list.ID}\');" target="_self"> <img src="images/flower.gif" width="18" align="absmiddle"/> '.$count.'</a></li>';
		}
		elseif($limit==7)//mm首页7张照片
		{
			echo '<div class="cont"><a href="friend/mm_friend/info.php?id='.$id.'" target="_blank"><img src="friend/mm_friend/photo/'.$photo.'" alt="'.$blogname0.'" width="94" height="118"/></a><br /><a href="friend/mm_friend/info.php?id='.$id.'" target="_blank" title="'.$blogname0.'">'.$blogname2.'</a><br />'.$info.'</div>';
		}
	}
}
?>
