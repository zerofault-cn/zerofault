<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/tpl_header_comments.php');
	require('inc/tpl_menu.php');
	require('inc/tpl_blog.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// if comments are enabled
	if(!isset($conf_comments_act) || $conf_comments_act == 1) {
		require('inc/tpl_comments_add.php');
	}
	
	require('inc/tpl_comments.php');
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>