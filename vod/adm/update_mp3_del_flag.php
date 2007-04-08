<?
if($goldsoft_admin!="zerofault")
{
	?>
	<script>
		alert("ÄúÎÞÈ¨²Ù×÷");
		window.history.go(-1);
	</script>
	<?
}
else
{
if(''==$server)
{
	$server='server14_4';
}
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$sql1="select id,path from song_info where path like '%".$server."%' order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$id=$r[0];
	$song_path=$r[1];
	$realpath = "/dpfs/".$song_path;
	if(file_exists($realpath))
	{
		$del_flag=1;
	}
	else
	{
		$del_flag=-1;
	}
	$sql2="update song_info set del_flag=".$del_flag." where id=".$id;
	echo($i.":".$song_path.":");
	if(mysql_query($sql2))
	{
		if($del_flag==1)
		{
			echo "<span style='color:blue'>1</span><br>";
		}
		else
		{
			echo "<span style='color:red'>-1</span><br>";
		}
	}
	else
	{
		echo "<span style='color:red'>error</span><br>";
	}
}
}
?>