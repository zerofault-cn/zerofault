<?php
	
	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/
date_default_timezone_set('Etc/GMT-8');
	require('inc/auth.php');
	require('inc/tpl_header.php');
	require('inc/tpl_menu.php');

	// include blocks
	require('inc/block_custom.php');			// custom blocks

	/* start <sblog_main> */
	ob_start();

?>
<div class="sblog_post_text">
				<form id="image" method="post" action="image_ul.php">
					<fieldset>
						<legend><?php echo lang('Options'); ?></legend>
							<div>
								<input type="hidden" name="ref" id="ref" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
								<input type="reset" value="<?php echo lang('Go back'); ?>" onclick="javascript:location.href='index.php';return false" class="sblog_button" />
								<input type="submit" value="<?php echo lang('Upload image'); ?>" class="sblog_button" />
							</div>
					</fieldset>
				</form><br />
<?php

	require('inc/mysql.php');
	require('inc/sImageResize.php');

	if($handle = opendir('upload/')) {
		while (false !== ($file = readdir($handle))) {
			if(substr($file, 0, 1) != '.' && (substr(strtolower($file), -4) == '.jpg' || substr(strtolower($file), -4) == '.gif' || substr(strtolower($file), -4) == '.png')) {
				$query = 'SELECT id, topic FROM ' . $conf_mysql_prefix . 'data WHERE text LIKE \'%upload/' . $file . '%\'';
				
				$q = mysql_query($query);
				$n = mysql_num_rows($q);
				
				$imgsize = getimagesize('upload/' . $file);
				$filedate = strftime(lang($conf_date), filemtime('upload/' . $file));
				echo "\t\t\t\t" . '<a name="' . htmlspecialchars($file) . '"></a>' . "\n";
				echo "\t\t\t\t" . '<div class="sblog_image">' . "\n";

				echo "\t\t\t\t\t" . '<div class="sblog_image_tn">' . "\n";
				if(extension_loaded('gd')) {
					if(!file_exists('upload/tn/' . $file)) {
						sImageResize('upload/' . $file, 'upload/tn/' . $file, 120, 50);
					}
					echo "\t\t\t\t\t" . '<a href="#" onclick="javascript:window.open(\'image_view.php?filename=' . rawurlencode($file) . '\', \'image\', \'width=' . $imgsize[0] . ',height=' . $imgsize[1] . '\');return false"><img src="upload/tn/' . $file . '" alt="' . htmlspecialchars($file) . '" /></a>' . "\n";
				}
				else {
					echo "\t\t\t\t\t" . '<a href="#" onclick="javascript:window.open(\'image_view.php?filename=' . rawurlencode($file) . '\', \'image\', \'width=' . $imgsize[0] . ',height=' . $imgsize[1] . '\');return false"><img src="upload/' . $file . '" width="120" border="0" alt="' . htmlspecialchars($file) . '" class="img" /></a>' . "\n";
				}
				echo "\t\t\t\t\t" . '</div>' . "\n";

				echo "\t\t\t\t\t" . '<div class="sblog_image_info">';
				echo "\t\t\t\t\t" . lang('Filename') . ': <strong>' . $file . '</strong><br />' . "\n";
				echo "\t\t\t\t\t\t" . lang('Uploaded') . ': ' . $filedate . '<br />' . "\n";
				echo "\t\t\t\t\t\t" . lang('Dimensions') . ': ' . $imgsize[0] . ' x ' . $imgsize[1] . '<br />' . "\n";
				echo "\t\t\t\t\t\t" . '<p><a href="image_del.php?file=' . rawurlencode($file) . '">' . lang('delete') . '</a> | <a href="image_rename.php?file=' . rawurlencode($file) . '">' . lang('rename') . '</a></p>' . "\n";

				if($n > 0) {
					echo "\t\t\t\t\t\t" . '<strong>' . lang('Used in the following post(s)') . ':</strong><br />' . "\n";
					while($r = mysql_fetch_assoc($q)) {
						echo "\t\t\t\t\t\t" . '&raquo; <a href="blog.php?id=' . $r['id'] . '">' . htmlspecialchars(stripslashes($r['topic'])) . '</a><br />' . "\n";
					}
				}
				else {
					echo "\t\t\t\t\t\t" . '&raquo; ' . lang('Not assigned to any post(s).') . "\n";
				}
				
				echo "\t\t\t\t\t" . '</div>' . "\n";
				
				echo "\t\t\t\t" . '</div>' . "\n";
			}
		}

		closedir($handle);
	}
	
	mysql_close();

?>
			</div>

<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>