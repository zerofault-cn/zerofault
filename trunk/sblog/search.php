<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// include headers
	require('inc/tpl_header.php');		// header
	require('inc/tpl_menu.php');			// menu

	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// declare truncate() is not already declared
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}
	
	if(!function_exists('bbcode_strip')) {
		require('inc/func_bbcode_strip.php');
	}
	
	require('inc/mysql.php');

	/* start <sblog_main> */
	ob_start();
	
?>
<!-- START OF SEARCH -->
<?php

	if(isset($_REQUEST['keyword']) && strlen($_REQUEST['keyword']) > 1) {
		$keyword	= stripslashes($_REQUEST['keyword']);
		$hilite	= '<span class="hilite">\\0</span>';
		
		$query = 'SELECT id, topic, text FROM ' . $conf_mysql_prefix . 'data WHERE topic LIKE \'%' . $keyword . '%\' OR text LIKE \'%' . $keyword . '%\' ORDER BY date_created DESC';
		
		$q = mysql_query($query);
		$n = mysql_num_rows($q);
		
		if($n > 0) {
			while($r = mysql_fetch_assoc($q)) {
				
				$text			= bbcode_strip($r['text']);
				$pos_start	= strpos(strtolower($text), strtolower($keyword)) - 20;
				$pos_end		= 180;

				// find the first occurrence of $keyword in $text. strtolower() 'emulates' case-insensitive since stripos() only works in php5
				if($pos_start > 0) {
					$text = '...' . htmlspecialchars(substr($text, $pos_start, $pos_end)) . '...';
				}
				else {
					$text = htmlspecialchars(substr($text, 0, $pos_end));
				}

				echo '<div class="sblog_post">' . "\n";
				echo '<div class="sblog_post_topic"><a href="blog.php?id=' . $r['id'] . '">' . preg_replace('/' . $keyword . '/i', $hilite, stripslashes($r['topic'])) . '</a></div>' . "\n";
				echo '<div class="sblog_post_text">' . preg_replace('/' . htmlspecialchars($keyword) . '/i', $hilite, $text) . '</div>' . "\n";
				echo '</div>' . "\n";
			}
		}
		else {
			echo '<div class="sblog_quote">没有找到与 &quot;<span class="hilite">' . $keyword . '</span>&quot; 相匹配的项!</div>';
		}
	}
	else {
		echo '<div class="sblog_quote">' . lang('The search string is too short!') . '</div>';
	}

?>
						<!-- END OF SEARCH -->
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */

	require('inc/tpl_foot.php');
	
	mysql_close();

	echo $tpl_main;

?>