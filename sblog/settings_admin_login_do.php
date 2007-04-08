<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	require('inc/config.php');
	require('inc/lang.php');

	if(array_key_exists('admin_username', $_POST)) {
		$admin_username = $_POST['admin_username'];
	}
	else {
		$admin_username = null;
	}
	
	if(array_key_exists('admin_password_current', $_POST)) {
		$admin_password_current = md5($_POST['admin_password_current']);
	}
	else {
		$admin_password_current = null;
	}
	
	if(array_key_exists('admin_password_new1', $_POST)) {
		$admin_password_new1 = $_POST['admin_password_new1'];
	}
	else {
		$admin_password_new1 = null;
	}
	
	if(array_key_exists('admin_password_new2', $_POST)) {
		$admin_password_new2 = $_POST['admin_password_new2'];
	}
	else {
		$adminm_password_new2 = null;
	}
	
	if(strlen($admin_username) > 0) {
		require('inc/mysql.php');
		
		$query = 'UPDATE ' . $conf_mysql_prefix . 'config SET conf_value=\'' . $admin_username . '\' WHERE conf_name=\'conf_admin_username\' LIMIT 1';

		if(mysql_query($query)) {
			$msg[] = lang('Administrator\'s username has been updated.');
		}
		else {
			$error[] = lang('Could not update administrator\'s username!');
		}
		
		if(strlen($admin_password_new1) > 0) {
			if(strlen($admin_password_new1) >= 4 && $admin_password_current == $conf_admin_password) {
				if($admin_password_new1 == $admin_password_new2) {
					$query = 'UPDATE ' . $conf_mysql_prefix . 'config SET conf_value=\'' . md5($admin_password_new1) . '\' WHERE conf_name=\'conf_admin_password\' LIMIT 1';

					if(mysql_query($query)) {
						$msg[] = lang('Administrator\'s password has been updated.');
					}
					else {
						$error[] = lang('Could NOT update administrator\'s password!');
					}
				}
				else {
					$error[] = lang('Passwords doesn\'t match!');
				}
			}
			else {
				$error[] = lang('Wrong password!');
			}
		}
		
		mysql_close();
	}
	else {
		$error[] = lang('ERROR: Invalid username!');
	}
	
	// include headers
	require('inc/tpl_header.php');		// header
	require('inc/tpl_menu.php');			// menu

	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// start <sblog_main>
	ob_start();

?>
	<div class="sblog_post_text">
<?php

	if(isset($error)) {
		echo "\t" . '<fieldset>' . "\n";
		echo "\t\t" . '<legend>' . lang('Error(s)') . '</legend>' . "\n";
		
		while(list(, $val) = each($error)) {
			echo '<span style="color: #CC0000;">' . $val . '</span><br />' . "\n";
		}
		
		echo "\t" . '</fieldset>' . "\n";
	}

?>
<?php

	if(isset($msg)) {
		echo "\t" . '<fieldset>' . "\n";
		echo "\t\t" . '<legend>' . lang('Message(s)') . '</legend>' . "\n";
		
		while(list(, $val) = each($msg)) {
			echo '<span style="color: #009900;">' . $val . '</span><br />' . "\n";
		}
		
		echo "\t" . '</fieldset>' . "\n";
	}

?>
		<fieldset>
			<legend>选项</legend>
			<input type="reset" value="返回" onclick="javascript:location.href='settings_admin_login.php';return false" />
		</fieldset>
	</div>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	// end <sblog_main>
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>