<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");
include_once($root_path."dbtable2.php");

require_once($root_path."templates/admin/left.htm");//左边菜单
$date=$_REQUEST['date'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>感动社会十大优秀护士评选活动选手赛区排名</div>';
echo '<div>';
echo '请选择日期:';
echo '<select onchange="window.location=\'?date=\'+this.value">';
for($i=mktime(0,0,0,7,11,2007);$i<time();$i+=24*60*60)
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
echo '<div>当日各赛区前10名用户列表:</div>';

$sql1="select user_id,addvote from ".$sms_table." where status=1 and polltime<".($date+24*60*60);
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$arr1[intval($row['user_id'])]+=$row['addvote'];
}
echo '<pre>';
//print_r($arr1);
echo '</pre>';
$sql3="select max(id) from user_info where pass>0";
$result3=$db->sql_query($sql3);
$max_id=$db->sql_fetchfield(0,0,$result3);

for($i=1;$i<=$max_id;$i++)
{
	$arr3[$i]=intval($arr1[$i]);
}
while($i<80 && list($key,$val)=each($arr3))
{
	$area=getField($key,'area');
	if(''==$area)
	{
		continue;
	}
	$arr4[$area]['id'][]=$key;
	$arr4[$area]['realname'][]=getField($key,'realname');
	$arr4[$area]['vote'][]=$val;
}
for($i=1;$i<sizeof($area_arr);$i++)
{
	echo '<div style="float:left;width:250px;border:1px solid #00f;text-align:left;margin:4px 6px;">';
	echo $area_arr[$i].'：';

	for($j=0;$j<10;$j++)
	{
		echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:70px;float:right;text-align:left;">'.$arr4[$i]['vote'][$j].' 票</span><span style="width:24px;float:left;padding-left:2px;">'.($j+1).':</span><span style="width:152px;float:left;padding-left:2px;"><a href="../comment.php?id='.$arr4[$i]['id'][$j].'" target="_blank">'.sprintf("%04d",$arr4[$i]['id'][$j]).'</a>['.$arr4[$i]['realname'][$j].']</span></div>';
	}
	echo '</div>';
}

echo '</div>';

?>