<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>欧颂装饰</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="欧颂装饰 欧颂官方网站" />
	<meta name="description" content="欧颂（上海）装饰设计有限公司" />
	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div id="bg_container">
		<div id="left_wrapper">
			<div id="audio_control">
				AUDIO: <a href="javascript:void(0);">OFF</a>
			</div>
			<div id="navigation_title">
				EXPERIENCE NAVIGATION
			</div>
			<ul id="navigation">
				<li class="focus"><a href="javascript:void(0);" onclick="load('index');">主<span class="placeholder">页主</span>页</a></li>
				<li><a href="culture.php">企业文件</a></li>
				<li><a href="stylist.php">设 计 师</a></li>
				<li><a href="javascript:void(0);" onclick="load('contact');">联系方式</a></li>
				<li id="en">CHANSON <br />EUROPÉENNE <br />DÉCOR</li>
				<li>欧颂全球</li>
			</ul>
			<div id="contact_label">
				CONTACTS
			</div>
		</div>
		<div id="right_wrapper">
			<?php include_once('index.inc');?>
		</div>
		<img id="float_banner" src="images/banner.gif" />
	</div>
</body>
<script language="JavaScript" type="text/javascript" src="js/jquery-1.4.2.min.js?20110305"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/Andale_Mono_400.font.js"></script>
<script type="text/javascript" src="js/GillSans_500.font.js"></script>
<script language="JavaScript" type="text/javascript" src="js/function.js?20110305"></script>
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	init();
	Cufon.set('fontFamily', 'Andale Mono').replace('#navigation_title');
	Cufon.set('fontFamily', 'GillSans').replace('#navigation li#en');
});
</script>
</html>

