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

	if(array_key_exists('ref', $_REQUEST)) {
		$ref = stripslashes($_REQUEST['ref']);
	}
	else {
		$ref = 'categories.php';
	}
	
	if(array_key_exists('id', $_REQUEST)) {
		$id = intval($_REQUEST['id']);
	}
	else {
		$id = null;
	}
	
	if(array_key_exists('category_id', $_REQUEST)) {
		$category_id = intval($_REQUEST['category_id']);
	}
	else {
		$category_id = null;
	}
	
	if(array_key_exists('topic', $_REQUEST)) {
		$topic = stripslashes($_REQUEST['topic']);
	}
	else {
		$topic = null;
	}
	
	if(array_key_exists('text', $_REQUEST)) {
		$text = stripslashes($_REQUEST['text']);
	}
	else {
		$text= null;
	}
	
	if(array_key_exists('date_created', $_REQUEST)) {
		$date_created = $_REQUEST['date_created'];
	}
	else {
		$date_created = date('YmdHis');
	}

	/* start <sblog_main> */
	ob_start();

?>

			<div class="sblog_post_text">
				<form id="categories" method="post" action="categories_do.php">
					<fieldset>
						<input type="hidden" name="ref" id="ref" value="<?php echo $ref; ?>" />
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
						<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
						<input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" />
						<input type="hidden" name="text" id="text" value="<?php echo htmlspecialchars($text); ?>" />
						<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
						<input type="hidden" name="del_id" id="del_id" value="" />
						<legend><?php echo lang('Category'); ?></legend>
						<input type="text" name="category" id="category" value="" class="sblog_input" />
					</fieldset>
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
						<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:document.getElementById('categories').action='<?php echo $ref; ?>';submit();" class="sblog_button" /> <input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
					</fieldset>
<?php

	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}

	require('inc/mysql.php');

	$query = 'SELECT id, category FROM ' . $conf_mysql_prefix . 'categories WHERE id!=\'1\' ORDER BY category ASC';
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);
	
	if($n > 0) {
		echo "\t\t\t\t\t" . '<fieldset>' . "\n";
		echo "\t\t\t\t\t\t" . '<legend>' . lang('Existing categories') . '</legend>' . "\n";
		echo "\t\t\t\t\t\t\t" . '<ul>' . "\n";
		
		while($r = mysql_fetch_assoc($q)) {
			echo "\t\t\t\t\t\t" . '<li><a href="#" onclick="javascript:document.getElementById(\'del_id\').value=\'' . $r['id'] . '\';document.getElementById(\'categories\').action=\'categories_del.php\';document.getElementById(\'categories\').submit();return false">' . lang('delete') . '</a> ' . truncate($r['category'], 32) . '</li>' . "\n";
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