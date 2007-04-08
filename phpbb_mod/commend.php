<?php
/***************************************************************************
 *                               commend.php
 *                            -------------------
 *   begin                : 2004/7/25
 *   copyright            : Ray (C) 2003,2004 iOptional
 *   email                : blue_sky_ray02@hotmail.com
 *
 *   $Id: commend.php,v1.0.3 2004/7/25 20:42 Ray Exp $
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
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start initial var setup
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = ( isset($HTTP_GET_VARS[POST_FORUM_URL]) ) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : intval($HTTP_POST_VARS[POST_FORUM_URL]);
}
else if ( isset($HTTP_GET_VARS['forum']))
{
	$forum_id = intval($HTTP_GET_VARS['forum']);
}
else
{
	$forum_id = '';
}

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = (isset($HTTP_POST_VARS['mark'])) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}
//
// End initial var setup
//

//
// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
//
if ( !empty($forum_id) )
{
	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
	}
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// If the query doesn't return any rows this isn't a valid forum. Inform
// the user.
//
if ( !($forum_row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_row);

if ( !$is_auth['auth_read'] || !$is_auth['auth_view'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = POST_FORUM_URL . "=$forum_id" . ( ( isset($start) ) ? "&start=$start" : '' );
		redirect(append_sid("login.$phpEx?redirect=commend.$phpEx&$redirect", true));
	}
	//
	// The user is not authed to read this forum ...
	//
	$message = ( !$is_auth['auth_view'] ) ? $lang['Forum_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End of auth check
//

$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : '';
$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : '';

//
// Generate a 'Show topics in previous x days' select box. If the topicsdays var is sent
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Topics'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if ( !empty($HTTP_POST_VARS['topicdays']) || !empty($HTTP_GET_VARS['topicdays']) )
{
	$topic_days = ( !empty($HTTP_POST_VARS['topicdays']) ) ? intval($HTTP_POST_VARS['topicdays']) : intval($HTTP_GET_VARS['topicdays']);
	$min_topic_time = time() - ($topic_days * 86400);

	$sql = "SELECT COUNT(t.topic_id) AS forum_topics 
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p 
		WHERE t.forum_id = $forum_id 
			AND t.topic_type = " . POST_COMMEND . "
			AND p.post_id = t.topic_last_post_id
			AND p.post_time >= $min_topic_time"; 

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$topics_count = ( $row['forum_topics'] ) ? $row['forum_topics'] : 1;
	$limit_topics_time = "AND p.post_time >= $min_topic_time";

	if ( !empty($HTTP_POST_VARS['topicdays']) )
	{
		$start = 0;
	}
}
else
{
	$sql = "SELECT *
		FROM " . TOPICS_TABLE . "
		WHERE forum_id = $forum_id 
			AND topic_type = " . POST_COMMEND; 
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
	}
	$c_row = $db->sql_fetchrow($result);
	
	$topics_count = ( $c_row['forum_topics'] ) ? $c_row['forum_topics'] : 1;

	$limit_topics_time = '';
	$topic_days = 0;
}

$select_topic_days = '<select name="topicdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($topic_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_topic_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_topic_days .= '</select>';

//
// Grab all the basic data (all topics except announcements)
// for this forum
//
$sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time 
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2
	WHERE t.forum_id = $forum_id
		AND t.topic_poster = u.user_id
		AND p.post_id = t.topic_first_post_id
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id 
		AND t.topic_type = " . POST_COMMEND . " 
		$limit_topics_time
	ORDER BY t.topic_last_post_id DESC 
	LIMIT $start, ".$board_config['topics_per_page'];
if ( !($result = $db->sql_query($sql)) )
{
   message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

$total_topics = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_topics++;
}

$db->sql_freeresult($result);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Post URL generation for templating vars
//
$template->assign_vars(array(
	'L_DISPLAY_TOPICS' => $lang['Display_topics'],

	'U_POST_NEW_TOPIC' => append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id"),

	'S_SELECT_TOPIC_DAYS' => $select_topic_days,
	'S_POST_DAYS_ACTION' => append_sid("commend.$phpEx?" . POST_FORUM_URL . "=" . $forum_id . "&amp;start=$start"))
);

//
// Mozilla navigation bar
//
$nav_links['up'] = array(
	'url' => append_sid('index.'.$phpEx),
	'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
);

if ( !is_null($userdata[$board_config['access_point']]) )
{
	if (!empty($board_config['access_name']) && !empty($board_config['access_point']))
	{
		if ($userdata['user_id'] == ANONYMOUS)
		{
			if (($forum_row['forum_access'] > $userdata[$board_config['access_point']]) && ($forum_row['forum_access'] != 0))
			{
				message_die(GENERAL_ERROR, sprintf($lang['access_error2'], "<a href=\"" . append_sid("index.$phpEx") . "\">", "</a>"), $lang['access_error']);
			}
		}
		else if (($userdata['user_level'] != ADMIN || !($is_auth['auth_mod'])))
		{
			if (($forum_row['forum_access'] > $userdata[$board_config['access_point']]) && ($forum_row['forum_access'] != 0))
			{
				message_die(GENERAL_ERROR, sprintf($lang['access_error1'], $forum_row['forum_access'], $board_config['access_name'], "<a href=\"" . append_sid("index.$phpEx") . "\">", "</a>"),  $lang['access_error']);
			}
		}
	}
}

//
// Dump out the page header and load commend template
//
define('SHOW_ONLINE', true);
$page_title = $lang['View_forum'] . ' - ' . $forum_row['forum_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'commend_body.tpl')
);
make_jumpbox('commend.'.$phpEx);

$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_NAME' => $forum_row['forum_name'],
	'COMMEND_NAME' => $forum_row['forum_name'] . '&nbsp;' . $lang['Commend'],

	'FOLDER_COMMEND_IMG' => $images['folder_commend'],
	'FOLDER_COMMEND_NEW_IMG' => $images['folder_commend_new'],

	'L_TOPICS' => $lang['Topics'],
	'L_REPLIES' => $lang['Replies'],
	'L_VIEWS' => $lang['Views'],
	'L_POSTS' => $lang['Posts'],
	'L_LASTPOST' => $lang['Last_Post'],

	'L_POST_NEW_TOPIC' => ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'], 
	'L_NO_NEW_POSTS' => $lang['No_new_posts'],
	'L_NEW_POSTS' => $lang['New_posts'],
	'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'], 
	'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'], 
	'L_NO_NEW_POSTS_HOT' => $lang['No_new_posts_hot'],
	'L_NEW_POSTS_HOT' => $lang['New_posts_hot'],

	'L_COMMEND' => $lang['Post_Commend'], 
	'L_POSTED' => $lang['Posted'],
	'L_JOINED' => $lang['Joined'],
	'L_AUTHOR' => $lang['Author'],

	'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id"),
	'U_VIEW_COMMEND' => append_sid("commend.$phpEx?" . POST_FORUM_URL ."=$forum_id"))
);
//
// End header
//

//
// Okay, lets dump out the page ...
//
if( $total_topics )
{
	for($i = 0; $i < $total_topics; $i++)
	{
		$topic_id = $topic_rowset[$i]['topic_id'];

		$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

		if ($board_config['allow_new_topic'] == 1)
		{
			if ((time() - $topic_rowset[$i]['topic_time'] < ($board_config['new_topic_time'] * 3600)))
			{
				$topic_new_icon = ' <img src="'.$images['new_topic_commend'].'" border="0">';
			}
			else
			{
				$topic_new_icon = '';
			}
		}

		$replies = $topic_rowset[$i]['topic_replies'];

		$topic_type = $topic_rowset[$i]['topic_type'];

		if( $topic_type == POST_COMMEND )
		{
			$topic_type = $lang['Topic_Commend'] . ' ';
		}
		else
		{
			$topic_type = '';		
		}

		if( $topic_rowset[$i]['topic_vote'] )
		{
			$topic_type .= $lang['Topic_Poll'] . ' ';
		}

		$folder = $images['folder_commend'];
		$folder_new = $images['folder_commend_new'];

		$newest_post_img = '';
		if( $userdata['session_logged_in'] )
		{
			if( $topic_rowset[$i]['post_time'] > $userdata['user_lastvisit'] ) 
			{
				if( !empty($tracking_topics) || !empty($tracking_forums) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
				{
					$unread_topics = true;
					
					if( !empty($tracking_topics[$topic_id]) )
					{
						if( $tracking_topics[$topic_id] >= $topic_rowset[$i]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if( !empty($tracking_forums[$forum_id]) )
					{
						if( $tracking_forums[$forum_id] >= $topic_rowset[$i]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
					{
						if( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] >= $topic_rowset[$i]['post_time'] )
						{
							$unread_topics = false;
						}
					}

					if( $unread_topics )
					{
						$folder_image = $folder_new;
						$folder_alt = $lang['New_posts'];

						$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
					}
					else
					{
						$folder_image = $folder;
						$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

						$newest_post_img = '';
					}
				}
				else
				{
					$folder_image = $folder_new;
					$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['New_posts'];

					$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
				}
			}
			else 
			{
				$folder_image = $folder;
				$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

				$newest_post_img = '';
			}
		}
		else
		{
			$folder_image = $folder;
			$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

			$newest_post_img = '';
		}

		if( ( $replies + 1 ) > $board_config['posts_per_page'] )
		{
			$total_pages = ceil( ( $replies + 1 ) / $board_config['posts_per_page'] );
			$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="' . $lang['Goto_page'] . '" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';

			$times = 1;
			for($j = 0; $j < $replies + 1; $j += $board_config['posts_per_page'])
			{
				$goto_page .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
				if( $times == 1 && $total_pages > 4 )
				{
					$goto_page .= ' ... ';
					$times = $total_pages - 3;
					$j += ( $total_pages - 4 ) * $board_config['posts_per_page'];
				}
				else if ( $times < $total_pages )
				{
					$goto_page .= ', ';
				}
				$times++;
			}
			$goto_page .= ' ] ';
		}
		else
		{
			$goto_page = '';
		}
		
		$view_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id");

		$topic_author = ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $topic_rowset[$i]['user_id']) . '">' : '';
		$topic_author .= ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? $topic_rowset[$i]['username'] : ( ( $topic_rowset[$i]['post_username'] != '' ) ? $topic_rowset[$i]['post_username'] : $lang['Guest'] );

		$topic_author .= ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

		$first_post_time = create_date('Y-m-d G:i', $topic_rowset[$i]['topic_time'], $board_config['board_timezone']);

		$last_post_time = create_date('Y-m-d G:i', $topic_rowset[$i]['post_time'], $board_config['board_timezone']);

		$last_post_author = ( $topic_rowset[$i]['id2'] == ANONYMOUS ) ? ( ($topic_rowset[$i]['post_username2'] != '' ) ? $topic_rowset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $topic_rowset[$i]['id2']) . '">' . $topic_rowset[$i]['user2'] . '</a>';

		$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

		$views = $topic_rowset[$i]['topic_views'];
		
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('topicrow', array(
			'ROW_COLOR' => $row_color,
			'ROW_CLASS' => $row_class,
			'FORUM_ID' => $forum_id,
			'TOPIC_ID' => $topic_id,
			'TOPIC_FOLDER_IMG' => $folder_image, 
			'TOPIC_AUTHOR' => $topic_author, 
			'GOTO_PAGE' => $goto_page,
			'REPLIES' => $replies,
			'NEWEST_POST_IMG' => $newest_post_img, 
			'TOPIC_TITLE' => $topic_title,
			'TOPIC_TYPE' => $topic_type,
			'VIEWS' => $views,
			'FIRST_POST_TIME' => $first_post_time, 
			'LAST_POST_TIME' => $last_post_time, 
			'LAST_POST_AUTHOR' => $last_post_author, 
			'LAST_POST_IMG' => $last_post_url, 

			'TOPIC_NEW_ICON' => $topic_new_icon,

			'L_TOPIC_FOLDER_ALT' => $folder_alt, 

			'U_VIEW_TOPIC' => $view_topic_url)
		);
	}

	$template->assign_vars(array(
		'PAGINATION' => generate_pagination("commend.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;topicdays=$topic_days", $topics_count, $board_config['topics_per_page'], $start),
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $topics_count / $board_config['topics_per_page'] )), 

		'L_GOTO_PAGE' => $lang['Goto_page'])
	);
}
else
{
	//
	// No topics
	//
	$no_topics_msg = ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['No_topics_commend_one'];
	$template->assign_vars(array(
		'L_NO_TOPICS' => $no_topics_msg)
	);

	$template->assign_block_vars('switch_no_topics', array() );

}

//
// Parse the page and print
//
$template->pparse('body');

//
// Page footer
//
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>