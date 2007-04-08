<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');
	require('inc/lang.php');

	if(isset($_REQUEST['del_id'])) {
		
		$del_id = intval($_REQUEST['del_id']);
		
		// delete category
		require('inc/mysql.php');
		$query = 'DELETE FROM ' . $conf_mysql_prefix . 'categories WHERE id=\'' . $del_id . '\' LIMIT 1';
		$queryUpdate = 'UPDATE ' . $conf_mysql_prefix . 'data SET category_id=\'1\' WHERE category_id=\'' . $del_id . '\'';
		mysql_query($queryUpdate);
		mysql_query($query);
		mysql_close();
		
		$msg = lang('The category was successfully deleted.');
	}
	else {
		$msg = lang('Could not delete the category!');
	}

	// include headers
	require('inc/tpl_header.php');		// header
	require('inc/tpl_menu.php');			// menu

	// include blocks
	require('inc/block_custom.php');			// custom blocks

	$ref = $_POST['ref'];
	$id = intval($_POST['id']);
	$category_id = intval($_POST['category_id']);
	$topic = $_POST['topic'];
	$text = $_POST['text'];
	$date_created = $_POST['date_created'];
	
	ob_start();
	
?>
		<form id="temp" method="post" action="<?php echo htmlspecialchars($ref); ?>">
			<fieldset>
				<input type="hidden" name="ref" id="ref" value="<?php echo htmlspecialchars($ref); ?>" />
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
				<input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" />
				<input type="hidden" name="text" id="text" value="<?php echo htmlspecialchars($text); ?>" />
				<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
				<legend><?php echo lang('Message(s)'); ?></legend>
				<?php echo $msg ; ?>
			</fieldset>
			<fieldset>
				<legend><?php echo lang('Options'); ?></legend>
				<input type="submit" value="<?php echo lang('Go back'); ?>" class="sblog_button" />
			</fieldset>
		</form>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);

	ob_end_clean();

	require('inc/tpl_foot.php');
	
	echo $tpl_main;
	
	//header('Location: categories.php');
	exit;

?>