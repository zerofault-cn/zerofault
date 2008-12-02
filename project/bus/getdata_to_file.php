<pre>
<?php
include_once 'simple_html_dom.php';

$fp=fopen("hangzhou_bus_data2.txt","a");
$c = curl_init();
curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$start=$_REQUEST['start'];
$offset=0;
//for($i=$start;$i<$start+10;$i++)
{
	curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=y20");
	$data = curl_exec($c);
	$html=str_get_html($data);
	$table=$html->find('table[width="98%"] table',0);
	$descr=$table->children(1)->plaintext;
	
	if(strlen(trim($descr))<2)
	{
		continue;
	}
	if(strlen(trim($descr))>2 &&strlen(trim($descr))<20)
	{
		$offset=2;
	}
	
	$descr=$table->children(1+$offset)->plaintext;
	$line_arr=explode("\n",$descr);

	$number_arr=explode("/",$line_arr[1]);
	echo $number=trim(str_ireplace("K",'',$number_arr[0]));
	echo ':';
	$term_arr=explode("--",$line_arr[6]);

	$time1_arr=explode("-",$line_arr[14]);
	$time2_arr=explode("-",$line_arr[15]);
	$str=trim($line_arr[1]).','.trim($term_arr[0]).','.trim($time1_arr[0]).','.trim($time1_arr[1]).','.trim($term_arr[1]).','.trim($time2_arr[0]).','.trim($time2_arr[1]).','.trim($line_arr[26]).',';
	
	$route_arr=$table->children(2+$offset)->find('table[bgcolor="3E89C0"]');
	foreach($route_arr as $r=>$route)
	{
		if($r==1 && ($number=='55' || $number=='56' || $number=='59' || $number=='60'|| $number=='676'))
		{
			continue;
		}
		$tr_arr=$route->children();
		foreach($tr_arr as $row=>$tr)
		{
			
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
				$str.='-';
			}
			else
			{
				$str.=',';
			}
		}
	}
	$str.='空调车:'.trim($line_arr[22]).' 普通车:'.trim($line_arr[18]).",\r\n";
	if(fwrite($fp,$str))
	{
		echo $str;
	}
	if($offset==2)
	{
		$descr=$table->children(4+$offset)->plaintext;
		$line_arr=explode("\n",$descr);

		$number_arr=explode("/",$line_arr[1]);
		echo $number=trim(str_ireplace("K",'',$number_arr[0]));

		$term_arr=explode("--",$line_arr[6]);

		$time1_arr=explode("-",$line_arr[14]);
		$time2_arr=explode("-",$line_arr[15]);
		$str=trim($line_arr[1]).','.trim($term_arr[0]).','.trim($time1_arr[0]).','.trim($time1_arr[1]).','.trim($term_arr[1]).','.trim($time2_arr[0]).','.trim($time2_arr[1]).','.trim($line_arr[26]).',';
		
		$route_arr=$table->children(5+$offset)->find('table[bgcolor="3E89C0"]');
		foreach($route_arr as $r=>$route)
		{
			if($r==1 && ($number=='55' || $number=='56' || $number=='59' || $number=='60'|| $number=='676'))
			{
				continue;
			}
			$tr_arr=$route->children();
			foreach($tr_arr as $row=>$tr)
			{
				
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
					$str.='-';
				}
				else
				{
					$str.=',';
				}
			}
		}
		$str.='空调车:'.trim($line_arr[22]).' 普通车:'.trim($line_arr[18]).",\r\n";
		if(fwrite($fp,$str))
		{
			echo $str;
		}
	}
	$html->clear();
	unset($html);
}
curl_close($c);

function arr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
?>
</pre>