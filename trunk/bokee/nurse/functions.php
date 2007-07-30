<?php
/**
*根据id读取mm_info中的特定列的值
*用来避免mm_comment与mm_info表的连接查询
*/
function getField($id,$field)
{
	global $db;
	$sql0="select ".$field." from user_info where id=".$id;
	$result0=$db->sql_query($sql0);
	$row=$db->sql_fetchrow($result0);
	$value=$row[$field];
	$db->sql_freeresult($result0);
	return $value;
}

/**
*转换字符编码的函数
*因为从20.36上提交的表单中的变量都是utf-8编码的,存入数据库前要先转为gb2312
*只有包含中文字符的需要转换,数字和英文不需要转换
*/
function conv($str)
{
	return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
}

/**
*字符串截取函数，
*保证得到的字符串中没有半个汉字的情况
*/
function substr_cut($str_cut,$length = 10)
{
	if (strlen($str_cut) > $length)
	{
		for($i=0; $i < $length; $i++)
		{
			if (ord($str_cut[$i]) > 128)
			{
				$i++;
			}
		}
	$str_cut = substr($str_cut,0,$i);
	}
	return $str_cut;
}
/**
*添加留言时用到
*/
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=str_replace("\r\n","",$text);
//	$text=str_replace("\n","",$text);
//	$text=addslashes($text);
	return $text;
}
/**
*获取用户IP
*/
function GetIP()
{
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	{
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	{
		$ip = getenv("REMOTE_ADDR");
	}
	elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else
	{
		$ip = "unknown";
	}
	$ip=substr($ip,0,strpos($ip,','));
	return($ip);
}
function checkLogin($blogurl)
{
	$bokie=split(',',base64_decode($_COOKIE['bokie']));
	$cBlogID=substr($bokie[1],0,strpos($bokie[1],'.'));
	$blogID=substr($blogurl,7,strpos($blogurl,'.')-7);
	if(''!=$cBlogID && ''!=$blogID && $cBlogID==$blogID)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function getBokie($field='blogID') 
{
	$bokie=split(',',base64_decode($_COOKIE['bokie']));
	if(sizeof($bokie)>0)
	{
		$blogURL=$bokie[1];
		$blogID=substr($blogURL,0,strpos($blogURL,'.'));
		$groupID=$bokie[4];
	}
	else
	{
		$blogURL='';
		$blogID='';
		$groupID=0;
	}
	return ${$field};
}
//注册或通过审核后给用户发邮件
function mailto($email,$subject,$info_arr,$id)
{
	global $root_path;
	include_once($root_path."includes/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->setPluginDir($root_path."includes/");//设置include目录，自己在原始class里面另加的
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->CharSet = 'gb2312';
	$mail->Encoding = 'base64';
	$mail->From = 'qian9128@163.com';
	$mail->FromName = 'nurse.bokee.com';
	$mail->Host = 'smtp.163.com';
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = $mail->From;
	$mail->Password = "8210150920";
	
	$mail->addAddress($email);
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	//生成html格式邮件内容
	if(is_array($info_arr) && sizeof($info_arr)>0)//报名确认信
	{
		$html=file_get_contents("mail1.inc.php");
		while(list($key,$val)=each($info_arr))
		{
			$body.='<div><span class="label">'.$key.'：</span><span class="value">'.$val.'</span></div>'."\r\n";
		}
		$html=str_replace('<!-- INFO -->',$body,$html);
	}
	else//通过审核后
	{
		$html=file_get_contents($root_path."mail2.inc.php");
		$html=str_replace('{ID}',$id,$html);
	}
	$mail->Body = $html;

	if(!$mail->Send())
	{
		echo "Mail send failed.\r\n";
		echo "Error message: ". $mail->ErrorInfo ."\r\n";
		return false;
	}
	else
	{
		echo("Send to &lt;".$email."&gt; successed.<br />\r\n");
		return true;
	}
}
//mailto('zerofault@gmail.com','邮件测试','','00001');
?>