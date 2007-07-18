<?php
define('IN_MATCH', true);
session_start();
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");

$id=$_REQUEST['id'];

include_once "header.php";
if(''==$id || 0==$id)
{
	include_once "comment_left.php";
}
else
{
	include_once "main.php";
}
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

$page=$_REQUEST["page"];

$username	= $_POST['username'];
$content	= $_POST['content'];
if(''!=$_POST['submit'])
{
	$ip=GetIP();
	//�ж��Ƿ�ˢ��
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('���Բ�Ҫ������һ�䰡��');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 30)
		{
			echo "<script>alert('������Ƶ��Ҳ̫���˰ɣ�');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		else
		{
			$_SESSION['lasttime']=time();
			$_SESSION['lastcontent']=$content;
		}
	}
	else
	{
		$_SESSION['lasttime']=time();
		$_SESSION['lastcontent']=$content;
	}
	if(strlen(trim($content))<2)
	{
		echo "<script>alert('��������̫���ˣ�');history.back();</script>";
		exit;
	}
	include_once ("./filter.php");//���������ַ�����$filter_arr
	$strlen=strlen($content);
	//strlen(str_replace("http://","",$content))<$strlen || 
	if(strlen(eregi_replace("^[0-9]+[a-z]+$","",$content))<$strlen || strlen( str_replace($filter_arr,'',$content) ) < $strlen)//������ַ������Σ������ַ�����ԭ�ַ����̣��Դ����ж��Ƿ�������
	{
		header("location:?".$_SERVER["QUERY_STRING"]."&filter");
		exit;
	}
	$sql="insert into comment set username='".$username."',content='".format(trim($content))."',addtime=UNIX_TIMESTAMP(),ip='".$ip."',user_id=".$id;
	$sql2="update user_info set comm_count=comm_count+1 where id=".$id;
	if($db->sql_query($sql))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//�������Լ���
		}
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo $sql;
	//	echo '<script>alert("�д�����!���Ժ����ԣ�������ϵ�ͷ���Ա");parent.location.reload();</script>';
	}
}
/*�������Խ���*/

if($id>0)
{
	$sql="select * from user_info where pass>0 and id=".$id;
	if($db->sql_numrows($db->sql_query($sql))==0)
	{
		echo "���û���δͨ����ˣ���ȴ�ͨ����˺�������!";

		exit;
	}
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$blogurl=$row['blogurl'];
}
/**
*�ұ������б�
*/
$pageitem=20;
$sql="select * from comment";
if($id>0)
{
	$pageitem=16;
	$sql.=" where user_id=".$id;
}
$sql.=" order by id desc";
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?id=".$id);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$class=('liulicon liuli'!=$class)?'liulicon liuli':'liulicon';
	$tpl->assign_block_vars("list", array(
		"ID"=>$row['id'],
		"CLASS"=>$class,
		"CONTENT" => (($id>0)?'':'��<a href="comment.php?id='.$row["user_id"].'">['.getField($row['user_id'],'blogname').']</a>������<br />').$row['content'],
		"USERNAME" => (''!=$row['username'])?$row['username']:'�ο�',
		"ADDTIME" => date("y/m/d H:i",$row['addtime'])
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav,
	"DISPLAY" => checkLogin($blogurl)?'':'none',
	"FORMDISPLAY"=>$id>0?'':'none'
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

require_once "templates/footer.htm";
?>