<?
include_once "session.php";
define('IN_MATCH', true);

$root_path ="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_edit.htm'));

$id			= $_REQUEST['id'];
$realname	= $_REQUEST['realname'];
$blogurl	= $_REQUEST['blogurl'];
$groupurl	= $_REQUEST['groupurl'];
$category	= $_REQUEST['category'];
$adder_name	= $_REQUEST['adder_name'];
$adder_contact= $_REQUEST['adder_contact'];
$addtime	= $_REQUEST['addtime'];
$oldphoto	= $_REQUEST['oldphoto'];
$photo		= $_FILES['photo'];

if(''!=$_REQUEST['submit'])
{
	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");//��������ϴ�����Ƭ,������µ��ļ���,���⻺��
		@unlink('../photo/'.$oldphoto);//ɾ������Ƭ
		if(copy($photo['tmp_name'],'../photo/'.$filename))
		{
			$upload_flag=1;
			$sqlext=",photo='".$filename."'";
		}
		else
		{
			$upload_flag=0;
		}
	}
	else
	{
		$upload_flag=1;
	}
	
	$sql="update user_info set realname='".$realname."',blogurl='".$blogurl."',groupurl='".trim($groupurl)."',category=".$category.",adder_name='".$adder_name."',adder_contact='".$adder_contact."'".$sqlext." where id=".$id;
	if($upload_flag && $db->sql_query($sql))
	{
		$tpl->assign_vars(array("script_str" => 'alert("�޸ĳɹ�!");window.close();opener.location.reload();'));
	}
	elseif(0==$upload_flag)
	{
		echo "ͼƬ�ϴ�����";
	}
	else
	{
		echo "sql����<br />";
		echo $sql;
	}
}
else
{
	$sql="select * from user_info where id=".$id;

	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);

	$cate_arr=array('','��������','��������','�Ļ�����','�������','Ӱ�ӽ�ɫ','�ݸ�����','����');
	for($i=1;$i<sizeof($cate_arr);$i++)
	{
		$cate_str .= '<option value='.$i;
		if($i==$row['category'])
		{
			$cate_str .= ' selected';
		}
		$cate_str .= '>'.$cate_arr[$i].'</option>';
	}
	$tpl->assign_vars(array(
		"ID" => $id,
		"REALNAME" => $row['realname'],
		"BLOGURL" => $row['blogurl'],
		"GROUPURL" => $row['groupurl'],
		"CATEOPTION" => $cate_str,
		"ADDER_NAME" => $row['adder_name'],
		"ADDER_CONTACT" => $row['adder_contact'],
		"ADDTIME" => date("y-m-d H:i",$row['addtime']),
		"PHOTO" => $row['photo']
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
