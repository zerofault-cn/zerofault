<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable.php");

include_once("left.php");//��߲˵�
$mm_id=$_REQUEST['mm_id'];

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '�ڶ�����Ů���ʹ�������ͶƱͳ��<span style="color:red">(����ںܶ�ʱ�����ж��ͶƱ,���ʾ�п�������)</span>';
echo '<div>ID��<a href="../comment.php?id='.$mm_id.'" target="_blank">'.sprintf("%04d",$mm_id).'</a> ���ڣ�';
$date=$_REQUEST['date'];
if(''==$date)
{
	$date=mktime(0,0,0,date("m"),date("d"),date("Y"));
}
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
echo '<div>���ո�IP��ͶƱʱ�� <a href="ipvote_info.php?mm_id='.$mm_id.'&date='.$date.'">���ո�IP��ͶƱ����</a></div>';

$sql1="select ip,polltime from ".$ip_table." where del_flag=0 and mm_id=".$mm_id." and polltime>=".$date." and polltime<".($date+24*60*60);
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$ip=$row['ip'];
	$arr[$ip][]=$row['polltime'];
}
//arsort($arr);
$all=0;
while(list($key,$val)=each($arr))
{
//	for($i=0;sizeof($val)>30 && $i<sizeof($val);$i++)
//	for($i=0;$i<sizeof($val);$i++)
	{
	//	if(sizeof($val)>=20 && ($val[sizeof($val)-1]-$val[0])<=60)//ͶƱ��ʼ�ͽ���ʱ������60�����ڵ���Ϊ����
	//	if(($val[sizeof($val)-1]-$val[0])>60)//��Ϊ��������
		{
			echo '<div style="float:left;width:190px;margin-left:4px;margin-top:10px;border:1px solid #00f;text-align:left;padding:4px 6px;">';
			echo '<div>IP:<span style="color:red">'.$key.'</span></div>';
		//	echo '<div><a href="del_flag.php?del_flag=2&ip='.$key.'&date='.$date.'" target="_blank">����Ϊ��Ч2</a></div>';
			while(list($key2,$val2)=each($val))
			{
				echo '<div><div style="float:right">'.date("Y-m-d H:i:s",$val2).'</div><div style="float:left;color:blue">'.($key2+1).':</div></div>';
				$all++;
			}
			echo '</div>';
		//	@fopen('http://mm.bokee.com/2007/mm2007/admin/del_flag.php?del_flag=2&ip='.$key.'&date='.mktime(0,0,0,date("m",$val2),date("d",$val2),date("Y",$val2)),"r");
//			break;
		}
	}
	
}
echo '(�ܼ�'.$all.'Ʊ)';
echo '</div>';

?>