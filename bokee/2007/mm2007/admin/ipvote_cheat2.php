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

$del_flag=$_REQUEST["del_flag"];
if(''==$del_flag)
{
	$del_flag=1;
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>�ڶ�����Ů���ʹ�������ͶƱͳ��</div>';
echo '<div>��IPÿ���ͶƱ����</div>';
echo '<div style="color:red">�������ݱ�ʾ�п�������</div>';
echo '<a href="?del_flag=1">���ɽϴ�</a>&nbsp;&nbsp;<a href="?del_flag=0">���ɽ�С</a>';

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
}
$all=0;
while(list($key,$val)=each($arr))
{
	while(list($key2,$val2)=each($val))
	{
		if($val2>30)
		{
			echo '<div style="float:left;width:152px;margin-left:4px;margin-top:10px;border:1px solid #00f;text-align:left;padding:4px">';
			echo '<div>IP��<span style="color:red">'.$key.'</span></div>';
			echo '<div>ͶƱID��<a href="ipvote_cheat.php?mm_id='.$arr2[$key][$key2].'&date='.mktime(0,0,0,substr($key2,5,2),substr($key2,8,2),substr($key2,0,4)).'" target="_blank">'.sprintf("%04d",$arr2[$key][$key2]).'</a></div>';
			echo '<div><div style="width:52px;float:right;">'.$val2.'Ʊ</div><div style="float:left;width:90px;">'.$key2.':</div></div>';
			if($del_flag==0)
			{
				echo '<div><a href="del_flag.php?ip='.$key.'&date='.mktime(0,0,0,substr($key2,5,2),substr($key2,8,2),substr($key2,0,4)).'" target="_blank">����Ϊ��Ч</a></div>';
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