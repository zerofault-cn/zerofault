<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(!file_exists('config.php')) {
		echo 'upload config.php';
		exit;
	}
	
	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');

	// include blocks
	require('inc/block_custom.php');		// custom blocks

	/* start <sblog_main> */
	
	ob_start();
	
?>
	<div class="sblog_post_text">
		<form id="login" method="post" action="login_do.php">
			<fieldset>
				<legend><?php echo lang('Username'); ?></legend>
				<input type="text" name="username" id="username" value="" />
			</fieldset>
			<fieldset>
				<legend><?php echo lang('Password'); ?></legend>
				<input type="password" name="password" id="password" value="" />
			</fieldset>
			<fieldset>
				<legend><?php echo lang('Options'); ?></legend>
				<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" />
				<input type="submit" value="<?php echo lang('Login'); ?>" class="sblog_button" />
				<label for="cookie"><input type="checkbox" name="cookie" id="cookie" value="1" /> <?php echo lang('Remember me for a week.'); ?></label>
			</fieldset>
		</form>
	</div>
	
	<script type="text/javascript">
	<!--
		document.getElementById('username').focus();
	-->
	</script>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');

	echo $tpl_main;

?>