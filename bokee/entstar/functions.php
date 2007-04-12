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
	$value=$db->sql_fetchfield(0,0,$result0);
//	$db->sql_freeresult($result0);
	return $value;
}
//参数分别为模版区块名,sql语句,是否需要递增计数
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
//参数仅为sql语句
function assign_vars_by_sql($sql) 
{
	global $db,$tpl;
	$result=$db->sql_query($sql);
	$row=$db->sql_fetchrow($result);
	$tpl->assign_vars($row);
}

/**
*添加留言时用到,实体化html代码
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
	if(strrpos($ip,',')>0)
	{
		$ip=substr($ip,0,strrpos($ip,','));//截取真实IP，去掉代理IP
	}
	return($ip);
}
?>