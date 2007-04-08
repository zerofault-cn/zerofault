<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// make sure php writes valid xhtml tags if session.use_trans_sid
	if(ini_get('session.use_trans_sid') == 1) {
		ini_set('arg_separator.output', '&amp;');
		ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,fieldset=');
	}

	// import some important stuff
	require(dirname(__FILE__) . '/../config.php');
	require(dirname(__FILE__) . '/mysql.php');
	require(dirname(__FILE__) . '/func_config_update.php');
	require(dirname(__FILE__) . '/sCensor.php');

	// load admin (global) configuration from database
	$query = 'SELECT conf_name, conf_value FROM ' . $conf_mysql_prefix . 'config';
	
	$q = mysql_query($query);
	
	// define $conf_* vars
	while($r = mysql_fetch_assoc($q)) {
		$$r['conf_name'] = $r['conf_value'];
	}

	if(file_exists('inc/version.inso')) {	
		$v = parse_ini_file('inc/version.inso', false);
		
		if($conf_current_version != $v['conf_current_version']) {
			sblog_config_update('conf_current_version', $v['conf_current_version']);
		}
		
		if($conf_current_build != $v['conf_current_build']) {
			sblog_config_update('conf_current_build', $v['conf_current_build']);
		}
	}
	
	// load username and password from cookie
	if(array_key_exists('username', $_COOKIE) && array_key_exists('password', $_COOKIE)) {
		if($_COOKIE['username'] == $conf_admin_username && $_COOKIE['password'] == $conf_admin_password) {
			$_SESSION['Username'] = $conf_admin_username;
		}
	}

	// load user (visitor) configuration from cookie	
	if(array_key_exists('conf_style_user', $_COOKIE) && $_COOKIE['conf_style_user'] != '') {
		$conf_style_user = $_COOKIE['conf_style_user'];
	}
	
	// set date and time
	if(!isset($conf_date) || $conf_date == '') {
		$conf_date = 'Y-m-d H:i';
	}
	
	// set max image width
	if(!isset($conf_img_width) || $conf_img_width == '' || $conf_img_width == 0) {
		$conf_img_width = 320;
	}

	if(!isset($conf_link_new)) {
		$conf_link_new = 0;
	}
	else {
		$conf_link_new = intval($conf_link_new);
	}
					

	$conf_link_new = intval($conf_link_new);

	// close mysql connection
	mysql_close();

?>