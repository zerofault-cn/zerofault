<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable2.php");

include_once("left.php");//左边菜单
$mm_id=$_REQUEST['mm_id'];
$date=$_REQUEST['date'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '第二届美女博客大赛短信投票统计';
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

$sql1="select feephone,polltime,addvote from ".$sms_table." where status=1 and mm_id=".$mm_id." and polltime>=".$date." and polltime<".($date+24*60*60);
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$phone=$row['feephone'];
	$arr1[$phone][]=$row['polltime'];
	$arr2[$phone][]=$row['addvote'];
	$allvote+=$row['addvote'];
}
//print_r($arr1);
//arsort($arr1);
echo '<div>今日得票:'.$allvote.'</div>';
while(sizeof($arr1)>0 && list($key,$val)=each($arr1))
{
	for($i=0;$i<sizeof($val);$i++)
	{
		echo '<div style="float:left;width:190px;margin-left:4px;margin-top:10px;border:1px solid #00f;text-align:left;padding:4px 6px;">';
		echo '<div>手机号:<span style="color:red">'.$key.'</span></div>';
		while(list($key2,$val2)=each($val))
		{
			echo '<div><div style="float:right">'.date("Y-m-d H:i:s",$val2).' <span style="color:blue">'.$arr2[$key][$key2].'</span></div><div style="float:left;">'.($key2+1).':</div></div>';
		}
		echo '</div>';
		break;
	}
	
}

echo '</div>';

?>