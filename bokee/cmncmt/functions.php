<?php
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
function format2($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace("\r\n"," ",$text);
	$text=str_replace("\n"," ",$text);
	$text=addslashes($text);
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
	if(strrpos($ip,',')>0)
	{
		$ip=substr($ip,0,strrpos($ip,','));//截取真实IP，去掉代理IP
	}
	return($ip);
}

function getBlogID()
{
	$bokie=split(',',base64_decode($_COOKIE['bokie']));
	$cBlogID=substr($bokie[1],0,strpos($bokie[1],'.'));
	return $cBlogID;
}

function getBlogPhoto($username)
{
	$blogPhoto='http://'.$username.'.bokee.com/inc/logo_s.png';
	$file=file_get_contents($blogPhoto);
	if(strlen($file)>100)
	{
		return $blogPhoto;
	}
	else
	{
		return '';
	}
}
?>