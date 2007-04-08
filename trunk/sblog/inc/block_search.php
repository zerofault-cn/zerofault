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
	
	if(array_key_exists('keyword', $_POST) && strlen($_POST['keyword']) > 1) {
		$keyword = stripslashes($_POST['keyword']);
	}
	else {
		$keyword = null;
	}

?>
<!-- START OF BLOCK_SEARCH -->
			<form id="search" method="post" action="search.php">
				<div class="sblog_block">
					<div class="sblog_block_topic">
						<h2 class="sblog_block_topic_text"><?php echo lang('Search posts'); ?></h2>
					</div>
					<div class="sblog_block_text">
						<input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="sblog_search" />
					<input type="submit" value="<?php echo lang('Search posts'); ?>" /></div>
				</div>
			</form>
			<!-- END OF BLOCK_SEARCH -->