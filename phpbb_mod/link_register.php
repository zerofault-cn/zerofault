<?php
/***************************************************************************
*                            link_register.php
*                            -------------------
*  MOD add-on page. Contains GPL code copyright of phpBB group.
*  Author: OOHOO < webdev@phpbb-tw.net >
*  Author: Stefan2k1 and ddonker from www.portedmods.com
*  Author: CRLin from http://mail.dhjh.tcc.edu.tw/~gzqbyr/
*  Demo: http://phpbb-tw.net/
*  Version: 1.0.X - 2002/03/22 - for phpBB RC serial, and was named Related_Links_MOD
*  Version: 1.1.0 - 2002/04/25 - Re-packed for phpBB 2.0.0, and renamed to Links_MOD
*  Version: 1.2.0 - 2003/06/15 - Enhanced and Re-packed for phpBB 2.0.4
*  Version: 1.2.1 - 2003/10/15 - Enhanced by CRLin
*  Version: 1.2.2 - 2004/05/10 - Enhanced by CRLin
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

$phpbb_root_path = "./";
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LINKS);
init_userprefs($userdata);
require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main_link.' . $phpEx);
//
// End session management
//


// Users Authentication, members only area
if( !$userdata['session_logged_in'] )
{
	header("Location: " . append_sid("login.$phpEx?redirect=links.php", true));
	exit;
}

$link_title = ( !empty($HTTP_POST_VARS['link_title']) ) ? trim($HTTP_POST_VARS['link_title']) : '';
$link_desc = ( !empty($HTTP_POST_VARS['link_desc']) ) ? trim($HTTP_POST_VARS['link_desc']) : '';
$link_category = ( !empty($HTTP_POST_VARS['link_category']) ) ? (is_numeric($HTTP_POST_VARS['link_category']) ? $HTTP_POST_VARS['link_category'] : 0) : 0;
$link_url = ( !empty($HTTP_POST_VARS['link_url']) ) ? trim($HTTP_POST_VARS['link_url']) : '';
$link_logo_src = ( !empty($HTTP_POST_VARS['link_logo_src']) ) ? trim($HTTP_POST_VARS['link_logo_src']) : '';
if ($link_logo_src == 'http://')  $link_logo_src = '';
$link_joined = time();
$user_id = $userdata['user_id'];

//
// Get Link Config
//
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
}

//
// Check Link config
//
if($link_config['lock_submit_site'] && $userdata['user_level'] != ADMIN)
{
	$message = $lang['Link_lock_submit_site'];
	$message .= '<br /><br />' . sprintf($lang['Click_return_links'], '<a href="' . append_sid("links.$phpEx") . '">', '</a>');
	
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("links.$phpEx") . '">'
	));

	message_die(GENERAL_MESSAGE, $message);
}

if(!$link_config['allow_no_logo'] && !$link_logo_src)
{	
	$message = $lang['Link_incomplete'];

	$message .= '<br /><br />' . sprintf($lang['Click_return_links'], '<a href="' . append_sid("links.$phpEx") . '">', '</a>');
	$message .= '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("links.$phpEx") . '">'
	));
		
	message_die(GENERAL_MESSAGE, $message);
}

//
// Add new link
//
if($link_title && $link_desc && $link_category && $link_url)
{
	// Check regiter interval
	$sql = "SELECT MAX(link_joined) AS last_link_joined FROM " . LINKS_TABLE . " 
		WHERE " . ($user_id != ANONYMOUS ? "user_id = '$user_id'" : "user_ip = '$user_ip'");
		
	if ( !($result = $db->sql_query($sql)) )
	{
		$message = $lang['Link_update_fail'];
	}		
	else
	{
		if($row = $db->sql_fetchrow($result))
		{
			$last_link_joined = $row['last_link_joined'];
		}
		else
		{
			$last_link_joined = 0;
		}

		if($link_joined - $last_link_joined > 60)
		{
			$is_admin = ( $userdata['user_level'] == ADMIN ) ? TRUE : 0;
			$sql = "INSERT INTO " . LINKS_TABLE . " (link_title, link_desc, link_category, link_url, link_logo_src, link_joined,link_active , user_id , user_ip)
				VALUES ('$link_title', '$link_desc', '$link_category', '$link_url', '$link_logo_src', '$link_joined', '$is_admin', '$user_id ', '$user_ip')";

			if ( !$db->sql_query($sql) )
			{
				$message = $lang['Link_update_fail'];
			}
			else
			{
			  if ( $userdata['user_level'] != ADMIN )
			  {
			    $sql = "SELECT user_id, username, user_notify_pm, user_allow_pm, user_email, user_lang, user_active 
				FROM " . USERS_TABLE . "
				WHERE user_level = " . ADMIN;
				if ( !($admin_result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not query users table", "", __LINE__, __FILE__, $sql);
				}
					
				if ( $link_config['email_notify'] )
				{
				  include($phpbb_root_path . 'includes/emailer.'.$phpEx);
				  while( $to_userdata = $db->sql_fetchrow($admin_result) )
				  {
				    if ( $to_userdata['user_email'] )
				    {
				      $emailer = new emailer($board_config['smtp_delivery']);
					
					  $emailer->from($board_config['board_email']);
					  $emailer->replyto($board_config['board_email']);

					  $emailer->use_template('link_add', $to_userdata['user_lang']);
					  $emailer->email_address($to_userdata['user_email']);
					
					  $emailer->assign_vars(array(
						  'LINK_URL' => $link_url,
						  'SITENAME' => $board_config['sitename']
						)
					  );

					  $emailer->send();
					  $emailer->reset();
					}
				  }
				}

				if ( empty($board_config['privmsg_disable']) && $link_config['pm_notify'] )
				{
				  $html_on = 0; $bbcode_on = 0; $smilies_on = 0; $attach_sig = 0;
				  while( $to_userdata = $db->sql_fetchrow($admin_result) )
				  {
				    //
				    // Has admin prevented user from sending PM's?
				    //
		            if ( $to_userdata['user_allow_pm'] )
					{
					  $bbcode_uid = make_bbcode_uid();
					  $msg_time = time();
					  //
					  // See if recipient is at their inbox limit
					  //
					  $sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time 
						FROM " . PRIVMSGS_TABLE . " 
						WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
							OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "  
							OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " ) 
							AND privmsgs_to_userid = " . $to_userdata['user_id'];
					  if ( !($result = $db->sql_query($sql)) )
					  {
						message_die(GENERAL_MESSAGE, $lang['No_such_user']);
					  }

					  $sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

					  if ( $inbox_info = $db->sql_fetchrow($result) )
					  {
						if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
						{
						  $sql = "SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . " 
							WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . " 
								OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
								OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  ) 
								AND privmsgs_date = " . $inbox_info['oldest_post_time'] . " 
								AND privmsgs_to_userid = " . $to_userdata['user_id'];
						  if ( !$result = $db->sql_query($sql) )
						  {
							message_die(GENERAL_ERROR, 'Could not find oldest privmsgs (inbox)', '', __LINE__, __FILE__, $sql);
						  }
						  $old_privmsgs_id = $db->sql_fetchrow($result);
						  $old_privmsgs_id = $old_privmsgs_id['privmsgs_id'];
				
						  $sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . " 
							WHERE privmsgs_id = $old_privmsgs_id";
						  if ( !$db->sql_query($sql) )
						  {
							message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs (inbox)'.$sql, '', __LINE__, __FILE__, $sql);
						  }

						  $sql = "DELETE $sql_priority FROM " . PRIVMSGS_TEXT_TABLE . " 
							WHERE privmsgs_text_id = $old_privmsgs_id";
						  if ( !$db->sql_query($sql) )
						  {
							message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs text (inbox)', '', __LINE__, __FILE__, $sql);
						 }
					  }
					}
					$privmsg_subject = $lang['Link_pm_notify_subject'];
					$sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
					VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $privmsg_subject) . "', " . $to_userdata['user_id'] . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip', $html_on, $bbcode_on, $smilies_on, $attach_sig)";
					if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
					{
						message_die(GENERAL_ERROR, "Could not insert/update private message sent info.", "", __LINE__, __FILE__, $sql_info);
					}
		
					$privmsg_sent_id = $db->sql_nextid();
					$privmsg_message = sprintf($lang['Link_pm_notify_message'], $link_url);
		
					$preview_message = stripslashes(prepare_message($privmsg_message, $html_on, $bbcode_on, $smilies_on, $bbcode_uid));

					$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
					VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $privmsg_message) . "')";
		
					if ( !$db->sql_query($sql, END_TRANSACTION) )
					{
						message_die(GENERAL_ERROR, "Could not insert/update private message sent text.", "", __LINE__, __FILE__, $sql_info);
					}

					//
					// Add to the users new pm counter
					//
					$sql = "UPDATE " . USERS_TABLE . "
						SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . "  
						WHERE user_id = " . $to_userdata['user_id']; 
					if ( !$status = $db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update private message new/read status for user', '', __LINE__, __FILE__, $sql);
					}
				  }
				}
			  }
			}
			$message = $lang['Link_update_success'];
		  }	
		}
		else
		{
			$message = $lang['Link_intval_warning'];		
		}
	}
}
else
{
	$message = $lang['Link_incomplete'];
}

$message .= '<br /><br />' . sprintf($lang['Click_return_links'], '<a href="' . append_sid("links.$phpEx") . '">', '</a>');
$message .= '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

$template->assign_vars(array(
	'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("links.$phpEx") . '">'
));
		
message_die(GENERAL_MESSAGE, $message);

?>