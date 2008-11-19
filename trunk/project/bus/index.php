<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query" />
输入线路编号：<input type="text" name="number" size="3" /><input type="submit" value="查询" />
</form>

<?php
$action=$_REQUEST['action'];
if('query'==$action)
{
	include_once 'simple_html_dom.php';
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
	curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	$line=intval(trim($_REQUEST['number']));
	if($line>0)
	{
		curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$line);
		$data = curl_exec($c);
		$html=str_get_html($data);//'4.html'
		$table=$html->find('table[width="98%"] table',0);
		//echo '<pre>';
		//print_r($table);
		echo $table->children(1)->plaintext;
		echo '<br />';
		$route_arr=$table->children(2)->find('table[bgcolor="3E89C0"]');
		foreach($route_arr as $route)
		{
			$tr_arr=$route->children();
			foreach($tr_arr as $row=>$tr)
			{
				if($row==0)
				{
					echo $tr->plaintext;
					echo '：<br />';
				}
				elseif($row==1)
				{
					continue;
				}
				else
				{
					echo trim($tr->children(1)->plaintext);
				}
				if($row!=0 && $row!=(sizeof($tr_arr)-1))
				{
					echo '→';
				}
			}
			echo '</br />';
		}
		//echo '</pre>';
	}
	curl_close($c);

}
?>
