<html>
<head>
<title>杭州公交线路查询－手机适用版</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="description" content="杭州公交汽车线路查询，与杭州公交集团网站数据同步" />
<meta name="keywords" content="杭州 公交车 线路 换乘 查询 手机适用" />
<link href="style.css" rel="stylesheet" type="text/css">
<base href="http://www.hzbus.com.cn/content/busline/" />
</head>
<body>
<form name="form1" method="get">
<input type="hidden" name="action" value="query_line" />
输入线路编号：<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="查询线路信息" />
</form>
<form name="form1" method="get">
<input type="hidden" name="action" value="query_site" />
输入站点名称：<input type="text" name="site_name" size="6" value="<?=$_REQUEST['site_name']?>" /><input type="submit" value="查询经过线路" />
</form>
<form name="form1" method="get">
<input type="hidden" name="action" value="query_transfer" />
输入起点：<input type="text" name="from" size="8" value="<?=$_REQUEST['from']?>" /><br />
输入终点：<input type="text" name="to" size="8" value="<?=$_REQUEST['to']?>" /><input type="submit" value="换乘查询" />
</form>
<?php
function parseLineInfo($descr,$tmp_offset)
{
	global $singleWayLines,$table;
	$line_arr=explode("\n",$descr);

	$number_arr=explode("/",$line_arr[1]);
	$number=trim(str_ireplace("K",'',$number_arr[0]));

	$term_arr=explode("--",$line_arr[6]);

	$time1_arr=explode("-",$line_arr[14]);
	$time2_arr=explode("-",$line_arr[15]);
	$str=trim($line_arr[1]).','.trim($term_arr[0]).','.trim($time1_arr[0]).','.trim($time1_arr[1]).','.trim($term_arr[1]).','.trim($time2_arr[0]).','.trim($time2_arr[1]).','.trim($line_arr[26]);
	
	$str.=',空调车:'.trim($line_arr[22]).' 普通车:'.trim($line_arr[18]).",\r\n";
	$str .= '<br />';
	
	$route_arr=$table->children($tmp_offset)->find('table[bgcolor="3E89C0"]');
	foreach($route_arr as $r=>$route)
	{
		if($r==1 && in_array($number,$singleWayLines))
		{
			continue;
		}
		$tr_arr=$route->children();
		foreach($tr_arr as $row=>$tr)
		{
			if(!isset($flag)){
				$str.='正向：';
				$flag=0;
			}
			if($flag){
				$str.='反向：';
				$flag=0;
			}
			
			if($row==0 || $row==1)
			{
				continue;
			}
			else
			{
				$str.=trim($tr->children(1)->plaintext);
			}
			if($row!=sizeof($tr_arr)-1)
			{
				$str.='→';
			}
			else
			{
				$str.='<br />';
				$flag=1;
			}
		}
	}
	echo $str;
	echo '<br />';
}
$singleWayLines = array('55','56','59','60','676');
$action=$_REQUEST['action'];
include_once 'simple_html_dom.php';
$c = curl_init();
curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

if('query_line'==$action)
{
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
	curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$_REQUEST['line_name']);
	$data = curl_exec($c);
	$html=str_get_html($data);
	$table=$html->find('table[width="98%"] table',0);
	$descr=$table->children(1)->plaintext;
	
	if(strlen(trim($descr))<2)
	{
		echo 'No data';
		exit;
	}
	if(strlen(trim($descr))>2 &&strlen(trim($descr))<20)
	{
		$offset=2;
	}
	
	$descr=$table->children(1+$offset)->plaintext;
	parseLineInfo($descr,2+$offset);
	if($offset==2)
	{
		$descr=$table->children(4+$offset)->plaintext;
		parseLineInfo($descr,5+$offset);
	}
	$html->clear();
	unset($html);
}
if('query_site'==$action)
{
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/linestop_search.jsp");
	curl_setopt($c, CURLOPT_POSTFIELDS,"stop_name=".$_REQUEST['site_name']);
	$data = curl_exec($c);
	$html=str_get_html($data);
	$table=$html->find('table[width="98%"] table',0);
	echo $table;
}
if('query_transfer'==$action)
{
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/stop_search.jsp");
	curl_setopt($c, CURLOPT_POSTFIELDS,"s_stopname=".$_REQUEST['from']."&e_stopname=".$_REQUEST['to']);
	$data = curl_exec($c);
	$html=str_get_html($data);
	$table=$html->find('table[width="98%"] table',0);
	echo $table;
}
echo '<br /><br /><br />数据来源于杭州公交集团网站(http://www.hzbus.com.cn)，数据采集日期:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">我的BLOG</a>
</body>
</html>