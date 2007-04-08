<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];
$markall=$_REQUEST['markall'];

if(!is_array($id))
{
	$sql="update mm_comment set mark=(NOT mark) where id=".$id;
}
else
{
	$sql="update mm_comment set mark=".$markall." where id in (".implode(',',$id).")";
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