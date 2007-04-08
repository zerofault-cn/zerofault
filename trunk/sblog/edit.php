<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');

	if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && !array_key_exists('text', $_REQUEST)) {
		
		$id = intval($_REQUEST['id']);

		require('inc/config.php');
		require('inc/mysql.php');
		
		$query = 'SELECT UNIX_TIMESTAMP(date_created) AS date_created, topic, text, category_id FROM ' . $conf_mysql_prefix . 'data WHERE id=\'' . $id . '\' LIMIT 1';
		
		$q = mysql_query($query);
		$r = mysql_fetch_assoc($q);
		
		mysql_close();
		
		$topic			= stripslashes($r['topic']);
		$text				= stripslashes($r['text']);
		$category_id	= intval($r['category_id']);
		$date_created	= date('YmdHis', $r['date_created']);
		$date_modified = date('YmdHis', time());
	}
	else if(array_key_exists('text', $_POST)) {
		if(array_key_exists('id', $_POST)) {
			$id = intval($_POST['id']);
		}
		else {
			$id = null;
		}
		
		$topic			= stripslashes($_POST['topic']);
		$text				= stripslashes($_POST['text']);
		$category_id 	= intval($_POST['category_id']);
		
		if(strlen($_POST['date_created']) == 14) {
			$date_created = $_POST['date_created'];
		}
		else {
			$date_created = date('YmdHis');
		}
		
		if(array_key_exists('silent', $_POST)) {
			$silent = 1;
			$date_modified = $date_created;
		}
		else {
			$silent = 0;
			$date_modified = date('YmdHis', time());
		}
	}
	else {
		$id				= null;
		$topic			= null;
		$text				= null;
		$category_id	= 1;
		$date_created	= null;
		$date_modified = null;
		$silent			= 0;
	}

	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	/* start <sblog_main> */
	
	ob_start();
	
?>
	<!-- EDIT -->
<?php

	if(array_key_exists('topic', $_REQUEST)) {
		
		require('inc/mysql.php');
		require('inc/sRenderPost.php');
		
		if(!function_exists('truncate')) {
			require('inc/func_truncate.php');
		}
		
		$queryCategory = 'SELECT category FROM ' . $conf_mysql_prefix . 'categories WHERE id=\'' . $category_id . '\' LIMIT 1';
		$qCategory = mysql_query($queryCategory);
		$nCategory = mysql_num_rows($qCategory);
		
		if($nCategory > 0) {
			$rCategory = mysql_fetch_assoc($qCategory);
			$category = $rCategory['category'];
		}
		else {
			$category = lang('Uncategorized');
		}
		
		if($silent == 1) {
			
		}

		sRenderPost($id, $category_id, $category, mktime(substr($date_created, 8, 2), substr($date_created, 10, 2), substr($date_created, 12, 2), substr($date_created, 4, 2), substr($date_created, 6, 2), substr($date_created, 0, 4)), mktime(substr($date_modified, 8, 2), substr($date_modified, 10, 2), substr($date_modified, 12, 2), substr($date_modified, 4, 2), substr($date_modified, 6, 2), substr($date_modified, 0, 4)), $topic, $text);
		
		mysql_close();

	}

?>
			<form id="edit" method="post" action="edit_do.php">
				<fieldset>
					<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
					<input type="hidden" name="ref" id="ref" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
					<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
					<legend><?php echo lang('Category'); ?></legend>
					<select name="category_id" id="category_id">
						<option value="1">&laquo; <?php echo lang('Uncategorized'); ?> &raquo;</option>
<?php

	require('inc/mysql.php');

	$queryCategories = 'SELECT id, category FROM ' . $conf_mysql_prefix . 'categories WHERE id!=\'1\' ORDER BY category ASC';
	$qCategories = mysql_query($queryCategories);
	
	while($rCategories = mysql_fetch_assoc($qCategories)) {
		if($category_id == $rCategories['id']) {
			$selected = ' selected';
		}
		else {
			$selected = null;
		}
		
		echo "\t\t\t\t\t\t" . '<option value="' . $rCategories['id'] . '"' . $selected . '>' . $rCategories['category'] . '</option>' . "\n";
	}
	
	mysql_close();
	
?>
					</select>
					<input type="reset" value="<?php echo lang('Add new category'); ?>" onclick="javascript:document.getElementById('edit').action='categories.php';submit();" class="sblog_button" />
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Images'); ?></legend>
					<select name="image" id="image" onchange="javascript:document.getElementById('text').value+='[img]' + this.options[selectedIndex].value + '[/img]';" class="sblog_input">
						<option value=""></option>
<?php

	if($handle = opendir('upload/')) {
		while(false !== ($file = readdir($handle))) {
			if(substr($file, 0, 1) != '.' && (substr(strtolower($file), -4) == '.jpg' || substr(strtolower($file), -4) == '.gif' || substr(strtolower($file), -4) == '.png')) {
				$imgsize = getimagesize('upload/' . $file);
				echo "\t\t\t\t\t\t" . '<option value="upload/' . rawurlencode($file) . '">' . $file . '(' . $imgsize[0] . 'x' . $imgsize[1] . ')</option>' . "\n";
			}
		}
	}

?>
					</select>
					<input type="submit" value="<?php echo lang('Upload image'); ?>" onclick="javascript:document.getElementById('edit').action='image_ul.php';submit();" class="sblog_button" />
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Topic'); ?></legend>
					<input type="text" name="topic" id="topic" value="<?php echo htmlspecialchars($topic); ?>" tabindex="1" class="sblog_input" />
				</fieldset>
<?php
	$checked = ' checked="checked"';
	if(isset($silent) && $silent == 1) {
		$checked = ' checked="checked"';
	}
	else {
		$checked = null;
	}

?>
				<fieldset>
					<legend><?php echo lang('Text'); ?></legend>
					<script type="text/javascript">edToolbar();</script><br />
					<textarea name="text" id="text" tabindex="2" cols="40" rows="10" class="sblog_text"><?php echo htmlspecialchars($text); ?></textarea><br />
					<label for="silent"><input type="checkbox" name="silent" id="silent" value="1"<?php echo $checked; ?> /> <?php echo lang('Silent edit'); ?></label>
					<script type="text/javascript">var edCanvas = document.getElementById('text');</script> 
				</fieldset>
				<fieldset style="display:none">
					<legend><?php echo lang('Smilies'); ?></legend>
					<a href="#" title=":)" onclick="javascript:document.getElementById('text').value+=':)';return false"><img src="img/smilies/smile.png" alt=":)" /></a>
					<a href="#" title=":|" onclick="javascript:document.getElementById('text').value+=':|';return false"><img src="img/smilies/neutral.png" alt=":|" /></a>
					<a href="#" title=":(" onclick="javascript:document.getElementById('text').value+=':(';return false"><img src="img/smilies/sad.png" alt=":(" /></a>
					<a href="#" title=":D" onclick="javascript:document.getElementById('text').value+=':D';return false"><img src="img/smilies/big_smile.png" alt=":D" /></a>
					<a href="#" title=":o" onclick="javascript:document.getElementById('text').value+=':o';return false"><img src="img/smilies/yikes.png" alt=":o" /></a>
					<a href="#" title=";)" onclick="javascript:document.getElementById('text').value+=';)';return false"><img src="img/smilies/wink.png" alt=";)" /></a>
					<a href="#" title="=/" onclick="javascript:document.getElementById('text').value+='=/';return false"><img src="img/smilies/hmm.png" alt="=/" /></a>
					<a href="#" title=":P" onclick="javascript:document.getElementById('text').value+=':P';return false"><img src="img/smilies/tongue.png" alt=":P" /></a>
					<a href="#" title=":lol:" onclick="javascript:document.getElementById('text').value+=':lol:';return false"><img src="img/smilies/lol.png" alt=":lol:" /></a>
					<a href="#" title=":mad:" onclick="javascript:document.getElementById('text').value+=':mad:';return false"><img src="img/smilies/mad.png" alt=":mad:" /></a>
					<a href="#" title=":roll:" onclick="javascript:document.getElementById('text').value+=':roll:';return false"><img src="img/smilies/roll.png" alt=":roll:" /></a>
					<a href="#" title=":cool:" onclick="javascript:document.getElementById('text').value+=':cool:';return false"><img src="img/smilies/cool.png" alt=":cool:" /></a>
				</fieldset>
				<fieldset>
					<legend><?php echo lang('Options'); ?></legend>
					<input type="reset" value="<?php echo lang('Cancel'); ?>" onclick="javascript:location.href='index.php';return false" class="sblog_button" />
					<input type="submit" value="<?php echo lang('Help'); ?>" onclick="javascript:document.getElementById('edit').action='help.php';submit();" class="sblog_button" />
					<input type="submit" value="<?php echo lang('Preview'); ?>" tabindex="3" accesskey="p" onclick="document.getElementById('edit').action='<?php echo $_SERVER['PHP_SELF']; ?>'" class="sblog_button" />
					<input type="submit" value="<?php echo lang('Publish'); ?>" tabindex="4" accesskey="s" onclick="javascript:document.getElementById('edit').action='edit_do.php'" class="sblog_button" />
				</fieldset>
			</form>

			<script type="text/javascript">document.getElementById('topic').focus();</script>

<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>