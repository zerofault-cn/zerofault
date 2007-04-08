<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."functions.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'signup.htm'));

if(''!=$_POST['submit'])
{
	$blogname	= conv($_REQUEST['blogname']);
	$blogurl	= $_REQUEST['blogurl'];
	$realname	= conv($_REQUEST['realname']);
	$age		= conv($_REQUEST['age']);
	$height		= conv($_REQUEST['height']);
	$weight		= conv($_REQUEST['weight']);
	$area		= $_REQUEST['area'];
	$certitype	= $_REQUEST['certitype'];
	$certinum	= $_REQUEST['certinum'];
	$address	= conv($_REQUEST['address']);
	$postcode	= $_REQUEST['postcode'];
	$telenum	= conv($_REQUEST['telenum']);
	$email		= $_REQUEST['email'];
	$other		= conv($_REQUEST['other']);
	$english	= conv($_REQUEST['english']);
	$putonghua	= conv($_REQUEST['putonghua']);
	$intro		= conv($_REQUEST['intro']);
	$photo		= $_FILES['photo'];

	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");
		if(copy($photo['tmp_name'],'photo/'.$area.'/'.$filename))
		{
			$tmp_blogurl=substr($blogurl,7);
			if(strpos($tmp_blogurl,'/')>0)
			{
				$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));
			}
			$sql="select * from mm_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
			$result=$db->sql_query($sql);
			if($row=$db->sql_fetchrow($result))
			{
				echo '<script>alert("�˲������ӵ�ַ�Ѿ�ע����!�����ظ�ע��");history.back();</script>';
				exit;
			}
			$sql="insert into mm_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',area=".$area.",telenum='".$telenum."',email='".$email."',photo='".$filename."'";
			$sql.=(''==$age)?"":",age=".$age;
			$sql.=(''==$height)?"":",height=".$height;
			$sql.=(''==$weight)?"":",weight=".$weight;
			$sql.=(''==$certitype)?"":",certitype=".$certitype;
			$sql.=",certinum='".$certinum."'";
			$sql.=",address='".$address."'";
			$sql.=",postcode='".$postcode."'";
			$sql.=",other='".$other."'";
			$sql.=",english='".$english."'";
			$sql.=",putonghua='".$putonghua."'";
			$sql.=",intro='".$intro."'";
			$sql.=",addtime=".time();
			if($db->sql_query($sql))
			{
				$area_arr = array('','�в�','�ϲ�','����');
				$certi_arr=array('','���֤','ѧ��֤','����');
				$info_arr=array(
					array("���",$db->sql_nextid()),
					array("��ѡ��������",$blogname),
					array("�������ӵ�ַ",$blogurl),
					array("��ʵ����",$realname),
					array("����",$age),
					array("���",$height),
					array("����",$weight),
					array("��������",$area_arr[$area]),
					array("֤������",$certi_arr[$area]),
					array("֤������",$certinum),
					array("��ϵ��ַ",$address),
					array("�ʱ�",$postcode),
					array("��ϵ�绰",$telenum),
					array("E_mail",$email),
					array("������ϵ��ʽ",$other),
					array("Ӣ��ˮƽ",$english),
					array("��ͨ��ˮƽ",$putonghua),
					array("�����س�",$intro),
					array("��Ƭ",'<img src="http://mm.bokee.com/2007/mm2007/photo/'.$area.'/'.$filename.'" />'));
				
				mailto($email,'�ڶ�����Ů���ʹ�������ȷ����',$info_arr,'');
				$tpl->assign_vars(array(
					"MSGTITLE" => '�������ύ�ɹ�!',
					"MSGTEXT" => '<p style="text-indent:2em;font-size:14px;line-height:200%;">��л���μӵڶ�����Ů���ʹ��������Ѿ��ɹ�������ϵͳ�ѷ���һ��ȷ���ʼ�������д��email��ַ ����ע��鿴�������ľ��������������κ����⣬��������ϵ�����޸ģ�</p><p style="text-indent:2em;font-size:14px;line-height:200%;">�������뽫������˶����У��������ʱ��Ϊһ�������գ��������ʻ��޸��������µ�010-51818811-3232 �����ʼ�haoranzhang@bokee-inc.com�������Ϻ����һ�����ȷ���ʼ��ٴη��͸����������ĵȴ�����ע��鿴�ʼ���</p><br /><br />',
					"MSGLINK" => '<a href="../">������ҳ</a><br />'
					));
			}
			else
			{
				$tpl->assign_vars(array(
					"MSGTITLE" => '������!',
					"MSGTEXT" => '�ܱ�Ǹ������ĳЩδ֪ԭ�����ı��������ύʧ���ˣ�����ϵ����Ա�򷵻�����',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">����</a>'
					));
			}
		}
		else
		{
			$tpl->assign_vars(array(
					"MSGTITLE" => '������!',
					"MSGTEXT" => '��Ƭ�ϴ�����!',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">����</a>'
					));
		}
	}
	else
	{
		$tpl->assign_vars(array(
					"MSGTITLE" => '������!',
					"MSGTEXT" => '��û���ύ��Ƭ,�����Ǳ������������!�뷵�������ύ!',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">����</a>'
					));
	}
}
else
{
	header("location:../");
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
