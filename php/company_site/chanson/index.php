<?php
list($module, $action) = each($_REQUEST);
if (empty($module) || !in_array($module, array('index', 'culture', 'stylist', 'contact'))) {
	$module = 'index';
	$action = '';
}
?>
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
				<li id="li_index"><a href="?index">主　　页</a></li>
				<li id="li_culture"><a href="?culture">企业文化</a></li>
				<li id="li_stylist"><a href="?stylist">设 计 师</a></li>
				<li id="li_contact"><a href="?contact">联系方式</a></li>
				<li id="en">CHANSON <br />EUROPÉENNE <br />DÉCOR</li>
				<li>欧颂全球</li>
			</ul>
			<div id="contact_label">
				CONTACTS
			</div>
		</div>
		<div id="right_wrapper">
			<?php
			if (!empty($action)) {
				include_once($module.'_'.$action.'.inc.php');
			}
			else {
				include_once($module.'.inc.php');
			}
			?>
		</div>
		<img id="float_banner" src="images/banner.gif" />
	</div>
</body>
<script language="JavaScript" type="text/javascript" src="js/jquery-1.4.2.min.js?20110305"></script>
<script language="JavaScript" type="text/javascript" src="js/cufon-yui.js"></script>
<script language="JavaScript" type="text/javascript" src="js/GillSans_500.font.js"></script>
<script language="JavaScript" type="text/javascript" src="js/coin-slider.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/coin-slider-styles.css" /> 
<script language="JavaScript" type="text/javascript" src="js/function.js?20110305"></script>
<script language="JavaScript" type="text/javascript">
var module = '<?php echo $module;?>';
$(document).ready(function(){
	init();
});
Cufon.replace('#audio_control', {hover: true});
Cufon.replace('#navigation_title');
Cufon.replace('#navigation #en');
</script>
</html>

