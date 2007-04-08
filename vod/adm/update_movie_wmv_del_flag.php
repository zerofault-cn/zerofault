<?
if($goldsoft_admin!="zerofault")
{
	?>
	<script>
		alert("您无权操作");
		window.history.go(-1);
	</script>
	<?
}
else
{
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$sql1="select prog_id,prog_path from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and (prog_path like '%.wmv' or prog_path like '%.WMV') order by prog_id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$prog_id=$r[0];
	$prog_path=$r[1];
	$realpath = "/dpfs/".$prog_path;
	$prog_ip=getIpByPath($prog_path);
	$p_ip=substr(strrchr($prog_ip,"."),1);
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	if(($s_ip==87&&($p_ip==87||$p_ip==88||$p_ip==89)) || ($s_ip==88&&($p_ip==87||$p_ip==88||$p_ip==89)) || ($s_ip==89&&($p_ip==87||$p_ip==88||$p_ip==89)) ||	($s_ip==90&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip==91&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip==92&&($p_ip==90||$p_ip==91||$p_ip==92)) || ($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92) )
	{
		if(file_exists($realpath))
		{
			$del_flag=1;
		}
		else
		{
			$del_flag=-1;
		}
		$sql2="update prog_info set del_flag=".$del_flag." where prog_id=".$prog_id;
		echo($i.":".$prog_path.":");
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
			echo "<span style='color:red'>error</span><br>";
	}
	else
	{
		echo($i.":".$prog_path.":<span style='color:red'>无法判断!</span><br>");
	}
}
}
?>