<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/
	// do not declare truncate() more than once!
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}
	
	// find all styles
	if($handle = @opendir('style/')) {
		while(false !== ($file = readdir($handle))) {
			// verify that the file extension is .css
			if(is_file('style/' . $file) && substr($file, -4) == '.css') {
				$styles[] = basename($file, '.css');
			}
		}
	}
	else {
		$styles = null;
	}

	// only render the style list if more than one style exists
	if(count($styles) > 1) {

?>
<!-- START OF BLOCK_STYLE -->
			<form id="style" method="post" action="style_set.php">
				<div class="sblog_block">
					<div class="sblog_block_topic">
						<h2 class="sblog_block_topic_text"><?php echo lang('Style'); ?></h2>
					</div>
					<div class="sblog_block_text">
						<select name="style_user" id="conf_style_user" onchange="javascript:submit();">
							<option value=""><?php echo lang('Default'); ?></option>
<?php

	// render the style list
	while(list(, $val) = each($styles)) {
		// select the selected style in list
		if(isset($conf_style_user) && $val == $conf_style_user) {
			$selected = ' selected';
		}
		else {
			$selected = null;
		}
		echo "\t\t\t\t\t\t\t" . '<option value="' . $val . '"' . $selected . '>' . truncate($val, $conf_block_chars) . '</option>' . "\n";
	}

?>
						</select>
					</div>
				</div>
			</form>
			<!-- END OF BLOCK_STYLE -->
<?php

	}

?>