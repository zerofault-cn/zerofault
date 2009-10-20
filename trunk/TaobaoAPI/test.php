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

http://container.open.taobao.com/container?authcode=TOP-103d7c4ceb4857cfdffe6769168d9c8054fI7aIa5YEqIQFDTNMQJZrGxo0VdFi8-END

http://localhost/?top_appkey={appkey}&top_parameters=xxx&top_session=xxx&top_sign=xxx&authcode={授权码} 
回调url上的top_session即为SessionKey 
127.0.0.1 - - [20/Oct/2009:14:52:35 +0800] "GET /TaobaoAPI/test.php?top_appkey=1
2011633&top_parameters=aWZyYW1lPTEmdHM9MTI1NjAyMTU4NTI1NiZ2aWV3X21vZGU9ZnVsbCZ2a
WV3X3dpZHRoPTAmdmlzaXRvcl9pZD00MDExOTIyMCZ2aXNpdG9yX25pY2s9emVyb2ZhdWx0&top_sess
ion=1070ff04b100b5aa704ab6a36076d7578&top_sign=4bSExOWg%2ByccvueNYz88sQ%3D%3D HT
TP/1.1" 302 -
*/

//参数数组 
$paramArr = array( 
	'app_key' => $appKey, 
	'session' => '1070ff04b100b5aa704ab6a36076d7578',
	'method' => 'taobao.trades.bought.get', 
	'format' => 'xml', 
	'v' => '1.0', 
	'timestamp' => date('Y-m-d H:i:s'), 
//	'fields' => 'sex, buyer_credit, seller_credit, created, last_visit, birthday, type, alipay_bind',
//	'fields' => 'sid,cid,nick,title,desc,bulletin,pic_path,created,modified', 
	'fields' => 'seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,payment,discount_fee, adjust_fee,post_fee,pay_time,end_time,consign_time,modified,buyer_obtain_point_fee,point_fee, real_point_fee,received_payment,pic_path,iid,num,price,cod_fee,shipping_type',
	'nick' => '' 
);
 
//生成签名 
$sign = createSign($paramArr); 
//组织参数 
$strParam = createStrParam($paramArr); 
$strParam .= 'sign='.$sign; 
//访问服务 
//$url = 'http://gw.sandbox.taobao.com/router/rest?';
//$url = 'http://gw.api.tbsandbox.com/router/rest?';
$url = 'http://gw.api.taobao.com/router/rest?';
$url .= $strParam; 
header("Location: ".$url); 
?>