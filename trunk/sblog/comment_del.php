<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');

	if(array_key_exists('id', $_REQUEST) && $_REQUEST['id'] != '') {
		
		$id		= $_REQUEST['id'];
		$blog_id	= $_REQUEST['blog_id'];
		
		require('inc/config.php');
		require('inc/mysql.php');
		
		$query = 'DELETE FROM ' . $conf_mysql_prefix . 'comments WHERE id=\'' . $id . '\' AND blog_id=\'' . $blog_id . '\' LIMIT 1';
		
		mysql_query($query);
		
		mysql_close();
	}
	
	header('Location: comments.php?id=' . $blog_id);
	exit;

?>