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
$blogname	= $_REQUEST['blogname'];
$blogurl	= $_REQUEST['blogurl'];
$realname	= $_REQUEST['realname'];
$cardtype	= $_REQUEST['cardtype'];
$cardnum	= $_REQUEST['cardnum'];
$addr		= $_REQUEST['addr'];
$post		= $_REQUEST['post'];
$phone		= $_REQUEST['phone'];
$email		= $_REQUEST['email'];
$other		= $_REQUEST['other'];
$vouth		= $_REQUEST['vouth'];
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
	
	$sql="update user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',cardtype=".$cardtype.",cardnum='".$cardnum."',addr='".$addr."',post='".$post."',phone='".$phone."',email='".$email."',other='".$other."',vouth='".$vouth."'".$sqlext." where id=".$id;
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

	$cardOption_str='';
	$cardtype_arr=array('����','���֤','ѧ��֤');
	for($i=0;$i<sizeof($cardtype_arr);$i++)
	{
		$cardOption_str .= '<option value="'.$i.'"';
		if($i==$row['cardtype'])
		{
			$cardOption_str .= ' selected';
		}
		$cardOption_str .= '>'.$cardtype_arr[$i].'</option>';
	}
	$vouthtype_arr=array('δ�Ƽ�','���Ƽ�');
	$vouthOption_str='';
	for($i=0;$i<sizeof($vouthtype_arr);$i++)
	{
		$vouthOption_str.='<option value="'.$i.'"';
		if($i==$row['vouth'])
		{
			$vouthOption_str.=' selected';
		}
		$vouthOption_str.='>'.$vouthtype_arr[$i].'</option>';
	}
	$tpl->assign_vars(array(
		"ID" => $id,
		"BLOGNAME" => $row['blogname'],
		"BLOGURL" => $row['blogurl'],
		"REALNAME" => $row['realname'],
		"CARDOPTION" => $cardOption_str,
		"CARDNUM" => $row['cardnum'],
		"ADDR" => $row['addr'],
		"POST" => $row['post'],
		"PHONE" => $row['phone'],
		"EMAIL" => $row['email'],
		"OTHER" => $row['other'],
		"ADDTIME" => date("y-m-d H:i",$row['addtime']),
		"VOUTHOPTION" => $vouthOption_str,
		"VOUTH_TIME" => (0==$row['vouth_time'])?'δ�Ƽ�':date("y-m-d H:i",$row['vouth_time']),
		"PHOTO" => $row['photo']
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
