<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$sid=$_REQUEST['sid'];
$pageitem=$_REQUEST['pageitem'];
if(''==$pageitem || 0==$pageitem)
{
	$pageitem=4;
}
if(''!=$_REQUEST['submit1'])
{
	$content=trim(conv($_REQUEST['content']));
	$username=trim(conv($_REQUEST['username']));
	$ip=GetIP();
	$sql="insert into comment set sid='".$sid."',username='".$username."',content='".format($content)."',addtime=UNIX_TIMESTAMP(),ip='".$ip."'";
	if($db->sql_query($sql))
	{
		echo "<script>parent.alertOK();</script>";
	}
	else
	{
		echo $sql;
	}
}
elseif(''!=$_REQUEST['sid'])
{
	$sql="select * from comment where sid='".$sid."' and content!='' order by id desc limit ".$pageitem;
	$result=$db->sql_query($sql);
	$i=0;
	while($row=$db->sql_fetchrow($result))
	{
		
		$i++;
		$username=$row['username'];
		if(''==$username)
		{
			$username='匿名';
		}
		$content=$row['content'];
		$addtime=date("Y-m-d H:i",$row['addtime']);
		$ip=$row['ip'];
		$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
		if($sid=='2008')
		{
			$content=substr_cut(str_replace('<br />',' ',str_replace("\r\n","",$content)),60);
			echo '<div class="mess"><div class="lt"><img width="40" height="40" src="/cmncmt/getBlogPhoto.php?sid='.$sid.'&username='.$username.'" /></div><div class="messtext"><div><strong>'.((''==$userPhoto)?$username:'<a href="http://'.$username.'.bokee.com/" target="_blank">'.$username.'</a>').'</strong>: ('.$addtime.')</div><div>'.$content.'</div></div><div class="clear"></div></div>';
		}
		elseif($sid=='ent_comic')
		{
			$content=substr_cut(str_replace('<br />',' ',str_replace("\r\n","",$content)),180);//过滤换行
			echo '<li class="liulibg">'.$content.'</li>';
			echo '<li>留言人：'.$username.' 留言时间：'.$addtime.'</li>';
		}
	}
}
else
{
	$blogID=getBlogID();
	if(''!=$blogID)
	{
		echo "document.commentForm.username.value='".$blogID."';\n";
	}
}
$db->sql_close();
?>

