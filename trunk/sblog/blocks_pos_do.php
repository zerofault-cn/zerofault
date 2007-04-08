<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	require('inc/mysql.php');

	if(array_key_exists('pos', $_POST)) {
		while(list($key, $val) = each($_POST['pos'])) {
			$id = intval($key);
			$pos = intval($val);
			
			mysql_query('UPDATE ' . $conf_mysql_prefix . 'blocks SET block_pos=\'' . $pos . '\' WHERE id=\'' . $id . '\' LIMIT 1');
		}
	}
	
	if(array_key_exists('vis', $_POST)) {
		mysql_query('UPDATE ' . $conf_mysql_prefix . 'blocks SET block_vis=\'0\'');
		
		while(list($key, $val) = each($_POST['vis'])) {
			$id = intval($key);
			$vis = intval($val);
			
			mysql_query('UPDATE ' . $conf_mysql_prefix . 'blocks SET block_vis=\'' . $vis . '\' WHERE id=\'' . $id . '\' LIMIT 1');
		}
	}

	mysql_close();
	
	header('Location: blocks_pos.php');
	exit;

?>