<?
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
$curpage="tuijian";
include_once("header.php");//����ͷ��

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'add.htm'));
//�����ύ��
if(''!=$_POST['submit'])
{
	$username	=$_POST['realname'];
	$category	=$_POST['category'];
	$blogurl	=$_POST['blogurl'];
	$groupurl	=$_POST['groupurl'];
	$adder_name	=$_POST['adder_name'];
	$adder_contact=$_POST['adder_contact'];
	$photo		= $_FILES['photo'];

	$tmp_blogurl=substr($blogurl,7);
	if(strpos($tmp_blogurl,'/')>0)
	{
		$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));
	}
	$sql="select * from user_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
	if($db->sql_numrows($db->sql_query($sql)))
	{
		echo '<script>alert("�˲������ӵ�ַ�Ѿ�ע����!�����ظ�ע��");history.back();</script>';
		exit;
	}
	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");
		if(copy($photo['tmp_name'],'photo/'.$filename))
		{
			$sql="insert into user_info set realname='".$realname."',blogurl='".$blogurl."',groupurl='".trim($groupurl)."',category=".$category.",adder_name='".$adder_name."',adder_contact='".$adder_contact."',photo='".$filename."',addtime=".time();
			if($db->sql_query($sql))
			{
				$tpl->assign_vars(array("script_str" => 'alert("�Ƽ��ɹ�,�����Ƽ�����ͨ����˺������ҳ������ʾ!");window.location="index.php"'));
//				exit;
			}
			else
			{
				$tpl->assign_vars(array(
					"script_str" => 'alert("�����ݿ������,����ϵ����Ա");'
					));
			}
		}
		else
		{
			$tpl->assign_vars(array(
					"script_str" => 'alert("�ϴ���Ƭ��������,����ϵ����Ա");'
					));
		}
	}
	else
	{
		$tpl->assign_vars(array(
					"script_str" => 'alert("������,�������ύ��Ƭ,������");'
					));
	}
}
//�ύ���Դ������

$tpl->pparse('body');
$tpl->destroy();

include_once("footer.php")//����ҳ��
?>