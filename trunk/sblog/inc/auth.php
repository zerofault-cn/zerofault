<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	session_start();

	require('inc/config.php');
	
	if(!array_key_exists('Username', $_SESSION) || $_SESSION['Username'] != $conf_admin_username) {
		header('Location: ' . $conf_web_root);
		exit;
	}

?>