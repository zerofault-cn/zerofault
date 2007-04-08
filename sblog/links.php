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
				<div class="sblog_post_text">
				<form id="links" method="post" action="links_do.php">
					<fieldset>
						<legend><?php echo lang('Link title'); ?></legend>
						<input type="text" name="link_title" id="link_title" value="" class="sblog_input" />
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Link URL'); ?></legend>
						<input type="text" name="link_url" id="link_url" value="" class="sblog_input" />
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
						<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" /> <input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
					</fieldset>
<?php

	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}

	require('inc/mysql.php');

	$query = 'SELECT id, link_title, link_url FROM ' . $conf_mysql_prefix . 'links ORDER BY link_title ASC';
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);
	
	if($n > 0) {
		echo "\t\t\t\t\t" . '<fieldset>' . "\n";
		echo "\t\t\t\t\t\t" . '<legend>' . lang('Existing links') . '</legend>' . "\n";
		echo "\t\t\t\t\t\t" . '<ul>' . "\n";
		
		while($r = mysql_fetch_assoc($q)) {
			echo "\t\t\t\t\t\t" . '<li><a href="links_del.php?id=' . $r['id'] . '">' . lang('delete') . '</a> <a href="' . $r['link_url'] . '" title="'. $r['link_title'] . '">' . truncate($r['link_title'], 32) . '</a></li>' . "\n";
		}
		
		echo "\t\t\t\t\t\t" . '</ul>' . "\n";
		echo "\t\t\t\t\t" . '</fieldset>' . "\n";
	}

	mysql_close();

?>
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