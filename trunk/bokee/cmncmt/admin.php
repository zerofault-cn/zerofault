<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
$sid=$_REQUEST['sid'];
if(''==$sid)
{
	$sid='1';
}
if($_REQUEST['del'])
{
	$id=$_REQUEST['id'];
	$sql="delete from comment where id=".$id;
	if($db->sql_query($sql))
	{
		echo '<script>parent.location.reload();</script>';
		exit;
	}
	else
	{
		echo $sql;
		exit;
	}
}
$pageitem=15;
$sql="select * from comment where sid='".$sid."' order by id desc ";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?sid=".$sid);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
echo '<body top-margin=0 left-margin=0 align=center>';
echo '<table width="90%" border=1>';
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$username=$row['username'];
	$content=$row['content'];
	$addtime=date("Y-m-d H:i",$row['addtime']);
	echo '<tr><td>'.$username.'</td><td>'.$content.'</td><td nowrap>'.$addtime.'</td><td nowrap><a href="?sid='.$sid.'&del=1&id='.$id.'" target="iframe1">É¾³ý</a></td></tr>';
}
echo '</table>';
echo $pagenav;
echo '<iframe name="iframe1" id="iframe1" src="" width="0" height="0" border="0" frameborder="0" framespacing="0" scrolling="no"></iframe>';
echo '</body>';
$db->sql_close();
?>
