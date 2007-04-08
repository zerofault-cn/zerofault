<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	session_start();
	
	unset($_SESSION['Username']);
	
	setcookie('username', null, time()-3600);
	setcookie('password', null, time()-3600);
	
	header("Location: index.php");
	exit;

?>