<?
include "session.php";
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//左边菜单

echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$pageitem=15;
$side_arr=array("1"=>'正方',"-1"=>"反方","0"=>"中立");
$page=$_REQUEST["page"];
$sid=$_REQUEST['sid'];

if(!session_is_registered('sid'))
{
	session_register('sid');//判断留言对象的radio使用
}
$_SESSION['sid']=$sid;

$sql="select * from comment where sid=".$sid." order by id desc";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?mm_id=".$mm_id."&submit=".$_REQUEST['submit']."&s_username=".$s_username."&s_blogname=".$s_blogname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	?>
	<tr>
	<td><input type="checkbox" name="id[]" value="<?=$row['id']?>" /></td>
	<td><?=$side_arr[$row['side']]?></td>
	<td><?=$row['username']?></td>
	<td style="word-wrap:break-word;word-break:break-all;"><?=$row['title']?><br /><?=$row['content']?></td>
	<td nowrap><?=$row['addtime']?></td>
	<td align="center"><input type="button" value="删除" onclick="confirmdel(<?=$row['id']?>,<?=$row['sid']?>)" /></td>
</tr>
	<?
}

$db->sql_close();
echo '</table>';
echo '</div>';
?>