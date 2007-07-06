<?php
/**
*根据id读取table表中的特定列field的值
*/
function getField($id,$field,$table)
{
	global $db;
	$sql0="select ".$field." from ".$table." where id=".$id;
	$result0=$db->sql_query($sql0);
	$value=$db->sql_fetchfield(0,0,$result0);
//	$db->sql_freeresult($result0);
	return $value;
}
//参数分别为：模版区块名,sql语句,是否需要递增计数
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

function getBlogID()
{
	$bokie=split(',',base64_decode($_COOKIE['bokie']));
	$cBlogID=substr($bokie[1],0,strpos($bokie[1],'.'));
	return $cBlogID;
}

?>