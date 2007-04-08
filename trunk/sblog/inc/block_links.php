<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	$queryLinks = 'SELECT link_title, link_url FROM ' . $conf_mysql_prefix . 'links ORDER BY link_title ASC';
	
	$qLinks = mysql_query($queryLinks);
	$nLinks = mysql_num_rows($qLinks);

	if($nLinks > 0) {
		// do not declare truncate() more than once!
		if(!function_exists('truncate')) {
			require('inc/func_truncate.php');
		}

?>
<!-- START OF BLOCK_LINKS -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Links'); ?></h2>
				</div>
				<div class="sblog_block_text">
<?php

		if($nLinks > 0) {
			echo "\t\t\t\t\t" . '<ul>' . "\n";
			
			while($rLinks = mysql_fetch_assoc($qLinks)) {
				$tmp_link_title = truncate($rLinks['link_title'], $conf_block_chars);
				echo "\t\t\t\t\t\t" . '<li><a href="' . $rLinks['link_url'] . '" rel="external" title="' . htmlspecialchars($rLinks['link_title']) . '">' . $tmp_link_title . '</a></li>' . "\n";
			}
			
			echo "\t\t\t\t\t" . '</ul>' . "\n";
		}

?>
				</div>
			</div>
			<!-- END OF BLOCK_LINKS -->
<?php

	}

?>