<?
include "session.php";
define('IN_MATCH', true);

$root_path = "./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

require_once($root_path."templates/admin/left.htm");//��߲˵�

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array(
			'body' => 'comment_list.htm')
		);


$pageitem=15;
$mark_arr=array('��Ϊ����','ȡ������');

$page=$_REQUEST["page"];
if(''!=$_REQUEST['submit'])
{
	$s_username=$_REQUEST["s_username"];
	$s_blogname=$_REQUEST['s_blogname'];
	if(''!=$s_username)//��ѯ�����ߵ��������ԣ����Զ������ѯ��mm_id�󵥶�ȡ��
	{
		$sql="select * from comment where username like '%".$s_username."%' order by id desc";
	}
	elseif(''!=$s_blogname)//�������mm_info���н���һ����¼����Ҫ���Ȳ��mm_id�����Դ�Ϊ�ؼ��ֲ�ѯ����
	{
	//	$sql="select id,blogurl from user_info where binary blogname like '%".$s_blogname."%'";
	//	$result=$db->sql_query($sql);
	//	$user_id=$db->sql_fetchfield(0,0,$result);
	//	$blogurl=$db->sql_fetchfield(1,0,$result);
	//	$db->sql_freeresult();
	//	$sql="select *,'".$s_blogname."' as blogname,'".$blogurl."' as blogurl from comment where user_id=".$user_id." order by id desc";
		$sql="select comment.*,user_info.blogname,user_info.blogurl from comment,user_info where comment.user_id=user_info.id and binary user_info.blogname like '%".$s_blogname."%'";
	}
}
else
{
	$sql="select comment.*,user_info.blogname,user_info.blogurl from comment,user_info where comment.user_id=user_info.id order by comment.id desc";
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_username=".$s_username."&s_blogname=".$s_blogname);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$i=($page-1)*$pageitem;//���
while($row=$db->sql_fetchrow($result))
{
	$i++;
	$t_blogname='';
	$t_blogurl='';
	$user_id=$row['user_id'];//ȡ����ֵ����Ϊ�գ�Ҫô��0��Ҫô�Ƿ�0
	if(''!=$s_username && 0!=$t_user_id)//��������ؼ��������������������Զ�����뵥����user_info����ȡ��
	{
		$t_blogname=getField($user_id,'blogname');
		$t_blogurl=getField($user_id,'blogurl');
	}
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $row['id'],
		"USER_ID" => $row['user_id'],
		"USERNAME" => (''==$row['username'])?'�ο�':$row['username'],
		"CONTENT" => $row["content"],
		"ADDTIME" => date("y/m/d H:i:s",$row["addtime"]),
		"MARK" => $mark_arr[$row['mark']],
		"BLOGNAME" => (''!=$t_blogname)?$t_blogname:((strlen($user_id)==1&&$user_id==0)?'������':$row['blogname']),
		"BLOGURL" => (''!=$t_blogurl)?$t_blogurl:((strlen($user_id)==1&&$user_id==0)?'#':$row['blogurl']),
		"BGCOLOR" => $bgcolor,//�����еı���ɫ����
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"PAGE" => $pagenav
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>