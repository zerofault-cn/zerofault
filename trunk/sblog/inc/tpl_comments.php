<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(array_key_exists('id', $_REQUEST)) {
		$id = intval($_REQUEST['id']);
	}
	else {
		$id = null;
	}

	// start <sblog_comments>
	ob_start();

?>
<?php

	require('inc/mysql.php');
	
	$query = 'SELECT id, blog_id, UNIX_TIMESTAMP(date_created) AS date_created, username, email, homepage, comment FROM ' . $conf_mysql_prefix . 'comments WHERE blog_id=\'' . $id . '\' ORDER BY date_created DESC';
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);
	
	if($n > 0) {
		echo "\t\t" . '<a name="comments"></a>' . "\n";
		while($r = mysql_fetch_assoc($q)) {
			echo "\t\t" . '<a name="' . $r['id'] . '"></a>' . "\n";
			echo "\t\t" . '<div class="sblog_comment">' . "\n";
			echo "\t\t\t" . '<div class="sblog_comment_topic">' . "\n";
			echo "\t\t\t\t";
			
			if($r['email'] != '') {
			echo '<a href="mailto:' . htmlspecialchars($r['email']) . '" title="' . htmlspecialchars($r['email']) . '">' . htmlspecialchars($r['username']) . '</a>';
			}
			else {
				echo $r['username'];
			}
			
			if($r['homepage'] != '') {
				echo ' @ <a href="http://' . htmlspecialchars($r['homepage']) . '" rel="external">' . htmlspecialchars($r['homepage']) . '</a>';
			}
			
			echo "\t\t\t" . '</div>' . "\n";
			echo "\t\t\t" . '<div class="sblog_comment_text">' . "\n";
			echo '<div class="sblog_comment_edit">' . strftime(lang($conf_date), $r['date_created']) . '</div>' . "\n";
			echo "\t\t\t\t" . bbcode($r['comment']) . "\n";
			echo "\t\t\t" . '</div>' . "\n";
			
			if(array_key_exists('Username', $_SESSION) && $_SESSION['Username'] == $conf_admin_username) {
				echo "\t\t\t" . '<div class="sblog_comment_options">' . "\n";
				echo "\t\t\t\t" . '<a href="comment_del.php?blog_id=' . $r['blog_id'] . '&id=' . $r['id'] . '" class="sblog_comment_options_link">' . lang('delete') . '</a>' . "\n";
				echo "\t\t\t" . '</div>' . "\n";
			}
			
			echo "\t\t" . '</div>' . "\n";
		}
	}
	
	mysql_close();

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_comments>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
?>