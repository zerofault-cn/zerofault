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
	
	$ref = stripslashes($_POST['ref']);
	
	if(array_key_exists('id', $_POST)) {
		$id = intval($_POST['id']);
	}
	else {
		$id = null;
	}

	if(array_key_exists('topic', $_POST)) {
		$topic = stripslashes($_POST['topic']);
	}
	else {
		$topic = null;
	}
	
	if(array_key_exists('text', $_POST)) {
		$text = stripslashes($_POST['text']);
	}
	else {
		$text = null;
	}
	
	if(array_key_exists('category_id', $_POST)) {
		$category_id = intval($_POST['category_id']);
	}
	else {
		$category_id = null;
	}
	
	if(array_key_exists('date_created', $_POST)) {
		$date_created = $_POST['date_created'];
	}
	else {
		$date_created = date('YmdHis');
	}

?>

<div class="sblog_post_text">
	<form id="image_ul"  method="post" enctype="multipart/form-data" action="image_ul_do.php">
	<fieldset>
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="ref" id="ref" value="<?php echo $ref; ?>" />
		<input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" />
		<input type="hidden" name="text" id="text" value="<?php echo htmlspecialchars($text); ?>" />
		<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
		<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
		<legend><?php echo lang('Upload image'); ?></legend>
		<input type="file" name="image" id="image" />
	</fieldset>
	<fieldset>
		<legend><?php echo lang('Options'); ?></legend>
		<input type="submit" value="<?php echo lang('Go back'); ?>" onclick="javascript:document.getElementById('image_ul').action='<?php echo $ref; ?>';submit();" class="sblog_button" />
		<input type="submit" value="<?php echo lang('OK'); ?>" class="sblog_button" />
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