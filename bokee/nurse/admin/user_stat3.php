<?
include_once "session.php";

define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");
include_once($root_path."dbtable2.php");

require_once($root_path."templates/admin/left.htm");//��߲˵�
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<div>�ж����ʮ�����㻤ʿ��ѡ�ѡ�ָ�������</div>';
echo '<div style="width:430px;border:1px solid #00f;text-align:left;margin:4px 6px;">';
	
$sql1="select * from user_info order by smsvote desc limit 30";
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$i++;
	echo '<div style="border-bottom:1px dotted #aaa;"><span style="width:90px;float:right;text-align:left;">'.$row['allvote'].' Ʊ</span><span style="width:30px;float:left;padding-left:2px;">'.($i).':</span><span style="width:280px;float:left;padding-left:2px;"><a href="../comment.php?id='.$row['id'].'" target="_blank">'.sprintf("%04d",$row['id']).'</a> <span style="width:80px">['.$row['realname'].']</span>[<a href="'.$row['blogurl'].'" target="_blank">'.$row['blogname'].'</a>]</span></div>';
}
	echo '</div>';

echo '</div>';

?>