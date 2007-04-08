<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	
	if(array_key_exists('id', $_POST) && intval($_POST['id']) != 0) {
		$id = intval($_POST['id']);
	}
	
	$block_topic = mysql_escape_string($_POST['block_topic']);
	$block_content = mysql_escape_string($_POST['block_content']);
	$block_vis = intval($_POST['block_vis']);
	$block_style = intval($_POST['block_style']);
	$block_top = intval($_POST['block_top']);
	
	require('inc/mysql.php');

	if(intval($id) != 0) {	
		$query = 'UPDATE ' . $conf_mysql_prefix . 'blocks SET block_topic=\'' . $block_topic . '\', block_content=\'' . $block_content . '\', block_vis=\'' . $block_vis . '\', block_style=\'' . $block_style . '\', block_top=\'' . $block_top . '\' WHERE id=\'' . $id . '\' LIMIT 1';
	}
	else {
		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'blocks SET block_topic=\'' . $block_topic . '\', block_content=\'' . $block_content . '\', block_vis=\'' . $block_vis . '\', block_style=\'' . $block_style . '\', block_top=\'' . $block_top . '\'';
	}
	
	mysql_query($query);
	
	if(intval($id) == 0) {
		$id = mysql_insert_id();
	}
	
	mysql_close();

	header('Location: blocks_edit.php?id=' . $id);
	exit;

?>