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
$mm_id=$_REQUEST['mm_id'];
if(''==$del_flag)
{
	$del_flag=0;
}
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>�ڶ�����Ů���ʹ�������ͶƱͳ��</div>';
echo '<div>ѡ��ͶƱ��������ͶƱ����ID:'.sprintf("%04d",$mm_id).'</div>';

echo '<div style="width:660px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo 'ÿ����������Ʊ������:';
echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;">��������Ʊ��</span><span style="width:130px;float:left;text-align:right;padding:2px;">���ڣ�</span></div>';
$sql1="select * from ".$ip_table." where mm_id=".$mm_id." and del_flag=".$del_flag;
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$polltime=$row['polltime'];
	$pollday=date("Y-m-d",$polltime);
	$arr[$pollday]++;
}
while(list($key,$val)=each($arr))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:510px;float:right;text-align:left;padding:2px;"><span style="width:'.($val/10).'px;background-color:#00f;margin:2px;"> </span>'.$val.' Ʊ</span><span style="width:130px;float:left;text-align:right;padding:2px;"><a href="ipvote_cheat.php?mm_id='.$mm_id.'&date='.mktime(0,0,0,substr($key,5,2),substr($key,8,2),substr($key,0,4)).'">'.$key.'</a>��</span></div>';
	$all+=$val;
}
echo '</div>';
echo '&nbsp;&nbsp;����'.$all.'Ʊ';
echo '</div>';

?>