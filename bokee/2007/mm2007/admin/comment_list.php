<?
include "session.php";
define('IN_MATCH', true);
$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//��߲˵�

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array(
			'body' => 'comment_list.htm')
		);


$pageitem=15;
$mark_arr=array('��Ϊ����','ȡ������');

$page=$_REQUEST["page"];
$mm_id=$_REQUEST['mm_id'];

if(!session_is_registered('mm_id'))
{
	session_register('mm_id');//�ж����Զ����radioʹ��
}
$_SESSION['mm_id']=$mm_id;
if(''!=$_REQUEST['submit'])
{
	$s_username=$_REQUEST["s_username"];
	$s_blogname=$_REQUEST['s_blogname'];
	if(''!=$s_username)//��ѯ�����ߵ��������ԣ����Զ������ѯ��mm_id�󵥶�ȡ��
	{
		$sql="select * from mm_comment where username like '%".$s_username."%' order by id desc";
	}
	elseif(''!=$s_blogname)//�������mm_info���н���һ����¼����Ҫ���Ȳ��mm_id�����Դ�Ϊ�ؼ��ֲ�ѯ����
	{
		$sql="select id,blogurl from mm_info where binary blogname like '%".$s_blogname."%'";
		$result=$db->sql_query($sql);
		$mm_id=$db->sql_fetchfield(0,0,$result);
		$blogurl=$db->sql_fetchfield(1,0,$result);
		$db->sql_freeresult();
		$sql="select *,'".$s_blogname."' as blogname,'".$blogurl."' as blogurl from mm_comment where mm_id=".$mm_id." order by id desc";
	}
}
else
{
	if(''==$mm_id)//��ͨ�������Ӳ�ѯ���޷�����
	{
		$sql="select mm_comment.*,mm_info.blogname,mm_info.blogurl from mm_comment,mm_info where mm_comment.mm_id=mm_info.id order by mm_comment.id desc";
	}
	else
	{
		$sql="select * from mm_comment where mm_id=0 order by id desc";
	}
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?mm_id=".$mm_id."&submit=".$_REQUEST['submit']."&s_username=".$s_username."&s_blogname=".$s_blogname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result))
{
	$t_blogname='';
	$t_blogurl='';
	$t_mm_id=$row['mm_id'];//ȡ����ֵ����Ϊ�գ�Ҫô��0��Ҫô�Ƿ�0
	if(''!=$s_username && 0!=$t_mm_id)//��������ؼ��������������������Զ�����뵥����mm_info����ȡ��
	{
		$t_blogname=getField($t_mm_id,'blogname');
		$t_blogurl=getField($t_mm_id,'blogurl');
	}
	if($t_mm_id==0)//��ȡ��mm_idΪ0ʱ����ʾ�������Ƕ������˵�
	{
		$mm_id=0;
	}
	$tpl->assign_block_vars("list", array(
		"ID" => $row['id'],
		"MM_ID" => $row['mm_id'],
		"USERNAME" => (''==$row['username'])?'�ο�':$row['username'],
		"CONTENT" => $row["content"],
		"ADDTIME" => date("y/m/d H:i:s",$row["addtime"]),
		"MARK" => $mark_arr[$row['mark']],
		"BLOGNAME" => (''!=$t_blogname)?$t_blogname:((strlen($mm_id)==1&&$mm_id==0)?'������':$row['blogname']),
		"BLOGURL" => (''!=$t_blogurl)?$t_blogurl:((strlen($mm_id)==1&&$mm_id==0)?'#':$row['blogurl']),
		"IP" => $row['ip'],
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"MM_ID" => $mm_id,
	"BTNFN" => $btnfn,//���ڽ��в鿴Ȩ�޵��û����������б��Ͱ�ť
	"CHECK0" => (strlen($mm_id)==1&&$mm_id==0)?' checked':'',
	"CHECK1" => (strlen($mm_id)==1&&$mm_id==0)?'':' checked',
//	"DELBTNFN" => (strlen($mm_id)==1&&$mm_id==0)?'':' disabled',//���������������˵�����
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

?>