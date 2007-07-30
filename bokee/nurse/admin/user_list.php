<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");

require_once($root_path."templates/admin/left.htm");//��߲˵�

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//һЩ����
$testmail=0;//��ʾ�����Ͳ����ʼ����İ�ť
$pageitem=12;//ÿҳ��ʾ����
$passbtn_arr=array('ͨ�����','ȡ�����');

$page=$_REQUEST["page"];//ҳ��

//�������еı���
$s_id=$_REQUEST["s_id"];
$s_blogname=$_REQUEST['s_blogname'];
$s_realname=$_REQUEST['s_realname'];
$s_area=$_REQUEST['s_area'];
$s_blogurl=$_REQUEST['s_blogurl'];
$s_city=$_REQUEST['s_city'];

//������ʾ����û���δ����û�
if(''!=$_REQUEST['s_pass'])
{
	$s_pass=$_REQUEST['s_pass'];
}
elseif(''!=$_SESSION['s_pass'])
{
	$s_pass=$_SESSION['s_pass'];
}
else
{
	$s_pass=0;//Ĭ����ʾδ���
}
if(!session_is_registered('s_pass'))
{
	session_register('s_pass');//�������������ʹ��
}
$_SESSION['s_pass']=$s_pass;
//���ð���ʲô��ʽ������ʾ
if(''!=$_REQUEST['order'])
{
	$order=$_REQUEST['order'];
}
elseif(''!=$_SESSION['order'])
{
	$order=$_SESSION['order'];
}
else
{
	$order='id';//Ĭ�ϰ�id����
}
if(!session_is_registered('order'))
{
	session_register('order');//�������������ʹ��
}
$_SESSION['order']=$order;

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
	$old=0;//oldΪ1ʱ��ʾ��ʾһ����Ϊͨ����˵�
}
if(!session_is_registered('old'))
{
	session_register('old');//�������������ʹ��
}
$_SESSION['old']=$old;

if($s_area>0)
{
	$sqlext=" and area=".$s_area;
}
if(''!=$_REQUEST['submit'])//��������
{
	$sql="select * from user_info where pass=".$s_pass.$sqlext." and (0";
	if(''!=$s_id)
	{
		$sql.=" or id=".$s_id;
	}
	if(''!=$s_blogname)
	{
		$sql.= " or binary blogname like '%".$s_blogname."%'";
	}
	if(''!=$s_blogurl)
	{
		$sql.= " or binary blogurl like '%".$s_blogurl."%'";
	}
	if(''!=$s_realname)
	{
		$sql.=" or realname like '%".$s_realname."%'";
	}
	if(''!=$s_city)
	{
		$sql.=" or address like '%".$s_city."%'";
	}
	$sql.=") order by ".$order." desc,id";
}
else
{
	if($old==1)
	{
		$sqlext.=" and addtime<".(time()-7*24*3600);
	}
	elseif($pass==0)
	{
		$sqlext.=" and addtime>=".(time()-7*24*3600);
	}
	$sql="select * from user_info where pass=".$s_pass.$sqlext." order by ".$order." desc,id desc";
}
echo $sql;
echo '<br>';
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_id=".$s_id."&s_blogname=".$s_blogname."&s_blogurl=".$s_blogurl."&s_realname=".$s_realname."&s_city=".$s_city."&s_area=".$s_area."&order=".$order);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);

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
	$id=$row["id"];
	$blogurl=$row['blogurl'];

	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $id,
		"AREA" => $row['area'],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['area'].'/'.$row['photo'],
		"BLOGURL" => substr($blogurl,7),
		"ADDTIME" => date("y/m/d H:i",$row["addtime"]),
		"AREANAME" => $area_arr[$row['area']],
		"NETVOTE" => $row['netvote'],
		"SMSVOTE" => $row['allvote'],
		"COMM_COUNT" => $row['comm_count'],
		"PASSBTN" => $passbtn_arr[$row['pass']],//���ð�ť����
		"PASSBTNSTYLE" => $row['pass']?'display:none':'',//���ð�ť��ʾ���
		"BGCOLOR" => $bgcolor,//�����еı���ɫ����
		));
}
for($i=0;$i<sizeof($area_arr);$i++)
{
	$tpl->assign_block_vars('subnavi',array(
		"I"=>$i,
		"COLOR"=>($i==$s_area)?'#6699FF':'',
		"AREA"=>$area_arr[$i],
		"COUNT"=>$total
		));
}
$areaOption_str='';
for($i=0;$i<sizeof($area_arr);$i++)
{
	$areaOption_str .= '<option value='.$i;
	if($i==$s_area)
	{
		$areaOption_str .= ' selected';
	}
	$areaOption_str.= '>'.$area_arr[$i].'</option>';
}
$tpl->assign_vars(array(
	"AREAOPTION" => $areaOption_str,
	"S_PASS" => $s_pass,
	"BTNFUNC" => $is_admin?'':' disabled',//���ð�ť���÷�
	"DISPLAY" => $s_pass?'none':'',//���á�ͨ����ˡ���ť�Ƿ�ɼ�

	"COLOR20" => (0==$s_pass&&0==$old&&'id'==$order)?'#99CCFF':'',
	"COLOR21" => (1==$s_pass&&0==$old&&'id'==$order)?'#99CCFF':'',
	"COLOR22" => (1==$s_pass&&0==$old&&'smsvote'==$order)?'#99CCFF':'',
	"COLOR23" => (0==$s_pass&&1==$old&&'id'==$order)?'#99CCFF':'',
	"PAGE" => $pagenav
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>