<?php
/***************************************************************************
 *                                index.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: index.php,v 1.99.2.3 2004/07/11 16:46:15 acydburn Exp $
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
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main_link.' . $phpEx);

//
// End session management
//

$viewcat = ( !empty($HTTP_GET_VARS[POST_CAT_URL]) ) ? $HTTP_GET_VARS[POST_CAT_URL] : -1;

if( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = ( isset($HTTP_POST_VARS['mark']) ) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}

//
// Handle marking posts
//
if( $mark_read == 'forums' )
{
	if( $userdata['session_logged_in'] )
	{
		setcookie($board_config['cookie_name'] . '_f_all', time(), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}

	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="3;url='  .append_sid("index.$phpEx") . '">')
	);

	$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');

	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_t"]) : array();
$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_f"]) : array();

//
// If you don't use these stats on your index you may want to consider
// removing them
//
$total_posts = get_db_stat('postcount');
$total_users = get_db_stat('usercount');
$newest_userdata = get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}


//
// Start page proper
//
$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
	FROM " . CATEGORIES_TABLE . " c 
	".(($userdata['user_level']!=ADMIN)? "WHERE c.cat_id<>'".HIDDEN_CAT."'" :"" )."
	ORDER BY c.cat_order";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
}

$category_rows = array();
while( $category_rows[] = $db->sql_fetchrow($result) );
$db->sql_freeresult($result);

if( ( $total_categories = count($category_rows) ) )
{
	//
	// Define appropriate SQL
	//
	switch(SQL_LAYER)
	{
		case 'postgresql':
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id 
				FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
				WHERE p.post_id = f.forum_last_post_id 
					AND u.user_id = p.poster_id  
					UNION (
						SELECT f.*, NULL, NULL, NULL, NULL
						FROM " . FORUMS_TABLE . " f
						WHERE NOT EXISTS (
							SELECT p.post_time
							FROM " . POSTS_TABLE . " p
							WHERE p.post_id = f.forum_last_post_id  
						)
					)
					ORDER BY cat_id, forum_order";
			break;

		case 'oracle':
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id 
				FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
				WHERE p.post_id = f.forum_last_post_id(+)
					AND u.user_id = p.poster_id(+)
				ORDER BY f.cat_id, f.forum_order";
			break;

		default: 
         $sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id,substring(pt.topic_title,1,18) as topic_title 
		 	FROM ((( " . FORUMS_TABLE . " f
				LEFT JOIN " . POSTS_TABLE . " p ON p.post_id = f.forum_last_post_id )
				LEFT JOIN " . USERS_TABLE . " u ON u.user_id = p.poster_id )
				LEFT JOIN " . TOPICS_TABLE . " pt ON pt.topic_id  = p.topic_id  )
				ORDER BY f.cat_id, f.forum_order";
			break;
	}
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$forum_data = array();
	$forum_sub = array();
	$forum_sub2 = array();
	$forum_main = array();
	$temp_forum_id=0;
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_data[] = $row;

		if($row[forum_sub]>0) 
		{
			if ( $row['forum_status'] == FORUM_LOCKED ) 
			{
				$forum_sub[$row['forum_sub']][$row['forum_id']] = '<a href='.append_sid('viewforum.'.$phpEx.'?' . POST_FORUM_URL .'='.$row['forum_id']).' class="forumlink">'. $row['forum_name'] . ' </a><img src="images/icon_minipost_lock.gif" alt="'.$lang['Forum_locked'].'" border="0">';
			}
			else
			{
				$forum_sub[$row['forum_sub']][$row['forum_id']]='<a href='.append_sid('viewforum.'.$phpEx.'?' . POST_FORUM_URL .'='.$row['forum_id']).' class="forumlink">'. $row['forum_name'] . ' </a>'; 
			} 
			$forum_sub2[$row['forum_sub']][]=$row[forum_id]; 
		} 
		if($row['main_sub']==0) 
		{ 
			$row['main_sub']=$row['forum_id']; 
		} 
		$forum_main[$row['main_sub']]['forum_posts']=$forum_main[$row['main_sub']]['forum_posts']+$row['forum_posts']; 
		$forum_main[$row['main_sub']]['forum_topics']=$forum_main[$row['main_sub']]['forum_topics']+$row['forum_topics']; 
		if($forum_main[$row['main_sub']]['post_time'] < $row['post_time']) 
		{ 
			$forum_main[$row['main_sub']]['post_time']=$row['post_time']; 
			$forum_main[$row['main_sub']]['post_username']=$row['post_username']; 
			$forum_main[$row['main_sub']]['username']=$row['username']; 
			$forum_main[$row['main_sub']]['user_id']=$row['user_id']; 
			$forum_main[$row['main_sub']]['topic_title']=$row['topic_title']; 
			$forum_main[$row['main_sub']]['forum_last_post_id']=$row['forum_last_post_id']; 
		} 
	}
	$db->sql_freeresult($result);

	if ( !($total_forums = count($forum_data)) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}

	//
	// Obtain a list of topic ids which contain
	// posts made since user last visited
	//
	if ( $userdata['session_logged_in'] )
	{
		// 60 days limit
		if ($userdata['user_lastvisit'] < (time() - 5184000))
		{
			$userdata['user_lastvisit'] = time() - 5184000;
		}

		$sql = "SELECT t.forum_id, t.topic_id, p.post_time 
			FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p 
			WHERE p.post_id = t.topic_last_post_id 
				AND p.post_time > " . $userdata['user_lastvisit'] . " 
				AND t.topic_moved_id = 0"; 
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
		}

		$new_topic_data = array();
		while( $topic_data = $db->sql_fetchrow($result) )
		{
			$new_topic_data[$topic_data['forum_id']][$topic_data['topic_id']] = $topic_data['post_time'];
		}
		$db->sql_freeresult($result);
	}

	//
	// Obtain list of moderators of each forum
	// First users, then groups ... broken into two queries
	//
	$sql = "SELECT aa.forum_id, u.user_id, u.username 
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 1 
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
			AND u.user_id = ug.user_id 
		GROUP BY u.user_id, u.username, aa.forum_id 
		ORDER BY aa.forum_id, u.user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	$forum_moderators = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
	}
	$db->sql_freeresult($result);

	$sql = "SELECT aa.forum_id, g.group_id, g.group_name 
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 0 
			AND g.group_type <> " . GROUP_HIDDEN . "
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
		GROUP BY g.group_id, g.group_name, aa.forum_id 
		ORDER BY aa.forum_id, g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
	}
	$db->sql_freeresult($result);

	//
	// Find which forums are visible for this user
	//
	$is_auth_ary = array();
	$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data);

	$sql = "SELECT *
		FROM ". LINK_CONFIG_TABLE;
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query Link config information", "", __LINE__, __FILE__, $sql);
	}
	
	while( $row = $db->sql_fetchrow($result) )
	{
		$link_config_name = $row['config_name'];
		$link_config_value = $row['config_value'];
		$link_config[$link_config_name] = $link_config_value;
		$link_self_img = $link_config['site_logo'];
		$site_logo_height = $link_config['height'];
		$site_logo_width = $link_config['width'];
	}
	
	// Birthday Mod, Show users with birthday 
	$sql = ($board_config['birthday_check_day']) ? "SELECT user_id, username, user_birthday,user_level FROM " . USERS_TABLE. " WHERE user_birthday!=999999 ORDER BY username" :"";
	if($result = $db->sql_query($sql)) 
	{ 
		if (!empty($result)) 
		{ 
			$time_now = time();
			$this_year = create_date('Y', $time_now, $board_config['board_timezone']);
			$date_today = create_date('Ymd', $time_now, $board_config['board_timezone']);
			$date_forward = create_date('Ymd', $time_now+($board_config['birthday_check_day']*86400), $board_config['board_timezone']);
		    while ($birthdayrow = $db->sql_fetchrow($result))
			{ 
		    	$user_birthday2 = $this_year.($user_birthday = realdate("md",$birthdayrow['user_birthday'] )); 
	      		if ( $user_birthday2 < $date_today ) $user_birthday2 += 10000;
				if ( $user_birthday2 > $date_today  && $user_birthday2 <= $date_forward ) 
				{ 
					// user are having birthday within the next days
					$user_age = ( $this_year.$user_birthday < $date_today ) ? $this_year - realdate ('Y',$birthdayrow['user_birthday'])+1 : $this_year- realdate ('Y',$birthdayrow['user_birthday']); 
					switch ($birthdayrow['user_level'])
					{
						case ADMIN :
		      				$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
	      					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
							break;
						case MOD :
		      				$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
	      					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
							break;
						default: $style_color = '';
					}
					$birthday_week_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>,'; 
				} else if ( $user_birthday2 == $date_today ) 
    	  		{ 
					//user have birthday today 
					$user_age = $this_year - realdate ( 'Y',$birthdayrow['user_birthday'] ); 
					switch ($birthdayrow['user_level'])
					{
						case ADMIN :
		      				$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
	      					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
							break;
						case MOD :
				      		$birthdayrow['username'] = '<b>' . $birthdayrow['username'] . '</b>'; 
    	  					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
							break;
						default: $style_color = '';
					}
					$birthday_today_list .= ' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $birthdayrow['user_id']) . '"' . $style_color .'>' . $birthdayrow['username'] . ' ('.$user_age.')</a>,'; 
			      } 
			}
			if ($birthday_today_list) $birthday_today_list[ strlen( $birthday_today_list)-1] = ' ';
			if ($birthday_week_list) $birthday_week_list[ strlen( $birthday_week_list)-1] = ' ';
		} 
		$db->sql_freeresult($result);
	}
	//
	// Start output of page
	//
	define('SHOW_ONLINE', true);
	$page_title = $lang['Index'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);

	if ( $board_config['real_default_lang'] == 'english' )
	{
		$Word_language = 'Language';
	}
	else
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['real_default_lang']. '/lang_main.'.$phpEx);
		$Word_language = 'Language' . ' / ' . $lang['Word_language'] . ' ';
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang']. '/lang_main.'.$phpEx);
	}
	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'), 

		'FORUM_IMG' => $images['forum'],
		'FORUM_NEW_IMG' => $images['forum_new'],
		'FORUM_LOCKED_IMG' => $images['forum_locked'],
		'LANGUAGE_SELECT' => language_select($board_config['default_lang'], 'language'), 

		'L_SELECT_LANG' => $Word_language,
		'L_CHANGE_NOW' => $lang['Submit'],
		'L_WHOSBIRTHDAY_WEEK' => ($board_config['birthday_check_day'] > 1) ? sprintf( (($birthday_week_list) ? $lang['Birthday_week'] : $lang['Nobirthday_week']), $board_config['birthday_check_day']).$birthday_week_list : '',
		'L_WHOSBIRTHDAY_TODAY' => ($board_config['birthday_check_day']) ? ($birthday_today_list) ? $lang['Birthday_today'].$birthday_today_list : $lang['Nobirthday_today'] : '',
		'L_FORUM' => $lang['Forum'],
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'], 
		'L_NO_NEW_POSTS' => $lang['No_new_posts'],
		'L_NEW_POSTS' => $lang['New_posts'],
		'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'], 
		'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'], 
		'L_ONLINE_EXPLAIN' => $lang['Online_explain'],
		'L_LINKS' => $lang['Site_links'],
		'U_LINKS' => append_sid("links.$phpEx"),
		'U_LINKS_JS' => "links.js.$phpEx",
		'U_SITE_LOGO' => $link_self_img,
		'SITE_LOGO_WIDTH' => $site_logo_width,
		'SITE_LOGO_HEIGHT' => $site_logo_height, 

		'L_MODERATOR' => $lang['Moderators'], 
		'L_FORUM_LOCKED' => $lang['Forum_is_locked'],
		'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'], 

		'U_MARK_READ' => append_sid("index.$phpEx?mark=forums"))
	);

	//
	// Okay, let's build the index
	//
	for($i = 0; $i < $total_categories; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];

		//
		// Should we display this category/forum set?
		//
		$display_forums = false;
		for($j = 0; $j < $total_forums; $j++)
		{
			if ( $is_auth_ary[$forum_data[$j]['forum_id']]['auth_view'] && $forum_data[$j]['cat_id'] == $cat_id )
			{
				$display_forums = true;
			}
		}

		//
		// Yes, we should, so first dump out the category
		// title, then, if appropriate the forum list
		//
		if ( $display_forums )
		{
			$template->assign_block_vars('catrow', array(
				'CAT_ID' => $cat_id,
				'CAT_DESC' => $category_rows[$i]['cat_title'],
				'U_VIEWCAT' => append_sid("index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
			);

			if ( $viewcat == $cat_id || $viewcat == -1 )
			{
				for($j = 0; $j < $total_forums; $j++)
				{
					if ( $forum_data[$j]['cat_id'] == $cat_id )
					{
						$forum_id = $forum_data[$j]['forum_id'];

						if ( $is_auth_ary[$forum_id]['auth_view'] && $forum_data[$j]['forum_sub'] ==0)
						{
							if ( $forum_data[$j]['forum_status'] == FORUM_LOCKED )
							{
								$folder_image = $images['forum_locked']; 
								$folder_alt = $lang['Forum_locked'];
							}
							else
							{
								$unread_topics = false;
								if ( $userdata['session_logged_in'] )
								{
									if ( !empty($new_topic_data[$forum_id]) )
									{
										$forum_last_post_time = 0;

										while( list($check_topic_id, $check_post_time) = @each($new_topic_data[$forum_id]) )
										{
											if ( empty($tracking_topics[$check_topic_id]) )
											{
												$unread_topics = true;
												$forum_last_post_time = max($check_post_time, $forum_last_post_time);

											}
											else
											{
												if ( $tracking_topics[$check_topic_id] < $check_post_time )
												{
													$unread_topics = true;
													$forum_last_post_time = max($check_post_time, $forum_last_post_time);
												}
											}
										}

										if ( !empty($tracking_forums[$forum_id]) )
										{
											if ( $tracking_forums[$forum_id] > $forum_last_post_time )
											{
												$unread_topics = false;
											}
										}

										if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
										{
											if ( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] > $forum_last_post_time )
											{
												$unread_topics = false;
											}
										}

									}
								}

								$folder_image = ( $unread_topics ) ? $images['forum_new'] : $images['forum']; 
								$folder_alt = ( $unread_topics ) ? $lang['New_posts'] : $lang['No_new_posts']; 
							}
							for($k=0;$k<count($forum_sub2[$forum_id]);$k++) 
							{ 
								$unread_topics = false; 
								$forum_id2=$forum_sub2[$forum_id][$k]; 
								if ( $userdata['session_logged_in'] ) 
								{ 
									if ( !empty($new_topic_data[$forum_id2]) ) 
									{ 
										$forum_last_post_time = 0; 
										while( list($check_topic_id, $check_post_time) = @each($new_topic_data[$forum_id2]) ) 
										{ 
											if ( empty($tracking_topics[$check_topic_id]) ) 
											{ 
												$unread_topics = true; 
												$forum_last_post_time = max($check_post_time, $forum_last_post_time); 
											} 
											else 
											{ 
												if ( $tracking_topics[$check_topic_id] < $check_post_time ) 
												{ 
													$unread_topics = true; 
													$forum_last_post_time = max($check_post_time, $forum_last_post_time); 
												} 
												if($new_topic_data[$forum_id2][0]) 
												{ 
													$unread_topics = true; 
												} 
											} 
										} 
										if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) ) 
										{ 
											if ( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] > $forum_last_post_time ) 
											{ 
												$unread_topics = false; 
											} 
										} 
									} 
								} 
								if($is_auth_ary[$forum_id2]['auth_view']) 
								{ 
									if($unread_topics) 
									{ 
										$forum_sub[$forum_id][$forum_id2] = $forum_sub[$forum_id][$forum_id2].'<img src="images/topnew.gif" alt='.$lang['New_posts'].' border="0">'; 
									} 
								}
								else
								{ 
									unset($forum_sub[$forum_id][$forum_id2]); 
								} 
							}

							$posts = $forum_data[$j]['forum_posts'];
							$topics = $forum_data[$j]['forum_topics'];
							if ( !empty($forum_data[$j]['forum_icon']) )
							{
								$icon = '<img src="./images/icons/' . $forum_data[$j]['forum_icon'] . '" border="0">&nbsp;';
							}
							else
							{
								$icon = '';
							}

							if ( $forum_main[$forum_id]['forum_last_post_id'] )
							{
								$last_post_time = create_date($board_config['default_dateformat'], $forum_main[$forum_id]['post_time'], $board_config['board_timezone']);

								$last_post = $last_post_time . '<br />';

								$last_post .= ( $forum_main[$forum_id]['user_id'] == ANONYMOUS ) ? ( ($forum_main[$forum_id]['post_username'] != '' ) ? $forum_main[$forum_id]['post_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $forum_main[$forum_id]['user_id']) . '">' . $forum_main[$forum_id]['username'] . '</a> ';
								
								$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $forum_main[$forum_id]['forum_last_post_id']) . '#' . $forum_main[$forum_id]['forum_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
							}
							else
							{
								$last_post = $lang['No_Posts'];
							}

							if ( count($forum_moderators[$forum_id]) > 0 )
							{
								$l_moderators = ( count($forum_moderators[$forum_id]) == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
								$moderator_list = implode(', ', $forum_moderators[$forum_id]);
							}
							else
							{
								$l_moderators = '&nbsp;';
								$moderator_list = '&nbsp;';
							}
							if ( count($forum_sub[$forum_id]) > 0 ) 
							{ 
								$forum_sub_list = implode(', ', $forum_sub[$forum_id]); 
							} 
							else 
							{
								$forum_sub_list = ''; 
							} 
							if(!empty($forum_sub_list)) 
							{ 
								$forum_sub_list = '<br />' . $lang['Forum_sub'] . ':&nbsp;' . $forum_sub_list;
							}

							$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
							$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

							$template->assign_block_vars('catrow.forumrow',	array(
								'ROW_COLOR' => '#' . $row_color,
								'ROW_CLASS' => $row_class,
								'FORUM_FOLDER_IMG' => $folder_image, 
								'FORUM_NAME' => $forum_data[$j]['forum_name'],
								'FORUM_DESC' => $forum_data[$j]['forum_desc'],
								'FORUM_NAME_SUB' => $forum_sub_list,
								'POSTS' => $forum_data[$j]['forum_posts'],
								'TOPICS' => $forum_data[$j]['forum_topics'],
								'LAST_POST' => $last_post,
								'MODERATORS' => $moderator_list,
								'FORUM_ICON' => $icon,

								'L_MODERATOR' => $l_moderators, 
								'L_FORUM_FOLDER_ALT' => $folder_alt, 

								'U_VIEWFORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"))
							);
						}
					}
				}
			}
		}
	} // for ... categories

}// if ... total_categories
else
{
	message_die(GENERAL_MESSAGE, $lang['No_forums']);
}

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>