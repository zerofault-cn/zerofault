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

	if(!isset($conf_comments_act) || $conf_comments_act == 1) {
		$comments_act_check = ' checked="checked"';
	}
	else {
		$comments_act_check = null;
	}

	if(!isset($conf_comments_email) || $conf_comments_email == 1) {
		$comments_email_check = ' checked="checked"';
	}
	else {
		$comments_email_check = null;
	}

	/* start <sblog_main> */
	ob_start();

?>
<!-- OPTIONS -->
			<div class="sblog_post_text">
				<form id="settings" method="post" action="settings_do.php">
					<fieldset>
						<legend><?php echo lang('Personal'); ?></legend>
						<a href="settings_admin_login.php"><?php echo lang('Change the administrator\'s username and password.'); ?></a><br /><br />
						<div class="sblog_var"><?php echo lang('Page title'); ?></div>
						<div class="sblog_val"><input type="text" name="page_title" id="page_title" size="40" maxlength="40" value="<?php echo htmlspecialchars(stripslashes($conf_page_title)); ?>" class="sblog_input" /></div>
						<div class="sblog_var"><?php echo lang('Page description'); ?></div>
						<div class="sblog_val"><input type="text" name="page_description" id="page_description" size="40" value="<?php echo htmlspecialchars(stripslashes($conf_page_description)); ?>" class="sblog_input" /></div>
						<div class="sblog_var"><?php echo lang('E-mail'); ?></div>
						<div class="sblog_val"><input type="text" name="admin_email" id="admin_email" size="40" value="<?php echo htmlspecialchars($conf_admin_email); ?>" class="sblog_input" /></div>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Comments'); ?></legend>
						<label for="comments_act" class="sblog_label_col"><input type="checkbox" name="comments_act" id="comments_act" value="1"<?php echo $comments_act_check; ?> /> <?php echo lang('Enable user comments'); ?></label>
						<label for="comments_email" class="sblog_label_col"><input type="checkbox" name="comments_email" id="comments_email" value="1"<?php echo $comments_email_check; ?> /> <?php echo lang('Send me e-mails when new comments are posted.'); ?></label>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Limits'); ?></legend>
						<input type="text" name="page_disp" id="page_disp" size="3" maxlength="3" value="<?php echo htmlspecialchars(stripslashes($conf_page_disp)); ?>" class="sblog_input" /> <?php echo lang('Posts per page'); ?><br />
						<input type="text" name="bar_latest_disp" id="bar_latest_disp" size="3" maxlength="3" value="<?php echo htmlspecialchars(stripslashes($conf_bar_latest_disp)); ?>" class="sblog_input" /> <?php echo lang('Posts in "Latest posts"'); ?><br />
						<input type="text" name="bar_comments_disp" id="bar_comments_disp" size="3" maxlength="3" value="<?php echo htmlspecialchars(stripslashes($conf_bar_comments_disp)); ?>" class="sblog_input" /> <?php echo lang('Posts in "Comments"'); ?><br />
						<input type="text" name="img_width" id="img_width" size="3" maxlength="4" value="<?php echo $conf_img_width; ?>" class="sblog_input" /> <?php echo lang('Max. image width (in pixels). This requires GD to work.'); ?> <?php echo lang('Default'); ?>: 320<br />
						
						<input type="text" name="block_chars" id="block_chars" size="3" maxlength="3" value="<?php echo $conf_block_chars; ?>" class="sblog_input" /> <?php echo lang('Max number of characters in blocks.');?> <?php echo lang('Default'); ?>: 16<br />
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Date and time'); ?></legend>
						<select name="conf_date" id="conf_date">
<?php

	if($conf_date == '%Y-%m-%d %H:%M') {
		$selected = ' selected="selected"';
	}
	else {
		$selected = null;
	}

?>
							<option value="%Y-%m-%d %H:%M"<?php echo $selected; ?>><?php echo strftime('%Y-%m-%d %H:%M', time()); ?></option>
<?php

	if($conf_date == '%A, %#d %B %Y %H:%M') {
		$selected = ' selected="selected"';
	}
	else {
		$selected = null;
	}

?>
							<option value="%A, %#d %B %Y %H:%M"<?php echo $selected; ?>><?php echo strftime('%A, %#d %B %Y %H:%M', time()); ?></option>
<?php

	if($conf_date == '%m/%d/%y %H:%M') {
		$selected = ' selected="selected"';
	}
	else {
		$selected = null;
	}

?>
							<option value="%m/%d/%y %H:%M"<?php echo $selected; ?>><?php echo strftime('%m/%d/%y %H:%M', time()); ?></option>
<?php

	if($conf_date == 'the %#d %B %Y %H:%M') {
		$selected = ' selected="selected"';
	}
	else {
		$selected = null;
	}

?>
							<option value="the %#d %B %Y %H:%M"<?php echo $selected; ?>><?php echo strftime(lang('the %#d %B %Y %H:%M'), time()); ?></option>
						</select><br />
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Miscellaneous'); ?></legend>
							<div class="sblog_var">
								<?php echo lang('Version'); ?>
							</div>
							<div class="sblog_val">
								<strong><?php echo $conf_current_version; ?></strong> (Build <?php echo $conf_current_build; ?>)<br />
								<a href="upgrade.php"><?php echo lang('Check for upgrade'); ?></a>
							</div>
							<div class="sblog_var">
								<?php echo lang('Style'); ?>
							</div>
							<div class="sblog_val">
								<select name="style_default" id="style_default">
<?php

	if($handle = opendir('style/')) {
		while(false !== ($file = readdir($handle))) {
			if(is_file('style/' . $file) && substr($file, -4) == '.css') {
				if(basename($file, '.css') == $conf_style_default) {
					$selected = ' selected="selected"';
				}
				else {
					$selected = null;
				}
				
				echo "\t\t\t\t\t\t\t\t\t" . '<option value="' . basename($file, '.css') . '"' . $selected . '>' . basename($file, '.css') . '</option>' . "\n";
			}
		}
	}

?>
								</select><br />
								<a href="http://servous.se/?c=styles" rel="external" title="<?php echo lang('Download new styles'); ?>"><?php echo lang('Download new styles'); ?></a>
							</div>
							
							<div class="sblog_var">
								<?php echo lang('Language'); ?>
							</div>
							<div class="sblog_val">
								<select name="lang_default" id="lang_default">
									<option value="Chinese_Simplified"><?php echo lang('Default'); ?></option>
<?php

	if($handle = opendir('lang/')) {
		while(false !== ($file = readdir($handle))) {
			if(is_file('lang/' . $file) && substr($file, -4) == '.php') {
				if(basename($file, '.php') == $conf_lang_default) {
					$selected = ' selected="selected"';
				}
				else {
					$selected = null;
				}
				
				echo "\t\t\t\t\t\t\t\t\t" . '<option value="' . basename($file, '.php') . '"' . $selected . '>' . basename($file, '.php') . '</option>' . "\n";
			}
		}
	}

?>
								</select><br />
								<a href="http://servous.se/?c=translation" rel="external" title="Download language files"><?php echo lang('Download language files'); ?></a>
							</div>
							<div class="sblog_var">
								<?php echo lang('Links'); ?>
							</div>
							<div class="sblog_val">
<?php

	if(intval($conf_link_new) == 1) {
		$checked = ' checked="checked"';
	}
	else {
		$checked = null;
	}

?>
							<label for="link_new"><input type="checkbox" name="link_new" id="link_new" value="1"<?php echo $checked; ?> /> <?php echo lang('Open links in a new window.'); ?></label>
						</div>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
						<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" /> <input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
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