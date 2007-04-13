<?
define('IN_MATCH', true);
$root_path = "./../";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

//×îÐÂ×¢²áMM
$sql="select * from user_info order by id desc limit 3";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	echo '<p><img src="http://mm.bokee.com/xiu/mm2006/photo/'.$row["photo"].'" width="61" height="81"><br><a href="'.$row["blogurl"].'" target="_blank">'.substr_cut($row["blogname"],10).'</a></p>';
}
?>