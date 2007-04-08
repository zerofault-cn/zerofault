<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// make sure that config.php has been uploaded
	if(!file_exists('config.php')) {
		header('Location: install/index.php');
		exit;
	}
	// make sure that the dir 'install' has been deleted
	else if(is_dir('install')) {
		echo '请删除 <b>install</b>目录和里面所有文件!';
		exit;
	}
	
	if(isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 6 || isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 8) {
		$year		= substr($_REQUEST['date'], 0, 4);
		$month	= substr($_REQUEST['date'], 4, 2);
		$day		= substr($_REQUEST['date'], 6, 2);
		$date		= $_REQUEST['date'];
	}
	else {
		$date = 0;
	}
	
	if(isset($_REQUEST['cat']) && intval($_REQUEST['cat']) > 0) {
		$cat = intval($_REQUEST['cat']);
	}
	else {
		$cat = null;
	}
	
	// include headers
	require('inc/tpl_header.php');			// header
	require('inc/tpl_menu.php');				// menu
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks

	// include functions
	require('inc/sRenderPost.php');

	// declare truncate() is not already declared
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}

	/* start <sblog_main> */
	ob_start();

?>
<!-- START OF LIST -->
<?php

	require('inc/mysql.php');

	// fetch all posts from a certain category
	if(isset($cat) && $cat != 0) {
		$query = 'SELECT d.id, UNIX_TIMESTAMP(d.date_created) AS date_created, UNIX_TIMESTAMP(d.date_modified) AS date_modified, d.topic, d.text, d.category_id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id AND category_id=\'' . $cat . '\' ORDER BY date_created DESC, date_modified DESC';
	}
	// fetch posts for yyyymmdd
	else if(isset($date) && strlen($date) == 8) {
		$query = 'SELECT d.id, UNIX_TIMESTAMP(d.date_created) AS date_created, UNIX_TIMESTAMP(d.date_modified) AS date_modified, d.topic, d.text, d.category_id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id AND SUBSTRING(d.date_created, 1, 10)=\'' . $year . '-' . $month . '-' . $day . '\' ORDER BY date_created DESC, date_modified DESC';
	}
	// fetch posts for yyyymm
	else if(isset($date) && strlen($date) == 6) {
		$query = 'SELECT d.id, UNIX_TIMESTAMP(d.date_created) AS date_created, UNIX_TIMESTAMP(d.date_modified) AS date_modified, d.topic, d.text, d.category_id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id AND SUBSTRING(d.date_created, 1, 7)=\'' . $year . '-' . $month . '\' ORDER BY date_created DESC, date_modified DESC';
	}
	// fetch all posts
	else {
		$query = 'SELECT d.id, UNIX_TIMESTAMP(d.date_created) AS date_created, UNIX_TIMESTAMP(d.date_modified) AS date_modified, d.topic, d.text, d.category_id, c.category FROM ' . $conf_mysql_prefix . 'data AS d, ' . $conf_mysql_prefix . 'categories AS c WHERE d.category_id=c.id ORDER BY date_created DESC, date_modified DESC';
	}

	// set active page
	if(!isset($_REQUEST['p'])) {
		$page = 1;
	}
	else {
		$page = $_REQUEST['p'];
	}
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);

	if($n > 0) {
		$counter = 0;
		
		// prevent division by zero error
		if(isset($conf_page_disp) && $conf_page_disp > 0) {
			$pages = ceil($n / $conf_page_disp);
		}
		else {
			$conf_page_disp = 5;
			$pages = 0;
		}
	
		// jump to active page in database
		mysql_data_seek($q, (($page - 1) * $conf_page_disp));

		while($r = mysql_fetch_assoc($q)) {
			$counter++;
			if($counter > $conf_page_disp) {
				break;
			}

			// render the post
			sRenderPostShort($r['id'], $r['category_id'], $r['category'], $r['date_created'], $r['date_modified'], $r['topic'], $r['text']);

		}

		if($pages > 1) {
			echo "\t\t\t" . '<!-- START OF PAGES -->' . "\n";
			echo "\t\t\t" . '<div class="sblog_pages">' . "\n";
			echo "\t\t\t\t" . '<div class="sblog_pages_prev">' . "\n";
			
			if($page > 1) {
				echo "\t\t\t\t\t" . '<a href="' . $_SERVER['PHP_SELF'] . '?cat=' . $cat . '&amp;date=' . $date . '&amp;p=1">&laquo; ' . lang('First') . '</a> <a href="' . $_SERVER['PHP_SELF'] . '?cat=' . $cat . '&amp;date=' . $date . '&amp;p=' . ($page - 1) . '">&laquo; ' . lang('Previous') . '</a>' . "\n";
			}
			else {
				echo "\t\t\t\t\t" . '&laquo; ' . lang('First') . ' &laquo; ' . lang('Previous') . "\n";
			}
			
			echo "\t\t\t\t" . '</div>' . "\n";
			echo "\t\t\t\t" . '<div class="sblog_pages_next">' . "\n";
			
			if($page < $pages) {
				echo "\t\t\t\t\t" . '<a href="' . $_SERVER['PHP_SELF'] . '?cat=' . $cat . '&amp;date=' . $date . '&amp;p=' . ($page + 1) . '">' . lang('Next') . ' &raquo;</a> <a href="' . $_SERVER['PHP_SELF'] . '?cat=' . $cat . '&amp;date=' . $date . '&amp;p=' . $pages . '">' . lang('Last') . ' &raquo;</a>' . "\n";
			}
			else {
				echo "\t\t\t\t\t" . lang('Next') . ' &raquo; ' . lang('Last') . ' &raquo;' . "\n";
			}
			
			echo "\t\t\t\t" . '</div>' . "\n";
			echo "\t\t\t\t" . '<div class="sblog_pages_current">' . "\n";
			echo "\t\t\t\t\t" . $page . ' ' . lang('of') . ' ' . $pages . "\n";
			echo "\t\t\t\t" . '</div>' . "\n";
			echo "\t\t\t" . '</div>' . "\n";
			echo "\t\t\t" . '<!-- END OF PAGES -->' . "\n";
		}
	}
	else {
		if(array_key_exists('cat', $_REQUEST)) {
			echo '<div class="sblog_quote">' . lang('There are no posts assigned to this category.') . '</div>' . "\n";
		}
		else if(array_key_exists('date', $_REQUEST)) {
			echo '<div class="sblog_quote">' . lang('No posts were posted on this date.') . '</div>' . "\n";
		}
		else {
			echo '<div class="sblog_quote">' . lang('The sBLOG is empty!') . '</div>' . "\n";
		}
	}
	
	mysql_close();

?>
			<!-- END OF LIST -->
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');

	echo $tpl_main;

?>