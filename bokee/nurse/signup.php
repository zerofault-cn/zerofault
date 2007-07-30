<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");
include_once($root_path."profile.inc.php");

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
	$age		= conv($_REQUEST['age']);
	$height		= conv($_REQUEST['height']);
	$weight		= conv($_REQUEST['weight']);
	$province	= conv($_REQUEST['province']);
	$area		= $_REQUEST['area'];
	$hospital	= conv($_REQUEST['hospital']);
	$IDcard		= $_REQUEST['IDcard'];
	$address	= conv($_REQUEST['address']);
	$postcode	= $_REQUEST['postcode'];
	$phone		= conv($_REQUEST['phone']);
	$email		= $_REQUEST['email'];
	$other		= conv($_REQUEST['other']);
	$intro		= conv($_REQUEST['intro']);
	$photo		= $_FILES['photo'];

	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");
		if(copy($photo['tmp_name'],'photo/'.$area.'/'.$filename))
		{
			if(substr($blogurl,-1)=='/')
			{
				$blogurl=substr($blogurl,0,-1);
			}
			$sql="select * from user_info where blogurl ='".$blogurl."'";
			$result=$db->sql_query($sql);
			if($row=$db->sql_fetchrow($result)>0)
			{
				echo '<script>alert("�˲������ӵ�ַ�Ѿ�������!�����ظ�����");</script>';
				exit;
			}
			$sql="insert into user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',area=".$area.",hospital='".$hospital."',phone='".$phone."',email='".$email."',photo='".$filename."'";
			$sql.=(''==$age)?"":",age=".$age;
			$sql.=(''==$height)?"":",height=".$height;
			$sql.=(''==$weight)?"":",weight=".$weight;
			$sql.=(''==$IDcard)?"":",IDcard='".$IDcard."'";
			$sql.=",address='".$address."'";
			$sql.=",postcode='".$postcode."'";
			$sql.=",other='".$other."'";
			$sql.=",intro='".$intro."'";
			$sql.=",addtime=UNIX_TIMESTAMP()";
			if($db->sql_query($sql))
			{
				$info_arr=array(
					"�������"=>sprintf("%05d",$db->sql_nextid()),
					"������������"=>$blogname,
					"�������ӵ�ַ"=>$blogurl,
					"��ʵ����"=>$realname,
					"����"=>''==$age?'δ��д':$age,
					"���"=>''==$height?'δ��д':$height,
					"����"=>''==$weight?'δ��д':$weight,
					"��������"=>$area_arr[$area],
					"����ҽԺ"=>$hospital,
					"֤������"=>''==$IDcard?'δ��д':$IDcard,
					"��ϵ��ַ"=>$address,
					"�ʱ�"=>''==$postcode?'δ��д':$postcode,
					"��ϵ�绰"=>$phone,
					"E_mail"=>$email,
					"������ϵ��ʽ"=>''==$other?'δ��д':$other,
					"�����س�"=>''==$intro?'δ��д':$intro,
					"��Ƭ"=>'<img src="http://nurse.bokee.com/nurse/photo/'.$area.'/'.$filename.'" />'
				);
				
				mailto($email,'�ж����ʮ�����㻤ʿ��ѡ�ȷ����',$info_arr,'');
		/*		$tpl->assign_vars(array(
					"MSGTITLE" => '�������ύ�ɹ�!',
					"MSGTEXT" => '<p style="text-indent:2em;font-size:14px;line-height:200%;">��л���μӵڶ�����Ů���ʹ��������Ѿ��ɹ�������ϵͳ�ѷ���һ��ȷ���ʼ�������д��email��ַ ����ע��鿴�������ľ��������������κ����⣬��������ϵ�����޸ģ�</p><p style="text-indent:2em;font-size:14px;line-height:200%;">�������뽫������˶����У��������ʱ��Ϊһ�������գ��������ʻ��޸��������µ�010-51818811-3232 �����ʼ�haoranzhang@bokee-inc.com�������Ϻ����һ�����ȷ���ʼ��ٴη��͸����������ĵȴ�����ע��鿴�ʼ���</p><br /><br />',
					"MSGLINK" => '<a href="../">������ҳ</a><br />'
					));*/
				echo '<script>alert("�������ύ�ɹ�!�������佫�յ�һ��ϵͳȷ���ţ���ע��鿴�����ĵȴ���ˣ�");parent.location.href="../";</script>';
				exit;
			}
			else
			{
				echo $sql;
				echo '<script>alert("���ݿ���������Ի���ϵ�ͷ���");</script>';
				exit;
			}
		}
		else
		{
			echo '<script>alert("��Ƭ�ϴ����������Ի���ϵ�ͷ���");</script>';
			exit;
		}
	}
	else
	{
		echo '<script>alert("��û���ϴ���Ƭ,�������ύ!");</script>';
		exit;
	}
}
$db->sql_close();
//$tpl->pparse('body');
//$tpl->destroy();
?>
