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
//获取用户授权码
//访问 http://auth.open.taobao.com/?appkey=12011633，

//http://container.open.taobao.com/container?authcode=TOP-1016b9367bc2747099fbca04bb1d178b1bQph3sdPRZieWbAK5GmukDyUVraEyQU-END

//http://localhost/?top_appkey={appkey}&top_parameters=xxx&top_session=xxx&top_sign=xxx&authcode={授权码} 
//回调url上的top_session即为SessionKey 

//参数数组 
$paramArr = array( 
	'app_key' => $appKey, 
	'method' => 'taobao.user.get', 
	'format' => 'xml', 
	'v' => '1.0', 
	'timestamp' => date('Y-m-d H:i:s'), 
	'fields' => 'sex, buyer_credit, seller_credit, created, last_visit, birthday, type, alipay_bind',
//	'fields' => 'sid,cid,nick,title,desc,bulletin,pic_path,created,modified', 
	'nick' => 'zerofault' 
);
 
//生成签名 
$sign = createSign($paramArr); 
//组织参数 
$strParam = createStrParam($paramArr); 
$strParam .= 'sign='.$sign; 
//访问服务 
$url = 'http://gw.sandbox.taobao.com/router/rest?';
$url = 'http://gw.api.tbsandbox.com/router/rest?';
$url = 'http://gw.api.taobao.com/router/rest?';
$url .= $strParam; 
header("Location: ".$url); 
?>