<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// make sure only administrator deletes stuff
	require('inc/auth.php');
	
	// import some important stuff
	require('inc/config.php');

	// define variables	
	$id = $_REQUEST['id'];

	if($id != '') {
		require('inc/mysql.php');
		
		$query = 'DELETE FROM ' . $conf_mysql_prefix . 'censoring WHERE id=\'' . $id . '\' LIMIT 1';
		
		mysql_query($query);
		mysql_close();
	}
	
	header('Location: censoring.php');
	exit;

?>