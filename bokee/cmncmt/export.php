<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$sid=$_REQUEST['sid'];
if(''==$sid)
{
	$sid='1';
}
$pageitem=$_REQUEST['pageitem'];
if(''==$pageitem)
{
	$pageitem=10;
}
if(''==$encode)
{
	$encode='utf-8';
}
if($_REQUEST['submit'])
{
	$content=conv($_REQUEST['content']);
	$username=conv($_REQUEST['username']);
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
	$sql="select * from comment where sid='".$sid."' order by id desc limit ".$pageitem;
	$result=$db->sql_query($sql);
	$i=0;
	while($row=$db->sql_fetchrow($result))
	{
		
		$i++;
		$username=$row['username'];
		if(''==$username)
		{
			$username='ÄäÃû';
		}
		$content=substr_cut(str_replace('<br />',' ',str_replace("\r\n","",$row['content'])),60);
		if(''==trim($content))
		{
			continue;
		}
		$addtime=date("Y-m-d H:i",$row['addtime']);
		$ip=$row['ip'];
		$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
		if($username!='ÄäÃû')
		{
			$userPhoto=getBlogPhoto($username);
		}
		else
		{
			$userPhoto='';
		}
		if($sid=='2008'||$sid=='ent_comic')
		{
			echo '<div class="mess"><div class="lt"><img width="40" height="40" src="'.((''==$userPhoto)?"http://images.bokee.com/2008/cphoto/2007-04-06/2O5Vx0asWK0a9tKz.gif":$userPhoto).'" /></div><div class="messtext"><div><strong>'.((''==$userPhoto)?$username:'<a href="http://'.$username.'.bokee.com/" target="_blank">'.$username.'</a>').'</strong>: ('.$addtime.')</div><div>'.$content.'</div></div><div class="clear"></div></div>';
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

