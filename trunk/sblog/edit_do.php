<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');

	// some important stuff
	require('inc/config.php');

	// update post
	if(array_key_exists('id', $_POST) && intval($_POST['id']) > 0) {
		$id				= intval($_POST['id']);
		$topic			= mysql_escape_string($_POST['topic']);
		$text				= mysql_escape_string($_POST['text']);
		$category_id	= intval($_POST['category_id']);
		
		require('inc/mysql.php');
		
		if(array_key_exists('silent', $_POST) && intval($_POST['silent']) == 1 && array_key_exists('date_created', $_POST) && strlen($_POST['date_created']) == 14) {
			$date_created = $_POST['date_created'];
		}
		else {
			$date_created = date('YmdHis');
		}
		
		$query = 'UPDATE ' . $conf_mysql_prefix . 'data SET date_modified=\'' . $date_created . '\', topic=\'' . $topic . '\', text=\'' . $text . '\', category_id=\'' . $category_id . '\' WHERE id=\'' . $id . '\' LIMIT 1';

		mysql_query($query);
		mysql_close();
	}
	// insert post
	else {
		$topic			= mysql_escape_string($_POST['topic']);
		$text				= mysql_escape_string($_POST['text']);
		$category_id	= intval($_POST['category_id']);
		
		require('inc/mysql.php');
		
		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'data SET date_created=NOW(), topic=\'' . $topic . '\', text=\'' . $text . '\', category_id=\'' . $category_id . '\'';
		
		mysql_query($query);
		mysql_close();
	}

	header('Location: index.php');
	exit;

?>