<?php
/**
*����id��ȡmm_info�е��ض��е�ֵ
*��������mm_comment��mm_info������Ӳ�ѯ
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
*ת���ַ�����ĺ���
*��Ϊ��20.36���ύ�ı��еı�������utf-8�����,�������ݿ�ǰҪ��תΪgb2312
*ֻ�а��������ַ�����Ҫת��,���ֺ�Ӣ�Ĳ���Ҫת��
*/
function conv($str)
{
	return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
}

/**
*�ַ�����ȡ������
*��֤�õ����ַ�����û�а�����ֵ����
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
*�������ʱ�õ�
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
*��ȡ�û�IP
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
function mailto() {
}
?>