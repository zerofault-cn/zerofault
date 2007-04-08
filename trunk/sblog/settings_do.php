<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	require('config.php');
	require('inc/config.php');
	require('inc/func_config_update.php');
	require('inc/mysql.php');

	// PERSONAL
	sblog_config_update('conf_admin_email', mysql_escape_string($_REQUEST['admin_email']));
	//sblog_config_update('conf_admin_icq', intval($_REQUEST['admin_icq']));
	//sblog_config_update('conf_admin_msn', mysql_escape_string($_REQUEST['admin_msn']));
	sblog_config_update('conf_comments_email', intval($_POST['comments_email']));
	sblog_config_update('conf_comments_act', intval($_POST['comments_act']));

	// PAGE
	sblog_config_update('conf_page_title', mysql_escape_string($_REQUEST['page_title']));
	sblog_config_update('conf_page_description', mysql_escape_string($_REQUEST['page_description']));

	// LIMITS
	sblog_config_update('conf_page_disp', intval($_REQUEST['page_disp']));
	sblog_config_update('conf_bar_latest_disp', intval($_REQUEST['bar_latest_disp']));
	sblog_config_update('conf_bar_comments_disp', intval($_REQUEST['bar_comments_disp']));
	sblog_config_update('conf_img_width', intval($_REQUEST['img_width']));
	sblog_config_update('conf_block_chars', intval($_REQUEST['block_chars']));
	
	// DATE AND TIME
	sblog_config_update('conf_date', mysql_escape_string($_REQUEST['conf_date']));

	// STYLE
	sblog_config_update('conf_style_default', mysql_escape_string($_REQUEST['style_default']));

	// LANGUAGE
	sblog_config_update('conf_lang_default', mysql_escape_string($_REQUEST['lang_default']));
	
	// LINKS
	sblog_config_update('conf_link_new', intval($_REQUEST['link_new']));

	mysql_close();
	
	header("Location: settings.php");
	exit;

?>