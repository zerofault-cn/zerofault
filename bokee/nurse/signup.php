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
		echo '已经报名了';
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
				echo '<script>alert("此博客链接地址已经报名了!不能重复报名");</script>';
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
					"参赛编号"=>sprintf("%05d",$db->sql_nextid()),
					"参赛博客名称"=>$blogname,
					"博客链接地址"=>$blogurl,
					"真实姓名"=>$realname,
					"年龄"=>''==$age?'未填写':$age,
					"身高"=>''==$height?'未填写':$height,
					"体重"=>''==$weight?'未填写':$weight,
					"报名地区"=>$area_arr[$area],
					"所在医院"=>$hospital,
					"证件号码"=>''==$IDcard?'未填写':$IDcard,
					"联系地址"=>$address,
					"邮编"=>''==$postcode?'未填写':$postcode,
					"联系电话"=>$phone,
					"E_mail"=>$email,
					"其他联系方式"=>''==$other?'未填写':$other,
					"个人特长"=>''==$intro?'未填写':$intro,
					"照片"=>'<img src="http://nurse.bokee.com/nurse/photo/'.$area.'/'.$filename.'" />'
				);
				
				mailto($email,'感动社会十大优秀护士评选活动确认信',$info_arr,'');
		/*		$tpl->assign_vars(array(
					"MSGTITLE" => '报名表提交成功!',
					"MSGTEXT" => '<p style="text-indent:2em;font-size:14px;line-height:200%;">感谢您参加第二届美女博客大赛，您已经成功报名，系统已发出一封确认邮件到您填写的email地址 ，请注意查看，如果你的觉得您的资料有任何问题，请立即联系我们修改！</p><p style="text-indent:2em;font-size:14px;line-height:200%;">报名申请将进入审核队列中！博客审核时间为一个工作日，如有疑问或修改资料请致电010-51818811-3232 或者邮件haoranzhang@bokee-inc.com，审核完毕后会有一封审核确认邮件再次发送给您，请耐心等待，并注意查看邮件！</p><br /><br />',
					"MSGLINK" => '<a href="../">返回首页</a><br />'
					));*/
				echo '<script>alert("报名表提交成功!您的邮箱将收到一封系统确认信，请注意查看并耐心等待审核！");parent.location.href="../";</script>';
				exit;
			}
			else
			{
				echo $sql;
				echo '<script>alert("数据库错误，请重试或联系客服！");</script>';
				exit;
			}
		}
		else
		{
			echo '<script>alert("照片上传错误，请重试或联系客服！");</script>';
			exit;
		}
	}
	else
	{
		echo '<script>alert("您没有上传照片,请重新提交!");</script>';
		exit;
	}
}
$db->sql_close();
//$tpl->pparse('body');
//$tpl->destroy();
?>
