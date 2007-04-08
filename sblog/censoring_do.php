<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// import some important stuff
	require('inc/config.php');

	// define variables
	$word_orig = mysql_escape_string($_POST['word_orig']);
	$word_repl = mysql_escape_string($_POST['word_repl']);
	
	// prevent blank posting
	if($word_orig != '' && $word_repl != '') {
		
		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'censoring SET word_orig=\'' . $word_orig . '\', word_repl=\'' . $word_repl . '\'';
		require('inc/mysql.php');
		mysql_query($query);
		mysql_close();
	}

	header('Location: censoring.php');
	exit;

?>