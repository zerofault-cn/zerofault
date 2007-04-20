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

$Service_arr=array("9951" =>'联通',"10665110" =>'移动');
$area_arr = array('','中部','南部','北部');

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '第二届美女博客大赛海选投票统计';

$sql1="select Service_code,addvote,count(*) as count from poll_sms1 where status=1 and Service_code!='' group by Service_code,addvote";
$result1=$db->sql_query($sql1);
echo '<div style="width:580px;">';
echo '<div style="width:280px;margin-top:20px;border:1px solid #00f;float:left;text-align:left;padding-top:4px;">';
echo ' 按运营商分:';
while($row=$db->sql_fetchrow($result1))
{
	$Service_code=$row['Service_code'];
	$addvote=$row['addvote'];
	$count=$row['count'];
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:180px;float:right;text-align:left;padding:4px;">'.$addvote.'×'.$count.'='.($addvote*$count).' 票</span><span style="width:80px;float:left;text-align:right;padding:4px;">'.$Service_arr[$Service_code].':</span></div>';
	$total+=$addvote*$count;
}
echo '</div>';

$sql2="select mm_info_0418.area as area,poll_sms1.addvote,count(*) as count from poll_sms1,mm_info_0418 where poll_sms1.status=1 and poll_sms1.Service_code!='' and poll_sms1.mm_id=mm_info_0418.id group by mm_info_0418.area,poll_sms1.addvote";
$result2=$db->sql_query($sql2);
echo '<div style="width:280px;margin-top:20px;border:1px solid #00f;float:right;text-align:left;padding-top:4px;">';
echo ' 按赛区分:';
while($row=$db->sql_fetchrow($result2))
{
	$area=$row['area'];
	$addvote=$row['addvote'];
	$count=$row['count'];
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:180px;float:right;text-align:left;padding:4px;">'.$addvote.'×'.$count.'='.($addvote*$count).' 票</span><span style="width:80px;float:left;text-align:right;padding:4px;">'.$area_arr[$area].':</span></div>';
}
echo '</div>';
echo '</div>';
echo '<div style="width:580px;margin-top:4px;border:1px solid #00f;">';
echo '<span style="width:380px;float:right;text-align:left;padding:4px;">'.$total.' 票</span><span style="width:110px;float:left;text-align:right;padding:4px;">总计：</span>';
echo '</div>';

$sql3="select * from mm_info_0418 where (hbun_vote!=0 or hbte_vote!=0 or hbivr_vote!=0)";
$result3=$db->sql_query($sql3);
$hbun_vote=0;
$hbte_vote=0;
$hbivr_vote=0;
while($row=$db->sql_fetchrow($result3))
{
	$hbun_vote+=$row['hbun_vote'];
	$hbte_vote+=$row['hbte_vote'];
	$hbivr_vote+=$row['hbivr_vote'];
}
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '湖北星空家园用户专有:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbun_vote.' 票</span><span style="width:120px;float:left;text-align:right;padding:4px;">湖北联通：</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbte_vote.' 票</span><span style="width:120px;float:left;text-align:right;padding:4px;">湖北小灵通：</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbivr_vote.' 票</span><span style="width:120px;float:left;text-align:right;padding:4px;">湖北IVR：</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.($hbun_vote+$hbte_vote+$hbivr_vote).' 票</span><span style="width:120px;float:left;text-align:right;padding:4px;">总计：</span></div>';
echo '</div>';

echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;">';
echo '<span style="width:380px;float:right;text-align:left;padding:4px;">'.($total+$hbun_vote+$hbte_vote+$hbivr_vote).' 票</span><span style="width:160px;float:left;text-align:right;padding:4px;">所有短信投票总计：</span>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$db->sql_fetchfield(0,0,$db->sql_query("select count(*) from poll_ip1 where del_flag!=1")).' 票</span><span style="width:160px;float:left;text-align:right;padding:4px;">所有网络投票总计：</span></div>';
echo '</div>';

//每天
$sql5="select * from poll_sms1 where status=1 and Service_code!=''";
$result5=$db->sql_query($sql5);
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '';
$i=0;
while($row=$db->sql_fetchrow($result5))
{
	$polltime=date("Ymd",$row['polltime']);
	$addvote=$row['addvote'];
	$dayVote[$polltime]+=$addvote;
}
$average=round($total/sizeof($dayVote),1);
echo '<div><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($average/3).'px;background-color:#00f;margin:2px;Filter: Alpha(Opacity=90, FinishOpacity=10, Style=1, StartX=100, StartY=0, FinishX=0, FinishY=0;"> </span>平均每天 '.$average.' 票</span><span style="width:110px;float:left;text-align:left;padding:2px;">每天投票数:</span></div>';
$min=10000;
$max=0;
while(list($key,$val)=each($dayVote))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($val/3).'px;background-color:#00f;margin:2px;"> </span>'.$val.' 票</span><span style="width:110px;float:left;text-align:right;padding:2px;">'.substr($key,0,4).'-'.substr($key,4,2).'-'.substr($key,6,2).'：</span></div>';
	
	$monthVote[substr(str_replace("-","",$key),0,6)]+=$val;
	$min=min($min,$val);
	$max=max($max,$val);
}
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($min/3).'px;background-color:#00f;margin:2px;"> </span>'.$min.' 票</span><span style="width:110px;float:left;text-align:right;padding:2px;">最少的一天：</span></div>';
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($max/3).'px;background-color:#00f;margin:2px;"> </span>'.$max.' 票</span><span style="width:110px;float:left;text-align:right;padding:2px;">最多的一天：</span></div>';
echo '</div>';

echo '<div style="width:680px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '<div>每月投票数:</div>';
while(list($key,$val)=each($monthVote))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:550px;float:right;text-align:left;padding:2px;"><span style="width:'.($val/20).'px;background-color:#00f;margin:2px;"> </span>'.$val.' 票</span><span style="width:110px;float:left;text-align:right;padding:2px;">'.substr($key,0,4).'-'.substr($key,4,2).'：</span></div>';
}
echo '</div>';

echo '</div>';

?>