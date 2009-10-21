<?php 
header("Content-Type:text/html;charset=UTF-8");

$appKey = '12011633'; 
$secretCode = '3db8701b36170b8cc7dfd46f919ad171';
 
//签名函数 
function createSign ($paramArr) { 
    global $secretCode; 
    $sign = $secretCode; 
    ksort($paramArr);
    foreach ($paramArr as $key => $val) { 
       if ($key !='' && $val !='') { 
           $sign .= $key.$val; 
       } 
    } 
    $sign = strtoupper(md5($sign)); 
    return $sign; 
} 
 
//组参函数
function createStrParam ($paramArr) { 
    $strParam = ''; 
    foreach ($paramArr as $key => $val) { 
       if ($key != '' && $val !='') { 
           $strParam .= $key.'='.urlencode($val).'&'; 
       } 
    } 
    return $strParam; 
} 
/*
获取用户授权码
访问 http://auth.open.taobao.com/?appkey=12011633

http://container.open.taobao.com/container?authcode=TOP-10073ff8470dd147b19481934f7bb8b3a9tjy2io4RDWbyCBTMDWd7m9F7PWnQ7Q-END
http://container.open.taobao.com/container?authcode=TOP-10073ff8470dd147b19481934f7bb8b3a9tjy2io4RDWbyCBTMDWd7m9F7PWnQ7Q-END

http://localhost/?top_appkey={appkey}&top_parameters=xxx&top_session=xxx&top_sign=xxx&authcode={授权码} 
回调url上的top_session即为SessionKey 

127.0.0.1 - - [20/Oct/2009:15:23:47 +0800] "GET /TaobaoAPI/test.php?top_appkey=1
2011633&top_parameters=aWZyYW1lPTEmdHM9MTI1NjAyMzQ1NzcxMiZ2aWV3X21vZGU9ZnVsbCZ2a
WV3X3dpZHRoPTAmdmlzaXRvcl9pZD00MDExOTIyMCZ2aXNpdG9yX25pY2s9emVyb2ZhdWx0&top_sess
ion=186cd1219c6aad8d76de94963ccebd0d4&top_sign=%2FsLDTusVQI2ELvpmKwpStg%3D%3D HT
TP/1.1" 302 -*/

$session = '';
$params = explode('&',$_SERVER['QUERY_STRING']);
foreach($params as $param_str) {
	$param_arr = explode('=',$param_str);
	if('top_session'==$param_arr[0]) {
		$session = $param_arr[1];
		break;
	}
}
//$session = '186cd1219c6aad8d76de94963ccebd0d4';
//参数数组 
$paramArr = array( 
	'app_key' => $appKey, 
	'session' => $session,
	'method' => 'taobao.taobaoke.items.get', 
	'format' => 'xml', 
	'v' => '1.0', 
	'timestamp' => date('Y-m-d H:i:s'), 
//	'fields' => 'sex, buyer_credit, seller_credit, created, last_visit, birthday, type, alipay_bind',
//	'fields' => 'sid,cid,nick,title,desc,bulletin,pic_path,created,modified', 
	'fields' => 'nick',
	'pid' => 'mm_14374711_0_0',
	'page_size' => 4,
	'page_no' => 5,
	'keyword' => '笔记本'
	
);
 
//生成签名 
$sign = createSign($paramArr); 
//组织参数 
$strParam = createStrParam($paramArr); 
$strParam .= 'sign='.$sign; 
//访问服务 
//测试
$url = 'http://gw.api.tbsandbox.com/router/rest?';
//正式
$url = 'http://gw.api.taobao.com/router/rest?';
$url .= $strParam; 
//header("Location: ".$url); 
echo httpPost('http://gw.api.taobao.com/router/rest',$strParam);

function httpPost($url,$params,$refer=''){
	$result = '';
	
	$URL_Info=parse_url($url);
	if(empty($URL_Info["port"])) {
		$URL_Info["port"]=80;
	}
	if(empty($refer)) {
		$refer = $URL_Info['scheme'].'://'.$URL_Info['host'];
	}
	
	// building POST-request:
	$request = '';
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