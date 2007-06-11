<?
include "session.php";
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page0.php");

$action=$_REQUEST['action'];
if('add'==$action)
{
	for($i=0;$i<10;$i++)
	{
		$sql="insert into subject set title='',addtime=UNIX_TIMESTAMP()";
		$db->sql_query($sql);
	}
	header("location:?");
	exit;
}
if('modify'==$action)
{
	$id=$_REQUEST['id'];
	$title=$_REQUEST['title'];
	$sql="update subject set title='".$title."' where id=".$id;
	if($db->sql_query($sql))
	{
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo 'sql:'.$sql;
	}
	exit;
}
include_once("left.php");//左边菜单
?>
<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<caption>主题管理 [<a href="?action=add">批量增加10个主题的数据空间</a>]</caption>
<tr style="padding:5px 0;background-color:#6699FF;font-weight:bold">
	<td>SID</td>
	<td>PK主题(点击即可修改)</td>
	<td>投票数(<span style="color:#FE6309">正方</span>/<span style="color:#0455DC">反方</span>)</td>
	<td>评论数(<span style="color:#FE6309">正方</span>/<span style="color:#0455DC">反方</span>/<span style="color:#A4CA64">三方</span>)</td>
	<td>添加时间</td>
</tr>
<?
$pageitem=15;
$page=$_REQUEST["page"];

$sql="select * from subject order by id desc";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,'');
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	?>
<tr>
	<td><?=$row['id']?></td>
	<td id="<?=$row['id']?>" onmouseover="this.style.cursor='hand'" onclick="modify(<?=$row['id']?>);"><?=(''==$row['title'])?'点击修改':$row['title']?></td>
	<td><span style="color:#FE6309"><?=$row['l_vote']?></span>/<span style="color:#0455DC"><?=$row['r_vote']?></span></td>
	<td><span style="color:#FE6309"><?=$row['l_comm']?></span>/<span style="color:#0455DC"><?=$row['r_comm']?></span>/<span style="color:#A4CA64"><?=$row['c_comm']?></span> [<a href="admin_comment.php?sid=<?=$row['id']?>">管理评论</a>]</td>
	<td nowrap><?=date("Y-m-d H:i:s",$row['addtime'])?></td>
</tr>
<tr>
	<td colspan="5"><div height="1" style="border-bottom:1px dotted #aaa"></div></td>
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
var last_id=0;
function modify(id) {
	if(last_id!=0)
	{
		last_t1=document.getElementById(last_id);
		last_t2=document.getElementById('title'+last_id);
		last_t1.innerHTML=last_t2.value;
	}
	last_id=id;
	t=document.getElementById(id);
	old_title=t.innerHTML;
	if(''!=old_title)
	{
		textSize=old_title.length;
	}
	if(old_title.indexOf('<')>=0 || old_title.indexOf('>')>=0)
	{
		return;
	}
	else
	{
		t.innerHTML='<input type="text" id="title'+id+'" size="'+2*textSize+'" value="'+old_title+'"><input type="button" onclick="submitModify('+id+',document.getElementById(\'title'+id+'\').value);" value="提交">';
		document.getElementById('title'+id).focus();
	}
}

function submitModify(id,title) {
	document.getElementById('iframe1').src='?action=modify&id='+id+'&title='+title;
}
</script>