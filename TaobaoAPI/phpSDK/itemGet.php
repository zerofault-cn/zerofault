<?php
/**
 * 查询单个商品详情
 */
header("Content-Type:text/html;charset=UTF-8");
require_once 'lib/config.inc.php';

//API系统参数
$topParamArr = array(
	'api_key' => APP_KEY,
	'method' => 'taobao.taobaoke.items.get',
	'format' => 'xml',
	'v' => '1.0',
	'timestamp' => date('Y-m-d H:i:s')
);

//API用户参数
$userParamArr = array(
	'fields' => 'iid,title,nick,pic_url,price,click_url, commission',
	'pid' => 'mm_14374711_0_0',
	'page_size' => 10,
	'keyword' => '手机'
);

//总参数数组
$paramArr = $topParamArr + $userParamArr;

/*
 * 以GET方式访问服务
 */
$result = Util::getResult($paramArr);
//解析xml结果
$result = Util::getXmlData($result);
echo '<pre>';
print_r($result);
echo '</pre>';
/*
 * 以POST方式访问服务

$result = Util::postResult($paramArr);
//解析xml结果
$result = Util::getXmlData($result);
echo '<pre>';
print_r($result);
echo '</pre>';
*/
?>