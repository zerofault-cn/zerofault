<?
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");

echo '<div style="width:900px;margin-top:10px;margin-left:auto;margin-right:auto;text-align:center;border:1px solid #000;padding:10px 0;">';
$del_flag=$_REQUEST['del_flag'];
if(''==$del_flag)
{
	$del_flag=1;
}
if($del_flag==1)
{
	echo '<div>�ڶ�����Ů���ʹ�������ͶƱ��һ����������</div>';
	echo '<div style="color:red">�������ѱ��������ף������ϵ�IP��Ʊ��</div>';
}
elseif($del_flag==2)
{
	echo '<div>�ڶ�����Ů���ʹ�������ͶƱ�ڶ�����������</div>';
	echo '<div style="color:red">�������ѱ����Ϊ�������׵�IP��Ʊ��</div>';
}
$sql1="select * from ".$ip_table." where del_flag=".$del_flag;
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$ip=$row['ip'];
	$polltime=$row['polltime'];
	$mm_id=$row['mm_id'];
	$pollday=date("Y-m-d",$polltime);
	$arr[$ip][$pollday]++;
	$arr2[$ip][$pollday]=$mm_id;
	$arr3[$ip][]=$polltime;
}
$all=0;
while(list($key,$val)=each($arr))
{
	while(list($key2,$val2)=each($val))
	{
		if(($del_flag==1 && $val2>30) || ($del_flag==2))
		{
			echo '<div style="float:left;width:190px;margin-left:4px;margin-top:10px;border:1px solid #00f;text-align:left;padding:4px">';
			echo '<div>IP��<span style="color:red">'.$key.'</span></div>';
			echo '<div>ͶƱ��ţ�'.sprintf("%04d",$arr2[$key][$key2]).'</div>';
			if($del_flag==1)
			{
				echo '<div><div style="width:60px;float:right;">'.$val2.'Ʊ</div><div style="float:left;width:100px;">'.$key2.':</div></div>';
			}
			elseif($del_flag==2)
			{
				while(list($key3,$val3)=each($arr3[$key]))
				{
					echo '<div><div style="float:right">'.date("Y-m-d H:i:s",$val3).'</div><div style="float:left;color:blue">'.($key3+1).':</div></div>';
				}
			}
			echo '</div>';
			$all+=$val2;
		}
		else
		{
			break;
		}
	}
	
}
echo '&nbsp;&nbsp;����'.$all.'Ʊ';
echo '</div>';

?>