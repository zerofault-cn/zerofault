<?php
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");


if(''!=$_POST['submit'])
{
	$blogname	= conv($_REQUEST['blogname']);
	$blogurl	= $_REQUEST['blogurl'];
	$realname	= conv($_REQUEST['realname']);
	$cardtype	= $_REQUEST['cardtype'];
	$cardnum	= $_REQUEST['cardnum'];
	$addr		= conv($_REQUEST['addr']);
	$post		= $_REQUEST['post'];
	$phone		= conv($_REQUEST['phone']);
	$email		= $_REQUEST['email'];
	$other		= conv($_REQUEST['other']);
	$photo		= $_FILES['photo'];

	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");
		if(copy($photo['tmp_name'],'photo/'.$filename))
		{
			$tmp_blogurl=substr($blogurl,7);
			if(strpos($tmp_blogurl,'/')>0)
			{
				$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));
			}
			$sql="select * from user_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
			$result=$db->sql_query($sql);
			if($row=$db->sql_fetchrow($result))
			{
				echo '<script>alert("�˲������ӵ�ַ�Ѿ�ע����!�����ظ�ע��");history.back();</script>';
				exit;
			}
			$sql="insert into user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',cardtype=".$cardtype.",cardnum='".$cardnum."',addr='".$addr."',post='".$post."',phone='".$phone."',email='".$email."',other='".$other."',photo='".$filename."',addtime=UNIX_TIMESTAMP()";
			if($db->sql_query($sql))
			{
				echo '<script>alert("�������ύ�ɹ�!��ȷ��������ҳ");location="../";</script>';
//				exit;
			}
			else
			{
				echo '<script>alert("���ݿ���������Ի���ϵ�ͷ���");history.back();</script>';
//				exit;
			}
		}
		else
		{
			echo '<script>alert("��Ƭ�ϴ����������Ի���ϵ�ͷ���");history.back();</script>';
//			exit;
		}
	}
	else
	{
		echo '<script>alert("��û���ύ��Ƭ,�����Ǳ������������!�뷵�������ύ!");history.back();</script>';
//		exit;
	}
}
else
{
	header("location:../");
}
$db->sql_close();
?>
