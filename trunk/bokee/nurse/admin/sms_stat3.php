<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable2.php");

require_once($root_path."templates/admin/left.htm");//左边菜单

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>每月手机投票排行榜</div>';
echo '<div>手机投票25票(含)以上列表</div>';
$month=$_REQUEST['month'];
if(''==$month)
{
	$month=date("m");
}
echo '<div>时间：2007年';
echo '<select onchange="window.location=\'?month=\'+this.value">';
for($i=1;$i<=date("m");$i++)
{
	if($month==$i)
	{
		echo '<option value="'.$i.'" selected>'.$i.'</option>';
	}
	else
	{
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
}
echo '</select>';
echo '月';

$date_begin=mktime(0,0,0,$month,1,2007);//每月开始时间
$date_end=mktime(0,0,0,$month+1,1,2007)-1;//每月结束时间
$sql1="select feephone,addvote,user_id from ".$sms_table." where Service_code!='' and status=1 and polltime>=".$date_begin." and polltime<=".$date_end;
$result1=$db->sql_query($sql1);
echo '<div style="width:400px;margin-top:20px;border:1px solid #00f;">';

while($row=$db->sql_fetchrow($result1))
{
	$feephone=$row['feephone'];
	$addvote=$row['addvote'];
	$user_id=$row['user_id'];
	$arr1[$feephone]+=$addvote;
	$arr2[$feephone][]=$user_id;
}
arsort($arr1);
$i=1;
while(list($key,$val)=each($arr1))
{
	if($val>=25)
	{
		echo '<div style="border-bottom:1px dotted #aaa;padding:2px;">'.($i++).'<span style="margin-left:2em;color:blue;">'.$key.'</span><span style="margin-left:2em"><span style="color:red">'.$val.'</span> 票</span> (投票ID:';
		$arr22=array_unique($arr2[$key]);
		while(list($key3,$val3)=each($arr22))
		{
			echo '<a style="color:#'.$val3.'" href="../comment.php?id='.$val3.'" target="_blank">'.sprintf("%04d",$val3).'</a> ';
		}
		echo ')</div>';
	}
}
if($i==1)
{
	echo '暂无';
}
echo '</div>';

echo '</div>';

?>