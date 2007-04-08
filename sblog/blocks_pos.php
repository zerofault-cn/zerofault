<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');

	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	ob_start();
	
?>

			<div class="sblog_post">
				<form id="custom_block" method="post" action="blocks_pos_do.php">
				<fieldset>
					<legend><?php echo lang('Block positions'); ?></legend>
<?php

	require('inc/mysql.php');

	$query = 'SELECT id, block_topic, block_pos, block_vis FROM ' . $conf_mysql_prefix . 'blocks ORDER BY block_pos ASC';
	
	$q = mysql_query($query);
	
	while($r = mysql_fetch_assoc($q)) {
		
		// fancy topics
		if(strlen($r['block_topic']) > 0) {
			if(substr($r['block_topic'], 0, 1) == '{' && substr($r['block_topic'], -1) == '}') {
				$topic = $r['block_topic'];
			}
			else {
				$topic = '<strong>' . $r['block_topic'] . '</strong>';
			}
		}
		else {
			$topic = '<strong><i>' . lang('no topic') . '</i></strong>';
		}
		
		// which boxes to check
		if(intval($r['block_vis']) == 1) {
			$checked = ' checked="checked"';
		}
		else {
			$checked = null;
		}

		echo "\t\t\t\t\t" . '<div class="sblog_var">' . "\n";
		echo "\t\t\t\t\t\t" . '<input type="checkbox" name="vis[' . $r['id'] . ']" value="1"' . $checked . ' title="' . lang('Show/Hide') . '" />' . "\n";
		//echo "\t\t\t\t\t\t" . '<a href="blocks_del.php?id=' . $r['id'] . '">' . lang('delete') . '</a>' . "\n";
		echo "\t\t\t\t\t\t" . '<a href="blocks_edit.php?id=' . $r['id'] . '">' . lang('edit') . '</a>' . "\n";
		echo "\t\t\t\t\t" . '</div>' . "\n";
		echo "\t\t\t\t\t" . '<div class="sblog_val">' . "\n";
		echo "\t\t\t\t\t\t" . lang('Position') . ': <input type="text" name="pos[' . $r['id'] . ']" value="' . $r['block_pos'] . '" size="3" maxlength="5" class="sblog_input" />' . "\n";
		echo "\t\t\t\t\t\t" . $topic . "\n";
		echo "\t\t\t\t\t" . '</div>' . "\n";
	}
	
	mysql_close();

?>
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Built in blocks'); ?></legend>
					{ADMIN} <strong><?php echo lang('Administrator'); ?></strong><br />
					{ARCHIVE} <strong><?php echo lang('Archive'); ?></strong><br />
					{CALENDAR} <strong><?php echo lang('Calendar'); ?></strong><br />
					{CATEGORIES} <strong><?php echo lang('Categories'); ?></strong><br />
					{COMMENTS} <strong><?php echo lang('Comments'); ?></strong><br />
					{LATEST} <strong><?php echo lang('Latest posts'); ?></strong><br />
					{LINKS} <strong><?php echo lang('Links'); ?></strong><br />
					{RSS} <strong><?php echo lang('RSS Feeds'); ?></strong><br />
					{SEARCH} <strong><?php echo lang('Search'); ?></strong><br />
					{STYLE} <strong><?php echo lang('Style'); ?></strong><br />
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Options'); ?></legend>
					<input type="button" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" />
					<input type="button" value="<?php echo lang('Create block'); ?>" onclick="javascript:location.href='blocks_edit.php';return false" class="sblog_button" />
					<input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
				</fieldset>
				</form>
			</div>

<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>