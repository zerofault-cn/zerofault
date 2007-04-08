<?php	

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');

	if(@ini_get('allow_url_fopen') == 0) {
		@ini_set('allow_url_fopen', '1');
	}

	if($remote = @file('http://www.sblog.cn/upgrade/version.inso')) {
		// remote version
		$remote_current_version = trim($remote[0]);
		$remote_current_build = trim($remote[1]);
		$remote_download = trim($remote[2]);
	}

	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');
	
	// include blocks
	require('inc/block_custom.php');	// custom blocks

	ob_start();
	
	if($remote != true) {
?>
			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Error'); ?></h2>
				</div>
				<div class="sblog_post_text">
					<strong><?php echo lang('Could not fetch information from server!'); ?></strong><br /><br />
					<?php echo lang('Please try again later.'); ?><br /><br />
					<input type="button" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.back(-1);return false" class="sblog_button" />
				</div>
			</div>
<?php
	}
	else if($remote_current_build > $conf_current_build) {

?>
			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('New version of sBLOG available!'); ?></h2>
				</div>
				<div class="sblog_post_text">
					<strong>sBLOG <?php echo $remote_current_version; ?> (Build <?php echo $remote_current_build; ?>)</strong><br /><br />
					<input type="button" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.back(-1);return false" class="sblog_button" />
					<input type="button" value="<?php echo lang('Download'); ?>" onclick="window.open('<?php echo $remote_download; ?>');return false" class="sblog_button" />
				</div>
			</div>
<?php

	}
	else {
		
?>
			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('No new version available.'); ?></h2>
				</div>
				<div class="sblog_post_text">
					<?php echo lang('You are using the latest version of sBLOG.'); ?><br />
					sBLOG中文版 <?php echo $conf_current_version; ?> (Build <?php echo $conf_current_build; ?>).<br /><br />
					<input type="button" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.back(-1);return false" class="sblog_button" />
				</div>
			</div>
<?php

	}
	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;
?>