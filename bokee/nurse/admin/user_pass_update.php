<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");


$id = $_REQUEST['id'];

if(!is_array($id))
{
	$sql="update user_info set pass=(pass+1) where id=".$id;
	$email_arr[]=getField($id,'email');
}
else
{
	$sql="update user_info set pass=(pass+1) where id in (".implode(',',$id).")";
	for($i=0;$i<sizeof($id);$i++)
	{
		$email_arr[]=getField($id[$i],'email');
	}
}
if($db->sql_query($sql))
{
	echo 'ok';
	for($i=0;$i<sizeof($email_arr);$i++)
	{
		echo mailto($email_arr[$i],'您报名参加感动社会十大优秀护士评选活动已经通过审核!','',is_array($id)?sprintf("%05d",$id[$i]):sprintf("%05d",$id));
	}
	echo '<script>parent.location.reload()</script>';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>