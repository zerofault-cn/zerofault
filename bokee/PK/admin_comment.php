<?
include "session.php";
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page0.php");

if($_REQUEST['del'])
{
	$id = $_REQUEST['id'];
	$sid= $_REQUEST['sid'];
	$field=$_REQUEST['field'];
	$sql="delete from comment where id =".$id;
	$sql2="update subject set ".$field."=(".$field."-1) where id=".$sid;
	if($db->sql_query($sql) && $db->sql_query($sql2))
	{
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo 'sql:'.$sql;
		echo '<br>';
		echo 'sql2:'.$sql2;
	}
	exit;
}
include_once("left.php");//左边菜单

$pageitem=10;
$side_arr=array("1"=>'正方',"-1"=>"反方","0"=>"中立");
$color_arr=array("1"=>'#FE6309',"-1"=>'#0455DC',"0"=>'#A4CA64');
$field_arr=array("1"=>'l_comm',"-1"=>"r_comm","0"=>"c_comm");
$page=$_REQUEST["page"];
$sid=$_REQUEST['sid'];

if(!session_is_registered('sid'))
{
	session_register('sid');//判断留言对象的radio使用
}
$_SESSION['sid']=$sid;
if(''==$sid)
{
	$caption="所有评论";
	$sql="select * from comment order by id desc";
}
else
{
	$sql0="select title from subject where id=".$sid;
	$caption='PK主题：'.$db->sql_fetchfield(0,0,$db->sql_query($sql0));
	$sql="select * from comment where sid=".$sid." order by id desc";
}
?>
<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<caption><?=$caption?></caption>
<tr style="padding:5px 0;background-color:#6699FF;font-weight:bold">
	<td>ID</td>
	<td nowrap>立场</td>
	<td>用户名</td>
	<td>观点</td>
	<td>评论时间</td>
	<td>操作</td>
</tr>
<?
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?sid=".$sid);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	?>
<tr>
	<td><?=$row['id']?></td>
	<td nowrap style="color:<?=$color_arr[$row['side']]?>"><?=$side_arr[$row['side']]?></td>
	<td><?=$row['username']?></td>
	<td style="word-wrap:break-word;word-break:break-all;"><?=$row['title']?><br /><?=$row['content']?></td>
	<td nowrap><?=date("y-m-d H:i:s",$row['addtime'])?></td>
	<td align="center"><input type="button" value="删除" onclick="confirmdel('<?=$row['id']?>','<?=$row['sid']?>','<?=$field_arr[$row['side']]?>')" /></td>
</tr>
<tr>
	<td colspan="6"><div height="1" style="border-bottom:1px dotted #aaa"></div></td>
</tr>
	<?
}

$db->sql_close();
?>
</table>
<?=$pagenav?>
</div>
<iframe frameborder="0" scrolling="no" id="iframe1" name="iframe1" width="600" height="50" src=""></iframe>
<script>
function confirmdel(id,sid,field)
{
	if(confirm('确定要删除ID为'+id+'的评论吗?'))
	{
		document.getElementById('iframe1').src='?del=1&id='+id+'&sid='+sid+'&field='+field;
	}
	else
	{
		return;
	}
}

function selectall(chk)
{
	var f = document.forms["form2"];
	for (i=0;i<f.elements.length;i++)
    {
		f.elements[i].checked = chk;
	}
}
function check2()
{
	var c = document.getElementsByName("id[]");
	for(i=0;i<c.length;i++)
	{
		if(c[i].checked == true)
		{
			return true;
		}
	}
	alert("您还没有做任何选择呢!");
	return false;
}

</script>