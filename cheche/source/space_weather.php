<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mtag.php 13083 2009-08-10 09:35:23Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once("simple_html_dom.php");
$city = $space['city_name'];
empty($city) && ($city='杭州');
$content = file_get_contents('http://php.weather.sina.com.cn/search.php?c=1&city='.$city.'&dpc=1');
if (!empty($content) && ''!=trim($content)) {
	$content = mb_convert_encoding($content, "UTF-8", "GB2312");

	$start = strpos($content, '<div class="m_left">');
	$end = strpos($content, '<ul class="m_right">');
	$content1 = substr($content, $start, $end-$start);
//	echo $content1;
/*
	$data = str_get_html($content1);

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
	*/
	$start = strpos($content, '<div class="weather_list')+35;
	$end = strpos($content, '<ul class="list_01">')-20;
	$content2 = substr($content, $start, $end-$start);

	include_once template("space_weather");

	exit;
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
.weather div.left div, .weather div.right div {
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
.weather .weather_list {
	display: none;
	position: absolute;
	width: 685px;
	height: 256px;
	top: 57px;
	left:50%;
	margin-left: -340px;
	z-index: 3000;
}
.weather .weather_list .mod_02{float: left;width: 158px;height: 243px;padding: 5px;margin-top: 3px;background: url(http://php.weather.sina.com.cn/images/weather_yc_01.jpg) -510px 0 no-repeat;color: #fff;}
.weather .weather_list .mod_02 .mod_03{float: left;width: 78px;text-align: center;font-family: 'Microsoft YaHei';}/*2010/9/1*/
.weather .weather_list .icon_mid_weather{width: 78px;height: 78px;margin: auto;}
.weather .weather_list .mod_03 h5{margin-bottom: 5px;font-size: 14px;}
.weather .weather_list .mod_03 ul{margin-top: -20px;}
.weather .weather_list .mod_03 ul{margin-top: -20px;}
.weather .weather_list .mod_02 h4{margin: 20px 0 15px;font:16px/30px 'Microsoft YaHei', "黑体", sans-serif;text-align: center;}

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
		<div class="clear"><a href="javascript:void(0);" onclick="jQuery('.weather .weather_list').toggle();jQuery(this).toggle();jQuery(this).next().toggle();">未来四天</a><a style="display:none;" href="javascript:void(0);" onclick="jQuery('.weather .weather_list').toggle();jQuery(this).toggle();jQuery(this).prev().toggle();">关闭</a></div>
		<div class="weather_list" style="display:none;"><?php echo $content2;?></div>
</div>