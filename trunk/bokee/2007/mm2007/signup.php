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
				echo '<script>alert("此博客链接地址已经注册了!不能重复注册");history.back();</script>';
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
				$area_arr = array('','中部','南部','北部');
				$certi_arr=array('','身份证','学生证','其他');
				$info_arr=array(
					array("编号",$db->sql_nextid()),
					array("参选博客名称",$blogname),
					array("博客链接地址",$blogurl),
					array("真实姓名",$realname),
					array("年龄",$age),
					array("身高",$height),
					array("体重",$weight),
					array("报名地区",$area_arr[$area]),
					array("证件种类",$certi_arr[$area]),
					array("证件号码",$certinum),
					array("联系地址",$address),
					array("邮编",$postcode),
					array("联系电话",$telenum),
					array("E_mail",$email),
					array("其他联系方式",$other),
					array("英语水平",$english),
					array("普通话水平",$putonghua),
					array("个人特长",$intro),
					array("照片",'<img src="http://mm.bokee.com/2007/mm2007/photo/'.$area.'/'.$filename.'" />'));
				
				mailto($email,'第二届美女博客大赛报名确认信',$info_arr,'');
				$tpl->assign_vars(array(
					"MSGTITLE" => '报名表提交成功!',
					"MSGTEXT" => '<p style="text-indent:2em;font-size:14px;line-height:200%;">感谢您参加第二届美女博客大赛，您已经成功报名，系统已发出一封确认邮件到您填写的email地址 ，请注意查看，如果你的觉得您的资料有任何问题，请立即联系我们修改！</p><p style="text-indent:2em;font-size:14px;line-height:200%;">报名申请将进入审核队列中！博客审核时间为一个工作日，如有疑问或修改资料请致电010-51818811-3232 或者邮件haoranzhang@bokee-inc.com，审核完毕后会有一封审核确认邮件再次发送给您，请耐心等待，并注意查看邮件！</p><br /><br />',
					"MSGLINK" => '<a href="../">返回首页</a><br />'
					));
			}
			else
			{
				$tpl->assign_vars(array(
					"MSGTITLE" => '出错了!',
					"MSGTEXT" => '很抱歉，由于某些未知原因，您的报名申请提交失败了，请联系管理员或返回重试',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">返回</a>'
					));
			}
		}
		else
		{
			$tpl->assign_vars(array(
					"MSGTITLE" => '出错了!',
					"MSGTEXT" => '照片上传错误!',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">返回</a>'
					));
		}
	}
	else
	{
		$tpl->assign_vars(array(
					"MSGTITLE" => '出错了!',
					"MSGTEXT" => '您没有提交照片,而这是报名手续必须的!请返回重新提交!',
					"MSGLINK" => '<a href="#" onclick="javascript:history.back()">返回</a>'
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
