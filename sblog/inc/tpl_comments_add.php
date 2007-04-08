<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(array_key_exists('id', $_REQUEST) && intval($_REQUEST['id']) > 0) {

		// start <sblog_comments>
		ob_start();

?>
<a name="add_comment"></a>
	<form id="comments" method="post" action="comments_do.php">
	<fieldset>
		<input type="hidden" name="blog_id" id="blog_id" value="<?php echo $_REQUEST['id']; ?>" />
		<legend><?php echo lang('Post comment'); ?></legend>
		<table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td>
					<?php echo lang('Name'); ?>
				</td>
				<td>
					<input type="text" name="username" id="username" value="" class="sblog_input" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo lang('E-mail'); ?>
				</td>
				<td>
					<input type="text" name="email" id="email" value="" class="sblog_input" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo lang('Homepage'); ?>
				</td>
				<td>
					<input type="text" name="homepage" id="homepage" value="" class="sblog_input" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo lang('Comment'); ?>
				</td>
				<td>
					<textarea name="comment" id="comment" cols="40" rows="4" class="sblog_comment"></textarea>
				</td>
			</tr>
		</table>
	</fieldset>
	<fieldset>
		<legend><?php echo lang('Options'); ?></legend>
		<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:history.go(-1);return false" /> <input type="submit" value="<?php echo lang('OK'); ?>" />
	</fieldset>
	</form>
<?php

		$tpl_temp = trim(ob_get_contents());
		$tpl_main = str_replace('<sblog_comments_add>', $tpl_temp, $tpl_main);
		
		ob_end_clean();
		
		/* end <sblog_main> */
	}
	else {
		$tpl_main = str_replace('<sblog_comments_add>', null, $tpl_main);
	}
	
?>