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
}
else
{
	$sql="update user_info set pass=(pass+1) where id in (".implode(',',$id).")";
}
if($db->sql_query($sql))
{
	echo 'ok';
	echo '<script>parent.location.reload()</script>';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>