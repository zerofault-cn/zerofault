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
	$value=$db->sql_fetchfield(0,0,$result0);
//	$db->sql_freeresult($result0);
	return $value;
}
//�����ֱ�Ϊģ��������,sql���,�Ƿ���Ҫ��������
function assign_block_vars_by_sql($block_name,$sql,$i=0)
{
	global $db,$tpl;
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		if($i>0)
		{
			$row["i"]=$i++;
		}
		$tpl->assign_block_vars($block_name, $row);
	}
}
//������Ϊsql���
function assign_vars_by_sql($sql) 
{
	global $db,$tpl;
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$tpl->assign_vars($row);
}

/**
*�������ʱ�õ�,ʵ�廯html����
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
	if(strrpos($ip,',')>0)
	{
		$ip=substr($ip,0,strrpos($ip,','));//��ȡ��ʵIP��ȥ������IP
	}
	return($ip);
}
?>