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
function getUserInfo($id)
{
	global $db;
	$sql="select user_info.blogname,user_info.blogurl,user_info.sex,user_info.photo,user_info_ext.location,user_info_ext.birthday from user_info,user_info_ext where user_info.id=".$id." and user_info_ext.id=".$id;
	$result=$db->sql_query($sql);
	return $row=$db->sql_fetchrow($result);
}

//��javascript��escape()������з����룬�������Ĵ��价��
function unescape($str,$charcode='utf-8'){
	$text = preg_replace_callback("/%u[0-9A-Za-z]{4}/",toUtf8,$str);
	return mb_convert_encoding($text, $charcode, 'utf-8');
}

function toUtf8($ar){
	foreach($ar as $val){
		$val = intval(substr($val,2),16);
		if($val < 0x7F){        // 0000-007F
			$c .= chr($val);
		}elseif($val < 0x800) { // 0080-0800
			$c .= chr(0xC0 | ($val / 64));
			$c .= chr(0x80 | ($val % 64));
		}else{                // 0800-FFFF
			$c .= chr(0xE0 | (($val / 64) / 64));
			$c .= chr(0x80 | (($val / 64) % 64));
			$c .= chr(0x80 | ($val % 64));
		}
	}
	return $c;
}
/**
*ת���ַ�����ĺ���
*��Ϊ��20.36���ύ�ı��еı�������utf-8�����,�������ݿ�ǰҪ��ת�룬תΪgbk��Ϊ�˾������ⶪʧ�ַ�
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
function generateOptions($field) 
{
	$field_arr_name=$field.'_arr';
	global ${$field_arr_name},$row2;
	$field_option_str='';
	for($i=0;$i<sizeof(${$field_arr_name});$i++)
	{
		if('location1'==$field)
		{
			$selected=substr($row2['location'],0,strpos($row2['location'],'-'));
		}
		else
		{
			$selected=$row2[$field];
		}
		$field_option_str.='<option value="'.${$field_arr_name}[$i].'"';
		if(${$field_arr_name}[$i]==$selected)
		{
			$field_option_str.=' selected';
		}
		$field_option_str.='>'.${$field_arr_name}[$i].'</option>';
	}
	return $field_option_str;
}
function generateCheckbox($field) 
{
	$field_arr_name=$field.'_arr';
	global ${$field_arr_name},$row2;
	$field_checkbox_str='';
	for($i=0;$i<sizeof(${$field_arr_name});$i++)
	{
		$field_checkbox_str.='<span style="width:100px;float:left;"><input type="checkbox" name="input_'.$field.'[]" value="'.${$field_arr_name}[$i].'"';
		$checked_arr=explode(',',$row2[$field]);
		for($j=0;$j<sizeof($checked_arr);$j++)
		{
			if(${$field_arr_name}[$i]==$checked_arr[$j])
			{
				$field_checkbox_str.=' checked';
			}
		}
		$field_checkbox_str.='/> '.${$field_arr_name}[$i].'</span>';
	}
	return $field_checkbox_str;
}
?>