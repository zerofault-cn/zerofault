<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');

	if(isset($_REQUEST['id'])) {
		
		$id = $_REQUEST['id'];
		
		// delete link
		require('inc/mysql.php');
		$query = 'DELETE FROM ' . $conf_mysql_prefix . 'links WHERE id=\'' . $id . '\' LIMIT 1';
		mysql_query($query);
		mysql_close();
	}
	
	header('Location: links.php');
	exit;

?>