<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");

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
$certitype	= $_REQUEST['certitype'];
$certinum	= $_REQUEST['certinum'];
$address	= $_REQUEST['address'];
$postcode	= $_REQUEST['postcode'];
$telenum	= $_REQUEST['telenum'];
$email		= $_REQUEST['email'];
$other		= $_REQUEST['other'];
$english	= $_REQUEST['english'];
$putonghua	= $_REQUEST['putonghua'];
$intro		= $_REQUEST['intro'];
$oldphoto	= $_REQUEST['oldphoto'];
$photo		= $_FILES['photo'];

if(''!=$_REQUEST['submit'])
{
	if($photo['size']>0)
	{
		$filename=date("YmdHis").strrchr($photo['name'],".");//如果重新上传了照片,则分配新的文件名,避免缓存
		@unlink('../photo/'.$oldarea.'/'.$oldphoto);//删除旧照片
		if(copy($photo['tmp_name'],'../photo/'.$area.'/'.$filename))
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
	$sql="update mm_info set blogname='".$blogname."',blogurl='".$blogurl."',realname='".trim($realname)."',area=".$area.",telenum='".$telenum."',email='".$email."'".$sqlext;
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
	$sql="select * from mm_info where id=".$id;

	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);

	$certitype_arr=array('','身份证','学生证','其他');
	$area_arr = array('','中部','南部','北部');

	$areaOption_str='';
	$certiOption_str='';
	for($i=1;$i<sizeof($area_arr);$i++)
	{
		$areaOption_str .= '<option value='.$i;
		if($i==$row['area'])
		{
			$areaOption_str .= ' selected';
		}
		$areaOption_str.= '>'.$area_arr[$i].'</option>';
	}
	for($i=1;$i<sizeof($certitype_arr);$i++)
	{
		$certiOption_str .= '<option value='.$i;
		if($i==$row['certitype'])
		{
			$certiOption_str .= ' selected';
		}
		$certiOption_str .= '>'.$certitype_arr[$i].'</option>';
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
		CERTIOPTION => $certiOption_str,
		CERTINUM => $row['certinum'],
		ADDRESS => $row['address'],
		POSTCODE => $row['postcode'],
		TELENUM => $row['telenum'],
		EMAIL => $row['email'],
		OTHER => $row['other'],
		ENGLISH => $row['english'],
		PUTONGHUA => $row['putonghua'],
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
