<?php 
header("Content-Type:text/html;charset=UTF-8");
require_once 'phpSDK/lib/config.inc.php';
require_once 'Paginator.class.php';
?>

<form method="get">
<input type="text" name="keyword" />
<input type="submit" />
</form>

<?php

/*
获取用户授权码
访问 http://auth.open.taobao.com/?appkey=12011633

http://container.open.taobao.com/container?authcode=TOP-10073ff8470dd147b19481934f7bb8b3a9tjy2io4RDWbyCBTMDWd7m9F7PWnQ7Q-END

http://localhost/?top_appkey={appkey}&top_parameters=xxx&top_session=xxx&top_sign=xxx&authcode={授权码} 
回调url上的top_session即为SessionKey 


*/
$session = '';
$params = explode('&',$_SERVER['QUERY_STRING']);
foreach($params as $param_str) {
	$param_arr = explode('=',$param_str);
	if('top_session'==$param_arr[0]) {
		$session = $param_arr[1];
		break;
	}
}
//API系统参数
$topParamArr = array(
	'api_key' => APP_KEY,
	'pid' => APP_PID,
	'method' => 'taobao.taobaoke.items.get',
	'format' => 'xml',
	'v' => '1.0',
	'timestamp' => date('Y-m-d H:i:s')
);
$limit = 10;
//API用户参数
$userParamArr = array(
	'fields' => 'iid,title,nick,pic_url,price,click_url, commission',
	'page_size' => $limit,
	'page_no' => empty($_REQUEST['p'])? 1 : $_REQUEST['p'],
	'keyword' => empty($_REQUEST['keyword'])? '充值卡' : $_REQUEST['keyword'],
	//'area' => '杭州',
	'sort' => 'price_desc',
);

//总参数数组
$paramArr = $topParamArr + $userParamArr;


//解析xml结果
$result = array();
if(!empty($_REQUEST['keyword'])) {
	$result = Util::getXmlData(Util::getResult($paramArr));
	$p = new Paginator($result['totalResults'],$limit);
	echo $p->showMultiNavi();
	echo '<table border="1" cellspacing="0" cellpadding="2" bordercolor="#999999" style="border-collapse:collapse;"><tr>';
	echo '<th width="5%">图片</th>';
	echo '<th width="35%">名称</th>';
	echo '<th>价格</th>';
	echo '<th>佣金</th>';
	echo '<th width="40%">店铺</th>';
	echo '</tr>';
	foreach($result['taobaokeItem'] as $item) {
		//获取店铺ID
		$ParamArr = array(
			'api_key' => APP_KEY,
			'pid' => APP_PID,
			'method' => 'taobao.shop.get',
			'format' => 'xml',
			'v' => '1.0',
			'timestamp' => date('Y-m-d H:i:s'),
			'fields' => 'sid',
			'nick' => $item['nick']
		);
		$shop_rs = Util::getXmlData(Util::getResult($ParamArr));
		//echo '<pre>';
		//print_r($shop_rs);
		//echo '</pre>';
		$shop_sid = $shop_rs['shop']['sid'];

		//获取推广店铺链接
		$ParamArr = array(
			'api_key' => APP_KEY,
			'pid' => APP_PID,
			'method' => 'taobao.taobaoke.shops.convert',
			'format' => 'xml',
			'v' => '1.0',
			'timestamp' => date('Y-m-d H:i:s'),
			'fields' => 'shop_title,click_url,shop_commission.rate',
			'sids' => $shop_sid,
			'nick' => 'zerofault'
		);
		$shop = Util::getXmlData(Util::getResult($ParamArr));
		//echo '<pre>';
		//print_r($shop);
		//echo '</pre>';
		
		echo '<tr>';
		echo '<td align="center"><a href="'.$item['click_url'].'" target="_blank"><img src="'.$item['pic_url'].'" border="0" height="30"/></a></td>';
		echo '<td><a href="'.$item['click_url'].'" target="_blank">'.$item['title'].'</a></td>';
		echo '<td>'.$item['price'].'</td>';
		echo '<td>'.$item['commission'].'</td>';
		echo '<td><a href="'.$shop['taobaokeShop']['click_url'].'" target="_blank">'.$shop['taobaokeShop']['shop_title'].'</a>';
		echo '</tr>';
	}
}



?>
