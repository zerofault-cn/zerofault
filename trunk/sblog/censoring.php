<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');
	
	// headers
	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// start <sblog_main>
	ob_start();

?>
<!-- CENSORING -->
			<div class="sblog_post_text">
				<form id="censoring" method="post" action="censoring_do.php">
					<fieldset>
						<legend><?php echo lang('Add word'); ?></legend>
						<div class="sblog_var"><?php echo lang('Word'); ?></div>
						<div class="sblog_val"><input type="text" name="word_orig" id="word_orig" value="" size="40" class="sblog_input" /></div>
						
						<div class="sblog_var"><?php echo lang('Replace with'); ?></div>
						<div class="sblog_val"><input type="text" name="word_repl" id="word_repl" value="" size="40" class="sblog_input" /></div>
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
						<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" class="sblog_button" />
						<input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
					</fieldset>
<?php

	require('inc/mysql.php');

	$query = 'SELECT id, word_orig, word_repl FROM ' . $conf_mysql_prefix . 'censoring ORDER BY word_orig ASC';
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);

	if($n > 0) {
		echo "\t\t\t\t\t" . '<fieldset>' . "\n";
		echo "\t\t\t\t\t\t" . '<legend>' . lang('Existing words') . '</legend>' . "\n";
		echo "\t\t\t\t\t\t" . '<ul>' . "\n";
		
		while($r = mysql_fetch_assoc($q)) {
			echo "\t\t\t\t\t\t" . '<li><a href="censoring_del.php?id=' . $r['id'] . '">' . lang('delete') . '</a> ' . htmlspecialchars($r['word_orig']) . ' -&gt; ' . htmlspecialchars($r['word_repl']) . "</li>\n";
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
	
	// end <sblog_main>

	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>