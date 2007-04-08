<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');

	$link_title		= mysql_escape_string($_REQUEST['link_title']);
	$link_url		= mysql_escape_string(str_replace('http://', '', $_REQUEST['link_url']));
	
	if($link_title != '' && $link_url != '') {
		
		require('inc/mysql.php');
		
		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'links SET date_created=NOW(), link_title=\'' . $link_title . '\', link_url=\'' . $link_url . '\'';
		
		mysql_query($query);
		mysql_close();
	
	}
	
	header('Location: links.php');
	exit;

?>