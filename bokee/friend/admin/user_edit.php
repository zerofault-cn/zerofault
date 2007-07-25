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
$sex		= $_REQUEST['sex'];
$address	= $_REQUEST['address'];
$post		= $_REQUEST['post'];
$phone		= $_REQUEST['phone'];
$email		= $_REQUEST['email'];
$other		= $_REQUEST['other'];
$oldphoto	= $_REQUEST['oldphoto'];
$pass		= $_REQUEST['pass'];
$photo		= $_FILES['photo'];

if(''!=$_REQUEST['submit'])
{
	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");//如果重新上传了照片,则分配新的文件名,避免缓存
		if(copy($photo['tmp_name'],'../photo/'.$filename))
		{
			@unlink('../photo/'.$oldphoto);//删除旧照片
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
	
	$sql1="update user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',sex=".$sex.",address='".$address."',post='".$post."',phone='".$phone."',email='".$email."',other='".$other."',pass=".$pass.$sqlext." where id=".$id;
	$sql2="update user_info_ext set sex=".$sex." where id=".$id;
	if($upload_flag && $db->sql_query($sql1)&& $db->sql_query($sql2))
	{
		$tpl->assign_vars(array("script_str" => 'alert("修改成功!");window.close();opener.location.reload();'));
	}
	elseif(0==$upload_flag)
	{
		echo "图片上传错误";
	}
	else
	{
		echo "sql错误<br />";
		echo $sql;
	}
}
else
{
	$sql="select * from user_info where id=".$id;

	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);

	$cardtype_arr=array('其他','身份证','学生证');

	$cardOption_str='';
	for($i=0;$i<sizeof($cardtype_arr);$i++)
	{
		$cardOption_str .= '<option value='.$i;
		if($i==$row['cardtype'])
		{
			$cardOption_str .= ' selected';
		}
		$cardOption_str .= '>'.$cardtype_arr[$i].'</option>';
	}
	$tpl->assign_vars(array(
		"ID" => $id,
		"BLOGNAME" => $row['blogname'],
		"BLOGURL" => $row['blogurl'],
		"REALNAME" => $row['realname'],
		"SEX"=>$row['sex'],
		"ADDRESS" => $row['address'],
		"POST" => $row['post'],
		"PHONE" => $row['phone'],
		"EMAIL" => $row['email'],
		"OTHER" => $row['other'],
		"ADDTIME" => date("y-m-d H:i",$row['addtime']),
		"PASS"=>$row['pass'],
		"PHOTO" => $row['photo']
		));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
