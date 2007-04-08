<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/
	
	require('inc/config.php');
	require('inc/lang.php');

	/* start <sblog_menu> */
	ob_start();
	
?>
<?php

	if(array_key_exists("Username", $_SESSION) && $_SESSION['Username'] == $conf_admin_username) {
		
?>
	<!-- MENU START -->
	<div id="sblog_menu">
			<a href="edit.php" class="sblog_menu_link"><?php echo lang('add post'); ?></a> <a href="image.php" class="sblog_menu_link"><?php echo lang('images'); ?></a> <a href="categories.php" class="sblog_menu_link"><?php echo lang('categories'); ?></a> <a href="links.php" class="sblog_menu_link"><?php echo lang('links'); ?></a> <a href="censoring.php" class="sblog_menu_link"><?php echo lang('censoring'); ?></a> <a href="blocks_pos.php" class="sblog_menu_link"><?php echo lang('blocks'); ?></a> <a href="settings.php" class="sblog_menu_link"><?php echo lang('settings'); ?></a> <a href="logout.php" class="sblog_menu_link"><?php echo lang('logout'); ?></a>
	</div>
	<!-- MENU END -->
<?php

	}
	else {
		
?>
	<!-- MENU START -->
	<!-- MENU END -->
<?php

	}

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_menu>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_menu> */

?>