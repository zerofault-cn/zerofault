<?
session_start();
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."functions.php");
$id=$_REQUEST['id'];
if(''==$id)
{
	header("location:index.php");
	exit;
}
//�����ύ������
if(''!=$_POST['submit'])
{
	$username	= trim($_POST['username']);
	if(''==$username)
	{
		$username='����';
	}
	$content	= trim($_POST['content']);
	//�ж��Ƿ�ˢ��
	if(isset($_SESSION["lasttime"]))
	{
		if($_SESSION["lastcontent"]==$content)
		{
			echo "<script>alert('�벻Ҫ�ظ����ԣ�');location='?".$_SERVER["QUERY_STRING"]."';</script>";
			exit;
		}
		if(time()-$_SESSION["lasttime"] < 0)
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
	if(strlen($content)<2)
	{
		echo "<script>alert('��������Ҳ̫���˰ɣ�');history.back();</script>";
		exit;
	}
	include_once ("./filter.php");//���������ַ�����$filter_arr
	if(strlen( str_replace($filter_arr,'',$content) ) < strlen($content) )//������ַ������Σ������ַ�����ԭ�ַ����̣��Դ����ж��Ƿ�������
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
	$client_ip=GetIP();
	if(strpos($client_ip,',')>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
/*
	$sql0="select count(*) from mm_comment where addtime>(UNIX_TIMESTAMP()-60) and ip='".$client_ip."'";
	$result0=$db->sql_query($sql0);//ͬһIP����ʱ��������60��
	if($db->sql_fetchfield(0,0,$result0)>0)
	{
		header("location:?".$_SERVER["QUERY_STRING"]);
		exit;
	}
*/
	$sql1="insert into comment set username='".$username."',content='".format($content)."',addtime=".time().",user_id=".$id.",ip='".$client_ip."'";
	$sql2="update user_info set comm=comm+1,month_comm=month_comm+1 where id=".$id;
	if($db->sql_query($sql1))
	{
		if($id>0)
		{
			$db->sql_query($sql2);//�����û������Լ���
		}
		header("location:?".$_SERVER["QUERY_STRING"]);
	//	echo '<script>window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
	else
	{
		echo '<script>alert("�д�����!���Ժ����ԣ�������ϵ�ͷ���Ա");window.location="?'.$_SERVER["QUERY_STRING"].'";</script>';
	}
}
//�ύ���Դ������
$curpage="comment";
include_once("header.php");//����ͷ��

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'comment.htm'));

//���������Ƭ
$sql1="select id,realname,blogurl,groupurl,photo,flower,egg from user_info where id=".$id;
assign_vars_by_sql($sql1);

$pageitem=6;
$sql="select username,FROM_UNIXTIME(addtime,'%y/%m/%d %H:%i:%s') as time,content from comment ";
if($id>0)
{
	$sql.=" where user_id=".$id;
}
$sql.=" order by id desc";

$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?id=".$id);
assign_block_vars_by_sql("comm_list",$sql." limit ".$offset.",".$pageitem);

$tpl->assign_vars(array(
	"PAGE" => $pagenav,
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
include_once("footer.php")//����ҳ��
?>