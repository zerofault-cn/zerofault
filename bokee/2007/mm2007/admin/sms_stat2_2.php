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

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
$sql1="select feephone,addvote from poll_sms2 where Service_code!='' and status=1 ";
$result1=$db->sql_query($sql1);
//echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;">';
//echo 'ͶƱ�ֻ�����';
while($row=$db->sql_fetchrow($result1))
{
	$feephone=$row['feephone'];
	$addvote=$row['addvote'];
	$arr[$feephone]+=$addvote;
}
arsort($arr);
while(list($key,$val)=each($arr))
{
	$i++;
	$arr2[$val]++;
//	echo '<div style="border-bottom:1px dotted #aaa;padding:2px;">'.$i.'<span style="margin-left:2em">'.$key.'</span><span style="margin-left:2em">'.$val.' Ʊ</span></div>';
}
//echo '</div>';

echo '<div style="width:400px;margin-top:20px;border:1px solid #00f;">';
echo '<div>����ͶƱ�ֻ�����ͳ��</div>';
while(list($key,$val)=each($arr2))
{
	echo '<div style="border-bottom:1px dotted #aaa;padding:2px;"><span style="width:100px;float:right;text-align:left;padding:2px;"><span style="color:blue">'.$val.'</span> ��</span><span style="width:280px;float:left;text-align:right;padding:2px;">��Ͷ <span style="color:red">'.$key.'</span> Ʊ���ֻ��Ÿ�����</span></div>';
}
echo '</div>';

echo '</div>';
echo '<pre>';
print_r($arr);
echo '</pre>';
?>