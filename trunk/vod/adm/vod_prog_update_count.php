<?
include_once "../include/mysql_connect.php";
$sql1="select count(*),prog_path from fee_info group by prog_path";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$count		=$r[0];
	$prog_path	=$r[1];
	$sql2="update prog_info set count=count+".($count/2)." where prog_path='".$prog_path."'";
	echo $prog_path.":".$count;
	if(mysql_query($sql2))
		echo "<span style='color:blue'>ok</span><br>";
	else
		echo "<span style='color:red'>error</span><br>";
}
?>
