<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable.php");

include_once("left.php");//左边菜单
$mm_id=$_REQUEST['mm_id'];
$date=$_REQUEST['date'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '第二届美女博客大赛网络投票统计<span style="color:red">(如果在很短时间内有多次投票,则表示有可能作弊)</span>';
echo '<div>ID：<a href="../comment.php?id='.$mm_id.'" target="_blank">'.sprintf("%04d",$mm_id).'</a> 日期：';
echo '<select onchange="window.location=\'?mm_id='.$mm_id.'&date=\'+this.value">';
for($i=mktime(0,0,0,1,18,2007);$i<time();$i+=24*60*60)
{
	if($date==$i)
	{
		echo '<option value="'.$i.'" selected>'.date("Y-m-d",$i).'</option>';
	}
	else
	{
		echo '<option value="'.$i.'">'.date("Y-m-d",$i).'</option>';
	}
}
echo '</select>';
echo '</div>';
echo '<div><a href="ipvote_cheat.php?mm_id='.$mm_id.'&date='.$date.'">当日各IP的投票时间</a> 当日各IP段投票次数</div>';

$sql1="select substring_index(ip,'.',3) as ip,polltime,count(*) as count from ".$ip_table." where mm_id=".$mm_id." and polltime>=".$date." and polltime<".($date+24*60*60)." group by substring_index(ip,'.',3) ";
$result1=$db->sql_query($sql1);
$i=0;
while($row=$db->sql_fetchrow($result1))
{
	$ip=$row['ip'];
	$arr1[$ip][$i][0]=$row['polltime'];
	$arr1[$ip][$i][1]=$row['count'];
	$i++;
}
ksort($arr1);


while(list($key1,$val1)=each($arr1))
{
	echo '<div style="float:left;width:194px;margin-left:3px;margin-top:10px;border:1px solid #00f;text-align:left;padding:3px">';
	echo '<div>IP:<span style="color:red">'.$key1.'.*</span></div>';
	while(list($key2,$val2)=each($val1))
	{
		echo '<div><div style="float:right;color:blue">'.(($val2[1]<=30)?'<span style="color:#888">'.$val2[1].'</span>':$val2[1]).'</div><div style="float:left;">'.date("Y-m-d H:i:s",$val2[0]).':</div></div>';
	}
	echo '</div>';
//		break;
}

echo '</div>';

?>