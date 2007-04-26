<?
define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include "session.php";

$action=$_REQUEST['action'];
if('del'==$action)
{
	$id = $_REQUEST['id'];
	$channel_id= $_REQUEST['channel_id'];
	$sql="delete from article where id =".$id;
	$sql2="update channel set article_count=(article_count-1) where id=".$channel_id;
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
if('batchdel'==$action)
{
	$channel_id=$_REQUEST['channel_id'];
	$sql1="update article set channel_id1=0 where channel_id1=".$channel_id." and addtime<(UNIX_TIMESTAMP()-6*30*86400)";
	$sql2="update article set channel_id2=0 where channel_id2=".$channel_id." and addtime<(UNIX_TIMESTAMP()-6*30*86400)";
	$sql3="update article set channel_id3=0 where channel_id3=".$channel_id." and addtime<(UNIX_TIMESTAMP()-6*30*86400)";
	if($db->sql_query($sql1) && $db->sql_query($sql2) && $db->sql_query($sql3))
	{
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo 'sql:'.$sql1;
		echo '<br>';
		echo 'sql2:'.$sql2;
		echo '<br>';
		echo 'sql3:'.$sql3;
	}
	exit;
}
if('modify'==$action)
{
	$id=$_REQUEST['id'];
	$title=$_REQUEST['title'];
	$sql="update article set title='".$title."' where id=".$id;
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
$channel_id=$_REQUEST['channel_id'];
if($channel_id>0)
{
	$sql1="select name from channel where id=".$channel_id;
	$caption='投稿器：'.$db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
else
{
	$caption='所有投稿文章';
}
$pageitem=15;
$page=$_REQUEST["page"];
if($channel_id>0)
{
	$sql="select * from article where channel_id1=".$channel_id." or channel_id2=".$channel_id." or channel_id3=".$channel_id." order by addtime desc";
}
else
{
	$sql="select * from article order by addtime desc";
}
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?channel_id=".$channel_id);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<caption>'.$caption.'(文章总数:'.$total.')</caption>';
echo '<tr bgcolor="#6699ff"><td>文章ID</td><td>作者博客</td><td>文章标题</td><td>所属分类</td><td>投稿时间</td><td>操作</td></tr>';
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$author_id=$row['author_id'];
	$title=$row['title'];
	$url=$row['url'];
	$addtime=date("Y-m-d H:i:s",$row['addtime']);
	$channel_id1=$row['channel_id1'];
	$channel_id2=$row['channel_id2'];
	$channel_id3=$row['channel_id3'];
	$channel_name1=$channel_name2=$channel_name3='';
	if(''!=$channel_id1 && $channel_id1>0)
	{
		$channel_name1=getField($channel_id1,'name','channel');
	}
	if(''!=$channel_id2 && $channel_id2>0)
	{
		$channel_name2=getField($channel_id2,'name','channel');
	}
	if(''!=$channel_id3 && $channel_id3>0)
	{
		$channel_name3=getField($channel_id3,'name','channel');
	}
	$vote=$row['vote'];
	echo '<tr>';
	echo '<td>'.$id.'</td>';
	echo '<td>'.getField($author_id,'blogname','author').'</td>';
	echo '<td><span id="span1'.$id.'"><a id="link'.$id.'" href="'.$url.'" target="_blank">'.$title.'</a><input type="button" onclick="modify('.$id.')" value="修改" /></span>';
	echo '<span id="span2'.$id.'" style="display:none"><input type="text" id="input'.$id.'" size="'.strlen($title).'" value="'.$title.'"><input type="button" onclick="submitModify('.$id.',document.getElementById(\'input'.$id.'\').value);" value="提交"></span></td>';
	echo '<td id="channels'.$id.'" oonclick="modifyChannel('.$id.','.$channel_id1.','.$channel_id2.','.$channel_id3.')">'.$channel_name1.' '.$channel_name2.' '.$channel_name3.'</td>';
	echo '<td>'.$addtime.'</td>';
	echo '<td><input type="button" value="删除" onclick="confirmdel('.$row['id'].','.$channel_id.')" /></td>';
	echo '</tr>';
	echo '<tr><td colspan="6"><div height="1" style="border-bottom:1px dotted #aaa"></div></td></tr>';
}
echo '</table>';
echo $pagenav;
$db->sql_close();
?>
<input type="button" onclick="confirmBatchDel(<?=$channel_id?>);" value="删除半年前的文章" />
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

function submitModify(id,title) {
	document.getElementById('iframe1').src='?action=modify&id='+id+'&title='+title;
}
function modifyChannel(id,id1,id2,id3) {
	if(last_id!=0)
	{
		last_t1=document.getElementById(last_id);
		last_t2=document.getElementById('title'+last_id);
		last_t1.innerHTML=last_t2.value;
	}
	last_id=id;
	t=document.getElementById(id);
	old_channel=t.innerHTML;
	//未完成
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
function confirmdel(id,cid)
{
	if(confirm('确定要删除ID为'+id+'的文章吗?'))
	{
		document.getElementById('iframe1').src='?action=del&id='+id+'&channel_id='+cid;
	}
	else
	{
		return;
	}
}
function confirmBatchDel(cid) {
	if(confirm('确定要删除此投稿器下半年前的文章吗?'))
	{
		document.getElementById('iframe1').src='?action=batchdel&channel_id='+cid;
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