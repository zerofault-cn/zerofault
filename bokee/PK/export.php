<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

$sid=$_REQUEST['sid'];
$field=$_REQUEST['field'];
$getall=$_REQUEST['getall'];
if(''==$getall)
{
	$getall=0;
}
$pageitem=$_REQUEST['pageitem'];
if(''==$pageitem)
{
	$pageitem=10;
}
if($_REQUEST['submit1'])
{
	$username=conv($_REQUEST['username']);
	$title=conv($_REQUEST['title']);
	$content=conv($_REQUEST['content']);
	$side=conv($_REQUEST['side']);
	$ip=GetIP();
	if($side==1)
	{
		$field='l_comment';
		$field2='l_comm';
	}
	elseif($side==-1)
	{
		$field='r_comment';
		$field2='r_comm';
	}
	elseif($side==0)
	{
		$field='c_comment';
		$field2='c_comm';
	}
	if(''==$title && ''==$content)
	{
		echo "<script>parent.getData('".$field."');parent.getData('".$field2."');</script>";
		exit;
	}
	$sql1="insert into comment set sid='".$sid."',side=".$side.",username='".$username."',content='".format($content)."',addtime=UNIX_TIMESTAMP(),ip='".$ip."'";
	$sql2="update subject set ".$field2."=".$field2."+1 where id=".$sid;
	if($db->sql_query($sql1) && $db->sql_query($sql2))
	{
		echo "<script>parent.clearForm();parent.getData('".$field."');parent.getData('".$field2."');</script>";
	}
	else
	{
		echo $sql;
	}
}
elseif(''!=$sid)
{
	switch($field) {
	case 'l_vote':
	case 'r_vote':
	case 'l_comm':
	case 'r_comm':
	case 'c_comm':
		$sql="select ".$field." from subject where id='".$sid."'";
		$result=$db->sql_query($sql);
		echo $db->sql_fetchfield(0,0,$result);
		break;
	case 'l_comment':
	case 'r_comment':
	case 'c_comment':
		$side_arr=array('l_comment'=>1,'r_comment'=>-1,'c_comment'=>0);
		$sql="select * from comment where sid='".$sid."' and side=".$side_arr[$field]." and content!='' order by id desc";
		$result=$db->sql_query($sql);
		$total=$db->sql_numrows($result);
		pageft($total,$pageitem,$field);
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
			$title=$row['title'];
			$content=str_replace("\r\n","",$row['content']);
			if(''!=$title)
			{
				$content=$title.'<br />&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if(''==trim($content))
			{
				continue;
			}
			$addtime=date("Y-m-d H:i",$row['addtime']);
			$ip=$row['ip'];
			$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
			echo '
			<div class="pkrleftext">
				<div class="pkrliutit">
					<span class="lt"><span style="color:red">'.($total-$i-$offset+1).'</span>楼：'.$username.'</span>
					<span class="rt">发表时间:'.$addtime.'</span>
					<div class="clear"></div>
				</div>
				<div class="pkliuwen">'.$content.'</div>
			</div>
			';
			if(0==$getall && $i>=$pageitem)
			{
				break;
			}
		}
		if($getall)
		{
			echo '<div class="pkrliutit" style="padding-right:0px;text-align:center;">'.$pagenav.'</div>';
		}
		break;
	}
}
else
{
	$blogID=getBlogID();
	if(''!=$blogID)
	{
		echo "document.pkForm_l.username.value='".$blogID."';\n";
		echo "document.pkForm_r.username.value='".$blogID."';\n";
		echo "document.pkForm_c.username.value='".$blogID."';\n";
	}
}
$db->sql_close();
?>

