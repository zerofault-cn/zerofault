<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// do not declare truncate() more than once!
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}
	
?>
<!-- START OF BLOCK_ADMIN -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Administrator'); ?></h2>
				</div>
				<div class="sblog_block_text">
					<ul>
<?php

	if(array_key_exists('Username', $_SESSION) && $_SESSION['Username'] == $conf_admin_username) {
		echo "\t\t\t\t\t\t" . '<li><a href="logout.php">' . lang('Logout') . '</a></li>' . "\n";
	}
	else {
		echo "\t\t\t\t\t\t" . '<li><a href="login.php">' . lang('Login') . '</a></li>' . "\n";
	}

?>
					</ul>
				</div>
			</div>
			<!-- END OF BLOCK_ADMIN -->