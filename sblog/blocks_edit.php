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
	
	if(array_key_exists('id', $_GET) && intval($_GET['id']) != 0) {
		$id = intval($_GET['id']);
		
		require('inc/mysql.php');
		
		$query = 'SELECT id, block_topic, block_content, block_vis, block_style, block_top FROM ' . $conf_mysql_prefix . 'blocks WHERE id=\'' . $id . '\' LIMIT 1';
		
		$q = mysql_query($query);
		$r = mysql_fetch_assoc($q);
		
		$block_topic = $r['block_topic'];
		$block_content = $r['block_content'];
		$block_vis = intval($r['block_vis']);
		$block_style = intval($r['block_style']);
		$block_top = intval($r['block_top']);
		
		mysql_close();
	}
	else {
		$id = null;
		$block_topic = null;
		$block_content = null;
		$block_vis = 0;
		$block_style = 1;
		$block_top = 1;
	}
	
	ob_start();
	
?>

			<div class="sblog_post">
				<form id="blocks_edit" method="post" action="blocks_edit_do.php">
				<fieldset>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<legend><?php echo lang('Block topic'); ?></legend>
					<input type="text" name="block_topic" id="block_topic" value="<?php echo htmlspecialchars(stripslashes($block_topic)); ?>" class="sblog_input" />
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Block content'); ?></legend>
					<textarea name="block_content" id="block_content" cols="40" rows="10" class="sblog_text"><?php echo htmlspecialchars(stripslashes($block_content)); ?></textarea><br />
					<?php echo lang('This field is not parsed as regular posts and may thus contain HTML tags.'); ?>
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Block settings'); ?></legend>
<?php

	if($block_vis == 1) {
		$checked = ' checked="checked"';
	}
	else {
		$checked = null;
	}

?>
					<label for="block_vis"><input type="checkbox" name="block_vis" id="block_vis" value="1"<?php echo $checked; ?> /> <?php echo lang('Make the block visible for visitors'); ?></label><br />
<?php

	if($block_style == 1) {
		$checked = ' checked="checked"';
	}
	else {
		$checked = null;
	}

?>
					<label for="block_style"><input type="checkbox" name="block_style" id="block_style" value="1"<?php echo $checked; ?> /> <?php echo lang('Use block style'); ?></label><br />
<?php

	if($block_top == 1) {
		$checked = ' checked="checked"';
	}
	else {
		$checked = null;
	}

?>
					<label for="block_top"><input type="checkbox" name="block_top" id="block_top" value="1"<?php echo $checked; ?> /> <?php echo lang('Show block topic'); ?></label><br />
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Options'); ?></legend>
					<input type="button" value="<?php echo lang('Cancel'); ?>" onclick="javascript:location.href='blocks_pos.php';return false" class="sblog_button" />
<?php

	if(isset($id)) {

?>
					<input type="button" value="<?php echo lang('Delete'); ?>" onclick="javascript:location.href='blocks_del.php?id=<?php echo $id; ?>';return false" class="sblog_button" />
<?php

	}

?>
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