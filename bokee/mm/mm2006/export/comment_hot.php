<?
define('IN_MATCH', true);
$root_path = "./../";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");
//����������
$time=time() - 86400*30;   //�����������
$sql="select * from user_info order by comm_count desc limit 6";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	echo '<li><a href="'.$row["blogurl"].'" target="_blank">'.substr_cut($row["blogname"],10).'</a></li>';
}
?>