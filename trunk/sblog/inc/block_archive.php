<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	$queryArchive = 'SELECT COUNT(id) AS n, UNIX_TIMESTAMP(date_created) AS date FROM ' . $conf_mysql_prefix . 'data GROUP BY SUBSTRING(date_created, 1, 7) ORDER BY date_created DESC';
	
	$qArchive = mysql_query($queryArchive);
	$nArchive = mysql_num_rows($qArchive);

	if($nArchive > 0) {
		// do not declare truncate() more than once!
		if(!function_exists('truncate')) {
			require('inc/func_truncate.php');
		}

	
?><!-- START OF BLOCK_ARCHIVE -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Archive'); ?></h2>
				</div>
				<div class="sblog_block_text">
<?php

			if($nArchive > 0) {
				echo "\t\t\t\t\t" . '<ul>' . "\n";
				while($rArchive = mysql_fetch_assoc($qArchive)) {
					echo "\t\t\t\t\t\t" . '<li><a href="index.php?date=' . date('Ym', $rArchive['date']) . '" title="' . ucwords(strftime('%Y年%m月', $rArchive['date'])) . ' [' . $rArchive['n'] . ']">' . ucwords(strftime('%Y年%m月', $rArchive['date'])) . '</a></li>' . "\n";
				}
				echo "\t\t\t\t\t" . '</ul>' . "\n";
			}

?>
				</div>
			</div>
			<!-- END OF BLOCK_ARCHIVE -->
<?php

	}

?>