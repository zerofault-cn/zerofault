<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");


$id = $_REQUEST['id'];
$passall=$_REQUEST['passall'];

if(!is_array($id))
{
	$sql="update mm_info set pass=1 where id=".$id;
	$email_arr[]=getField($id,'email');
}
else
{
	$sql="update mm_info set pass=1 where id in (".implode(',',$id).")";
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
		echo mailto($email_arr[$i],'您报名参加第二届美女博客大赛已经通过审核!','',is_array($id)?$id[$i]:$id);
	}
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>