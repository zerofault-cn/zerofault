<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// function for rendering the posts
	function sRenderPost($id, $category_id, $category, $date_created, $date_modified, $topic, $text) {
		global $conf_mysql_prefix, $conf_comments_act, $conf_date;

		// define variables
		$id				= intval($id);
		$category		= stripslashes($category);
		$date_created	= $date_created;
		$date_modified	= $date_modified;

		
		if(strlen($topic) > 0) {
			$topic = stripslashes($topic);
		}
		else {
			$topic = '-{ ' . lang('no topic') . ' }-';
		}
		
	//	$text = stripslashes($text);



		// fetch comments for current post
		$query_comments	= "SELECT id FROM " . $conf_mysql_prefix . "comments WHERE blog_id='" . $id . "'";
		$q_comments			= mysql_query($query_comments);
		$n_comments			= mysql_num_rows($q_comments);

		echo "\t\t\t" . '<!-- START OF POST -->' . "\n";
		echo "\t\t\t" . '<div class="sblog_post">' . "\n";
		echo "\t\t\t\t" . '<div class="sblog_post_topic">' . "\n";
		echo "\t\t\t\t\t" . '<h1 class="sblog_post_topic_text">' . htmlspecialchars($topic) . '</h1>' . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		echo "\t\t\t\t" . '<div class="sblog_post_text">' . "\n";
		
		// echo category if not 'Uncategorized'
		if($category_id != 1) {
			echo "\t\t\t\t\t" . '<span class="sblog_category">' . lang('Category') . ': <a href="index.php?cat=' . $category_id . '">' . htmlspecialchars($category) . '</a></span><br />' . "\n";
		}
	
		echo "\t\t\t\t\t" . '<div class="sblog_post_edit">' . lang('Posted') . ': ' . strftime(lang($conf_date), $date_created);
	
		// echo out 'last modified' date if post has been modified
		if($date_modified != $date_created) {
			echo ', ' . lang('Edited') . ': ' . strftime(lang($conf_date), $date_modified) . "\n";
		}
		
		echo '</div><br />' . "\n";
		echo "\t\t\t\t\t" . bbcode($text) . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		
		echo "\t\t\t\t" . '<div class="sblog_post_options">' . "\n";
		echo "\t\t\t\t\t";
		
		if($id != 0) {
			// if comments are enabled
			if(!isset($conf_comments_act) || $conf_comments_act == 1) {
				echo '<a href="comments.php?id=' . $id . '#comments" title="' . lang('comments') . '" class="sblog_post_options_link_comments">' . lang('comments') . ' (' . $n_comments . ')</a> ';
			}
			
			// permalink
			echo '<a href="blog.php?id=' . $id . '" title="' . lang('permalink') . '" class="sblog_post_options_link_perma">' . lang('permalink') . '</a> ';
		
			// administrator functions
			if(array_key_exists("Username", $_SESSION) && $_SESSION['Username'] != ''
			) {
				echo '<a href="del.php?id=' . $id . '" title="' . lang('delete') . '" class="sblog_post_options_link_delete">' . lang('delete') . '</a> <a href="edit.php?id=' . $id . '" title="' . lang('edit') . '" class="sblog_post_options_link_edit">' . lang('edit') . '</a> ';
			}
		}
		
		echo "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		echo "\t\t\t" . '</div>' . "\n";
		echo "\t\t\t" . '<!-- END OF POST -->' . "\n\n";

	}


	function sRenderPostShort($id, $category_id, $category, $date_created, $date_modified, $topic, $text) {
		global $conf_mysql_prefix, $conf_comments_act, $conf_date;

		// define variables
		$id				= intval($id);
		$category		= stripslashes($category);
		$date_created	= $date_created;
		$date_modified	= $date_modified;

		
		if(strlen($topic) > 0) {
			$topic = stripslashes($topic);
		}
		else {
			$topic = '-{ ' . lang('no topic') . ' }-';
		}
		
	//	$text = stripslashes($text);



		// fetch comments for current post
		$query_comments	= "SELECT id FROM " . $conf_mysql_prefix . "comments WHERE blog_id='" . $id . "'";
		$q_comments			= mysql_query($query_comments);
		$n_comments			= mysql_num_rows($q_comments);

		echo "\t\t\t" . '<!-- START OF POST -->' . "\n";
		echo "\t\t\t" . '<div class="sblog_post">' . "\n";
		echo "\t\t\t\t" . '<div class="sblog_post_topic">' . "\n";
		echo "\t\t\t\t\t" . '<h1 class="sblog_post_topic_text">'  . htmlspecialchars($topic) . '</h1>' . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		echo "\t\t\t\t" . '<div class="sblog_post_text">' . "\n";
		
		// echo category if not 'Uncategorized'
		if($category_id != 1) {
			echo "\t\t\t\t\t" . '<span class="sblog_category">' . lang('Category') . ': <a href="index.php?cat=' . $category_id . '">' . htmlspecialchars($category) . '</a></span><br />' . "\n";
		}
	
		echo "\t\t\t\t\t" . '<div class="sblog_post_edit">' . lang('Posted') . ': ' . strftime(lang($conf_date), $date_created);
	
		// echo out 'last modified' date if post has been modified
		if($date_modified != $date_created) {
			echo ', ' . lang('Edited') . ': ' . strftime(lang($conf_date), $date_modified) . "\n";
		}
		
		echo '</div><br />' . "\n";
//		echo "\t\t\t\t\t" . bbcode($text) . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		
		echo "\t\t\t\t" . '<div class="sblog_post_options">' . "\n";
		echo "\t\t\t\t\t";
		
		if($id != 0) {
			// if comments are enabled
			if(!isset($conf_comments_act) || $conf_comments_act == 1) {
				echo '<a href="comments.php?id=' . $id . '#comments" title="' . lang('comments') . '" class="sblog_post_options_link_comments">' . lang('comments') . ' (' . $n_comments . ')</a> ';
			}
			
			// permalink
			echo '<a href="blog.php?id=' . $id . '" title="' . lang('permalink') . '" class="sblog_post_options_link_perma">' . lang('permalink') . '</a> ';
		
			// administrator functions
			if(array_key_exists("Username", $_SESSION) && $_SESSION['Username'] != ''
			) {
				echo '<a href="del.php?id=' . $id . '" title="' . lang('delete') . '" class="sblog_post_options_link_delete">' . lang('delete') . '</a> <a href="edit.php?id=' . $id . '" title="' . lang('edit') . '" class="sblog_post_options_link_edit">' . lang('edit') . '</a> ';
			}
		}
		
		echo "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		echo "\t\t\t" . '</div>' . "\n";
		echo "\t\t\t" . '<!-- END OF POST -->' . "\n\n";

	}
?>