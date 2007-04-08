<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// start time
	list($usec, $sec) = explode(' ', microtime());
	$time_start = ((float)$usec + (float)$sec);

	if(!session_id()) {
		session_start();
	}

	require('inc/config.php');
	require('inc/lang.php');
	require('inc/func_bbcode.php');

	$tpl_main = file_get_contents($conf_doc_root . "template/main.tpl");

	/* start <sblog_header> */
	ob_start();

	if(isset($conf_style_user) && file_exists('style/' . $conf_style_user . '.css')) {
		$style = $conf_style_user;
	}	
	else if(file_exists('style/' . $conf_style_default . '.css')) {
		$style = $conf_style_default;
	}
	else {
		$style = 'Standard';
	}

?>
<meta name="keywords" content="sBLOG中文版, Servous, inso, <?php echo htmlspecialchars(stripslashes($conf_page_title)); ?>, <?php echo htmlspecialchars(stripslashes($conf_page_description)); ?>" />
<meta name="description" content="<?php echo htmlspecialchars(stripslashes($conf_page_description)); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo htmlspecialchars(stripslashes($conf_page_title)); ?> (RSS 0.91)" href="<?php echo $conf_web_root; ?>rss/?mode=0.91" />
<link rel="alternate" type="application/rss+xml" title="<?php echo htmlspecialchars(stripslashes($conf_page_title)); ?> (RSS 2.0)" href="<?php echo $conf_web_root; ?>rss/?mode=2.0" />
<link rel="stylesheet" href="style/<?php echo $style; ?>.css" />
<title><?php echo htmlspecialchars(stripslashes($conf_page_title)); ?></title>
<script src="js/js_quicktags.js" type="text/javascript"></script>
<script type="text/javascript" src="js/external.js"></script>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_header>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	$tpl_main = str_replace('<sblog_web_root>', $conf_web_root, $tpl_main);
	$tpl_main = str_replace('<sblog_page_title>', htmlspecialchars(stripslashes($conf_page_title)), $tpl_main);
	$tpl_main = str_replace('<sblog_page_description>', htmlspecialchars(stripslashes($conf_page_description)), $tpl_main);

?>