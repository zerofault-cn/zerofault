<?
define('IN_MATCH', true);
$save=$_REQUEST['save'];
$area=$_REQUEST['area'];
$area_arr=array('','中部','南部','北部');

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");


if($save)
{
	header("Content-type:application/vnd.ms-excel"); 
	header("Content-Disposition:filename=第二届美女博客大赛".$area_arr[$area]."赛区用户手机号.xls"); 

$sql="select * from mm_info where pass=1 and area=".$area." order by id";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$id=$row["id"];
	$realname=$row['realname'];
	$telenum=$row['telenum'];
	echo sprintf("%04d",$id)."\t".$realname."\t".$telenum."\t\n";
}

}
else
{
	echo '<a href="?save=1&area=1">中部赛区用户手机号</a><br>';
	echo '<a href="?save=1&area=2">南部赛区用户手机号</a><br>';
	echo '<a href="?save=1&area=3">北部赛区用户手机号</a><br>';
}
$db->sql_close();
?>