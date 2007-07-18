<?
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];
$user_id=intval($_REQUEST['user_id']);
$sql="delete from comment where id=".$id;
$sql2="update user_info set comm_count=comm_count-1 where id=".$user_id;

if(checkLogin(getField($user_id,'blogurl')) && $db->sql_query($sql) && $db->sql_query($sql2))
{
	echo '<script>parent.location.reload();</script>';
}
else
{
	echo 'err:'.$sql;
	echo '<br>'.$sql2;
}

$db->sql_close();

?>