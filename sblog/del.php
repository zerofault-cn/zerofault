<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// make sure only administrator access this page
	require('inc/auth.php');

	if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
		$id =  $_REQUEST['id'];
		
		require('inc/mysql.php');
		
		$query = 'DELETE FROM ' . $conf_mysql_prefix . 'data WHERE id=\'' . $id . '\' LIMIT 1';
		
		mysql_query($query);
		mysql_close();
		
		header("Location: index.php");
		exit;
	}
	else {
		// include headers
		require('inc/tpl_header.php');
		require('inc/tpl_menu.php');

		// include blocks
		require('inc/block_custom.php');			// custom blocks

		/* start <sblog_main> */
	
		ob_start();

?>

<form>
	<fieldset>
		<legend><?php echo lang('Are you sure you want to delete this post?'); ?></legend>
		<input type="reset" value="<?php echo lang('Go back'); ?>" onClick="javascript:history.go(-1);return false" class="sblog_button" />
		<input type="submit" value="<?php echo lang('OK'); ?>" onClick="javascript:location.href='del.php?id=<?php echo $_REQUEST['id']; ?>&ok=1';return false" class="sblog_button" />
	</fieldset>
</form>
<?php

		$tpl_temp = trim(ob_get_contents());
		$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
		
		ob_end_clean();
		
		/* end <sblog_main> */
		
		require('inc/tpl_foot.php');
	
		echo $tpl_main;
	}

?>