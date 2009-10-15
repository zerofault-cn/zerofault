<?php

require_once('simple_html_dom.php');

$name='B支6';

if(function_exists('curl_init')) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
	curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".iconv('GBK','UTF-8',$name));
	$data = curl_exec($c);
}
else{
	$data = httpPost("http://www.hzbus.com.cn/content/busline/line_search.jsp","line_name=".iconv('GBK','UTF-8',$name),"http://www.hzbus.com.cn/");
}
$data = iconv('GBK','UTF-8',$data);
//$data = mb_convert_encoding($data,'UTF-8','GBK');
$data=str_get_html($data);
$table=$data->find('table[width="98%"] table',0);
$descr=$table->children(1)->plaintext;

echo $descr;

function httpPost($url,$params,$refer){
	$result = '';
	
	$URL_Info=parse_url($url);
	if(empty($URL_Info["port"])) {
		$URL_Info["port"]=80;
	}
	if(empty($refer)) {
		$refer = $URL_Info['scheme'].'://'.$URL_Info['host'];
	}
	
	// building POST-request:
	$request .= "POST ".$URL_Info["path"]." HTTP/1.1\n";
	$request .= "Host: ".$URL_Info["host"]."\n";
	$request .= "Referer: ".$refer."\n";
	$request .= "Content-type: application/x-www-form-urlencoded\n";
	$request .= "Content-length: ".strlen($params)."\n";
	$request .= "Connection: close\n";
	$request .= "\n";
	//$request.=$data_string."\n";
	$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
	fputs($fp, $request);
	while(!feof($fp)) {
		$result .= fgets($fp, 1024);
	}
	fclose($fp);
	return $result;
}
?>