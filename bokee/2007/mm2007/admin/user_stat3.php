<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable.php");

include_once("left.php");//��߲˵�
$area_arr = array('','�в�����','�ϲ�����','��������');
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>�ڶ�����Ů���ʹ���ѡ����������</div>';

$sql1="select * from mm_info where pass=1 order by allvote desc limit 90";
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$area=$row['area'];
	$arr[$area]['id'][]=$row['id'];
	$arr[$area]['realname'][]=$row['realname'];
	$arr[$area]['allvote'][]=$row['allvote'];
}
for($i=1;$i<4;$i++)
{
	echo '<div style="float:left;width:250px;border:1px solid #00f;text-align:left;margin:4px 6px;">';
	echo $area_arr[$i].'��';

	for($j=0;$j<20;$j++)
	{
		echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:70px;float:right;text-align:left;">'.$arr[$i]['allvote'][$j].' Ʊ</span><span style="width:24px;float:left;padding-left:2px;">'.($j+1).':</span><span style="width:152px;float:left;padding-left:2px;"><a href="../comment.php?id='.$arr[$i]['id'][$j].'" target="_blank">'.sprintf("%04d",$arr[$i]['id'][$j]).'</a>['.$arr[$i]['realname'][$j].']</span></div>';
	}
	echo '</div>';
}

echo '</div>';

?>