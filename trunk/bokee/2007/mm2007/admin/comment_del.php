<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];
$mm_id=$_REQUEST['mm_id'];
if(!is_array($id))
{
	$sql="delete from mm_comment where id=".$id;
	$sql2="update mm_info set comm_count=comm_count-1 where id=".$mm_id;
}
else
{
	$sql="delete from mm_comment where id in (".implode(',',$id).")";
	$sql2="";//update mm_info set comm_count=comm_count-1 where id in (".implode(',',$mm_id).")";
}
if($db->sql_query($sql) && $db->sql_query($sql2))
{
	echo 'ok';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>