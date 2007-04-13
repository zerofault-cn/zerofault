<?
include "../include/db_connect.php";
$item=explode('|',$_GET['checked_id']);
$sql1="update vote_item set count=count+1 where 0 ";
for($i=0;$i<count($item);$i++)
{
	$sql1.=' or id='.$item[$i]; 
}
echo $sql1;
if($db->sql_query($sql1))
{
	setcookie('voted_id',$subject_id,time()+3*30*24*3600);
	?>
	<script>
	//	window.location="adm/vote_view.php?subject_id=<?=$subject_id?>";
		window.location="menu_1.php";
	</script>
	<?
}
?>