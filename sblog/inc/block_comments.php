<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(isset($conf_bar_comments_disp) && $conf_bar_latest_disp != '') {
		$limit = $conf_bar_comments_disp;
	}
	else {
		$limit = 10;
	}

	$queryComments = 'SELECT id, blog_id, comment FROM ' . $conf_mysql_prefix . 'comments ORDER BY date_created DESC LIMIT ' . $limit;
	
	$qComments = mysql_query($queryComments);
	$nComments = mysql_num_rows($qComments);

	if($nComments > 0) {
		// do not declare truncate() more than once!
		if(!function_exists('truncate')) {
			require('inc/func_truncate.php');
		}
	
		require('inc/func_bbcode_strip.php');	

?>
<!-- START OF BLOCK_COMMENTS -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Comments'); ?></h2>
				</div>
				<div class="sblog_block_text">
<?php

		if($nComments > 0) {
			echo "\t\t\t\t\t" . '<ul>' . "\n";		
			while($rComments = mysql_fetch_assoc($qComments)) {
				echo "\t\t\t\t\t\t" . '<li><a href="blog.php?id=' . $rComments['blog_id'] . '#' . $rComments['id'] . '" title="' . htmlspecialchars(bbcode_strip($rComments['comment'])) . '">' . htmlspecialchars(substr(bbcode_strip($rComments['comment']), 0, $conf_block_chars)) . ' </a></li>' . "\n";
			}
			echo "\t\t\t\t\t" . '</ul>' . "\n";
		}

?>
				</div>
			</div>
			<!-- END OF BLOCK_COMMENTS -->
<?php

	}

?>