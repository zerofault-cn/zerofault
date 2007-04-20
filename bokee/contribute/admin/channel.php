<?
define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include "session.php";

$action=$_REQUEST['action'];
if('add'==$action)
{
	$name=$_REQUEST['name'];
	$sql="insert into channel set name='".$name."',addtime=UNIX_TIMESTAMP()";
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
if('del'==$action)
{
	$id=$_REQUEST['id'];
	$sql="delete from channel where id=".$id;
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
if('modify'==$action)
{
	$id=$_REQUEST['id'];
	$name=$_REQUEST['name'];
	$sql="update channel set name='".$name."' where id=".$id;
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
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
$sys_flag=$_REQUEST['sys_flag'];
if(''==$sys_flag)
{
	$sys_flag=0;
}
if(1==$sys_flag)
{
	echo '系统投稿器';
}
else
{
	echo '自定义投稿器';
}
$pageitem=15;
$page=$_REQUEST["page"];

$sql="select * from channel where sys_flag=".$sys_flag;
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$name=$row['name'];
	$article_count=$row['article_count'];
	echo '<div style="float:left;text-align:left;width:190px;height:86px;border:1px solid #00f;padding:1px;margin-left:5px;margin-top:5px;">';
	echo '<span id="span1'.$id.'"><a id="link'.$id.'" href="article.php?channel_id='.$id.'">'.$name.'</a><input type="button" onclick="modify('.$id.')" value="修改" /><input type="button" onclick="confirmdel('.$id.','.$article_count.')" value="删除" /></span>';
	echo '<span id="span2'.$id.'" style="display:none"><input type="text" id="input'.$id.'" size="'.strlen($name).'" value="'.$name.'"><input type="button" onclick="submitModify('.$id.',document.getElementById(\'input'.$id.'\').value);" value="提交"></span>';
	echo '<br />ID：'.$id.'&nbsp;&nbsp;文章数：'.$article_count;
	echo '<br /><span style="cursor:hand" onclick="javascript:copy(\'http://blogs.bokee.com/contribute/channel.php?id='.$id.'\')">[投稿器地址]</span> <span style="cursor:hand" onclick="javascript:copy(\'http://blogs.bokee.com/contribute/rss.php?id='.$id.'\')">[RSS地址]</span></div>';
}
if($sys_flag==0)
{
	echo '<div style="float:left;text-align:left;width:190px;height:86px;border:1px solid #00f;padding:1px;margin-left:5px;margin-top:5px;">';
	echo '<input type="text" id="add" size="20" value=""><input type="button" onclick="submitAdd(document.getElementById(\'add\').value);" value="增加一个">';
	echo '</div>';
}
echo '</div>';
$db->sql_close();
?>

</div>
<iframe frameborder="0" scrolling="no" id="iframe1" name="iframe1" width="600" height="50" src=""></iframe>
<script>
var last_id=0;
function modify(id) {
	if(last_id!=0)
	{
		last_t1=document.getElementById('span1'+last_id);
		last_t2=document.getElementById('span2'+last_id);
		last_t1.style.display='';
		last_t2.style.display='none';
	}
	last_id=id;
	t1=document.getElementById('span1'+id);
	t2=document.getElementById('span2'+id);
	t1.style.display='none';
	t2.style.display='';
	document.getElementById('input'+id).focus();
}
function submitModify(id,name) {
	document.getElementById('iframe1').src='?action=modify&id='+id+'&name='+name;
}
function submitAdd(name) {
	document.getElementById('iframe1').src='?action=add&name='+name;
}
function confirmdel(id,article_count)
{
	if(article_count>0)
	{
		alert('该投稿器下的文章数不为零，不能直接删除!');
		return;
	}
	else if(confirm('确定要删除ID为'+id+'的投稿器吗?'))
	{
		document.getElementById('iframe1').src='?action=del&id='+id;
	}
	else
	{
		return;
	}
}
function copy(url){
	clipboardData.setData('Text',url);
	alert('链接地址已复制到剪贴板');
}

</script>