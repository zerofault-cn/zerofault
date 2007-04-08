<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
/*
for($i=0;$i<sizeof($dentry_id_r);$i++)
{
	echo $dentry_id_r[$i];
	for($j=0;$j<sizeof($admin_id_r);$j++)
	{
		if($limitflag[$i][$j])
		{
			echo '|1';
		}
		else
		{
			echo '|0';
		}
	}
	echo '<br>';
}
echo '<br>';
*/


for($i=0;$i<sizeof($dentry_id_r);$i++)
{
	for($j=0;$j<sizeof($admin_id_r);$j++)
	{
		if($limitflag[$i][$j])
		{
			$flag=1;
		}
		else
		{
			$flag=0;
		}
		$sql1="select adprio_id from admin_priority where admin_id='".$admin_id_r[$j]."' and limittype='".$dentry_id_r[$i]."'";
		$result1=mysql_query($sql1);
		if($r1=mysql_fetch_array($result1))
		{
			$adprio_id=$r1[0];
			$sql2="update admin_priority set limitflag='".$flag."',operator='".$_COOKIE['goldsoft_admin']."',operdate=CURDATE(),opertime=CURTIME() where adprio_id='".$adprio_id."'";
			$r=mysql_query($sql2);
		}
		else
		{
			$sql2="insert into admin_priority(admin_id,limittype,limitflag,operator,operdate,opertime) values('".$admin_id_r[$j]."','".$dentry_id_r[$i]."','".$flag."','".$_COOKIE['goldsoft_admin']."',CURDATE(),CURTIME())";
			$r=mysql_query($sql2);
		}
	}
}
if($r)
{
	?>
	<script>
		alert("修改成功！")
		window.location="index.php?content=admin_update_limit_1";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试,或者报告管理员");
		window.history.go(-1);
	</script>
	<?
}
?>