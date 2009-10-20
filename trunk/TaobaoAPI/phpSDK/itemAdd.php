<?php
/**
 * 添加商品，访问此api服务需要session
 */
header("Content-Type:text/html;charset=UTF-8");
require_once 'lib/config.inc.php';

//API系统参数
$topParamArr = array(
	'api_key' => APP_KEY,
	'method' => 'taobao.item.add',
	'format' => 'json',
	'v' => '1.0',
	'timestamp' => date('Y-m-d H:i:s'),
	'session' => '--见SDK使用说明，上面有获取session的链接--'
);

//API用户参数
$userParamArr = array(
	'approve_status' => 'onsale',
	'cid' => '50000671',
	'props' => '20665:29453;20661:29444;20663:29448;20664:28105;21541:111019;20509:28381;20511:28385;20000:29866;1625894:3216793;1625899:3216971',
	'num' => '1',
	'price' => '888.88',
	'type' => 'fixed',
	'stuff_status' => 'new',
	'title' => '测试SDK',
	'desc' => '宝贝描述，商品描述；宝贝描述，商品描述；宝贝描述，商品描述；',
	'location.state' => '浙江',
	'location.city' => '杭州'
);

//总参数数组
$paramArr = $topParamArr + $userParamArr;


/*
 * 以POST方式访问服务
 */
$result = Util::postResult($paramArr);
//解析json结果
$result = json_decode($result);
print_r($result);

/*
 * 以POST方式访问服务，带图片
 */
$imageArr = array();
$imageArr['image'] = '/tmp/200903271359385.jpg';			//注意：图片路径为服务器端路径并且图片可读，image为参数名。Snoopy上传图片支持gif,jpg格式，但不支持png格式的图片。
$result = Util::postImageResult($paramArr, $imageArr);
//解析json结果
$result = json_decode($result);
print_r($result);
?>