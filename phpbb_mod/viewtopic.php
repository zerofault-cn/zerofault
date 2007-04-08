<?php
/***************************************************************************
 *                               viewtopic.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: viewtopic.php,v 1.186.2.37 2004/11/18 17:49:39 acydburn Exp $
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
define('IN_CASHMOD', true);
define('CM_VIEWTOPIC', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);


//
// Start initial var setup
//
$topic_id = $post_id = 0;
$vote_id = array();
if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_GET_VARS['topic']) )
{
	$topic_id = intval($HTTP_GET_VARS['topic']);
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]))
{
	$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
}
if ( isset($HTTP_POST_VARS[POST_POST_URL]))
{
	$post_id = intval($HTTP_POST_VARS[POST_POST_URL]);
}


$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if (!$topic_id && !$post_id)
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}

//
// Find topic id if user requested a newer
// or older topic
//
if ( isset($HTTP_GET_VARS['view']) && empty($HTTP_GET_VARS[POST_POST_URL]) )
{
	if ( $HTTP_GET_VARS['view'] == 'newest' )
	{
		if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_GET_VARS['sid']) )
		{
			$session_id = isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) ? $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid'] : $HTTP_GET_VARS['sid'];

			if (!preg_match('/^[A-Za-z0-9]*$/', $session_id)) 
			{
				$session_id = '';
			}

			if ( $session_id )
			{
				$sql = "SELECT p.post_id
					FROM " . POSTS_TABLE . " p, " . SESSIONS_TABLE . " s,  " . USERS_TABLE . " u
					WHERE s.session_id = '$session_id'
						AND u.user_id = s.session_user_id
						AND p.topic_id = $topic_id
						AND p.post_time >= u.user_lastvisit
					ORDER BY p.post_time ASC
					LIMIT 1";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					message_die(GENERAL_MESSAGE, 'No_new_posts_last_visit');
				}

				$post_id = $row['post_id'];

				if (isset($HTTP_GET_VARS['sid']))
				{
					redirect("viewtopic.$phpEx?sid=$session_id&" . POST_POST_URL . "=$post_id#$post_id");
				}
				else
				{
					redirect("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id");
				}
			}
		}

		redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
	}
	else if ( $HTTP_GET_VARS['view'] == 'next' || $HTTP_GET_VARS['view'] == 'previous' )
	{
		$sql_condition = ( $HTTP_GET_VARS['view'] == 'next' ) ? '>' : '<';
		$sql_ordering = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'ASC' : 'DESC';

		$sql = "SELECT t.topic_id
			FROM " . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2
			WHERE
				t2.topic_id = $topic_id
				AND t.forum_id = t2.forum_id
				AND t.topic_moved_id = 0
				AND t.topic_last_post_id $sql_condition t2.topic_last_post_id
			ORDER BY t.topic_last_post_id $sql_ordering
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain newer/older topic information", '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$topic_id = intval($row['topic_id']);
		}
		else
		{
			$message = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'No_newer_topics' : 'No_older_topics';
			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

//
// This rather complex gaggle of code handles querying for topics but
// also allows for direct linking to a post (and the calculation of which
// page the post is on and the correct display of viewtopic)
//
$join_sql_table = (!$post_id) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = ( !$post_id ) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = (!$post_id) ? '' : ", COUNT(p2.post_id) AS prev_posts";

$order_sql = (!$post_id) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_commend, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.auth_ban, f.auth_greencard, f.auth_bluecard   ORDER BY p.post_id ASC";

$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_icon, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_commend, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.forum_sub, f.auth_ban, f.auth_greencard, f.auth_bluecard" . $count_sql . "
	FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $join_sql_table . "
	WHERE $join_sql
		AND f.forum_id = t.forum_id
		$order_sql";
attach_setup_viewtopic_auth($order_sql, $sql);
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}

$forum_id = intval($forum_topic_data['forum_id']);
$forum_path=forum_path($forum_topic_data,$forum_id);

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
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_topic_data);

if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = ($post_id) ? POST_POST_URL . "=$post_id" : POST_TOPIC_URL . "=$topic_id";
		$redirect .= ($start) ? "&start=$start" : '';
		redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&$redirect", true));
	}

	$message = ( !$is_auth['auth_view'] ) ? $lang['Topic_post_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End auth check
//
// Advanced Hide Post MOD
include($phpbb_root_path . 'includes/functions_hide.' . $phpEx);
if ( isset($HTTP_POST_VARS['buypost']) )
{
	buy_post($post_id, "viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id" . '">');
}


$forum_name = $forum_topic_data['forum_name'];
$forum_icon = ( !empty($forum_topic_data['forum_icon']) ) ? '<img src="./images/icons/' . $forum_topic_data['forum_icon'] . '" border="0">' : '';
$topic_title = $forum_topic_data['topic_title'];
$topic_id = intval($forum_topic_data['topic_id']);
$topic_time = $forum_topic_data['topic_time'];

if ($post_id)
{
	$start = floor(($forum_topic_data['prev_posts'] - 1) / intval($board_config['posts_per_page'])) * intval($board_config['posts_per_page']);
}

//
// Is user watching this thread?
//
if( $userdata['session_logged_in'] )
{
	$can_watch_topic = TRUE;

	$sql = "SELECT notify_status
		FROM " . TOPICS_WATCH_TABLE . "
		WHERE topic_id = $topic_id
			AND user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic watch information", '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($HTTP_GET_VARS['unwatch']) )
		{
			if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
			{
				$is_watching_topic = 0;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "DELETE $sql_priority FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not delete topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['No_longer_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = TRUE;

			if ( $row['notify_status'] )
			{
				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "UPDATE $sql_priority " . TOPICS_WATCH_TABLE . "
					SET notify_status = 0
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not update topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	else
	{
		if ( isset($HTTP_GET_VARS['watch']) )
		{
			if ( $HTTP_GET_VARS['watch'] == 'topic' )
			{
				$is_watching_topic = TRUE;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not insert topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['You_are_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = 0;
		}
	}
}
else
{
	if ( isset($HTTP_GET_VARS['unwatch']) )
	{
		if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
		{
			redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&" . POST_TOPIC_URL . "=$topic_id&unwatch=topic", true));
		}
	}
	else
	{
		$can_watch_topic = 0;
		$is_watching_topic = 0;
	}
}

//
// Generate a 'Show posts in previous x days' select box. If the postdays var is POSTed
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Posts'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if( !empty($HTTP_POST_VARS['postdays']) || !empty($HTTP_GET_VARS['postdays']) )
{
	$post_days = ( !empty($HTTP_POST_VARS['postdays']) ) ? intval($HTTP_POST_VARS['postdays']) : intval($HTTP_GET_VARS['postdays']);
	$min_post_time = time() - (intval($post_days) * 86400);

	$sql = "SELECT COUNT(p.post_id) AS num_posts
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
		WHERE t.topic_id = $topic_id
			AND p.topic_id = t.topic_id
			AND p.post_time >= $min_post_time";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain limited topics count information", '', __LINE__, __FILE__, $sql);
	}

	$total_replies = ( $row = $db->sql_fetchrow($result) ) ? intval($row['num_posts']) : 0;

	$limit_posts_time = "AND p.post_time >= $min_post_time ";

	if ( !empty($HTTP_POST_VARS['postdays']))
	{
		$start = 0;
	}
}
else
{
	$total_replies = intval($forum_topic_data['topic_replies']) + 1;

	$limit_posts_time = '';
	$post_days = 0;
}

$select_post_days = '<select name="postdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($post_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_post_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_post_days .= '</select>';

//
// Decide how to order the post display
//
if ( !empty($HTTP_POST_VARS['postorder']) || !empty($HTTP_GET_VARS['postorder']) )
{
	$post_order = (!empty($HTTP_POST_VARS['postorder'])) ? htmlspecialchars($HTTP_POST_VARS['postorder']) : htmlspecialchars($HTTP_GET_VARS['postorder']);
	$post_time_order = ($post_order == "asc") ? "ASC" : "DESC";
}
else
{
	$post_order = 'asc';
	$post_time_order = 'ASC';
}

$select_post_order = '<select name="postorder">';
if ( $post_time_order == 'ASC' )
{
	$select_post_order .= '<option value="asc" selected="selected">' . $lang['Oldest_First'] . '</option><option value="desc">' . $lang['Newest_First'] . '</option>';
}
else
{
	$select_post_order .= '<option value="asc">' . $lang['Oldest_First'] . '</option><option value="desc" selected="selected">' . $lang['Newest_First'] . '</option>';
}
$select_post_order .= '</select>';

//
// Go ahead and pull all data for this topic
//
$sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_skype, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, u.user_birthday, u.user_next_birthday_greeting, u.user_warnings, u.user_level, u.user_allow_viewonline, u.user_session_time, u.user_gender, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
	FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
	WHERE p.topic_id = $topic_id
		$limit_posts_time
		AND pt.post_id = p.post_id
		AND u.user_id = p.poster_id
	ORDER BY p.post_time $post_time_order
	LIMIT $start, ".$board_config['posts_per_page'];
	$cm_viewtopic->generate_columns($template,$forum_id,$sql);
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain post/user information.", '', __LINE__, __FILE__, $sql);
}

$postrow = array();
if ($row = $db->sql_fetchrow($result))
{
	do
	{
		$postrow[] = $row;
	}
	while ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);

	$total_posts = count($postrow);
}
else 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   message_die(GENERAL_MESSAGE, $lang['No_posts_topic']); 
} 

$resync = FALSE; 
if ($forum_topic_data['topic_replies'] + 1 < $start + count($postrow)) 
{ 
   $resync = TRUE; 
} 
elseif ($start + $board_config['posts_per_page'] > $forum_topic_data['topic_replies']) 
{ 
   $row_id = intval($forum_topic_data['topic_replies']) % intval($board_config['posts_per_page']); 
   if ($postrow[$row_id]['post_id'] != $forum_topic_data['topic_last_post_id'] || $start + count($postrow) < $forum_topic_data['topic_replies']) 
   { 
      $resync = TRUE; 
   } 
} 
elseif (count($postrow) < $board_config['posts_per_page']) 
{ 
   $resync = TRUE; 
} 

if ($resync) 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   $result = $db->sql_query('SELECT COUNT(post_id) AS total FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id); 
   $row = $db->sql_fetchrow($result); 
   $total_replies = $row['total']; 
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Censor topic title
//
if ( count($orig_word) )
{
	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
}

//
// Was a highlight request part of the URI?
//
$highlight_match = $highlight = '';
if (isset($HTTP_GET_VARS['highlight']))
{
	// Split words and phrases
	$words = explode(' ', trim(htmlspecialchars($HTTP_GET_VARS['highlight'])));

	for($i = 0; $i < sizeof($words); $i++)
	{
		if (trim($words[$i]) != '')
		{
			$highlight_match .= (($highlight_match != '') ? '|' : '') . str_replace('*', '\w*', preg_quote($words[$i], '#'));
		}
	}
	unset($words);

	$highlight = urlencode($HTTP_GET_VARS['highlight']);
	$highlight_match = phpbb_rtrim($highlight_match, "\\");
}

//
// Post, reply and other URL generation for
// templating vars
//
$new_topic_url = append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id");
$reply_topic_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id");
$view_forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id");
$view_prev_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=previous");
$view_next_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=next");

//
// Mozilla navigation bar
//
$nav_links['prev'] = array(
	'url' => $view_prev_topic_url,
	'title' => $lang['View_previous_topic']
);
$nav_links['next'] = array(
	'url' => $view_next_topic_url,
	'title' => $lang['View_next_topic']
);
$nav_links['up'] = array(
	'url' => $view_forum_url,
	'title' => $forum_name
);

$reply_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $images['reply_locked'] : $images['reply_new'];
$reply_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['Reply_to_topic'];
$post_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'];
$post_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'];

//
// Set a cookie for this topic
//
if ( $userdata['session_logged_in'] )
{
	$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
	$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();

	if ( !empty($tracking_topics[$topic_id]) && !empty($tracking_forums[$forum_id]) )
	{
		$topic_last_read = ( $tracking_topics[$topic_id] > $tracking_forums[$forum_id] ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
	}
	else if ( !empty($tracking_topics[$topic_id]) || !empty($tracking_forums[$forum_id]) )
	{
		$topic_last_read = ( !empty($tracking_topics[$topic_id]) ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
	}
	else
	{
		$topic_last_read = $userdata['user_lastvisit'];
	}

	if ( count($tracking_topics) >= 150 && empty($tracking_topics[$topic_id]) )
	{
		asort($tracking_topics);
		unset($tracking_topics[key($tracking_topics)]);
	}

	$tracking_topics[$topic_id] = time();

	setcookie($board_config['cookie_name'] . '_t', serialize($tracking_topics), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

//
// Load templates
//
$template->set_filenames(array(
	'body' => 'viewtopic_body.tpl',
	'qrbody' => 'viewtopic_quickreply.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);

//
// Output page header
//
$page_title = $lang['View_topic'] .' - ' . $topic_title;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//
// User authorisation levels output
//
$s_auth_can = ( ( $is_auth['auth_post'] ) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_reply'] ) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_delete'] ) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';
$s_auth_can .= ( $is_auth['auth_ban'] ) ? $lang['Rules_ban_can'] . "<br />" : ""; 
$s_auth_can .= ( $is_auth['auth_greencard'] ) ? $lang['Rules_greencard_can'] . "<br />" : ""; 
$s_auth_can .= ( $is_auth['auth_bluecard'] ) ? $lang['Rules_bluecard_can'] . "<br />" : ""; 

attach_build_auth_levels($is_auth, $s_auth_can);
$topic_mod = '';

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

	$topic_mod .= ( $is_auth['auth_delete'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;' : "";

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= ( $forum_topic_data['topic_status'] == TOPIC_UNLOCKED ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=lock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_lock'] . '" alt="' . $lang['Lock_topic'] . '" title="' . $lang['Lock_topic'] . '" border="0" /></a>&nbsp;' : "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=unlock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_unlock'] . '" alt="' . $lang['Unlock_topic'] . '" title="' . $lang['Unlock_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
	$normal_button = "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=normalise&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder'] . '" alt="' . $lang['Normal_topic'] . '" title="' . $lang['Normal_topic'] . '" border="0" /></a>&nbsp;';
    $sticky_button = ( $is_auth['auth_sticky'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder_sticky'] . '" alt="' . $lang['Sticky_topic'] . '" title="' . $lang['Sticky_topic'] . '" border="0" /></a>&nbsp;' : "";
    $announce_button = ( $is_auth['auth_announce'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=announce&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder_announce'] . '" alt="' . $lang['Announce_topic'] . '" title="' . $lang['Announce_topic'] . '" border="0" /></a>&nbsp;' : "";
    $commend_button = ( $is_auth['auth_commend'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=commend&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder_commend'] . '" alt="' . $lang['Commend_topic'] . '" title="' . $lang['Commend_topic'] . '" border="0" /></a>&nbsp;' : "";
	switch( $forum_topic_data['topic_type'] )
    {
        case POST_NORMAL: 
            $topic_mod .= $sticky_button . $announce_button . $commend_button;
            break;
        case POST_STICKY:
            $topic_mod .= $announce_button . $commend_button . $normal_button;
            break;
        case POST_ANNOUNCE:
            $topic_mod .= $sticky_button . $commend_button . $normal_button;
            break;
        case POST_COMMEND:
            $topic_mod .= $sticky_button . $announce_button . $normal_button;
            break;
    }
}

//
// Topic watch information
//
$s_watching_topic = '';
if ( $can_watch_topic )
{
	if ( $is_watching_topic )
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Stop_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['topic_un_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_un_watch'] . '" alt="' . $lang['Stop_watching_topic'] . '" title="' . $lang['Stop_watching_topic'] . '" border="0"></a>' : '';
	}
	else
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Start_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['Topic_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['Topic_watch'] . '" alt="' . $lang['Start_watching_topic'] . '" title="' . $lang['Start_watching_topic'] . '" border="0"></a>' : '';
	}
}

//
// If we've got a hightlight set pass it on to pagination,
// I get annoyed when I lose my highlight after the first page.
//
$pagination = ( $highlight != '' ) ? generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight", $total_replies, $board_config['posts_per_page'], $start) : generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order", $total_replies, $board_config['posts_per_page'], $start);

//
// Send vars to template
//
$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_PATH' => $forum_path,
	'FORUM_NAME' => $forum_name,
	'FORUM_ICON' => $forum_icon,
	'TOPIC_ID' => $topic_id,
	'TOPIC_TITLE' => $topic_title,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval($board_config['posts_per_page']) ) + 1 ), ceil( $total_replies / intval($board_config['posts_per_page']) )),

	'POST_IMG' => $post_img,
	'REPLY_IMG' => $reply_img,

	'L_AUTHOR' => $lang['Author'],
	'L_MESSAGE' => $lang['Message'],
	'L_POSTED' => $lang['Posted'],
	'L_POST_SUBJECT' => $lang['Post_subject'],
	'L_VIEW_NEXT_TOPIC' => $lang['View_next_topic'],
	'L_VIEW_PREVIOUS_TOPIC' => $lang['View_previous_topic'],
	'L_POST_NEW_TOPIC' => $post_alt,
	'L_POST_REPLY_TOPIC' => $reply_alt,
	'L_BACK_TO_TOP' => $lang['Back_to_top'],
	'L_DISPLAY_POSTS' => $lang['Display_posts'],
	'L_LOCK_TOPIC' => $lang['Lock_topic'],
	'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
	'L_MOVE_TOPIC' => $lang['Move_topic'],
	'L_SPLIT_TOPIC' => $lang['Split_topic'],
	'L_DELETE_TOPIC' => $lang['Delete_topic'],
	'L_GOTO_PAGE' => $lang['Goto_page'],
	// Topic Search MOD
	'L_SEARCH_TOPIC' => $lang['Search_topic'],
	// End Topic Search MOD

	'S_TOPIC_LINK' => POST_TOPIC_URL,
	'S_SELECT_POST_DAYS' => $select_post_days,
	'S_SELECT_POST_ORDER' => $select_post_order,
	'S_POST_DAYS_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id . "&amp;start=$start"),
	'S_AUTH_LIST' => $s_auth_can,
	'S_TOPIC_ADMIN' => $topic_mod,
	'S_WATCH_TOPIC' => $s_watching_topic,
	'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,

	'U_FAV' => append_sid("favorites.$phpEx?t=" . $topic_id . "&mode=add"),
	'L_FAV' => $lang['add_fav'],'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight"),
	
	'U_VIEW_FORUM' => $view_forum_url,
	'U_VIEW_OLDER_TOPIC' => $view_prev_topic_url,
	'U_VIEW_NEWER_TOPIC' => $view_next_topic_url,
	'U_POST_NEW_TOPIC' => $new_topic_url,
	// Topic Search MOD
	'U_TOPIC_SEARCH' => append_sid('search.' . $phpEx . '?mode=results'),
	// End Topic Search MOD
	'U_POST_REPLY_TOPIC' => $reply_topic_url)
);

//
// Does this topic contain a poll?
//
if ( !empty($forum_topic_data['topic_vote']) )
{
	$s_hidden_fields = '';

	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vd.vote_max, vd.vote_voted, vd.vote_hide, vd.vote_tothide, vr.vote_option_id, vr.vote_option_text, vr.vote_result
		FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
		WHERE vd.topic_id = $topic_id
			AND vr.vote_id = vd.vote_id
		ORDER BY vr.vote_option_id ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain vote data for this topic", '', __LINE__, __FILE__, $sql);
	}

	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options = count($vote_info);

		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];
		$max_vote = $vote_info[0]['vote_max'];
		$voted_vote = $vote_info[0]['vote_voted'];
		$hide_vote = $vote_info[0]['vote_hide'];
		$tothide_vote = $vote_info[0]['vote_tothide'];

		$sql = "SELECT vote_id
			FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id = $vote_id
				AND vote_user_id = " . intval($userdata['user_id']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);

		if ( isset($HTTP_GET_VARS['vote']) || isset($HTTP_POST_VARS['vote']) )
		{
			$view_result = ( ( ( isset($HTTP_GET_VARS['vote']) ) ? $HTTP_GET_VARS['vote'] : $HTTP_POST_VARS['vote'] ) == 'viewresult' ) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}

		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;

		if ( $user_voted || $view_result || $poll_expired || !$is_auth['auth_vote'] || $forum_topic_data['topic_status'] == TOPIC_LOCKED )
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_result.tpl')
			);

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}

			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
				$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);

				$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
				$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;

				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$hide_vote_bl = '';
				$hide_vote_zr = '0';
				$total_votes_1 = $lang['Total_votes'] ;
				$total_votes_2 = $vote_results_sum ;
				if ( ( $poll_expired == 0 ) && ( $hide_vote == 1 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
				{
					if ( $tothide_vote == 1 )
					{
						$total_votes_1 = '' ;
						$total_votes_2 = '' ;
					}
					$poll_expires_c = $lang['Results_after'];
					$template->assign_block_vars("poll_option", array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => $hide_vote_bl,
						'POLL_OPTION_PERCENT' => $hide_vote_bl,
						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => $hide_vote_zr)
					);
				}
				else
				{
					$poll_expires_c = '';
					$template->assign_block_vars("poll_option", array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => $vote_info[$i]['vote_result'],
						'POLL_OPTION_PERCENT' => sprintf("%.1d%%", ($vote_percent * 100)),

						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
					);
				}
			}

			if ( ( $poll_expired == 0 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
			{
				$poll_expire_1 = (( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] ) - time() );
				$poll_expire_2 = intval($poll_expire_1/86400);
				$poll_expire_a = $poll_expire_2*86400;
				$poll_expire_3 = intval(($poll_expire_1 - ($poll_expire_a))/3600);
				$poll_expire_b = $poll_expire_3*3600;
				$poll_expire_4 = intval((($poll_expire_1 - ($poll_expire_a) - ($poll_expire_b)))/60);
				$poll_comma = ', ';
				$poll_space = ' ';
				$poll_expire_2 == '0' ? $poll_expire_6='' : ( ( $poll_expire_3 == 0 && $poll_expire_4 == 0 ) ? $poll_expire_6=$poll_expire_2.$poll_space.$lang['Days'] : $poll_expire_6=$poll_expire_2.$poll_space.$lang['Days'].$poll_comma ) ;
				$poll_expire_3 == '0' ? $poll_expire_7='' : ( $poll_expire_4 == 0 ? $poll_expire_7=$poll_expire_3.$poll_space.$lang['Hours'] : $poll_expire_7=$poll_expire_3.$poll_space.$lang['Hours'].$poll_comma ) ;
				$poll_expire_4 == '0' ? $poll_expire_8='' : $poll_expire_8=$poll_expire_4.$poll_space.$lang['Minutes'] ;
				$poll_expires_d = $lang['Poll_expires'];
			}
			else if ($poll_expired == 1)
			{
				$poll_expires_6 = '';
				$poll_expires_7 = '';
				$poll_expires_8 = '';
				$poll_expires_d = $lang['Poll_expiredyes'];
			}
			else
			{
				$poll_expires_6 = '';
				$poll_expires_7 = '';
				$poll_expires_8 = '';
				$poll_expires_d = $lang['Poll_noexpire'];
			}
			$voted_vote_nb = $voted_vote;
			$template->assign_vars(array(
				'VOTED_SHOW' => $lang['Voted_show'],
				'L_TOTAL_VOTES' => $total_votes_1,
				'L_RESULTS_AFTER' => $poll_expires_c,
				'L_POLL_EXPIRES' => $poll_expires_d,
				'POLL_EXPIRES' => ($poll_expire_6.$poll_expire_7.$poll_expire_8),
				'TOTAL_VOTES' => $total_votes_2)
			);

		}
		else
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_ballot.tpl')
			);
			if ( $max_vote > 1 )
			{
				$vote_box = 'checkbox';
			}
			else 	$vote_box = 'radio';

			for($i = 0; $i < $vote_options; $i++)
			{
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars("poll_option", array(
					'POLL_VOTE_BOX' => $vote_box,
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'])
				);
			}

			$template->assign_vars(array(
				'L_SUBMIT_VOTE' => $lang['Submit_vote'],
				'L_VIEW_RESULTS' => $lang['View_results'],

				'U_VIEW_RESULTS' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;vote=viewresult"))
			);

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
			if ( $max_vote > 1 )
			{
				$vote_br = '<br/>';
				$max_vote_nb = $max_vote;
			}
			else
			{
				$vote_br = '';
				$lang['Max_voting_1_explain'] = '';
				$lang['Max_voting_2_explain'] = '';
				$lang['Max_voting_3_explain'] = '';
				$max_vote_nb = '';
			}
		}

		if ( count($orig_word) )
		{
			$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'POLL_QUESTION' => $vote_title,
			'POLL_VOTE_BR' => $vote_br,
			'MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
			'MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
			'MAX_VOTING_3_EXPLAIN' => $lang['Max_voting_3_explain'],
			'max_vote' => $max_vote_nb,
			'voted_vote' => $voted_vote_nb,

			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_POLL_ACTION' => append_sid("posting.$phpEx?mode=vote&amp;" . POST_TOPIC_URL . "=$topic_id"))
		);

		$template->assign_var_from_handle('POLL_DISPLAY', 'pollbox');
	}
}
init_display_post_attachments($forum_topic_data['topic_attachment']);
//
// Update the topic view counter
//
$sql = "UPDATE " . TOPICS_TABLE . "
	SET topic_views = topic_views + 1
	WHERE topic_id = $topic_id";
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}

//
// SQR
//
$sqr_last_page = ((floor( $start / intval($board_config['posts_per_page']) ) + 1 ) == ceil( $total_replies / intval($board_config['posts_per_page'])));
if ( $userdata['user_id'] != ANONYMOUS )
{
	$sqr_user_display = (bool)( ($userdata['user_show_quickreply']==2) ? $sqr_last_page : $userdata['user_show_quickreply'] );
}
else
{
	$sqr_user_display = (bool)( ($board_config['anonymous_show_sqr']==2) ? $sqr_last_page : $board_config['anonymous_show_sqr'] );
}

if ( ($board_config['allow_quickreply'] != 0) && $is_auth['auth_reply'] && $sqr_user_display )
{
	$show_qr_form =	true;
}
else
{
	$show_qr_form =	false;
}
//
// Okay, let's do the loop, yeah come on baby let's do the loop
// and it goes like this ...
//
// Start add - Birthday MOD
$this_year = create_date('Y', time(), $board_config['board_timezone']);
$this_date = create_date('md', time(), $board_config['board_timezone']);
// End add - Birthday MOD
for($i = 0; $i < $total_posts; $i++)
{
	$poster_id = $postrow[$i]['user_id'];
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
	// Start add - Birthday MOD
	if ( $postrow[$i]['user_birthday'] != 999999 ) 
	{
		$poster_birthdate=realdate('md', $postrow[$i]['user_birthday']);
		$poster_age = $this_year - realdate ('Y',$postrow[$i]['user_birthday']);
		if ($this_date < $poster_birthdate) $poster_age--;
		$poster_age = $lang['Age'] . ': ' . $poster_age;
	} else
	{
		$poster_age = '';
	}
// End add - Birthday MOD

	$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

	$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';

	$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';

	$poster_joined = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';

	$poster_avatar = '';
	if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )
	{
		switch( $postrow[$i]['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}

	//
	// Define the little post icon
	//
	if ( $userdata['session_logged_in'] && $postrow[$i]['post_time'] > $userdata['user_lastvisit'] && $postrow[$i]['post_time'] > $topic_last_read )
	{
		$mini_post_img = $images['icon_minipost_new'];
		$mini_post_alt = $lang['New_post'];
	}
	else
	{
		$mini_post_img = $images['icon_minipost'];
		$mini_post_alt = $lang['Post'];
	}

	$mini_post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['post_id']) . '#' . $postrow[$i]['post_id'];

	//
	// Generate ranks, set them to empty string initially.
	//
	$poster_rank = '';
	$rank_image = '';
	$gender_image = '';
	if ( $postrow[$i]['user_id'] == ANONYMOUS )
	{
	}
	else if ( $postrow[$i]['user_rank'] )
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
	else
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}

	//
	// Handle anon users posting with usernames
	//
	if ( $poster_id == ANONYMOUS && $postrow[$i]['post_username'] != '' )
	{
		$poster = $postrow[$i]['post_username'];
		$poster_rank = $lang['Guest'];
		
		// Start add - Birthday MOD
		$poster_age = '';
// End add - Birthday MOD
	}

	$temp_url = '';

	if ( $poster_id != ANONYMOUS )
	{
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		switch ($postrow[$i]['user_gender'])
		{ 
			case 1 : $gender_image = $lang['Gender'].": <img src=\"" . $images['icon_minigender_male'] . "\" alt=\"" . $lang['Gender'].  ":".$lang['Male']."\" title=\"" . $lang['Gender'] . ":".$lang['Male']. "\" border=\"0\" />"; break; 
			case 2 : $gender_image = $lang['Gender'].": <img src=\"" . $images['icon_minigender_female'] . "\" alt=\"" . $lang['Gender']. ":".$lang['Female']. "\" title=\"" . $lang['Gender'] . ":".$lang['Female']. "\" border=\"0\" />"; break; 
			default : $gender_image=""; 
		}
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '';
			$email = '';
		}

		$www_img = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($postrow[$i]['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
			$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

        $aim_img = ( $postrow[$i]['user_aim'] ) ? '<a href="http://friend.qq.com/cgi-bin/friend/user_show_info?ln=' . $postrow[$i]['user_aim'] . '" target="_blank"><img src="' . $php_install_url . $images['icon_aim'] . '" alt="' . $lang['AIM'] . $postrow[$i]['user_aim'] . '" title="' . $lang['AIM'] . $postrow[$i]['user_aim'] . '" border="0" /></a>' : '';
        $aim = ( $postrow[$i]['user_aim'] ) ? '<a href="http://friend.qq.com/cgi-bin/friend/user_show_info?ln=' . $postrow[$i]['user_aim'] . '" target="_blank">' . $lang['AIM']. '</a>' : '';

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
		$skype_img = ( $postrow[$i]['user_skype'] ) ? '<a href="callto://' . $postrow[$i]['user_skype'] . '/"><img src="' . $images['icon_skype'] . '" alt="' . $lang['SKYPE'] . '" title="' . $lang['SKYPE'] . '" border="0" /></a>' : '';
		$skype = ( $postrow[$i]['user_skype'] ) ? '<a href="callto://' . $postrow[$i]['user_skype'] . '/">' . $lang['SKYPE'] . '</a>' : '';
		$skype_status=( $postrow[$i]['user_skype'] ) ?'Skype ״̬:<img src="http://mystatus.skype.com/smallicon/'.$postrow[$i]['user_skype'].'">':'';
		$skype_func= ( $postrow[$i]['user_skype'] ) ? '<div id="skypeTransparentDrp"><div id="skypeDropdown-transparent-head"><a id="skypeTransparentDrp-Call" onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?call"><img id="skypeTransparentDrpCall-'.$postrow[$i]['post_id'].'" alt="" src="skype_func/call.gif"/></a><a id="skypeTransparentDrp-Switch" onclick="return false;" href="#"><img id="skypeTransparentDrpArrow-'.$postrow[$i]['post_id'].'" onmouseover="tail='.$postrow[$i]['post_id'].';skypeTransparentDrpDown()" onmouseout="skypeTransparentDrpUp();" alt="" src="skype_func/down.gif"/></a></div><div id="skypeDropdown-transparent-'.$postrow[$i]['post_id'].'" style="DISPLAY: none"><a onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?chat"><img id="SkpTranspBtn-2-'.$postrow[$i]['post_id'].'" onmouseover="skpBtnOvr(this)" onmouseout="skpBtnOut(this)" alt="" src="skype_func/2.gif"/></a><a onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?add"><img id="SkpTranspBtn-3-'.$postrow[$i]['post_id'].'" onmouseover="skpBtnOvr(this)" onmouseout="skpBtnOut(this)" alt="" src="skype_func/3.gif"/></a><a onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?voicemail"><img id="SkpTranspBtn-4-'.$postrow[$i]['post_id'].'" onmouseover="skpBtnOvr(this)" onmouseout="skpBtnOut(this)" alt="" src="skype_func/4.gif"/></a><a onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?userinfo"><img id="SkpTranspBtn-5-'.$postrow[$i]['post_id'].'" onmouseover="skpBtnOvr(this)" onmouseout="skpBtnOut(this)" alt="" src="skype_func/5.gif"/></a><a onclick="return skypeCheck();" href="skype:'.$postrow[$i]['user_skype'].'?sendfile"><img id="SkpTranspBtn-6-'.$postrow[$i]['post_id'].'" onmouseover="skpBtnOvr(this)" onmouseout="skpBtnOut(this)" alt="" src="skype_func/6.gif"/></a></div></div>' : '';
		if ( $postrow[$i]['user_session_time'] >= (time()-60) )
		{
			if ( $postrow[$i]['user_allow_viewonline'] )
			{
				$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_online'] . '" alt="' . sprintf($lang['is_online'], $poster) . '" title="' . sprintf($lang['is_online'], $poster) . '" /></a>&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <strong><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_online'], $poster) . '"' . $online_color . '>' . $lang['Online'] . '</a></strong>';
			}
			else if ( $is_auth['auth_mod'] || $userdata['user_id'] == $poster_id )
			{
				$online_status_img = '<a href="' . append_sid("viewonline.$phpEx") . '"><img src="' . $images['icon_hidden'] . '" alt="' . sprintf($lang['is_hidden'], $poster) . '" title="' . sprintf($lang['is_hidden'], $poster) . '" /></a>&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <strong><em><a href="' . append_sid("viewonline.$phpEx") . '" title="' . sprintf($lang['is_hidden'], $poster) . '"' . $hidden_color . '>' . $lang['Hidden'] . '</a></em></strong>';
			}
			else
			{
				$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $poster) . '" title="' . sprintf($lang['is_offline'], $poster) . '" />&nbsp;';
				$online_status = '<br />' . $lang['Online_status'] . ': <span title="' . sprintf($lang['is_offline'], $poster) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
			}
		}
		else
		{
			$online_status_img = '<img src="' . $images['icon_offline'] . '" alt="' . sprintf($lang['is_offline'], $poster) . '" title="' . sprintf($lang['is_offline'], $poster) . '" />&nbsp;';
			$online_status = '<br />' . $lang['Online_status'] . ': <span title="' . sprintf($lang['is_offline'], $poster) . '"' . $offline_color . '><strong>' . $lang['Offline'] . '</strong></span>';
		}
	}
	else
	{
		$profile_img = '';
		$profile = '';
		$pm_img = '';
		$pm = '';
		$email_img = '';
		$email = '';
		$www_img = '';
		$www = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$aim_img = '';
		$aim = '';
		$msn_img = '';
		$msn = '';
		$yim_img = '';
		$yim = '';
		$skype_img = '';
		$skype = '';
		$skype_func='';
		$online_status_img = '';
		$online_status = '';
	}

	$temp_url = append_sid("posting.$phpEx?mode=quote&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
	$quote_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_quote'] . '" alt="' . $lang['Reply_with_quote'] . '" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>';
	$quote = '<a href="' . $temp_url . '">' . $lang['Reply_with_quote'] . '</a>';

	$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts");
	$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" title="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" border="0" /></a>';
	$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '</a>';

	if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )
	{
		$temp_url = append_sid("posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
		$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
		$edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
	}
	else
	{
		$edit_img = '';
		$edit = '';
	}

	if ( $is_auth['auth_mod'] )
	{
		$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
		$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

		$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
		$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
		$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
	}
	else
	{
		$ip_img = '';
		$ip = '';

		if ( $userdata['user_id'] == $poster_id && $is_auth['auth_delete'] && $forum_topic_data['topic_last_post_id'] == $postrow[$i]['post_id'] )
		{
			$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
			$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
			$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		}
		else
		{
			$delpost_img = '';
			$delpost = '';
		}
	}
if($poster_id != ANONYMOUS && $postrow[$i]['user_level'] != ADMIN) 
{ 
	$current_user = str_replace("'","\'",$postrow[$i]['username']);
	if ($is_auth['auth_greencard']) 
	{ 
	      $g_card_img = ' <input type="image" name="unban" value="unban" onClick="return confirm(\''.sprintf($lang['Green_card_warning'],$current_user).'\')" src="'. $images['icon_g_card'] . '" alt="' . $lang['Give_G_card'] . '" >'; 
	} 
	else 
	{
		$g_card_img = ''; 
	}
	$user_warnings = $postrow[$i]['user_warnings'];
	$card_img = ($user_warnings) ? (( $user_warnings < $board_config['max_user_bancard']) ? sprintf($lang['Warnings'], $user_warnings) : $lang['Banned'] ) : '';
// these lines will make a icon apear beside users post, if user have warnings or ar banned
// used instead of the previous line of code, witch shows the status as a text
//  ------ From here --- do not include this line
// $card_img = ($user_warnings) ? '<img src="'.(( $user_warnings < $board_config['max_user_bancard']) ? 
//		$images['icon_y_card'] . '" alt="'. sprintf($lang['Warnings'], $user_warnings) .'">' : 
//		$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">') : '';
//  ----- To this line --- Do not included this line
// 
// You may also included several images, instead of only one yellow, these lines below will produce several yellow images, depending on mumber of yellow cards
//  ------ From here --- do not include this line
//$card_img = ($user_warnings >= $board_config['max_user_bancard'])  ? '<img src="'.$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">' : '';
//for ($n=0 ; $n<$user_warnings && $user_warnings < $board_config['max_user_bancard'];$n++)
//{
//$card_img .= ($user_warnings) ? '<img src="'.(( $user_warnings < $board_config['max_user_bancard']) ? 
//$images['icon_y_card'] . '" alt="'. sprintf($lang['Warnings'], $user_warnings) .'">' : 
//$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">') : '';
//}
//  ----- To this line --- Do not included this line

	if ($user_warnings<$board_config['max_user_bancard'] && $is_auth['auth_ban'] )
	{ 
		$y_card_img = ' <input type="image" name="warn" value="warn" onClick="return confirm(\''.sprintf($lang['Yellow_card_warning'],$current_user).'\')" src="'. $images['icon_y_card'] . '" alt="' . sprintf($lang['Give_Y_card'],$user_warnings+1) . '" >'; 
     		$r_card_img = ' <input type="image" name="ban" value="ban"  onClick="return confirm(\''.sprintf($lang['Red_card_warning'],$current_user).'\')" src="'. $images['icon_r_card'] . '" alt="' . $lang['Give_R_card'] . '" >'; 
	}
	else
	{
		$y_card_img = '';
		$r_card_img = ''; 
	} 
} else
{
	$card_img = '';
	$g_card_img = '';
	$y_card_img = '';
	$r_card_img = '';
}

	if ($is_auth['auth_bluecard']) 
	{ 
		if ($is_auth['auth_mod']) 
		{ 
			$b_card_img = (($postrow[$i]['post_bluecard'])) ? ' <input type="image" name="report_reset" value="report_reset" onClick="return confirm(\''.$lang['Clear_blue_card_warning'].'\')" src="'. $images['icon_bhot_card'] . '" alt="'. sprintf($lang['Clear_b_card'],$postrow[$i]['post_bluecard']) . '">':' <input type="image" name="report" value="report" onClick="return confirm(\''.$lang['Blue_card_warning'].'\')" src="'. $images['icon_b_card'] . '" alt="'. $lang['Give_b_card'] . '" >'; 
		} 
   		else 
		{ 
			$b_card_img = ' <input type="image" name="report" value="report" onClick="return confirm(\''.$lang['Blue_card_warning'].'\')" src="'. $images['icon_b_card'] . '" alt="'. $lang['Give_b_card'] . '" >';
			
   		}
	} else $b_card_img = '';

// parse hidden filds if cards visible
$card_hidden = ($g_card_img || $r_card_img || $y_card_img || $b_card_img) ? '<input type="hidden" name="post_id" value="'. $postrow[$i]['post_id'].'">' :'';




	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';

	$message = strip_hidden_contents($postrow[$i], $hiding_info);
	$bbcode_uid = $postrow[$i]['bbcode_uid'];

	$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig'] ) ? $postrow[$i]['user_sig'] : '';
	$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];

	//
	// Note! The order used for parsing the message _is_ important, moving things around could break any
	// output
	//

	//
	// If the board has HTML off but the post has HTML
	// on then we process it, else leave it alone
	//
	if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
	{
		if ( $user_sig != '' )
		{
			$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
		}

		if ( $postrow[$i]['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}
	}

	//
	// Parse message and/or sig for BBCode if reqd
	//
	if ($user_sig != '' && $user_sig_bbcode_uid != '')
	{
			$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
	}

	if ($bbcode_uid != '')
	{
		$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
	}

	if ( $user_sig != '' )
	{
		$user_sig = make_clickable($user_sig);
	}
	$message = make_clickable($message);

	//
	// Parse smilies
	//
	if ( $board_config['allow_smilies'] )
	{
		if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
		{
			$user_sig = smilies_pass($user_sig);
		}

		if ( $postrow[$i]['enable_smilies'] )
		{
			$message = smilies_pass($message);
		}
	}

	//
	// Highlight active words (primarily for search)
	//
	if ($highlight_match)
	{
		// This was shamelessly 'borrowed' from volker at multiartstudio dot de
		// via php.net's annotated manual
		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . str_replace('\\', '\\\\', addslashes($highlight_match)) . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1));
	}

	//
	// Replace naughty words
	//
	if (count($orig_word))
	{
		$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);

		if ($user_sig != '')
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
		}

		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
	}

	//
	// Replace newlines (we use this rather than nl2br because
	// till recently it wasn't XHTML compliant)
	//
	if ( $user_sig != '' )
	{
		$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
	}

	$message = str_replace("\n", "\n<br />\n", $message);

	//
	// Editing information
	//
	if ( $postrow[$i]['post_edit_count'] )
	{
		$l_edit_time_total = ( $postrow[$i]['post_edit_count'] == 1 ) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];

		$l_edited_by = '<br /><br />' . sprintf($l_edit_time_total, $poster, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
	}
	else
	{
		$l_edited_by = '';
	}

	//
	// SQR
	// If you have installed "User Profile MOD" - do not add this lines or remove "User Profile MOD"
	//
	if ( $show_qr_form )
	{
		$poster = '<a href="javascript:pn(\''.$poster.'\');">'.$poster.'</a>';
	}

	//
	// Again this will be handled by the templating
	// code at some point
	//
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	$hiding_info_box = get_hiding_info_box($hiding_info);
	$template->assign_block_vars('postrow', array(
		'ROW_COLOR' => '#' . $row_color,
		'ROW_CLASS' => $row_class,
		'POSTER_NAME' => $poster,	
		'POSTER_AGE' => $poster_age,
		'POSTER_RANK' => $poster_rank,
		'POSTER_GENDER' => $gender_image,
		'RANK_IMAGE' => $rank_image,
		'POSTER_JOINED' => $poster_joined,
		'POSTER_POSTS' => $poster_posts,
		'POSTER_FROM' => $poster_from,
		'POSTER_AVATAR' => $poster_avatar,
		'POSTER_ONLINE_STATUS_IMG' => $online_status_img,
		'POSTER_ONLINE_STATUS' => $online_status,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'MESSAGE' => $message,
		'SIGNATURE' => $user_sig,
		'EDITED_MESSAGE' => $l_edited_by,

		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img,
		'PROFILE' => $profile,
		'SEARCH_IMG' => $search_img,
		'SEARCH' => $search,
		'PM_IMG' => $pm_img,
		'PM' => $pm,
		'EMAIL_IMG' => $email_img,
		'EMAIL' => $email,
		'WWW_IMG' => $www_img,
		'WWW' => $www,
		'ICQ_STATUS_IMG' => $icq_status_img,
		'ICQ_IMG' => $icq_img,
		'ICQ' => $icq,
		'AIM_IMG' => $aim_img,
		'AIM' => $aim,
		'MSN_IMG' => $msn_img,
		'MSN' => $msn,
		'YIM_IMG' => $yim_img,
		'YIM' => $yim,
		'SKYPE_IMG' => $skype_img,
		'SKYPE' => $skype,
		'SKYPE_STATUS'=>$skype_status,
		'SKYPE_FUNC'=>$skype_func,
		'EDIT_IMG' => $edit_img,
		'EDIT' => $edit,
		'QUOTE_IMG' => $quote_img,
		'QUOTE' => $quote,
		'IP_IMG' => $ip_img,
		'IP' => $ip,
		'DELETE_IMG' => $delpost_img,
		'DELETE' => $delpost,
		'L_GENDER' => $lang['Gender'],
		'USER_WARNINGS' => $user_warnings,
        'CARD_IMG' => $card_img,
        'CARD_HIDDEN_FIELDS' => $card_hidden,
        'CARD_EXTRA_SPACE' => ($r_card_img || $y_card_img || $g_card_img || $b_card_img) ? ' ' : '',



		'L_MINI_POST_ALT' => $mini_post_alt,

		'U_MINI_POST' => $mini_post_url,
		'U_G_CARD' => $g_card_img, 
        'U_Y_CARD' => $y_card_img, 
        'U_R_CARD' => $r_card_img, 
        'U_B_CARD' => $b_card_img,
        'S_CARD' => append_sid("card.".$phpEx),
		'HIDING_INFO_BOX' => $hiding_info_box,
		'U_POST_ID' => $postrow[$i]['post_id'])
	);
	if ( $hiding_info['show_attachment'] )
	display_post_attachments($postrow[$i]['post_id'], $postrow[$i]['post_attachment']);
	$cm_viewtopic->post_vars($postrow[$i],$userdata,$forum_id
	);
}

if ( $show_qr_form )
{
	$template->assign_block_vars('switch_quick_reply', array());
	include($phpbb_root_path . 'includes/viewtopic_quickreply.'.$phpEx);
}
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
