<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	/* start <sblog_main> */
	ob_start();

?>

<?php

	require('inc/sRenderPost.php');
	require('inc/mysql.php');
	
	if(array_key_exists('id', $_REQUEST)) {
		$id = intval($_REQUEST['id']);
	}
	else {
		$id = null;
	}

	$query = 'SELECT d.id, UNIX_TIMESTAMP(d.date_created) AS date_created, UNIX_TIMESTAMP(d.date_modified) AS date_modified, d.topic, d.text, d.category_id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id AND d.id=\'' . $id . '\' LIMIT 1';
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);
	
	if($n > 0) {
		$r = mysql_fetch_assoc($q);
		
		sRenderPost($r['id'], $r['category_id'], $r['category'], $r['date_created'], $r['date_modified'], $r['topic'], $r['text']);
	}
	else {
		echo '<div class="sblog_post">';
		echo '<div class="sblog_post_topic">' . lang('The post has been deleted!') . '</div>';
		echo '</div>';
	}
	
	mysql_close();

?>
			<!-- <input type="reset" value="<?php echo lang('Go back'); ?>" onClick="javascript:history.go(-1);return false"> -->
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */

?>