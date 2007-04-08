<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");


$ip=$_REQUEST["ip"];//Ò³Âë
$date=$_REQUEST['date'];
$del_flag=$_REQUEST['del_flag'];
if(''==$del_flag)
{
	echo 'no del_flag';
	exit;
}
if(''==$date)
{
	echo 'no date';
	exit;
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}

$sql1="update ".$ip_table." set del_flag=".$del_flag." where ip='".$ip."' and polltime>".$date." and polltime<".($date+24*60*60);
if($db->sql_query($sql1))
{
	echo 'ok';
}
else
{
	echo 'err:'.$sql1;
}

?>