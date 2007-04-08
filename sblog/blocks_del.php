<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	
	$id = intval($_REQUEST['id']);
	
	if(array_key_exists('ok', $_POST) && $_POST['ok'] == 1) {
		require('inc/mysql.php');
		mysql_query('DELETE FROM ' . $conf_mysql_prefix . 'blocks WHERE id=\'' . $id . '\' LIMIT 1');
		mysql_close();
		
		header('Location: blocks_pos.php');
		exit;
	}
	else {
		require('inc/tpl_header.php');
		require('inc/tpl_menu.php');
		
		// include blocks
		require('inc/block_custom.php');			// custom blocks
	
		ob_start();
	
?>

			<div class="sblog_post">
				<form id="blocks_del" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<input type="hidden" name="ok" value="1" />
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<legend><?php echo lang('Delete block?'); ?></legend>
					<input type="button" value="<?php echo lang('Cancel'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" />
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
	}

?>