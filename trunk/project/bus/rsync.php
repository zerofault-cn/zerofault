<pre>
<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once 'simple_html_dom.php';

$c = curl_init();
curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$start=$_REQUEST['start'];
for($i=$start;$i<$start+6;$i++)
{
	curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$i);
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
		$number_arr=explode("/",$line_arr[1]);
		//arr($number_arr);
		//continue;
		$number=str_replace("K",'',$number_arr[0]);

		$term_arr=explode("--",$line_arr[6]);

		$time1_arr=explode("-",$line_arr[14]);
		$time2_arr=explode("-",$line_arr[15]);
		echo	"\r\n".$sql1="insert into bus_hz_line set name='".trim($line_arr[1])."',number=".trim($number).",term1=".getSiteId(trim($term_arr[0])).",start_time1='".trim($time1_arr[0])."',end_time1='".trim($time1_arr[1])."',term2=".getSiteId(trim($term_arr[1])).",start_time2='".trim($time2_arr[0])."',end_time2='".trim($time2_arr[1])."',fare_norm='".str_replace('--','',trim($line_arr[18]))."',fare_cond='".str_replace('--','',trim($line_arr[22]))."',ic_card='".trim($line_arr[26])."',service_hour='".trim($line_arr[30])."'";
		echo "\r\nresult:".$db->sql_query($sql1);
		
		$insertid=$db->sql_nextid();


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
						echo		"\r\n".$sql2="insert into bus_hz_route set lid=".$insertid.",sid=".getSiteId($sitename).",i=".(10*($row-1)).",direction=".$direction;
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
	$sql1="select id from bus_hz_site where binary name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>1)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		$sql2="insert into bus_hz_site set name='".$name."'";
		$db->sql_query($sql2);
		return $db->sql_nextid();
	}
}

?>
</pre>