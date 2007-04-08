<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable.php");

include_once("left.php");//左边菜单

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '第二届美女博客大赛用户报名情况';

$sql1="select * from mm_info where pass=1 order by id";
$result1=$db->sql_query($sql1);
echo '<div style="width:580px;margin-top:20px;border:1px solid #00f;text-align:left;padding-top:4px;">';
echo '每天报名数:';
while($row=$db->sql_fetchrow($result1))
{
	$addtime=date("Ymd",$row['addtime']);
	$dayAdd[intval($addtime)]++;
}
while(list($key,$val)=each($dayAdd))
{
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:380px;float:right;text-align:left;padding:2px;"><span style="width:'.(2*$val).'px;background-color:#00f;margin:2px;"> </span>'.$val.' 人</span><span style="width:170px;float:left;text-align:right;padding:2px;">'.substr($key,0,4).'-'.substr($key,4,2).'-'.substr($key,6,2).'：</span></div>';
}
echo '</div>';

echo '</div>';

?>