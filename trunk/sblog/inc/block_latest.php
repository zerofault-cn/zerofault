<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// define max rows in sblog_block_latest
	if(isset($conf_bar_latest_disp) && $conf_bar_latest_disp != '') {
		$limit = $conf_bar_latest_disp;
	}
	else {
		$limit = 10;
	}

	$queryRecent = 'SELECT id, topic FROM ' . $conf_mysql_prefix . 'data ORDER BY date_created DESC LIMIT ' . $limit;
	
	$qRecent = mysql_query($queryRecent);
	$nRecent = mysql_num_rows($qRecent);

	if($nRecent > 0) {
		// do not declare truncate() more than once!
		if(!function_exists('truncate')) {
			require('inc/func_truncate.php');
		}

?>
<!-- START OF BLOCK_LATEST -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Latest posts'); ?></h2>
				</div>
				<div class="sblog_block_text">
<?php
		
		if($nRecent > 0) {
			echo "\t\t\t\t\t" . '<ul>' . "\n";		
			while($rRecent = mysql_fetch_assoc($qRecent)) {
				if(strlen($rRecent['topic']) < 1) {
					$tmp_topic = '<i>-{ ' . lang('no topic') . ' }-</i>';
				}
				else {
					$tmp_topic = truncate(stripslashes($rRecent['topic']), $conf_block_chars);
				}
				
				echo "\t\t\t\t\t\t" . '<li><a href="blog.php?id=' . $rRecent['id'] . '" title="' . htmlspecialchars(stripslashes($rRecent['topic'])) . '">' . $tmp_topic . '</a></li>' . "\n";
			}
			echo "\t\t\t\t\t" . '</ul>' . "\n";
		}

?>
				</div>
			</div>
			<!-- END OF BLOCK_LATEST -->
<?php

	}

?>