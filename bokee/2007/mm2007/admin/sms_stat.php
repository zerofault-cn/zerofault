<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable2.php");

include_once("left.php");//��߲˵�

$Service_arr=array("9951" =>'��ͨ',"10665110" =>'�ƶ�');
$area_arr = array('','�в�','�ϲ�','����');

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '�ڶ�����Ů���ʹ�������ͶƱ���';

$sql1="select Service_code,addvote,count(*) as count from ".$sms_table." where status=1 and Service_code!='' group by Service_code,addvote";
$result1=$db->sql_query($sql1);
echo '<div style="width:580px;">';
echo '<div style="width:280px;margin-top:20px;border:1px solid #00f;float:left;text-align:left;padding-top:4px;">';
echo ' ����Ӫ�̷�:';
while($row=$db->sql_fetchrow($result1))
{
	$Service_code=$row['Service_code'];
	$addvote=$row['addvote'];
	$count=$row['count'];
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:180px;float:right;text-align:left;padding:4px;">'.$addvote.'��'.$count.'='.($addvote*$count).' Ʊ</span><span style="width:80px;float:left;text-align:right;padding:4px;">'.$Service_arr[$Service_code].':</span></div>';
	$total+=$addvote*$count;
}
echo '</div>';

$sql2="select mm_info.area as area,".$sms_table.".addvote,count(*) as count from ".$sms_table.",mm_info where ".$sms_table.".status=1 and ".$sms_table.".Service_code!='' and ".$sms_table.".mm_id=mm_info.id group by mm_info.area,".$sms_table.".addvote";
$result2=$db->sql_query($sql2);
echo '<div style="width:280px;margin-top:20px;border:1px solid #00f;float:right;text-align:left;padding-top:4px;">';
echo ' ��������:';
while($row=$db->sql_fetchrow($result2))
{
	$area=$row['area'];
	$addvote=$row['addvote'];
	$count=$row['count'];
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:180px;float:right;text-align:left;padding:4px;">'.$addvote.'��'.$count.'='.($addvote*$count).' Ʊ</span><span style="width:80px;float:left;text-align:right;padding:4px;">'.$area_arr[$area].':</span></div>';
}
echo '</div>';
echo '</div>';
echo '<div style="width:580px;margin-top:4px;border:1px solid #00f;">';
echo '<span style="width:380px;float:right;text-align:left;padding:4px;">'.$total.' Ʊ</span><span style="width:110px;float:left;text-align:right;padding:4px;">�ܼƣ�</span>';
echo '</div>';

$sql3="select * from mm_info where pass=1 and (hbun_vote!=0 or hbte_vote!=0 or hbivr_vote!=0)";
$result3=$db->sql_query($sql3);
while($row=$db->sql_fetchrow($result3))
{
	$hbun_vote+=$row['hbun_vote'];
	$hbte_vote+=$row['hbte_vote'];
	$hbivr_vote+=$row['hbivr_vote'];
}
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '�����ǿռ�԰�û�ר��:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbun_vote.' Ʊ</span><span style="width:120px;float:left;text-align:right;padding:4px;">������ͨ��</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbte_vote.' Ʊ</span><span style="width:120px;float:left;text-align:right;padding:4px;">����С��ͨ��</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$hbivr_vote.' Ʊ</span><span style="width:120px;float:left;text-align:right;padding:4px;">����IVR��</span></div>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.($hbun_vote+$hbte_vote+$hbivr_vote).' Ʊ</span><span style="width:120px;float:left;text-align:right;padding:4px;">�ܼƣ�</span></div>';
echo '</div>';

echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;">';
echo '<span style="width:380px;float:right;text-align:left;padding:4px;">'.($total+$hbun_vote+$hbte_vote+$hbivr_vote).' Ʊ</span><span style="width:160px;float:left;text-align:right;padding:4px;">���ж���ͶƱ�ܼƣ�</span>';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:4px;">'.$db->sql_fetchfield(0,0,$db->sql_query("select count(*) from ".$ip_table)).' Ʊ</span><span style="width:160px;float:left;text-align:right;padding:4px;">��������ͶƱ�ܼƣ�</span></div>';
echo '</div>';

//��ʱ��ͳ��,ȡ24Сʱ��ÿСʱ������
$sql4="select * from ".$sms_table." where status=1 and Service_code!='' and polltime>=".(time()-24*60*60)." order by id";
$result4=$db->sql_query($sql4);
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '���24СʱͶƱ��:';

while($row=$db->sql_fetchrow($result4))
{
	$polltime=date("YmdH",$row['polltime']);
	$addvote=$row['addvote'];
	$hourVote[$polltime]+=$addvote;
}
while(list($key,$val)=each($hourVote))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:2px;"><span style="width:'.(2*$val).'px;background-color:#00f;margin:2px;"> </span>'.$val.' Ʊ</span><span style="width:170px;float:left;text-align:right;padding:2px;">'.substr($key,0,4).'-'.substr($key,4,2).'-'.substr($key,6,2).' '.substr($key,8,2).':59:59��</span></div>';
}
echo '</div>';

//ÿ��
$sql5="select * from ".$sms_table." where status=1 and Service_code!='' order by id";
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
echo '<div><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($average/2).'px;background-color:#00f;margin:2px;Filter: Alpha(Opacity=90, FinishOpacity=10, Style=1, StartX=100, StartY=0, FinishX=0, FinishY=0;"> </span>ƽ��ÿ�� '.$average.' Ʊ</span><span style="width:110px;float:left;text-align:left;padding:2px;">ÿ��ͶƱ��:</span></div>';
while(list($key,$val)=each($dayVote))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.($val/2.5).'px;background-color:#00f;margin:2px;"> </span>'.$val.' Ʊ</span><span style="width:110px;float:left;text-align:right;padding:2px;">'.substr($key,0,4).'-'.substr($key,4,2).'-'.substr($key,6,2).'��</span></div>';
}
	
echo '</div>';

echo '</div>';

?>