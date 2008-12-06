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
输入站点名称：<input type="text" name="site_name" size="6" value="<?=$_REQUEST['site_name']?>" /><input type="submit" value="查询所在线路" />
</form>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_transfer" />
输入起点：<input type="text" name="term1" size="8" value="<?=$_REQUEST['term1']?>" /><br />
输入终点：<input type="text" name="term2" size="8" value="<?=$_REQUEST['term2']?>" /><input type="submit" value="换乘查询" />
</form>
<?php
$action=$_REQUEST['action'];
if('query_line'==$action)
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");

	$line_name=intval(trim($_REQUEST['line_name']));
	if($line_name>0)
	{
		$sql1="select * from ".$line_table." l where l.number='".$line_name."' or l.name='".$line_name."'";
		$result1=$db->sql_query($sql1);
		while($row1=$db->sql_fetchrow($result1))
		{
			$line_arr[$row1['name']]['line_info']=$row1;
			$sql2="select r.direction as dir,s.name as name from ".$site_table." s,".$route_table." r where r.lid=".$row1['id']." and s.id=r.sid order by r.i";
			$result2=$db->sql_query($sql2);
			while($row2=$db->sql_fetchrow($result2))
			{
				$line_arr[$row1['name']]['dir'][$row2['dir']][]=$row2['name'];
			}
		}
		if(sizeof($line_arr)==0)
		{
			echo '此线路还未开通！';
		}
		else
		{
			foreach($line_arr as $line_name=>$line_info)
			{
				echo '线路名称:'.$line_name.'<br>';
				echo '起点站:'.getSname($line_info['line_info']['term1']).'('.$line_info['line_info']['start_time1'].'-'.$line_info['line_info']['end_time1'].')<br>';
				echo '终点站:'.getSname($line_info['line_info']['term2']).'('.$line_info['line_info']['start_time2'].'-'.$line_info['line_info']['end_time2'].')<br>';
				echo '票价:'.$line_info['line_info']['fare_norm'].' '.$line_info['line_info']['fare_cond'].'<br>';
				echo '可使用公交卡:'.$line_info['line_info']['ic_card'].'<br>';
				foreach($line_info['dir'] as $dir=>$route_arr)
				{
						echo '<span style="color:blue">';
						if($dir==1)
						{
							echo '上行';
						}
						else
						{
							echo '下行';
						}
						echo '：</span><br />';
						foreach($route_arr as $index=>$name)
					{
				
						echo $name;
						if($index!=(sizeof($route_arr)-1))
						{
							echo '→';
						}
					}
					echo '</br />';
				}
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
echo '数据来源于杭州公交集团网站(http://www.hzbus.com.cn)，数据采集日期:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">我的BLOG</a>
</body>
</html>