<html>
<head>
<title>杭州公交线路查询－手机版</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="description" content="杭州公交汽车线路查询，与杭州公交集团网站数据同步" />
<meta name="keywords" content="杭州 公交车 线路 换乘 查询 手机适用" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_line" />
输入线路编号：<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="查询线路信息" />
</form>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_site" />
输入站点名称：<input type="text" name="site_name" size="6" value="<?=$_REQUEST['site_name']?>" /><input type="submit" value="查询经过线路" />
</form>
<form name="form1" action="" method="get">
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
	else
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
				echo '：<a href="?action=query_site&site_name='.$_REQUEST['site_name'].'&id='.$site_arr['id'].'">'.$site_arr['name'].'</a><br />';
			}
		}
	}
}
if('query_transfer'==$action)
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");

	include_once($root_path."trans_search.php");
	$term1=$_REQUEST['term1'];
	$term2=$_REQUEST['term2'];
	$s_sid=getSid($term1);
	$e_sid=getSid($term2);
	$result=findNext($s_sid);
	getResult($result);
}
echo '<br /><br /><br />数据来源于杭州公交集团网站(http://www.hzbus.com.cn)，数据采集日期:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">我的BLOG</a>
</body>
</html>