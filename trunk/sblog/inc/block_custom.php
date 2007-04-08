<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/mysql.php');
	
	$query = 'SELECT block_topic, block_content, block_style, block_top FROM ' . $conf_mysql_prefix . 'blocks WHERE block_vis=\'1\' ORDER BY block_pos ASC';
	
	$q = mysql_query($query);
	
	ob_start();

?>
<!-- START OF BLOCK_CUSTOM -->
<?php
	
	while($r = mysql_fetch_assoc($q)) {
		switch($r['block_topic']) {
			case '{CALENDAR}':
				require('inc/block_calendar.php');
				break;
			case '{ARCHIVE}':
				require('inc/block_archive.php');
				break;
			case '{CATEGORIES}':
				require('inc/block_categories.php');
				break;
			case '{LATEST}':
				require('inc/block_latest.php');
				break;
			case '{COMMENTS}':
				require('inc/block_comments.php');
				break;
			case '{SEARCH}':
				require('inc/block_search.php');
				break;
			case '{STYLE}':
				require('inc/block_style.php');
				break;
			case '{LINKS}':
				require('inc/block_links.php');
				break;
			case '{RSS}':
				require('inc/block_rss.php');
				break;
			case '{ADMIN}':
				require('inc/block_admin.php');
				break;
			default:
				echo "\t\t\t" . '<div class="sblog_block">' . "\n";
				if(intval($r['block_top']) == 1) {
					echo "\t\t\t\t" . '<div class="sblog_block_topic">' . "\n";
					echo "\t\t\t\t\t" . '<h2 class="sblog_block_topic_text">' . htmlspecialchars(stripslashes($r['block_topic'])) . '</h2>' . "\n";
					echo "\t\t\t\t" . '</div>' . "\n";
				}
				
				if(intval($r['block_style']) == 1) {
					echo "\t\t\t\t" . '<div class="sblog_block_text">' . "\n";
					echo "\t\t\t\t\t" . stripslashes($r['block_content']) . "\n";
					echo "\t\t\t\t" . '</div>' . "\n";
				}
				else {
					echo "\t\t\t\t" . $r['block_content'] . "\n";
				}
				
				echo "\t\t\t" . '</div>' . "\n";
				break;
		}
	}

?>
			<!-- END OF BLOCK_CUSTOM -->
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_block_custom>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	mysql_close();

?>