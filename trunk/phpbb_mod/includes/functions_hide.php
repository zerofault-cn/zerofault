<?php
/***************************************************************************
 *                            functions_hide.php
 *                            -------------------
 *   begin                : Tue, Nov 18, 2003
 *   copyright            : (C) 2003 shi@phpBB
 *   email                : roc@phpbbhost1.biz
 *
 *   $Id: functions_hide.php,v 1.0 2003/11/18 09:37:07
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

if ( !defined('CASH_CLASSES_INCLUDE') ) 
{ 
   include($phpbb_root_path . 'includes/functions_cash.php'); 
} 

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main_hide.' . $phpEx);

// Return value
//      true --- if the cash field is valid
//      false -- if the cash field is invalid
function get_cash_info($cash_id, &$cash_field_name, &$cash_name, &$is_prefix, &$max_min)
{
	global $board_config, $userdata, $db, $cash;
	
	$cash_field_name = '';
	$cash_name = '';
	$is_prefix = false;
	switch ($board_config['cash_system_type'])
	{
		case CASH_TYPE_POINTS:
			$cash_field_name = 'user_points';
			$cash_name = $board_config['points_name'];
			$max_min['max_price'] = $board_config['max_sellingprice'];
			$max_min['min_price'] = $board_config['min_sellingprice'];
			$max_min['max_fortune'] = $board_config['max_fortunerequired'];
			$max_min['min_fortune'] = $board_config['min_fortunerequired'];
			break;
			
		case CASH_TYPE_CASHMOD2:
			if (!$board_config['cash_disabled'])
			{
				while ( $c_cur = &$cash->currency_next($cm_i,CURRENCY_ENABLED) )
				{
					$cc_cur = $cash->currency($cash_id);
					$cash_name = $cc_cur->name(); 
					$cash_field_name = $cc_cur->db();
					$is_prefix = $cc_cur->mask(CURRENCY_PREFIX);
					$max_min['max_price'] = $cc_cur->cashmaxsellingprice();
					$max_min['min_price'] = $cc_cur->cashminsellingprice();
					$max_min['max_fortune'] = $cc_cur->cashmaxfortunerequired();
					$max_min['min_fortune'] = $cc_cur->cashminfortunerequired();
				}
			}

			break;

		default:
			$cash_name = $board_config['cash_type_name'];
			$cash_field_name = $board_config['cash_field_name'];
			$max_min['max_price'] = $board_config['max_sellingprice'];
			$max_min['min_price'] = $board_config['min_sellingprice'];
			$max_min['max_fortune'] = $board_config['max_fortunerequired'];
			$max_min['min_fortune'] = $board_config['min_fortunerequired'];
	}
	return (!empty($cash_field_name) && isset($userdata[$cash_field_name]));
}

function strip_hidden_contents($post, &$hiding_info)
{
	global $userdata, $db, $is_auth, $board_config;
	
	$hiding_info['type'] = '';
	$hiding_info['show_attachment'] = true;
	switch ( $post['hiding_type'] )
	{
		case REPLY_TO_READ:
			if ($board_config['allow_hide4reply'])
			{
				$hiding_info['type'] = 'Reply';
	
				$sql = 'SELECT poster_id
									FROM ' . POSTS_TABLE . '
									WHERE topic_id=' . $post['topic_id'] . '
										AND poster_id=' . $userdata['user_id'] . '
										AND post_time > ' . $post['post_time'];
				$check_view = 'if ( !(\$result = \$db->sql_query(\$sql)) )
					{
						message_die(GENERAL_ERROR, "Could not obtain posts information", "", __LINE__, __FILE__, \$sql);
					}
					\$canview = ( \$db->sql_numrows(\$result) > 0 );
					\$db->sql_freeresult(\$result);';
				}
			break;
		
		case PAY_TO_READ:
			if (get_cash_info($post['hiding_cash_id'], $cash_field_name, $cash_name, $is_prefix, $max_min))
			{
				$hiding_info['type'] = 'Sale';
				$hiding_info['cash_name'] = $cash_name;
				$hiding_info['cash_prefix'] = $is_prefix;
				$sql = 'SELECT user_id FROM ' . PAYMENT_TABLE . ' WHERE post_id=' . $post['post_id'] . ' AND user_id=' . $userdata['user_id'];
				\$check_view = "if ( !(\$result = \$db->sql_query(\$sql)) )
					{
						message_die(GENERAL_ERROR, \"Could not obtain payment information\", \"\", __LINE__, __FILE__, \$sql);
					}
					\$canview = ( \$db->sql_numrows(\$result) > 0 );
					\$db->sql_freeresult(\$result);";
			}
			break;
		
		case POSTS_TO_READ:
			if ( $board_config['allow_hide4posts'] )
			{
				$hiding_info['type'] = 'Posts';
				$check_view = '\$canview = ($userdata["user_posts"] >= $post["hiding_condition_value"]);';
			}
			break;
			
		case FORTUNE_TO_READ:
			if ( $board_config['allow_hide4fortune'] && (get_cash_info($post['hiding_cash_id'], $cash_field_name, $cash_name, $is_prefix, $max_min)) )
			{
				$hiding_info['type'] = 'Fortune';
				$hiding_info['cash_name'] = $cash_name;
				$hiding_info['cash_prefix'] = $is_prefix;
				$check_view = '\$canview = ($userdata[$cash_field_name] >= $post["hiding_condition_value"]);';
			}
			break;
	}		
	if ( $hiding_info['type'] )
	{
		if ( $userdata['session_logged_in'] )
		{
			if ($userdata['user_id'] != $post['poster_id'])
			{
				if ($is_auth['auth_mod'])
					{$hiding_info['state'] = 'Can_read';}
				else
				{
					eval($check_view);
					if ( $canview )
					{
						$hiding_info['state'] = 'Can_read';
					}
					else
					{
						$hiding_info['state'] = 'Cannot_read';
						$hiding_info['show_attachment'] = false;
						$hiding_info['post_id'] = $post['post_id'];
					}
				}
			}
			else
			{
				$hiding_info['state'] = 'Poster';
			}
		}
		else
		{
			$hiding_info['state'] = 'Cannot_read';
			$hiding_info['show_attachment'] = false;
			$hiding_info['post_id'] = $post['post_id'];
		}
		$hiding_info['hiding_condition_value'] = $post['hiding_condition_value'];
		
		if ( $hiding_info['show_attachment'] )
			$message = $post['post_text'];
		else
		{
			$uid=$post['bbcode_uid'];
			preg_match_all("#\[intro:$uid\](.*?)\[/intro:$uid\]#si", $post['post_text'], $matches, PREG_PATTERN_ORDER);
			$message = implode('', $matches[0]);
		}
		return $message;
	}
	else
		return $post['post_text'];
}

function get_hiding_info_box($hiding_info, $simple=false, $buy_action='')
{
	global $template, $lang, $phpEx;

	if ( !empty($hiding_info['type']) )
	{
		$template->set_filenames(array(
			'hidinginfo' => 'hiding_information.tpl')
		);
		
		$block_name = '';
		if ( in_array($hiding_info['type'], array('Sale', 'Fortune') ) )
		{
			if ($hiding_info['cash_prefix'])
			{
				$prefix = $hiding_info['cash_name'] . '&nbsp;';
				$postfix = '';
			}
			else
			{
				$prefix = '';
				$postfix = '&nbsp;' . $hiding_info['cash_name'];
			}
		}
		else
		{
			$prefix = '';
			$postfix = '';
		}

		switch ( $hiding_info['type'] )
		{
			case 'Sale':
				if ( empty($buy_action) )
					$buy_action = "viewtopic.$phpEx";
				if ( (!$simple) && ($hiding_info['state'] == 'Cannot_read') )
				{
					$block_name = 'selling';
					$template->assign_block_vars('selling', array(
						'L_SELL_DESCRIPTION' => $lang['Sale_info'][$hiding_info['state']],
						'L_SELLING_PRICE' => $lang['Selling_price'],
						'L_BUY' => $lang['Buy'],
						'U_POST_ID' => $hiding_info['post_id'],
						'S_BUYPOST_ACTION' => append_sid($buy_action),
						'SELLING_PRICE' => $prefix . intval($hiding_info['hiding_condition_value']) . $postfix )
					);
				}
				else
				{
					$block_name = 'bought';
					$template->assign_block_vars('bought', array(
						'L_BOUGHT_DESCRIPTION' => $lang['Sale_info'][$hiding_info['state']],
						'L_SELLING_PRICE' => $lang['Selling_price'],
						'SELLING_PRICE' => $prefix . intval($hiding_info['hiding_condition_value']) . $postfix )
					);
				}
				break;
				
			case 'Reply':
				$block_name = 'simple_hiding_box';
				$template->assign_block_vars('simple_hiding_box', array(
					'L_HIDING_DESCRIPTION' => $lang['Reply_info'][$hiding_info['state']])
				);
				break;
				
			case 'Posts':
			case 'Fortune':
				$block_name = 'simple_hiding_box';
				$template->assign_block_vars('simple_hiding_box', array(
					'L_HIDING_DESCRIPTION' => sprintf($lang[$hiding_info['type'] . '_info'][$hiding_info['state']], $prefix . intval($hiding_info['hiding_condition_value']) . $postfix) )
				);
				break;			
			
			default:
				break;
		}
		$template->assign_var_from_handle('tmpHiding', 'hidinginfo');
		if (!empty($block_name))
			unset($template->_tpldata[$block_name]);
		return $template->_tpldata['.'][0]['tmpHiding'];
	}
	else
		return '';
}

function buy_post($post_id, $url)
{
	global $userdata, $db, $lang, $template, $board_config;
	
	if ( $post_id <= 0 )
	{
		message_die(GENERAL_ERROR, 'Topic_post_not_exist');
	}
	if ( !$userdata['session_logged_in'] )
	{
		message_die(GENERAL_MESSAGE, $lang["Login_to_buy"]);
	}
	
	// Check if user have bought this post
	$sql = 'SELECT user_id FROM ' . PAYMENT_TABLE . " WHERE post_id=$post_id AND user_id=" . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain payment information", '', __LINE__, __FILE__, $sql);
	}
	if ( $db->sql_numrows($result) )
	{
		message_die(GENERAL_MESSAGE, $lang['Post_bought_before']);
	}
	// Check if user have enough money to buy this post
	$sql = 'SELECT hiding_type, hiding_condition_value, hiding_cash_id, poster_id FROM ' . POSTS_TABLE . ' WHERE post_id=' . $post_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain post information", '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	
	if ( ($row['hiding_type'] <> PAY_TO_READ) || (!$row['hiding_condition_value']) )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $url)
		);
		message_die(GENERAL_MESSAGE, $lang['Not_for_sale'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . $url, '</a>'));
	}
	
	if (! get_cash_info($row['hiding_cash_id'], $cash_field_name, $cash_name, $is_prefix, $max_min))
		message_die(GENERAL_ERROR, $lang['No_valid_cash_type']);

	if ( $userdata[$cash_field_name] < $row['hiding_condition_value'] )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $url)
		);
		message_die(GENERAL_ERROR, sprintf($lang['Not_enough_cash'], $cash_name) . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . $url, '</a>'));
	}
	$post_price = intval($row['hiding_condition_value']);
	$poster_id = $row['poster_id'];
	//Check
	if($post_price < 0)
	{
		$sql = 'SELECT ' . $cash_field_name . ' FROM ' . USERS_TABLE . ' WHERE user_id=' . $poster_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain post information", '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ((( $row[$cash_field_name] ) + ( $post_price )) < 0 )
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $url)
			);
			message_die(GENERAL_MESSAGE, $lang['Invalid_hiding_type'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . $url, '</a>'));
		}
	}
	//
	$sql = 'UPDATE ' . USERS_TABLE . '
		SET ' . $cash_field_name . '=' . $cash_field_name . '+(' . $post_price . ')
		WHERE user_id=' . $poster_id;
	if ( !($db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update poster's cash information", '', __LINE__, __FILE__, $sql);
	}

	$sql = 'UPDATE ' . USERS_TABLE . '
		SET ' . $cash_field_name . '=' . $cash_field_name . '-(' . $post_price . ')
		WHERE user_id=' . $userdata['user_id'];
	if ( !($db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update user's cash information", '', __LINE__, __FILE__, $sql);
	}
	$sql = 'INSERT INTO ' . PAYMENT_TABLE . ' (post_id, user_id) VALUES (' . $post_id . ', ' . $userdata['user_id'] . ')';
	if ( !($db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, sprintf($lang['Buy_post_fail'], $cash_name));
	}
	
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . $url)
	);

	$message = $lang['Buy_post_success'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . $url, '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//convert the value range to string
function get_value_range_string($min, $max)
{
	$range = '';

	if (!is_int($max))
		$max = intval($max);
	if (!is_int($min))
		$min = intval($min); 

	if ($max && $min)
		$range = "($min ~ $max)";
	elseif ($max)
		$range = "(&le;$max)";
	elseif ($min)
		$range = "(&ge;$min)";

	return '"' . $range . '"';
}

function aaget_value_range($hiding_type, $cash_id, &$min, &$max)
{
	global $board_config;
	
	$min = 0;
	$max = 0;
		
	switch ($hiding_type)
	{
		case PAY_TO_READ:
			if (get_cash_info($cash_id, $cash_field, $cash_name, $is_prefix, $max_min))
			{
				$min = $max_min['min_price'];
				$max = $max_min['max_price'];
			}
			else
				return false;
			break;
			
		case FORTUNE_TO_READ:
			if (get_cash_info($cash_id, $cash_field, $cash_name, $is_prefix, $max_min))
			{
				$min = $max_min['min_fortune'];
				$max = $max_min['max_fortune'];
			}
			else
				return false;
			break;
			
		case POSTS_TO_READ:
			$min = intval($board_config['max_postsrequired']);
			$max = intval($board_config['min_postsrequired']);
			break;
	}
	return true;
}

?>