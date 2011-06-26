<?php
header('Content-type: text/html; charset=utf-8');
include_once("simple_html_dom.php");
$city = $_REQUEST['city'];
empty($city) && die('');
//$city = '杭州';
$content = file_get_contents('http://php.weather.sina.com.cn/search.php?c=1&city='.$city.'&dpc=1');
if (!empty($content) && ''!=trim($content)) {
	$content = mb_convert_encoding($content, "UTF-8", "GB2312");

	$start = strpos($content, '<div class="m_left">');
	$end = strpos($content, '<ul class="m_right">');
	$content = substr($content, $start, $end-$start);
//	echo $content;
	$data = str_get_html($content);

	$day = $data->find('.day', 0);
	$day_style = $day->children(2)->style;
	$start = strpos($day_style, '(')+1;
	$end = strpos($day_style, ')');
	$day_pic = substr($day_style, $start, $end-$start);
	$day_str = $day->children(3)->children(1)->plaintext;
	$day_temp_str = $day->children(3)->children(0)->children(0)->plaintext;

	$night = $data->find('.night', 0);
	$night_style = $night->children(1)->style;
	$start = strpos($night_style, '(')+1;
	$end = strpos($night_style, ')');
	$night_pic = substr($night_style, $start, $end-$start);
	$night_str = $night->children(2)->children(1)->plaintext;
	$night_temp_str = $night->children(2)->children(0)->children(0)->plaintext;
	
	mb_internal_encoding("UTF-8");
	if (false !== mb_strpos($day_str, '雨') || false !== mb_strpos($night_str, '雨')) {
		$tip = '<em>不适宜洗车</em>';
	}
	else {
		$tip = '<i>适宜洗车</i>';
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
.weather span {
	float: right;
}
.weather div div {
	height: 60px;
	overflow-y: hidden;
}

.weather div.left {
	float:left;
	padding-left: 10px;
}
.weather div.right {
	float:right;
	padding-right: 10px;
}

.weather img {
	padding-right: 10px;
	padding-left: 10px;
}
.weather em, .weather i {
	font-style: normal;
}
</style>
<div class="sidebox weather">
		<h2 class="title">
			<span><?php echo $tip;?></span>今日天气 (<?php echo $_REQUEST['city'];?>)
		</h2>
		<div class="left">
			白天<br />
			<div><img src="<?php echo $day_pic;?>" width="90" height="80"/></div>
			<?php echo $day_str;?> <?php echo $day_temp_str;?>
		</div>
		<div class="right">
			夜间<br />
			<div><img src="<?php echo $night_pic;?>" width="90" height="80"/></div>
			<?php echo $night_str;?>  <?php echo $night_temp_str;?>
		</div>
		<div class="clear"></div>
</div>