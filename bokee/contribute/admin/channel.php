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
include_once("left.php");//��߲˵�
echo '<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">';
$sys_flag=$_REQUEST['sys_flag'];
if(''==$sys_flag)
{
	$sys_flag=0;
}
if(1==$sys_flag)
{
	echo 'ϵͳͶ����';
}
else
{
	echo '�Զ���Ͷ����';
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
	echo '<span id="span1'.$id.'"><a id="link'.$id.'" href="article.php?channel_id='.$id.'">'.$name.'</a><input type="button" onclick="modify('.$id.')" value="�޸�" /><input type="button" onclick="confirmdel('.$id.','.$article_count.')" value="ɾ��" /></span>';
	echo '<span id="span2'.$id.'" style="display:none"><input type="text" id="input'.$id.'" size="'.strlen($name).'" value="'.$name.'"><input type="button" onclick="submitModify('.$id.',document.getElementById(\'input'.$id.'\').value);" value="�ύ"></span>';
	echo '<br />ID��'.$id.'&nbsp;&nbsp;��������'.$article_count;
	echo '<br /><span style="cursor:hand" onclick="javascript:copy(\'http://blogs.bokee.com/contribute/channel.php?id='.$id.'\')">[Ͷ������ַ]</span> <span style="cursor:hand" onclick="javascript:copy(\'http://blogs.bokee.com/contribute/rss.php?id='.$id.'\')">[RSS��ַ]</span></div>';
}
if($sys_flag==0)
{
	echo '<div style="float:left;text-align:left;width:190px;height:86px;border:1px solid #00f;padding:1px;margin-left:5px;margin-top:5px;">';
	echo '<input type="text" id="add" size="20" value=""><input type="button" onclick="submitAdd(document.getElementById(\'add\').value);" value="����һ��">';
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
		alert('��Ͷ�����µ���������Ϊ�㣬����ֱ��ɾ��!');
		return;
	}
	else if(confirm('ȷ��Ҫɾ��IDΪ'+id+'��Ͷ������?'))
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
	alert('���ӵ�ַ�Ѹ��Ƶ�������');
}

</script>