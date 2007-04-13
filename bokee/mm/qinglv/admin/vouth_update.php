<?
include "session.php";
define('IN_MATCH', true);

$root_path = "./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];

if($id>0)
{
	$sql="update user_info set vouth=1,vouth_time=UNIX_TIMESTAMP() where id=".$id;
}
if(''!=$sql && $db->sql_query($sql))
{
	echo 'ok';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>