<?php
define('IN_MATCH', true);
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");
//查询手机号当月的投票票数
$phone=$_REQUEST['phone'];
$sql="select addvote from ".$sms_table." where status=1 and feephone=".$phone." and polltime>=".mktime(0,0,0,date("m"),1,date("Y"));
$result=$db->sql_query($sql);
$addvote=0;
while($row=$db->sql_fetchrow($result))
{
	$addvote+=$row['addvote'];
}
echo "<script>parent.showInfo(".$addvote.");</script>";
$db->sql_close();
?>
