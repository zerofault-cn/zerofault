<?php
include_once "session.php";
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$id=$_REQUEST['id'];
$count=$_REQUEST['count'];
$client_ip=GetIP();
$sql="select * from user_info where pass>0 and id=".$id;
if($db->sql_numrows($db->sql_query($sql))==0)
{
	echo "���û���δͨ�����!";
	exit;
}
if($_REQUEST['submit'])
{
	for($i=0;$i<$count;$i++)
	{
		$sql1="insert into ip_info set ip='".$client_ip."',user_id=".$id.",polltime=UNIX_TIMESTAMP()";
		$sql2="update user_info set vote=(vote+1),monthvote=(monthvote+1),weekvote=(weekvote+1) where id=".$id;
		if($db->sql_query($sql1) && $db->sql_query($sql2))
		{
			$j++;
		}
		else
		{
			
		}
	}
	echo '<script>alert("�ɹ�'.$j.'��");window.close();opener.location.reload();</script>';
	exit;
	
}
else
{
	?>
	<form>
	��<span style="color:blue"><?=$id?></span>��ѡ��һ�μ�<input type="text" name="count" size="3" value="100"/>Ʊ <input type="hidden" name="id" value="<?=$id?>" /><input name="submit" type="submit" value="�ύ">
	</form>
	<?
}
?>