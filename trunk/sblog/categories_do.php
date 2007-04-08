<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	require('inc/lang.php');

	$category		= mysql_escape_string($_POST['category']);
	$ref				= stripslashes($_POST['ref']);
	$id				= intval($_POST['id']);
	$category_id	= intval($_POST['category_id']);
	$topic			= stripslashes($_POST['topic']);
	$text				= stripslashes($_POST['text']);
	$date_created	= $_POST['date_created'];

	if($category != '' && $category != '') {
		
		require('inc/mysql.php');
		
		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'categories SET date_created=NOW(), category=\'' . $category. '\'';
		
		mysql_query($query);
		mysql_close();
		
		$msg[] = lang('The category has been created.');
	
	}
	else {
		$msg[] = lang('Could not create category!');
	}
	
	// include headers
	require('inc/tpl_header.php');		// header
	require('inc/tpl_menu.php');			// menu

	// include blocks
	require('inc/block_custom.php');			// custom blocks
	
	ob_start();

?>
		<form id="temp" method="post" action="<?php echo $ref; ?>">
		<fieldset>
			<input type="hidden" name="ref" id="ref" value="<?php echo $ref; ?>" />
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
			<input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" />
			<input type="hidden" name="text" id="text" value="<?php echo htmlspecialchars($text); ?>" />
			<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
			<legend><?php echo lang('Message(s)'); ?></legend>
<?php

	if(isset($msg)) {
		foreach($msg as $message) {
			echo $message . '<br />' . "\n";
		}
	}

?>
		</fieldset>
		<fieldset>
			<legend>选项</legend>
			<input type="submit" value="返回" />
		</fieldset>
		</form>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);

	ob_end_clean();

	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>