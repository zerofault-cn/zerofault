<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable2.php");

include_once("left.php");//左边菜单
$area_arr = array('','中部赛区','南部赛区','北部赛区');
$date=$_REQUEST['date'];
$cheat=$_REQUEST['cheat'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
if(''==$cheat)
{
	$cheat=0;
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>第二届美女博客大赛选手赛区排名</div>';
echo '<div>';
echo '请选择日期:';
echo '<select onchange="window.location=\'?cheat='.$cheat.'&date=\'+this.value">';
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
echo '<div>当日各赛区前20名用户列表:</div>';
echo '<div><a href="?cheat=0&date='.$date.'">不包含作弊数据</a> <a href="?cheat=1&date='.$date.'">包含作弊数据</a></div>';

$sql1="select mm_id,addvote from ".$sms_table." where status=1 and polltime<".($date+24*60*60);
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$arr1[intval($row['mm_id'])]+=$row['addvote'];
}
if(!$cheat)//cheat为0，未作弊的
{
	$sql_ext=' del_flag=0 and ';
}
$sql2="select mm_id,count(*) as count from ".$ip_table." where ".$sql_ext."polltime<".($date+24*60*60)." group by mm_id order by count desc";
$result2=$db->sql_query($sql2);
while($row=$db->sql_fetchrow($result2))
{
	$mm_id=$row['mm_id'];
	$count=$row['count'];
	$arr2[$mm_id]=$count;//用数组保存以供计算总票数
}

$sql3="select max(id) from mm_info where pass=1";
$result3=$db->sql_query($sql3);
$max_id=$db->sql_fetchfield(0,0,$result3);
for($i=0;$i<$max_id;$i++)
{
	$arr3[$i]=30*$arr1[$i]+$arr2[$i];
}
arsort($arr3);
$i=0;
while($i<100 && list($key,$val)=each($arr3))
{
	$i++;
	$area=getField($key,'area');
	$arr4[$area]['id'][]=$key;
	$arr4[$area]['realname'][]=getField($key,'realname');
	$arr4[$area]['vote'][]=$val;
}
for($i=1;$i<4;$i++)
{
	echo '<div style="float:left;width:250px;border:1px solid #00f;text-align:left;margin:4px 6px;">';
	echo $area_arr[$i].'：';

	for($j=0;$j<20;$j++)
	{
		echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:70px;float:right;text-align:left;">'.$arr4[$i]['vote'][$j].' 票</span><span style="width:24px;float:left;padding-left:2px;">'.($j+1).':</span><span style="width:152px;float:left;padding-left:2px;"><a href="../comment.php?id='.$arr4[$i]['id'][$j].'" target="_blank">'.sprintf("%04d",$arr4[$i]['id'][$j]).'</a>['.$arr4[$i]['realname'][$j].']</span></div>';
	}
	echo '</div>';
}

echo '</div>';

?>