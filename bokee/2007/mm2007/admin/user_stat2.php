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
$date=$_REQUEST['date'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '�ڶ�����Ů���ʹ���ѡ��ÿ���Ʊ���';
echo '<br /><br />';
echo '��ѡ������:';
echo '<select onchange="window.location=\'?date=\'+this.value">';
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

$sql1="select mm_id,addvote from ".$sms_table." where status=1 and polltime>=".$date." and polltime<".($date+24*60*60);
$result1=$db->sql_query($sql1);
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '�����������Ʊ������:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;">��������Ʊ��</span><span style="width:120px;float:left;text-align:right;padding:2px;">ѡ��ID��</span></div>';
while($row=$db->sql_fetchrow($result1))
{
	$arr[intval($row['mm_id'])]+=$row['addvote'];
}
arsort($arr);
$i=0;
while(list($key,$val)=each($arr))
{
	if($i++>10)
	{
		break;
	}
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:450px;float:right;text-align:left;padding:2px;"><span style="width:'.(2*$val).'px;background-color:#00f;margin:2px;"> </span>'.$val.' Ʊ</span><span style="width:120px;float:left;text-align:right;padding:2px;"><a href="smsvote_info.php?mm_id='.$key.'&date='.$date.'" target="_blank">'.sprintf("%04d",$key).'</a>��</span></div>';
}
echo '</div>';
/*
$sql2="select mm_id,count(*) as count from ".$ip_table." where polltime>=".$date." and polltime<".($date+24*60*60)." group by mm_id order by count desc";
$result2=$db->sql_query($sql2);
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '������������Ʊ������:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:490px;float:right;text-align:left;padding:2px;">��������Ʊ��</span><span style="width:80px;float:left;text-align:right;padding:2px;">ѡ��ID��</span></div>';
$i=0;
while($row=$db->sql_fetchrow($result2))
{
	$mm_id=$row['mm_id'];
	$count=$row['count'];
	if($count>4000)
	{
		$tmp_count=4000;
	}
	else
	{
		$tmp_count=$count;
	}
	$arr2[$mm_id]=$count;//�����鱣���Թ�������Ʊ��
	if($i++>10)//����ֻ��ʾ��ǰ10���͹���
	{
		continue;
	}
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;"><span style="width:'.($tmp_count/10).'px;background-color:#00f;margin:2px;"> </span>'.$count.' Ʊ</span><span style="width:60px;float:left;text-align:right;padding:2px;"><a href="ipvote_cheat.php?mm_id='.$mm_id.'&date='.$date.'" target="_blank">'.sprintf("%04d",$mm_id).'</a>��</span></div>';
}
echo '</div>';

echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '����������Ʊ������:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:490px;float:right;text-align:left;padding:2px;">������Ʊ��</span><span style="width:80px;float:left;text-align:right;padding:2px;">ѡ��ID��</span></div>';
$sql3="select max(id) from mm_info where pass=1";
$result3=$db->sql_query($sql3);
$max_id=$db->sql_fetchfield(0,0,$result3);
for($i=0;$i<$max_id;$i++)
{
	$arr3[$i]=30*$arr[$i]+$arr2[$i];
}
arsort($arr3);
$i=0;
while(list($key,$val)=each($arr3))
{
	if($val>4000)
	{
		$tmp_count=4000;
	}
	else
	{
		$tmp_count=$val;
	}
	if($i++>10)
	{
		break;
	}
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;"><span style="width:'.($tmp_count/10).'px;background-color:#00f;margin:2px;"> </span>'.$val.' Ʊ</span><span style="width:60px;float:left;text-align:right;padding:2px;"><a href="../comment.php?id='.$key.'" target="_blank">'.sprintf("%04d",$key).'</a>��</span></div>';
}
echo '</div>';
*/
$sql4="select mm_id,count(*) as count from mm_comment where addtime>=".$date." and addtime<".($date+24*60*60)." group by mm_id order by count desc limit 10";
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '������������������:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:490px;float:right;text-align:left;padding:2px;">����������</span><span style="width:80px;float:left;text-align:right;padding:2px;">ѡ��ID��</span></div>';
$result4=$db->sql_query($sql4);
while($row=$db->sql_fetchrow($result4))
{
	$mm_id=$row['mm_id'];
	$count=$row['count'];
	if($count>1200)
	{
		$tmp_count=1200;
	}
	else
	{
		$tmp_count=$count;
	}
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;"><span style="width:'.($tmp_count/3).'px;background-color:#00f;margin:2px;"> </span>'.$count.' ��</span><span style="width:60px;float:left;text-align:right;padding:2px;"><a href="../comment.php?id='.$mm_id.'" target="_blank">'.sprintf("%04d",$mm_id).'</a>��</span></div>';
}
echo '</div>';

echo '</div>';

?>