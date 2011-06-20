<?php
header('Content-type: text/html; charset=utf-8');
include_once("simple_html_dom.php");
$content = file_get_contents('http://php.weather.sina.com.cn/search.php?c=1&city='.$_REQUEST['city'].'&dpc=1');
if (!empty($content) && ''!=trim($content)) {
	$content = mb_convert_encoding($content, "UTF-8", "GB2312");
	$data = str_get_html($content);

	$today = $data->find('.mod_today');
//	print_r($today);
//	exit;
	$today_day_str = $today->children(0)->chindren(0)->chindren(1);
	print_r($today_day_str);
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