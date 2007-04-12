<?
//include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");

include_once("left.php");//左边菜单

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '每月鲜花排行榜上榜名单';
echo '<br /><br />';

$sql="select * from month_vote order by id";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$sdate=$row['date'];
	$user_id=$row['user_id'];
	$vote=$row['vote'];
	$month_arr[$sdate][$i][0]=$user_id;
	$month_arr[$sdate][$i][1]=$vote;
	$i++;
}
while(list($key,$val)=each($month_arr))
{
	echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
	echo '统计月份：'.substr($key,0,7);
	while(list($key1,$val1)=each($val))
	{
		echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;"><span style="width:'.($val1[1]/40).'px;background-color:#00f;margin:2px;"> </span>'.$val1[1].' 朵</span><span style="width:60px;float:left;text-align:right;padding:2px;"><a href="../comment.php?id='.$val1[0].'" target="_blank">'.sprintf("%04d",$val1[0]).'</a>：</span></div>';
	}
	echo '</div>';
}
echo '</div>';


?>