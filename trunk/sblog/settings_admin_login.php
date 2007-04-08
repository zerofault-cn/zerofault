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

	/* start <sblog_main> */
	ob_start();

?>
<!-- ADMIN LOGIN -->
				<form id="admin_login" method="post" action="settings_admin_login_do.php">
					<fieldset>
						<legend><?php echo lang('Username'); ?></legend>
						<div class="sblog_var">
							<?php echo lang('Username'); ?>
						</div>
						<div class="sblog_val">
							<input type="text" name="admin_username" id="admin_username" value="<?php echo $conf_admin_username; ?>" class="sblog_input" />
						</div>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Password'); ?></legend>
						<div class="sblog_var">
							<?php echo lang('Current password'); ?>
						</div>
						<div class="sblog_val">
							<input type="password" name="admin_password_current" id="admin_password_current" value="" class="sblog_input" />
						</div>
						
						<div class="sblog_var">
							<?php echo lang('New password'); ?>
						</div>
						<div class="sblog_val">
							<input type="password" name="admin_password_new1" id="admin_password_new1" value="" class="sblog_input" />
						</div>
						
						<div class="sblog_var">
							<?php echo lang('Verify new password'); ?>
						</div>
						<div class="sblog_val">
							<input type="password" name="admin_password_new2" id="admin_password_new2" value="" class="sblog_input" />
						</div>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
						<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" />
						<input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
					</fieldset>
				</form>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>