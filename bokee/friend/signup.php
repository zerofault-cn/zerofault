<?php
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$action=$_REQUEST['action'];
if($action=='checkUrl')
{
	$url=$_REQUEST['url'];
	if(substr($url,-1)=='/')
	{
		$url=substr($url,0,-1);
	}
	$sql="select * from user_info where blogurl ='".$url."'";
	$result=$db->sql_query($sql);
	if($row=$db->sql_fetchrow($result)>0)
	{
		echo '�Ѿ�������';
		exit;
	}
	else
	{
		echo 'ok';
		exit;
	}
}
if(''!=$_POST['submit'])
{
	$blogname	= conv($_REQUEST['blogname']);
	$blogurl	= $_REQUEST['blogurl'];
	$realname	= conv($_REQUEST['realname']);
	$sex		= $_REQUEST['sex'];
	$input_location= conv($_REQUEST['input_location']);
	$address	= conv($_REQUEST['address']);
	$post		= $_REQUEST['post'];
	$phone		= conv($_REQUEST['phone']);
	$email		= $_REQUEST['email'];
	$other		= conv($_REQUEST['other']);
	$photo		= $_FILES['photo'];

	if($photo['size']>0)
	{
		if($photo['size']>500*1024)
		{
			echo '<script>parent.alert("���ϴ���ͼƬ�ļ�̫���ˣ���ò�Ҫ����500K");</script>';
			exit;
		}
		$filename=date("YmdHis").strrchr($photo['name'],".");
		if(copy($photo['tmp_name'],'photo/'.$filename))
		{
			if(substr($blogurl,-1)=='/')
			{
				$blogurl=substr($blogurl,0,-1);
			}
			$sql="select * from user_info where blogurl ='".$blogurl."'";
			$result=$db->sql_query($sql);
			if($row=$db->sql_fetchrow($result)>0)
			{
				echo '<script>parent.alert("�˲������ӵ�ַ�Ѿ�������!�����ظ�����");</script>';
				exit;
			}
			$sql="insert into user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',sex=".$sex.",address='".$address."',post='".$post."',phone='".$phone."',email='".$email."',other='".$other."',photo='".$filename."',addtime=UNIX_TIMESTAMP()";
			if($db->sql_query($sql))
			{
				$id=$db->sql_nextid();
				$sql2="insert into user_info_ext set id=".$id.",sex=".$sex.",location='".$input_location."'";
				$db->sql_query($sql2);
				echo '<script>parent.alert("�������ύ�ɹ�!���¼����ͨ��֤������������ϸ���ϣ�");parent.location.href="info.php?id='.$id.'";</script>';
				exit;
			}
			else
			{
				echo '<script>parent.alert("���ݿ���������Ի���ϵ�ͷ���");</script>';
				exit;
			}
		}
		else
		{
			echo '<script>parent.alert("��Ƭ�ϴ����������Ի���ϵ�ͷ���");</script>';
			exit;
		}
	}
	else
	{
		echo '<script>parent.alert("��û���ϴ���Ƭ,�������ύ!");</script>';
		exit;
	}
}
$db->sql_close();
?>
