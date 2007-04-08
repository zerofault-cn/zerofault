<?php
/***************************************************************************
 *                            admin_links_cat.php
 *                            -------------------
 *  MOD add-on page. Contains GPL code copyright of phpBB group.
 *  Author: OOHOO < webdev@phpbb-tw.net >
 *  Author: Stefan2k1 and ddonker from www.portedmods.com
 *  Demo: http://phpbb-tw.net/
 *  Version: 1.0.X - 2002/03/22 - for phpBB RC serial, and was named Related_Links_MOD
 *  Version: 1.1.0 - 2002/04/25 - Re-packed for phpBB 2.0.0, and renamed to Links_MOD
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

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Links']['Category'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_link.' . $phpEx);


// --------------------------
// This function will sort the order of all categories
//
function reorder_cat()
{
	global $db;

	$sql = "SELECT cat_id, cat_order
			FROM ". LINK_CATEGORIES_TABLE ."
			WHERE cat_id <> 0
			ORDER BY cat_order ASC";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get list of Categories', '', __LINE__, __FILE__, $sql);
	}

	$i = 10;

	while( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE ". LINK_CATEGORIES_TABLE ."
				SET cat_order = $i
				WHERE cat_id = ". $row['cat_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update order fields', '', __LINE__, __FILE__, $sql);
		}
		$i += 10;
	}
}
// END
// --------------------------


if( !isset($HTTP_POST_VARS['mode']) )
{
	if( !isset($HTTP_GET_VARS['action']) )
	{
		$template->set_filenames(array(
			'body' => 'admin/admin_link_cat_body.tpl')
		);

		$template->assign_vars(array(
			'L_LINK_CAT_TITLE' => $lang['Link_Categories_Title'],
			'L_LINK_CAT_EXPLAIN' => $lang['Link_Categories_Explain'],
			'L_LINK_ACTION' => append_sid("admin_links_cat.$phpEx"),
			'L_MOVE_UP' => $lang['Move_up'],
			'L_MOVE_DOWN' => $lang['Move_down'],
			'L_EDIT' => $lang['Edit'],
			'L_DELETE' => $lang['Delete'],
			'S_MODE' => 'new',
			'L_CREATE_CATEGORY' => $lang['Create_category'])
		);

		$sql = "SELECT *
				FROM ". LINK_CATEGORIES_TABLE ."
				ORDER BY cat_order ASC";
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query Link Categories information', '', __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$catrow[] = $row;
		}

		for( $i = 0; $i < count($catrow); $i++ )
		{
			$template->assign_block_vars('catrow', array(
				'COLOR' => ($i % 2) ? 'row1' : 'row2',
				'TITLE' => $catrow[$i]['cat_title'],
				'S_MOVE_UP' => append_sid("admin_links_cat.$phpEx?action=move&amp;move=-15&amp;cat_id=" . $catrow[$i]['cat_id']),
				'S_MOVE_DOWN' => append_sid("admin_links_cat.$phpEx?action=move&amp;move=15&amp;cat_id=" . $catrow[$i]['cat_id']),
				'S_EDIT_ACTION' => append_sid("admin_links_cat.$phpEx?action=edit&amp;cat_id=" . $catrow[$i]['cat_id']),
				'S_DELETE_ACTION' => append_sid("admin_links_cat.$phpEx?action=delete&amp;cat_id=" . $catrow[$i]['cat_id'])
				)
			);
		}

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
	}
	else
	{
		if( $HTTP_GET_VARS['action'] == 'edit' )
		{
			$cat_id = intval($HTTP_GET_VARS['cat_id']);

			$sql = "SELECT *
					FROM ". LINK_CATEGORIES_TABLE ."
					WHERE cat_id = '$cat_id'";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not query Link Categories information', '', __LINE__, __FILE__, $sql);
			}
			if( $db->sql_numrows($result) == 0 )
			{
				message_die(GENERAL_ERROR, 'The requested category is not existed');
			}
			$catrow = $db->sql_fetchrow($result);

			$template->set_filenames(array(
				'body' => 'admin/admin_link_cat_new_body.tpl')
			);

			$template->assign_vars(array(
				'L_LINK_CAT_TITLE' => $lang['Link_Categories_Title'],
				'L_LINK_CAT_EXPLAIN' => $lang['Link_Categories_Explain'],
				'S_LINK_ACTION' => append_sid("admin_links_cat.$phpEx?cat_id=$cat_id"),
				'L_CAT_TITLE' => $lang['Category_Title'],

				'L_DISABLED' => $lang['Disabled'],

				'S_CAT_TITLE' => $catrow['cat_title'],


				'S_MODE' => 'edit',


				'L_PANEL_TITLE' => $lang['Edit_Category'])
			);

			$template->pparse('body');

			include('./page_footer_admin.'.$phpEx);
		}
		else if( $HTTP_GET_VARS['action'] == 'delete' )
		{
			$cat_id = intval($HTTP_GET_VARS['cat_id']);

			$sql = "SELECT cat_id, cat_title, cat_order
					FROM ". LINK_CATEGORIES_TABLE ."
					ORDER BY cat_order ASC";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not query Link Categories information', '', __LINE__, __FILE__, $sql);
			}

			$cat_found = FALSE;
			while( $row = $db->sql_fetchrow($result) )
			{
				if( $row['cat_id'] == $cat_id )
				{
					$thiscat = $row;
					$cat_found = TRUE;
				}
				else
				{
					$catrow[] = $row;
				}
			}
			if( $cat_found == FALSE )
			{
				message_die(GENERAL_ERROR, 'The requested category is not existed');
			}

			$select_to = '<select name="target"><option value="0">'. $lang['Delete_all_links'] .'</option>';
			for ($i = 0; $i < count($catrow); $i++)
			{
				$select_to .= '<option value="'. $catrow[$i]['cat_id'] .'">'. $catrow[$i]['cat_title'] .'</option>';
			}
			$select_to .= '</select>';

			$template->set_filenames(array(
				'body' => 'admin/admin_link_cat_delete_body.tpl')
			);

			$template->assign_vars(array(
				'S_LINK_ACTION' => append_sid("admin_links_cat.$phpEx?cat_id=$cat_id"),
				'L_CAT_DELETE' => $lang['Delete_Category'],
				'L_CAT_DELETE_EXPLAIN' => $lang['Delete_Category_Explain'],
				'L_CAT_TITLE' => $lang['Category_Title'],
				'S_CAT_TITLE' => $thiscat['cat_title'],
				'L_MOVE_CONTENTS' => $lang['Move_contents'],
				'L_MOVE_DELETE' => $lang['Move_and_Delete'],
				'S_SELECT_TO' => $select_to)
			);

			$template->pparse('body');

			include('./page_footer_admin.'.$phpEx);
		}
		else if( $HTTP_GET_VARS['action'] == 'move' )
		{
			$cat_id = intval($HTTP_GET_VARS['cat_id']);
			$move = intval($HTTP_GET_VARS['move']);

			$sql = "UPDATE ". LINK_CATEGORIES_TABLE ."
					SET cat_order = cat_order + $move
					WHERE cat_id = $cat_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not change category order', '', __LINE__, __FILE__, $sql);
			}

			reorder_cat();

			// Return a message...
			$message = $lang['Category_changed_order'] . "<br /><br />" . sprintf($lang['Click_return_link_category'], "<a href=\"" . append_sid("admin_links_cat.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
	}
}
else
{
	if( $HTTP_POST_VARS['mode'] == 'new' )
	{
		if( !isset($HTTP_POST_VARS['cat_title']) )
		{
			$template->set_filenames(array(
				'body' => 'admin/admin_link_cat_new_body.tpl')
			);

			$template->assign_vars(array(
				'L_LINK_CAT_TITLE' => $lang['Link_Categories_Title'],
				'L_LINK_CAT_EXPLAIN' => $lang['Link_Categories_Explain'],
				'S_LINK_ACTION' => append_sid("admin_links_cat.$phpEx"),
				'L_CAT_TITLE' => $lang['Category_Title'],


				'L_DISABLED' => $lang['Disabled'],

				'S_MODE' => 'new',


				'L_PANEL_TITLE' => $lang['Create_category'])
			);

			$template->pparse('body');

			include('./page_footer_admin.'.$phpEx);
		}
		else
		{
			// Get posting variables
			$cat_title = str_replace("\'", "''", htmlspecialchars(trim($HTTP_POST_VARS['cat_title'])));


			// Get the last ordered category
			$sql = "SELECT cat_order FROM ". LINK_CATEGORIES_TABLE ."
					ORDER BY cat_order DESC
					LIMIT 1";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not query Link Categories information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$last_order = $row['cat_order'];
			$cat_order = $last_order + 10;

			// Here we insert a new row into the db
			$sql = "INSERT INTO ". LINK_CATEGORIES_TABLE ." (cat_title, cat_order)
					VALUES ('$cat_title', '$cat_order')";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not create new Link Category', '', __LINE__, __FILE__, $sql);
			}

			// Return a message...
			$message = $lang['New_category_created'] . "<br /><br />" . sprintf($lang['Click_return_link_category'], "<a href=\"" . append_sid("admin_links_cat.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else if( $HTTP_POST_VARS['mode'] == 'edit' )
	{
		// Get posting variables
		$cat_id = intval($HTTP_GET_VARS['cat_id']);
		$cat_title = str_replace("\'", "''", htmlspecialchars(trim($HTTP_POST_VARS['cat_title'])));


		// Now we update this row
		$sql = "UPDATE ". LINK_CATEGORIES_TABLE ."
				SET cat_title = '$cat_title'
				WHERE cat_id = '$cat_id'";
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update this Link Category', '', __LINE__, __FILE__, $sql);
		}

		// Return a message...
		$message = $lang['Category_updated'] . "<br /><br />" . sprintf($lang['Click_return_link_category'], "<a href=\"" . append_sid("admin_links_cat.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( $HTTP_POST_VARS['mode'] == 'delete' )
	{
		$cat_id = intval($HTTP_GET_VARS['cat_id']);
		$target = intval($HTTP_POST_VARS['target']);

		if( $target == 0 ) // Delete All
		{
			// Get file information of all pics in this category
			$sql = "SELECT *
					FROM ". LINKS_TABLE ."
					WHERE link_category = '$cat_id'";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not query Link information', '', __LINE__, __FILE__, $sql);
			}
			$catrow = array();
			while( $row = $db ->sql_fetchrow($result) )
			{
				$catrow[] = $row;
				$cat_id_row[] = $row['link_id'];
			}

			if( count($catrow) != 0 ) // if this category is not empty
			{

				// Delete pic entries in db
				$sql = "DELETE FROM ". LINKS_TABLE ."
						WHERE link_category = '$cat_id'";
				if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not delete link entries in the DB', '', __LINE__, __FILE__, $sql);
				}
			}

			// This category is now emptied, we can remove it!
			$sql = "DELETE FROM ". LINK_CATEGORIES_TABLE ."
					WHERE cat_id = '$cat_id'";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete this Category', '', __LINE__, __FILE__, $sql);
			}

			// Re-order the rest of categories
			reorder_cat();

			// Return a message...
			$message = $lang['Category_deleted'] . "<br /><br />" . sprintf($lang['Click_return_link_category'], "<a href=\"" . append_sid("admin_links_cat.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
		else // Move content...
		{
			$sql = "UPDATE ". LINKS_TABLE ."
					SET pic_cat_id = '$target'
					WHERE pic_cat_id = '$cat_id'";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update this Category content', '', __LINE__, __FILE__, $sql);
			}

			// This category is now emptied, we can remove it!
			$sql = "DELETE FROM ". LINK_CATEGORIES_TABLE ."
					WHERE cat_id = '$cat_id'";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete this Category', '', __LINE__, __FILE__, $sql);
			}

			// Re-order the rest of categories
			reorder_cat();

			// Return a message...
			$message = $lang['Category_deleted'] . "<br /><br />" . sprintf($lang['Click_return_link_category'], "<a href=\"" . append_sid("admin_links_cat.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

/* Powered by Photo Link v2.x.x (c) 2002-2003 Smartor */

?>