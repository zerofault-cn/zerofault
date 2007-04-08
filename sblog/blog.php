<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// include headers
	require('inc/tpl_header_blog.php');
	require('inc/tpl_comments.php');
	require('inc/tpl_menu.php');
	require('inc/tpl_blog.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// include blocks
	require('inc/tpl_foot.php');

	// echo buffer
	echo $tpl_main;

?>