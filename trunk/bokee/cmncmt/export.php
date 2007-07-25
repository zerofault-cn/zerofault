<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

$sid=$_REQUEST['sid'];
$getall=$_REQUEST['getall'];
if(''==$getall)
{
	$getall=0;
}
$page=$_REQUEST["page"];
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
		echo $sql;
		echo "<script>parent.alertOK();</script>";
	}
	else
	{
		echo $sql;
	}
}
elseif(''!=$_REQUEST['sid'])
{
	$sql="select * from comment where sid='".$sid."' and content!='' order by id desc";
	$result=$db->sql_query($sql);
	$total=$db->sql_numrows($result);
	pageft($total,$pageitem);
	$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
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
		$addtime=date("Y-m-d H:i:s",$row['addtime']);
		$ip=$row['ip'];
		$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
		if($sid=='2008')
		{
			if(!$getall)
			{
				$content=substr_cut(str_replace('<br />',' ',str_replace("\r\n","",$content)),60);
			}
			echo '<div class="mess"><div class="lt"><img width="40" height="40" src="/cmncmt/getBlogPhoto.php?sid='.$sid.'&username='.$username.'" /></div><div class="messtext"><div><strong>'.$username.'</strong>: ('.$addtime.')</div><div>'.$content.'</div></div><div class="clear"></div></div>';
		}
		elseif($sid=='ent_comic')
		{
			$content=substr_cut(str_replace('<br />',' ',str_replace("\r\n","",$content)),180);//过滤换行
			echo '<li class="liulibg">'.$content.'</li>';
			echo '<li>留言人：'.$username.' 留言时间：'.$addtime.'</li>';
		}
		elseif($sid=='techToutiao')
		{
			echo '<div style="background-color:#e3e3e3;border:1px solid #ddd">'.$addtime.'&nbsp;&nbsp;'.$username.' IP:'.$ip1.'</div>';
			echo '<div style="border:1px solid #ddd;border-top:0;">'.$content.'</div>';
		}
		elseif($sid=='nurse')
		{
			echo '<li>留言人：'.$username.' 时间：'.$addtime.'<br /><strong>'.$content.'</strong>';
		}
		else//if(substr($sid,0,4)=='mmzk')//mm周刊
		{
			echo '<div class="label" style="padding-top:3px;border-left:3px solid #CC0000;background-color:#BEBEBE">留言人：'.$username.' 留言时间：'.$addtime.'</div>';
			echo '<div class="content" style="padding-top:5px;padding-bottom:7px;line-height:140%;">'.$content.'</div>';
		}
		if(0==$getall && $i>=$pageitem)
		{
			break;
		}
	}
	if($getall)
	{
		echo '<div style="text-align:center;margin:10px 0">'.$pagenav.'</div>';
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

