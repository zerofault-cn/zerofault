<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."profile.inc.php");

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_edit.htm'));

$id			= $_REQUEST['id'];
$blogname	= $_REQUEST['blogname'];
$blogurl	= $_REQUEST['blogurl'];
$realname	= $_REQUEST['realname'];
$age		= $_REQUEST['age'];
$height		= $_REQUEST['height'];
$weight		= $_REQUEST['weight'];
$area		= $_REQUEST['area'];
$oldarea	= $_REQUEST['oldarea'];
$hospital	= $_REQUEST['hospital'];
$IDcard		= $_REQUEST['IDcard'];
$address	= $_REQUEST['address'];
$postcode	= $_REQUEST['postcode'];
$phone		= $_REQUEST['telenum'];
$email		= $_REQUEST['email'];
$other		= $_REQUEST['other'];
$intro		= $_REQUEST['intro'];
$oldphoto	= $_REQUEST['oldphoto'];
$photo		= $_FILES['photo'];

if(''!=$_REQUEST['submit'])
{
	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");//如果重新上传了照片,则分配新的文件名,避免缓存
		if(copy($photo['tmp_name'],'../photo/'.$area.'/'.$filename))
		{
			@unlink('../photo/'.$oldarea.'/'.$oldphoto);//删除旧照片
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
		if($oldarea!=$area)
		{
			if(rename('../photo/'.$oldarea.'/'.$oldphoto,'../photo/'.$area.'/'.$oldphoto))
			{
				$upload_flag=1;
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
	}
	$sql="update user_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',area=".$area.",hospital='".$hospital."',phone='".$phone."',email='".$email."'".$sqlext;
	$sql.=(''==$age)?"":",age=".$age;
	$sql.=(''==$height)?"":",height=".$height;
	$sql.=(''==$weight)?"":",weight=".$weight;
	$sql.=(''==$IDcard)?"":",IDcard='".$IDcard."'";
	$sql.=",address='".$address."'";
	$sql.=",postcode='".$postcode."'";
	$sql.=",other='".$other."'";
	$sql.=",intro='".$intro."'";
	$sql.=" where id=".$id;
	if($upload_flag && $db->sql_query($sql))
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


	$areaOption_str='';
	for($i=1;$i<sizeof($area_arr);$i++)
	{
		$areaOption_str .= '<option value='.$i;
		if($i==$row['area'])
		{
			$areaOption_str .= ' selected';
		}
		$areaOption_str.= '>'.$area_arr[$i].'</option>';
	}
	$tpl->assign_vars(array(
		ID => $id,
		BLOGNAME => $row['blogname'],
		BLOGURL => $row['blogurl'],
		REALNAME => $row['realname'],
		AGE => $row['age'],
		HEIGHT => $row['height'],
		WEIGHT => $row['weight'],
		AREA => $row['area'],
		AREAOPTION => $areaOption_str,
		HOSPITAL=>$row['hospital'],
		IDCARD => $row['IDcard'],
		ADDRESS => $row['address'],
		POSTCODE => $row['postcode'],
		PHONE => $row['phone'],
		EMAIL => $row['email'],
		OTHER => $row['other'],
		INTRO => $row['intro'],
		ADDTIME => date("y-m-d H:i",$row['addtime']),
		VOTE => $row['vote'],
		PHOTO => $row['photo']
		));
	$tpl->assign_vars(array("BTNFN" => $btnfn));
}
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>
