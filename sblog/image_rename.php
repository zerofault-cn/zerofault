<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		���İ�֧��: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only
	require('inc/auth.php');
	
	$filename = stripslashes($_REQUEST['file']);
	
	if(array_key_exists('ok', $_POST) && $_POST['ok'] == 1 && strlen($_POST['newfile']) != 0) {
		$newfile = stripslashes($_POST['newfile']);
		if(rename('upload/' . $filename, 'upload/' . $newfile)) {
			header('Location: image.php#' . rawurlencode($newfile));
			exit;
		}
		else {
			header('Location: image_rename.php?file=' . rawurlencode($filename));
			exit;
		}
	}

	// include headers
	require('inc/tpl_header.php');		// header
	require('inc/tpl_menu.php');			// menu
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	ob_start();
	
?>
	<form id="rename" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<fieldset>
		<legend>������Ϊ:</legend>
		<input type="hidden" name="file" id="file" value="<?php echo $filename; ?>" />
		<input type="hidden" name="ok" id="ok" value="1" />
		<input type="text" name="newfile" id="newfile" value="<?php echo $filename; ?>" /><br />
		�����������ͼƬ������,Blog������Ǹĳ���Ӧ��.<br />
		<strong>ȷ������Ч��ͼƬ�ļ���׺(.JPG, .PNG or .GIF).</strong>
	</fieldset>
	<fieldset>
		<legend>ѡ��</legend>
		<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:location.href='image.php';return false" />
		<input type="submit" value="<?php echo lang('OK'); ?>" />
	</fieldset>
	</form>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);

	ob_end_clean();
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>