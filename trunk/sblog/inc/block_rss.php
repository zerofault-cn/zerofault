<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// do not declare truncate() more than once!
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}
	
?>
<!-- START OF BLOCK_RSS -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('RSS Feeds'); ?></h2>
				</div>
				<div class="sblog_block_text">
					<a href="<?php echo $conf_web_root; ?>rss/?mode=0.91"><img src="img/rss091.png" alt="RSS 0.91" /></a><br />
					<a href="<?php echo $conf_web_root; ?>rss/?mode=2.0"><img src="img/rss20.png" alt="RSS 2.0" /></a>
				</div>
			</div>
			<!-- END OF BLOCK_RSS -->