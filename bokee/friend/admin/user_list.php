<?
include_once "session.php";
define('IN_MATCH', true);

$root_path ="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//��߲˵�

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//һЩ����
$pageitem=10;//ÿҳ��ʾ����

$page=$_REQUEST["page"];//ҳ��

//������ʾ����û���δ����û�
if(''!=$_REQUEST['pass'])
{
	$pass=$_REQUEST['pass'];
}
elseif(''!=$_SESSION['pass'])
{
	$pass=$_SESSION['pass'];
}
else
{
	$pass=0;//Ĭ����ʾδ���
}
if(!session_is_registered('pass'))
{
	session_register('pass');//�������������ʹ��
}
$_SESSION['pass']=$pass;
//���ð���ʲô��ʽ������ʾ
if(''!=$_REQUEST['sex'])
{
	$sex=$_REQUEST['sex'];
}
elseif(''!=$_SESSION['sex'])
{
	$sex=$_SESSION['sex'];
}
else
{
	$sex='0';//Ĭ�ϰ�id����
}
if(!session_is_registered('sex'))
{
	session_register('sex');//�������������ʹ��
}
$_SESSION['sex']=$sex;

//������ʾ������
if(''!=$_REQUEST['old'])
{
	$old=$_REQUEST['old'];
}
elseif(''!=$_SESSION['old'])
{
	$old=$_SESSION['old'];
}
else
{
	$old=0;//Ĭ�ϰ�id����
}
if(!session_is_registered('old'))
{
	session_register('old');//�������������ʹ��
}
$_SESSION['old']=$old;

//�������еı���
$s_id=$_REQUEST["s_id"];
$s_blogname=$_REQUEST['s_blogname'];
$s_realname=$_REQUEST['s_realname'];

if(''!=$_REQUEST['submit'])
{
	$sql="select * from user_info where 0";
	if(''!=$s_id)
	{
		$sql.=" or id=".$s_id;
	}
	if(''!=$s_blogname)
	{
		$sql.= " or blogname like '%".$s_blogname."%'";
	}
	if(''!=$s_realname)
	{
		$sql.=" or realname like '%".$s_realname."%'";
	}
	$sql.=" order by id desc";
}
else
{
	if($sex>0)
	{
		$sql_ext=" and sex=".$sex;
	}
	if($old>0)
	{
		$sql_ext.=" and addtime<=".(time()-3*24*3600);
	}
	elseif($pass==0)
	{
		$sql_ext.=" and addtime>".(time()-3*24*3600);
	}
	if($pass==2)
	{
		$order=" updatetime desc";
	}
	else
	{
		$order=" id desc";
	}
	$sql="select * from user_info where pass=".$pass.$sql_ext." order by ".$order;
}
echo $sql;
echo '<br />';
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_id=".$s_id."&s_blogname=".$s_blogname."&s_realname=".$s_realname."&pass=".$pass."&sex=".$sex."&old=".$old);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
$passbtn_arr=array('ͨ�����','�Ƽ�','�ٴ��Ƽ�');
$i=($page-1)*$pageitem;//���
while($row=$db->sql_fetchrow($result))
{
	$i++;
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
		"ID" => $row["id"],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['photo'],
		"BLOGURL" => substr($row["blogurl"],7),
		"ADDTIME" => date("y/m/d H:i",$row["addtime"]),
		"VOTE" => $row['vote'],
		"PASSBTN" => $passbtn_arr[$row['pass']],
		"PASSBTNDISABLED"=>(2==$row['pass'])?'':'',
		"BGCOLOR" => $bgcolor,//�����еı���ɫ����
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"COLOR10" => (0==$pass && 0==$old)?'#99CCFF':'',
	"COLOR11" => (1==$pass && 0==$old)?'#99CCFF':'',
	"COLOR12" => (2==$pass && 0==$old)?'#99CCFF':'',
	"COLOR13" => (0==$pass && 1==$old)?'#99CCFF':'',
	"COLOR20" => (0==$sex)?'#6699FF':'',
	"COLOR21" => (1==$sex)?'#6699FF':'',
	"COLOR22" => (2==$sex)?'#6699FF':'',
	"COUNT" => '('.$total.'��)',
	"PAGE" => $pagenav
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>