<html>
<head>
<title>杭州公交线路查询－手机适用版</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="description" content="杭州公交汽车线路查询，与杭州公交集团网站数据同步" />
<meta name="keywords" content="杭州 公交车 线路 换乘 查询 手机适用" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" action="index.php" method="get">
<input type="hidden" name="action" value="query_line" />
输入线路编号：<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="查询线路信息" />
</form>
<form name="form1" action="index.php" method="get">
<input type="hidden" name="action" value="query_site" />
输入站点名称：<input type="text" name="site_name" size="6" value="<?=$_REQUEST['site_ame']?>" /><input type="submit" value="查询经过线路" />
</form>
<form name="form1" action="index.php" method="get">
<input type="hidden" name="action" value="query_transfer" />
输入起点：<input type="text" name="from" size="8" value="<?=$_REQUEST['from']?>" /><br />
输入终点：<input type="text" name="to" size="8" value="<?=$_REQUEST['to']?>" /><input type="submit" value="换乘查询" />
</form>
<?php
$action=$_REQUEST['action'];
if(!empty($action))
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");
}
if('query_line'==$action)
{
	include_once($root_path."line_info.php");
	if(!empty($_REQUEST['id']))
	{
		line_info($_REQUEST['id']);
	}
	else
	{
		$line_name=trim($_REQUEST['line_name']);
		if(!empty($line_name)>0)
		{
			$sql1="select * from ".$line_table." l where l.number='".$line_name."' or l.name='".$line_name."'";
			$result1=$db->sql_query($sql1);
			while($row1=$db->sql_fetchrow($result1))
			{
				$line_list[]=$row1;
			}
			if(count($line_list)==0)
			{
				echo '暂时没有此线路的信息<br />';
			}
			else
			{
				foreach($line_list as $key=>$line_arr)
				{
					line_info($line_arr['id']);
				}
			}
		}
	}
}
if('query_site'==$action)
{
	include_once($root_path."site_info.php");
	if(!empty($_REQUEST['id']))
	{
		site_info($_REQUEST['id']);
	}
	elseif(strlen(trim($_REQUEST['site_name']))>0)
	{
		$sql="select * from ".$site_table." where binary name like '%".$_REQUEST['site_name']."%'";
		$result=$db->sql_query($sql);
		while($row=$db->sql_fetchrow($result))
		{
			$site_list_arr[]=$row;
		}
	//	checkvar($site_list_arr);
		if(count($site_list_arr)==0)
		{
			echo '暂时没有经过此处的公交线路!';
		}
		else if(count($site_list_arr)==1)
		{
			site_info($site_list_arr[0]['id']);
		}
		else
		{
			echo '您查询的关键字有多个可能，请选择最接近的一个：<br />';
			foreach($site_list_arr as $key=>$site_arr)
			{
				printf("%2d",$key+1);
				echo '：<a href="site_id_'.$site_arr['id'].'.html">'.$site_arr['name'].'</a><br />';
			}
		}
	}
}
if('query_transfer'==$action)
{
	include_once($root_path."trans_search.php");
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$from_sid=$_REQUEST['from_sid'];
	$to_sid=$_REQUEST['to_sid'];
	
	if(strlen($from)>0 && strlen($to)>0)
	{
		$sql1="select * from ".$site_table." where binary name like '%".$from."%'";
		$result1=$db->sql_query($sql1);
		while($row1=$db->sql_fetchrow($result1))
		{
			$from_site_list_arr[]=$row1;
		}
		$sql2="select * from ".$site_table." where binary name like '%".$to."%'";
		$result2=$db->sql_query($sql2);
		while($row2=$db->sql_fetchrow($result2))
		{
			$to_site_list_arr[]=$row2;
		}
		if(count($from_site_list_arr)==0 || count($to_site_list_arr)==0)
		{
			echo '暂时没有经过此起点或终点的公交线路!';
		}
		elseif(count($from_site_list_arr)==1 && count($to_site_list_arr)==1)
		{
			$from_sid = $from_site_list_arr[0]['id'];
			$to_sid   = $to_site_list_arr[0]['id'];
		}
		else
		{
			echo '<form action="index.php" method="get">';
			echo '<input type="hidden" name="action" value="query_transfer" />';
			echo '您查询的起点或终点有多个可能，请选择最准确的一个：<br />';
			echo '请选择起点：';
			foreach($from_site_list_arr as $key=>$site_arr)
			{
				echo '<input type="radio" name="from_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			echo '<hr>请选择终点：';
			foreach($to_site_list_arr as $key=>$site_arr)
			{
				echo '<input type="radio" name="to_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			echo '<br /><input type="submit" value="开始精确查询" />';
			echo '</form>';
		}
		
		
	}
	if($from_sid>0 && $to_sid>0)
	{
		getResult($from_sid,$to_sid);
	}
}
echo '<br /><br /><br />数据来源于杭州公交集团网站(http://www.hzbus.com.cn)，数据采集日期:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">我的BLOG</a>
</body>
</html>