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
	$email_arr[]=getField($id,'email');
}
else
{
	for($i=0;$i<sizeof($id);$i++)
	{
		$email_arr[]=getField($id[$i],'email');
	}
}
//for($i=0;$i<sizeof($email_arr);$i++)
{
	echo '('.$i.')'.$email_arr[$i].':'.mailto($email_arr[$i],'您报名参加第二届美女博客大赛已经通过审核!','',is_array($id)?$id[$i]:$id);
//	echo mailto($email_arr,'您报名参加第二届美女博客大赛已经通过审核!','','0');
	echo '<br />';
}

?>