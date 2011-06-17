<?php
header('Content-type: text/html; charset=utf-8');
$content = file_get_contents('http://php.weather.sina.com.cn/search.php?c=1&city='.$_REQUEST['city'].'&dpc=1');
if (!empty($content) && ''!=trim($content)) {
	$content = mb_convert_encoding($content, "UTF-8", "GB2312");
	preg_match('/(<h5>今天白天<\/h5>.*)<ul class="detail">/isU', $content, $matches);
	$weather = preg_replace('/.+[\s]title=\'(.+)\'[\s].+/ism', "\\1", $matches[1]);
	preg_match('/url\([\"\']?([%+\*\w\/:\._-]+)[\"\']?\)/ism', $matches[1], $arr);
	$url = $arr[1];
	mb_internal_encoding("UTF-8");
	if (false !== mb_strpos($weather, '雨')) {
		$tip = '<em>不适于洗车</em>';
	}
	else {
		$tip = '<i>适于洗车</i>';
	}
}
?>
<style>
.weather {
	text-align: center;
}
.weather h2 {
	text-align: left;
}
.weather em, .weather i {
	font-style: normal;
}
</style>
<div class="sidebox weather">
		<h2 class="title">
			今日天气 (<?php echo $_REQUEST['city'];?>)
		</h2>
		<img src="<?php echo $url;?>"/><br />
		<?php echo $weather;?> <?php echo $tip;?>
</div>