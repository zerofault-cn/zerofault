<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	session_start();

	require('inc/config.php');

	if($_REQUEST['username'] == $conf_admin_username && md5($_REQUEST['password']) == $conf_admin_password) {
		$_SESSION['Username'] = $conf_admin_username;
		if(array_key_exists('cookie', $_POST) && intval($_POST['cookie']) == 1) {
			setcookie('username', $conf_admin_username, time() + (3600 * 24 * 7));
			setcookie('password', $conf_admin_password, time() + (3600 * 24 * 7));
		}
	}
	
	header("Location: index.php");
	exit;

?>