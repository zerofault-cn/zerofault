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

	require('inc/sImageResize.php');

	// define variables
	if(array_key_exists('id', $_POST)) {
		$id = intval($_POST['id']);
	}
	else {
		$id = null;
	}
	
	if(array_key_exists('ref', $_POST)) {
		$ref = stripslashes($_POST['ref']);
	}
	else {
		$ref = null;
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
		$date_created = null;
	}

	// verify that there was no errors and that mime type is image*
	if(array_key_exists('image', $_FILES) && $_FILES['image']['error'] == 0 && substr($_FILES['image']['type'], 0, 5) == 'image') {
		$info = pathinfo($_FILES['image']['name']);
		
		if(array_key_exists('extension', $info)) {
			$filename = 'upload/' . str_replace('.' . $info['extension'], '.jpg', $_FILES['image']['name']);
		}
		else {
			$filename = 'upload/' . $_FILES['image']['name'] . '.jpg';
		}

		$file_src = $_FILES['image']['tmp_name'];

		// change file extension to '.jpg'
		$file_dst = $filename;

		sImageResize($file_src, $file_dst, $conf_img_width, 100);
		$msg[] = lang('Your image was successfully uploaded.');
		$msg[] = lang('You can now access it from the image list.');
	}
	else {
		$error[] = 'Error!';
	}

	// include headers
	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');			// menu

	// include blocks
	require('inc/block_custom.php');			// custom blocks

	ob_start();
	
?>
	<form id="image" method="post" action="<?php echo $ref; ?>">
<?php

	if(isset($msg)) {
		echo "\t" . '<fieldset>' . "\n";
		echo "\t\t" . '<legend>' . lang('Message(s)') . '</legend>' . "\n";
		
		while(list(, $val) = each($msg)) {
			echo "\t\t" . $val . "<br />\n";
		}
		
		echo "\t" . '</fieldset>' . "\n";
	}

	if(isset($error)) {
		echo "\t" . '<fieldset>' . "\n";
		echo "\t\t" . '<legend>' . lang('Message(s)') . '</legend>' . "\n";
		
		while(list(, $val) = each($error)) {
			echo "\t\t" . $val . "<br />\n";
		}
		
		echo "\t" . '</fieldset>' . "\n";
	}

?>
	<fieldset>
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" />
		<input type="hidden" name="text" id="text" value="<?php echo htmlspecialchars($text); ?>" />
		<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
		<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
		<legend>Options</legend>
		<input type="submit" value="<?php echo lang('Go back'); ?>" class="sblog_button" />
	</fieldset>
	</form>

<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();

	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>