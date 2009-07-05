<pre>
<?php
include_once("config.php");
include_once("function.php");
include_once(PATH_ROOT.'/include/simple_html_dom.php');

$c = curl_init();
curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

$sql = "select * from ".LINE_TABLE." where update_time<'".date("Y-m-d H:i:s",time()-30*86400)."' limit 15";
echo $sql;
$result=$db->sql_query($sql);
while($rr=$db->sql_fetchrow($result)) {
	$number = $rr['number'];
	if($number>1000){
		$number = $rr['name'];
	}
	$line_id=$rr['id'];

	curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$number);
	$data = curl_exec($c);
	$html=str_get_html($data);
	$table=$html->find('table[width="98%"] table',0);
	$descr=$table->children(1)->plaintext;
	if(strlen(trim($descr))<2)
	{
		continue;
	}
	else
	{
		$line_arr=explode("\n",$descr);
		$numbers= explode("/",$line_arr[1]);
		$number = str_ireplace("K",'',$numbers[0]);
		$number = str_ireplace("(夜间线)",'',$number);
		$number = str_ireplace("(区间)",'',$number);
		$number = substr($number,0,3)=='B支'? (2000+intval(str_ireplace("B支",'',$number))) : $number;
		$number = substr($number,0,1)=='B' ? (1000+intval(str_ireplace("B",'',$number))) : $number;
		$number = substr($number,0,1)=='Y' ? (3000+intval(str_ireplace("Y",'',$number))) : $number;
		$number = substr($number,0,1)=='J' ? (4000+intval(str_ireplace("J",'',$number))) : $number;
		$number = intval($number);

		$term_arr=explode("--",$line_arr[6]);

		$time1_arr=explode("-",$line_arr[14]);
		$time2_arr=explode("-",$line_arr[15]);
		$sql1="update ".LINE_TABLE." set start_sid=".getSiteId(trim($term_arr[0])).",start_first='".trim($time1_arr[0])."',start_last='".trim($time1_arr[1])."',end_sid=".getSiteId(trim($term_arr[1])).",end_first='".trim($time2_arr[0])."',end_last='".trim($time2_arr[1])."',fare_norm='".str_replace('--','',trim($line_arr[18]))."',fare_cond='".str_replace('--','',trim($line_arr[22]))."',ic_card='".trim($line_arr[26])."',service_hour='".trim($line_arr[30])."',update_time=NOW() where name='".trim($line_arr[1])."' and number=".$number;
		echo $sql1;
		echo "\r\nresult:".$db->sql_query($sql1);

		$route_arr=$table->children(2)->find('table[bgcolor="3E89C0"]');
		foreach($route_arr as $r=>$route)
		{
			if($r==0)
			{
				$direction=1;
			}
			else
			{
				$direction=-1;
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
					$sitename=trim($tr->children(1)->plaintext);
					if(strlen($sitename)>1)
					{
						$sql1 = "select * from ".ROUTE_TABLE." where lid=".$line_id." and i=".(10*($row-1))." and direction=".$direction;
						echo $sql1;
						$r1 = $db->sql_query($sql1);
						if($db->sql_numrows($r1)>0){
							$sql2="update ".ROUTE_TABLE." set sid=".getSiteId($sitename)." where lid=".$line_id." and i=".(10*($row-1))." and direction=".$direction;
						}
						else{
							$sql2="insert into ".ROUTE_TABLE." set lid=".$insertid.",sid=".getSiteId($sitename).",i=".(10*($row-1)).",direction=".$direction;
						}
						echo "\r\nresult:".$db->sql_query($sql2);
					}

				}
			}
		}
	}
}
curl_close($c);

function arr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function getSiteId($name) {
	global $db;
	$sql1="select id from ".SITE_TABLE." where binary name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>1)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		$sql2="insert into ".SITE_TABLE." set name='".$name."'";
		$db->sql_query($sql2);
		return $db->sql_nextid();
	}
}

?>
</pre>