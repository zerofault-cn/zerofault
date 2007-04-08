<?php
/***************************************************************************
 *                               functions.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: functions.php,v 1.133.2.33 2004/11/18 17:49:42 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

function get_db_stat($mode)
{
	global $db;

	switch( $mode )
	{
		case 'usercount':
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
			break;

		case 'newestuser':
			$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
			break;

		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		return false;
	}

	$row = $db->sql_fetchrow($result);

	switch ( $mode )
	{
		case 'usercount':
			return $row['total'];
			break;
		case 'newestuser':
			return $row;
			break;
		case 'postcount':
			return $row['post_total'];
			break;
		case 'topiccount':
			return $row['topic_total'];
			break;
	}

	return false;
}

// added at phpBB 2.0.11 to properly format the username
function phpbb_clean_username($username)
{
	$username = substr(htmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25);
	$username = ereg_replace("&amp;","&",htmlspecialchars(trim(trim($username), "\\")));
	$username = phpbb_rtrim($username, "\\");
	$username = str_replace("'", "\'", $username);

	return $username;
}

/**
* This function is a wrapper for ltrim, as charlist is only supported in php >= 4.1.0
* Added in phpBB 2.0.18
*/
function phpbb_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	// php version < 4.1.0
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str{0} == $charlist)
		{
			$str = substr($str, 1);
		}
	}
	else
	{
		$str = ltrim($str, $charlist);
	}

	return $str;
}

// added at phpBB 2.0.12 to fix a bug in PHP 4.3.10 (only supporting charlist in php >= 4.1.0)
function phpbb_rtrim($str, $charlist = false)
{
   if ($charlist === false)
   {
      return rtrim($str);
   }
   
   $php_version = explode('.', PHP_VERSION);

   // php version < 4.1.0
   if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
   {
      while ($str{strlen($str)-1} == $charlist)
      {
         $str = substr($str, 0, strlen($str)-1);
      }
   }
   else
   {
      $str = rtrim($str, $charlist);
   }

   return $str;
}

//
// Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
//
function get_userdata($user, $force_str = false)
{
	global $db;

	if (!is_numeric($user) || $force_str)
	{
		$user = phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . " 
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	return ( $row = $db->sql_fetchrow($result) ) ? $row : false;
}

function make_jumpbox($action, $match_forum_id=0)
{
	global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID,$is_auth; 
	$sql="SELECT cat_id,cat_title 
		FROM ".CATEGORIES_TABLE." 
		".(($userdata['user_level'] == ADMIN)? "" : " WHERE cat_id<>'".HIDDEN_CAT."'" )." 
		ORDER BY cat_order ";
	if( !$result = $db->sql_query($sql) ) 
	{ 
		message_die(GENERAL_ERROR, "Couldn't get list of Categories/Forums", "", __LINE__, __FILE__, $sql); 
	} 
	$cat_data = array(); 
	while( $row = $db->sql_fetchrow($result) ) 
	{ 
		$cat_data[] = $row; 
	}
	$db->sql_freeresult($result); 
	$sql = "SELECT cat_id,forum_id,forum_name,sort_sub,forum_sub,auth_view 
		FROM ".FORUMS_TABLE." 
		".(($userdata['user_level'] == ADMIN)? "" : " WHERE cat_id<>'".HIDDEN_CAT."'" )." 
		ORDER BY cat_id,forum_order"; 
	if( !$result = $db->sql_query($sql) ) 
	{ 
		message_die(GENERAL_ERROR, "Couldn't get list of Categories/Forums", "", __LINE__, __FILE__, $sql); 
	} 
	$forum_data = array(); 
	$forum_sub = array(); 
	$forum_sub2 = array(); 
	while( $row = $db->sql_fetchrow($result) ) 
	{
		$s=""; 

		if($row['auth_view'] <= AUTH_REG) 
		{
			if($row[forum_sub]==0) 
			{ 
				$forum_data[$row['cat_id']][] = $row; 
			} 
			else 
			{ 
				if ($row[forum_id] == $match_forum_id) 
				{ 
					$s = " selected=\"selected\""; 
				} 
				$forum_sub[$row['forum_sub']][] = "add_select('".$row[forum_id]."','".$row[forum_name]."','$s',".($row[sort_sub]+1).");"; 
				$forum_sub2[$row['forum_sub']][]=$row[forum_id]; 
			} 
		} 
	} 
	$db->sql_freeresult($result); 
	$sub_list="add_select('-1','".$lang['Select_forum']."','$s',0);"; 
	for( $i=0;$i<count($cat_data);$i++) 
	{ 
		$s = ""; 
		$cat_id=$cat_data[$i][cat_id]; 
		$sub_list .="add_select('-1','&nbsp;','$s',0);"; 
		$sub_list .="add_select('-1','".$cat_data[$i][cat_title]."','$s',0);"; 
		for($j=0;$j<count($forum_data[$cat_id]);$j++) 
		{ 
			$s = ""; 
			if ($forum_data[$cat_id][$j][forum_id] == $match_forum_id) 
			{ 
				$s = " selected=\"selected\""; 
			} 
			$sub_list .= "add_select('".$forum_data[$cat_id][$j][forum_id]."','".$forum_data[$cat_id][$j][forum_name]."','$s',".($forum_data[$cat_id][$j][sort_sub]+1).");"; 
			if ( count($forum_sub[$forum_data[$cat_id][$j][forum_id]]) > 0 ) 
			{ 
				for($jj=0;$jj<count($forum_sub[$forum_data[$cat_id][$j][forum_id]]);$jj++) 
				{ 
					$sub_list.= $forum_sub[$forum_data[$cat_id][$j][forum_id]][$jj]; 
					$sub_list.=sub_search($forum_sub2[$forum_data[$cat_id][$j][forum_id]][$jj],$forum_sub,$forum_sub2); 
				} 
			} 
		} 
	} 
	$template->set_filenames(array( 
		'jumpbox' => 'jumpbox.tpl') 
	); 
	$template->assign_vars(array( 
		'L_GO' => $lang['Go'], 
		'L_JUMP_TO' => $lang['Jump_to'], 
		'L_SELECT_FORUM' => $lang['Select_forum'], 
		'JUMP_NAME'=>POST_FORUM_URL, 
		'S_JUMPBOX_SELECT' => $sub_list, 
		'S_JUMPBOX_ACTION' => append_sid($action)) 
	); 
	$template->assign_var_from_handle('JUMPBOX', 'jumpbox'); 
	return; 
} 

function sub_search($id, $forum_sub, $forum_sub2) 
{ 
	if ( count($forum_sub[$id]) > 0 ) 
	{ 
		$list=""; 
		for($jj=0;$jj<count($forum_sub[$id]);$jj++) 
		{ 
			$list.= $forum_sub[$id][$jj]; 
			$list.=sub_search($forum_sub2[$id][$jj],$forum_sub,$forum_sub2); 
		} 
	} 
	return $list; 
} 

//
// Initialise user settings on page load
function init_userprefs($userdata)
{
	global $board_config, $theme, $images;
	global $template, $lang, $phpEx, $phpbb_root_path;
	global $nav_links;

	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
		{
			$board_config['default_lang'] = $userdata['user_lang'];
		}

		if ( !empty($userdata['user_dateformat']) )
		{
			$board_config['default_dateformat'] = $userdata['user_dateformat'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}
	}

	if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx)) )
	{
		$board_config['default_lang'] = 'english';
	}

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	if ( defined('IN_CASHMOD') )
	{
		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_cash.'.$phpEx)) )
		{
			include($phpbb_root_path . 'language/lang_english/lang_cash.' . $phpEx);
		}
		else
		{
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_cash.' . $phpEx);
		}
	}

	if ( defined('IN_ADMIN') )
	{
		if( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)) )
		{
			$board_config['default_lang'] = 'english';
		}

		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	include_attach_lang();
	//
	// Set up style
	//
	if ( !$board_config['override_user_style'] )
	{
		if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
		{
			if ( $theme = setup_style($userdata['user_style']) )
			{
				return;
			}
		}
	}

	$theme = setup_style($board_config['default_style']);

	//
	// Mozilla navigation bar
	// Default items that should be valid on all pages.
	// Defined here to correctly assign the Language Variables
	// and be able to change the variables within code.
	//
	$nav_links['top'] = array ( 
		'url' => append_sid($phpbb_root_path . 'index.' . $phpEx),
		'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
	);
	$nav_links['search'] = array ( 
		'url' => append_sid($phpbb_root_path . 'search.' . $phpEx),
		'title' => $lang['Search']
	);
	$nav_links['help'] = array ( 
		'url' => append_sid($phpbb_root_path . 'faq.' . $phpEx),
		'title' => $lang['FAQ']
	);
	$nav_links['author'] = array ( 
		'url' => append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
		'title' => $lang['Memberlist']
	);

	return;
}

function setup_style($style)
{
	global $db, $board_config, $template, $images, $phpbb_root_path;

	$sql = "SELECT *
		FROM " . THEMES_TABLE . "
		WHERE themes_id = $style";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Could not query database for theme info');
	}

	if ( !($row = $db->sql_fetchrow($result)) )
	{
		message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
	}

	$template_path = 'templates/' ;
	$template_name = $row['template_name'] ;

	$template = new Template($phpbb_root_path . $template_path . $template_name);

	if ( $template )
	{
		$current_template_path = $template_path . $template_name;
		@include($phpbb_root_path . $template_path . $template_name . '/' . $template_name . '.cfg');

		if ( !defined('TEMPLATE_CONFIG') )
		{
			message_die(CRITICAL_ERROR, "Could not open $template_name template config file", '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang'])) ) ? $board_config['default_lang'] : 'english';

		while( list($key, $value) = @each($images) )
		{
			if ( !is_array($value) )
			{
				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);
			}
		}
	}

	return $row;
}

function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//
// Create date/time from format and timezone
//
function create_date($format, $gmepoch, $tz)
{
	global $board_config, $lang;
	static $translate;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}

//
// Pagination routine, generates
// page number sequence
//
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{
	global $lang;

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ", ";
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ', ';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
			}
			else
			{
				$page_string .= ' ... ';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if( $i <  $total_pages )
				{
					$page_string .= ", ";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ', ';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a href="' . append_sid($base_url . "&amp;start=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $lang['Previous'] . '</a>&nbsp;&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . append_sid($base_url . "&amp;start=" . ( $on_page * $per_page ) ) . '">' . $lang['Next'] . '</a>';
		}

	}

	if ( $total_pages > 5 )
	{	
		$select_page = ' <select name="generate_pagination" onChange="if(this.options[this.selectedIndex].value != -1){ window.location = this.options[this.selectedIndex].value; }">';
		for($i = 1; $i <= $total_pages; $i++)
		{
			$selected = ( $i == $on_page ) ? ' selected="selected"' : ''; // highlight current page by default
			$select_page .= '<option value="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) )  . '"' . $selected . '>' . $i . '</option>';
		}
		$select_page .= '</select>:';
	}
	else
	{
		$select_page = '';
	}
	
	$page_string = $lang['Goto_page'] . $select_page . ' ' . $page_string;

	return $page_string;
}

//
// This does exactly what preg_quote() does in PHP 4-ish
// If you just need the 1-parameter preg_quote call, then don't bother using this.
//
function phpbb_preg_quote($str, $delimiter)
{
	$text = preg_quote($str);
	$text = str_replace($delimiter, '\\' . $delimiter, $text);
	
	return $text;
}

//
// Obtain list of naughty words and build preg style replacement arrays for use by the
// calling script, note that the vars are passed as references this just makes it easier
// to return both sets of arrays
//
function obtain_word_list(&$orig_word, &$replacement_word)
{
	global $db;

	//
	// Define censored word matches
	//
	$sql = "SELECT word, replacement
		FROM  " . WORDS_TABLE;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get censored words from database', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		do 
		{
			$orig_word[] = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
			$replacement_word[] = $row['replacement'];
		}
		while ( $row = $db->sql_fetchrow($result) );
	}

	return true;
}

//
// This is general replacement for die(), allows templated
// output in users (or default) language, etc.
//
// $msg_code can be one of these constants:
//
// GENERAL_MESSAGE : Use for any simple text message, eg. results 
// of an operation, authorisation failures, etc.
//
// GENERAL ERROR : Use for any error which occurs _AFTER_ the 
// common.php include and session code, ie. most errors in 
// pages/functions
//
// CRITICAL_MESSAGE : Used when basic config data is available but 
// a session may not exist, eg. banned users
//
// CRITICAL_ERROR : Used when config data cannot be obtained, eg
// no database connection. Should _not_ be used in 99.5% of cases
//
function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
	global $userdata, $user_ip, $session_length;
	global $starttime;

	if(defined('HAS_DIED'))
	{
		die("message_die() was called multiple times. This isn't supposed to happen. Was message_die() used in page_tail.php?");
	}
	
	define('HAS_DIED', 1);
	

	$sql_store = $sql;
	
	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent 
	// subsequent queries from overwriting the status of sql_error()
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		$sql_error = $db->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= "<br /><br />$sql_store";
		}

		if ( $err_line != '' && $err_file != '' )
		{
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . basename($err_file);
		}
	}

	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )
	{
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		init_userprefs($userdata);
	}

	//
	// If the header hasn't been output then do it
	//
	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )
	{
		if ( empty($lang) )
		{
			if ( !empty($board_config['default_lang']) )
			{
				include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx);
			}
			else
			{
				include($phpbb_root_path . 'language/lang_english/lang_main.'.$phpEx);
			}
		}

		if ( empty($template) )
		{
			$template = new Template($phpbb_root_path . 'templates/' . $board_config['board_template']);
		}
		if ( empty($theme) )
		{
			$theme = setup_style($board_config['default_style']);
		}

		//
		// Load the Page Header
		//
		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_header_admin.'.$phpEx);
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Information'];
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Critical_Information'];
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )
			{
				$msg_text = $lang['An_error_occured'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = $lang['General_Error'];
			}
			break;

		case CRITICAL_ERROR:
			//
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			//
			include($phpbb_root_path . 'language/lang_english/lang_main.'.$phpEx);

			if ( $msg_text == '' )
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = 'phpBB : <b>' . $lang['Critical_Error'] . '</b>';
			}
			break;
	}

	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}

		if ( !defined('IN_ADMIN') )
		{
			$template->set_filenames(array(
				'message_body' => 'message_body.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'message_body' => 'admin/admin_message_body.tpl')
			);
		}

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $msg_title,
			'MESSAGE_TEXT' => $msg_text)
		);
		$template->pparse('message_body');

		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
		}
	}
	else
	{
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}

	exit;
}

//
// This function is for compatibility with PHP 4.x's realpath()
// function.  In later versions of PHP, it needs to be called
// to do checks with some functions.  Older versions of PHP don't
// seem to need this, so we'll just return the original value.
// dougk_ff7 <October 5, 2002>
function phpbb_realpath($path)
{
	global $phpbb_root_path, $phpEx;

	return (!@function_exists('realpath') || !@realpath($phpbb_root_path . 'includes/functions.'.$phpEx)) ? $path : @realpath($path);
}

function redirect($url)
{
	global $db, $board_config;

	if (!empty($db))
	{
		$db->sql_close();
	}

	if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r"))
	{
		message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
	}

	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
	$url = preg_replace('#^\/?(.*?)\/?$#', '/\1', trim($url));

	// Redirect via an HTML form for PITA webservers
	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')))
	{
		header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name . $url);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name . $url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $server_protocol . $server_name . $server_port . $script_name . $url);
	exit;
}

// the originate php "mktime()", does not work proberly on all OS, especially when going back in time
// before year 1970 (year 0), this function "mkrealtime()", has a mutch larger valid date range,
// from 1901 - 2099. it returns a "like" UNIX timestamp divided by 86400, so
// calculation from the originate php date and mktime is easy.
// mkrealdate, returns the number of day (with sign) from 1.1.1970.

function mkrealdate($day,$month,$birth_year)
{
	// range check months
	if ($month<1 || $month>12) return "error";
	// range check days
	switch ($month)
	{
		case 1: if ($day>31) return "error";break;
		case 2: if ($day>29) return "error";
			$epoch=$epoch+31;break;
		case 3: if ($day>31) return "error";
			$epoch=$epoch+59;break;
		case 4: if ($day>30) return "error" ;
			$epoch=$epoch+90;break;
		case 5: if ($day>31) return "error";
			$epoch=$epoch+120;break;
		case 6: if ($day>30) return "error";
			$epoch=$epoch+151;break;
		case 7: if ($day>31) return "error";
			$epoch=$epoch+181;break;
		case 8: if ($day>31) return "error";
			$epoch=$epoch+212;break;
		case 9: if ($day>30) return "error";
			$epoch=$epoch+243;break;
		case 10: if ($day>31) return "error";
			$epoch=$epoch+273;break;
		case 11: if ($day>30) return "error";
			$epoch=$epoch+304;break;
		case 12: if ($day>31) return "error";
			$epoch=$epoch+334;break;
	}
	$epoch=$epoch+$day;
	$epoch_Y=sqrt(($birth_year-1970)*($birth_year-1970));
	$leapyear=round((($epoch_Y+2) / 4)-.5);
	if (($epoch_Y+2)%4==0)
	{// curent year is leapyear
		$leapyear--;
		if ($birth_year >1970 && $month>=3) $epoch=$epoch+1;
		if ($birth_year <1970 && $month<3) $epoch=$epoch-1;
	} else if ($month==2 && $day>28) return "error";//only 28 days in feb.
	//year
	if ($birth_year>1970)
		$epoch=$epoch+$epoch_Y*365-1+$leapyear;
	else
		$epoch=$epoch-$epoch_Y*365-1-$leapyear;
	return $epoch;
}

// the originate php "date()", does not work proberly on all OS, especially when going back in time
// before year 1970 (year 0), this function "realdate()", has a mutch larger valid date range,
// from 1901 - 2099. it returns a "like" UNIX date format (only date, related letters may be used, due to the fact that
// the given date value should already be divided by 86400 - leaving no time information left)
// a input like a UNIX timestamp divided by 86400 is expected, so
// calculation from the originate php date and mktime is easy.
// e.g. realdate ("m d Y", 3) returns the string "1 3 1970"

// UNIX users should replace this function with the below code, since this should be faster
//
//function realdate($date_syntax="Ymd",$date=0) 
//{ return create_date($date_syntax,$date*86400+1,0); }

function realdate($date_syntax="Ymd",$date=0)
{
	global $lang;
	$i=2;
	if ($date>=0)
	{
	 	return create_date($date_syntax,$date*86400+1,0);
	} else
	{
		$year= -(date%1461);
		$days = $date + $year*1461;
		while ($days<0)
		{
			$year--;
			$days+=365;
			if ($i++==3)
			{
				$i=0;
				$days++;
			}
		}
	}
	$leap_year = ($i==0) ? TRUE : FALSE;
	$months_array = ($i==0) ?
		array (0,31,60,91,121,152,182,213,244,274,305,335,366) :
		array (0,31,59,90,120,151,181,212,243,273,304,334,365);
	for ($month=1;$month<12;$month++)
	{
		if ($days<$months_array[$month]) break;
	}

	$day=$days-$months_array[$month-1]+1;
	//you may gain speed performance by remove som of the below entry's if they are not needed/used
	return strtr ($date_syntax, array(
		'a' => '',
		'A' => '',
		'\\d' => 'd',
		'd' => ($day>9) ? $day : '0'.$day,
		'\\D' => 'D',
		'D' => $lang['day_short'][($date-3)%7],
		'\\F' => 'F',
		'F' => $lang['month_long'][$month-1],
		'g' => '',
		'G' => '',
		'H' => '',
		'h' => '',
		'i' => '',
		'I' => '',
		'\\j' => 'j',
		'j' => $day,
		'\\l' => 'l',
		'l' => $lang['day_long'][($date-3)%7],
		'\\L' => 'L',
		'L' => $leap_year,
		'\\m' => 'm',
		'm' => ($month>9) ? $month : '0'.$month,
		'\\M' => 'M',
		'M' => $lang['month_short'][$month-1],
		'\\n' => 'n',
		'n' => $month,
		'O' => '',
		's' => '',
		'S' => '',
		'\\t' => 't',
		't' => $months_array[$month]-$months_array[$month-1],
		'w' => '',
		'\\y' => 'y',
		'y' => ($year>29) ? $year-30 : $year+70,
		'\\Y' => 'Y',
		'Y' => $year+1970,
		'\\z' => 'z',
		'z' => $days,
		'\\W' => '',
		'W' => '') );
}

function forum_path($forum_row, $forum_id) 
{ 
	global $db,$phpEx; 
	if($forum_row['forum_sub'] > 0) 
	{ 
		$forum_path="-> <a href=".append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id")." class=\"nav\">".$forum_row['forum_name']."</a> "; 
		$sql="SELECT forum_id,forum_name,forum_sub 
			FROM ".FORUMS_TABLE." 
			WHERE forum_id=".$forum_row['forum_sub']; 
		if ( !($result = $db->sql_query($sql)) ) 
		{ 
			message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql); 
		} 
		while($row = $db->sql_fetchrow($result)) 
		{ 
			$forum_path="-> <a href=".append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=".$row[forum_id])." class=\"nav\">".$row['forum_name']."</a> ".$forum_path; 
			if($row['forum_sub']==0) 
			{ 
				break; 
			} 
			$sql="SELECT forum_id,forum_name,forum_sub 
				FROM ".FORUMS_TABLE." 
				WHERE forum_id=".$row['forum_sub']; 
			if ( !($result = $db->sql_query($sql)) ) 
			{ 
				message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql); 
			} 
		} 
	}
	else 
	{ 
		$forum_path="-> <a href=".append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id")." class=\"nav\">".$forum_row['forum_name']."</a> "; 
	} 
	$db->sql_freeresult($result); 
	unset($row); 
	unset($forum_row); 
	return $forum_path; 
}
?>