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
<!-- START OF BLOCK_CATEGORY -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Categories'); ?></h2>
				</div>
				<div class="sblog_block_text">
<?php

	$queryCategories = 'SELECT COUNT(d.id) AS n, c.id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id AND c.id!=\'1\' GROUP BY d.category_id ORDER BY category ASC';
	
	$qCategories = mysql_query($queryCategories);
	$nCategories = mysql_num_rows($qCategories);

	echo "\t\t\t\t\t" . '<ul>' . "\n";		
	echo "\t\t\t\t\t\t" . '<li><a href="index.php?cat=1" title="' . lang('Uncategorized') . '">' . truncate(lang('Uncategorized'), $conf_block_chars) . '</a></li>' . "\n";

	if($nCategories > 0) {		
		while($rCategories = mysql_fetch_assoc($qCategories)) {
			echo "\t\t\t\t\t\t" . '<li><a href="index.php?cat=' . $rCategories['id'] . '" title="' . htmlspecialchars($rCategories['category']) . '">' . truncate($rCategories['category'], $conf_block_chars) . '</a> ' . $rCategories['n'] . '</li>' . "\n";
		}
	}
	
	echo "\t\t\t\t\t" . '</ul>' . "\n";

?>
				</div>
			</div>
			<!-- END OF BLOCK_CATEGORY -->