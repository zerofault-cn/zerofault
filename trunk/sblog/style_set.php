<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/config.php');

	if(array_key_exists('style_user', $_REQUEST) && $_REQUEST['style_user'] != '') {
		$style_user = $_REQUEST['style_user'];
		setcookie('conf_style_user', $style_user, time() + 33600);
	}
	else {
		setcookie('conf_style_user', null, time() - 3600);
	}
	
	header('Location: index.php');
	exit;

?>