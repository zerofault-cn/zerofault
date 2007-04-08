<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
echo $sql1="select * from singer_info_1 order by singer_name_fc,binary singer_name";
$result1=$db->sql_query($sql1);
while($r=$db->sql_fetchrow($result1))
{
	$sql2="insert into singer_info values('','".$r[1]."','".$r[2]."','".addslashes($r[3])."','".$r[4]."','".$r[5]."','".$r[6]."')";
	if($db->sql_query($sql2))
	{
		echo $i++;
		echo '<br>';
	}
}
?>