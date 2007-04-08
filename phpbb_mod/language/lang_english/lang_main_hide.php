<?php
/***************************************************************************
 *                            lang_main_hide.php [english]
 *                            -------------------
 *     begin                : Mod Nov 17 2003
 *     copyright            : (C) 2003 shi@phpbb
 *     email                : roc@phpbbhost1.biz
 *
 *     $Id: lang_main_hide.php,v 1.00 2003/11/17 13:39:42
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Login_to_buy'] = 'Please login before buying';
$lang['Not_enough_cash'] = 'You have not enough %s to buy this post';
$lang['Buy_post_fail'] = 'You have paid %s for this post, but failed to buy it. Please contact with the site admin.';
$lang['Buy_post_success'] = 'You have bought this post successfully';
$lang['Selling_price'] = 'Price: ';
$lang['Buy'] = 'Buy';
$lang['Not_for_sale'] = 'The post have not been sold. You cannot buy it.';
$lang['Introduction'] = 'Intrduction of the hidden content';

// messages used in hiding information box when reading a post
$lang['Sale_info']['Can_read'] = 'You have bought this post';
$lang['Sale_info']['Cannot_read'] = 'The message has been hidden. You must pay for reading.';
$lang['Sale_info']['Poster'] = 'Your post is for sale';
$lang['Reply_info']['Can_read'] = 'You must reply the post to read it.<br />You can read all contents now.';
$lang['Reply_info']['Cannot_read'] = 'The message has been hidden. You must login and/or reply to read.';
$lang['Reply_info']['Poster'] = 'Only the users replied after your post can see the hidden contents.';
$lang['Posts_info']['Can_read'] = 'You must have at least <b>%s</b> posts to read this post.<br />You can read all contents now.';
$lang['Posts_info']['Cannot_read'] = 'The message has been hidden. You must have at least <b>%s</b> posts to read this post.';
$lang['Posts_info']['Poster'] = 'Only the users with at least <b>%s</b> posts can see the hidden contents.';
$lang['Fortune_info']['Can_read'] = 'You must have at least <b>%s</b> to read this post.<br />You can read all contents now.';
$lang['Fortune_info']['Cannot_read'] = 'he message has been hidden. You must have at least <b>%s</b> to read this post.';
$lang['Fortune_info']['Poster'] = 'Only the users with at least <b>%s</b> can see the hidden contents.';

// validation check
$lang['Sorry_high']['Sale'] = 'Sorry, the price you specified <b>%s</b> is higher than the allowed maximum value: <b>%s</b>.';
$lang['Sorry_low']['Sale'] = 'Sorry, the price you specified <b>%s</b> is lower than the allowed minimum value: <b>%s</b>.';
$lang['Sorry_high']['Posts'] = 'Sorry, the amount of posts you required <b>%s</b> is higher than the allowed maximum value: <b>%s</b>.';
$lang['Sorry_low']['Posts'] = 'Sorry, the amount of posts you required <b>%s</b> is lower than the allowed minimum value: <b>%s</b>.';
$lang['Sorry_high']['Fortune'] = 'Sorry, the fortune you required <b>%s</b> is higher than the allowed maximum value: <b>%s</b>.';
$lang['Sorry_low']['Fortune'] = 'Sorry, the fortune you required <b>%s</b> is lower than the allowed minimum value: <b>%s</b>';
$lang['Sorry_auth']['Reply'] = 'Sorry, you are not authorized to hide the post for replying.';
$lang['Sorry_auth']['Sale'] = 'Sorry, you are not authorized to sell post.';
$lang['Sorry_auth']['Posts'] = 'Sorry, you are not authorized to hide the post for user\'s amount of posts.';
$lang['Sorry_auth']['Fortune'] = 'Sorry, you are not authorized to hide the post for user\'s fortune(Cash/Points).';
$lang['No_cash_system'] = 'Hiding for fortune(Cash/Points) is enabled. But the corresponding cash/points system cannot be found. Please contact with the site admin.';
$lang['No_valid_cash_type'] = 'Cannot find the specified cash/points. Please contact with the site admin.';
$lang['Invalid_hiding_type'] = 'Invalid hiding type.';

// Select hiding type when posting
$lang['Posting_desc']['Normal'] = 'Normal post';
$lang['Posting_desc']['Reply'] = 'Hide the post till user reply';
$lang['Posting_desc']['Sale'] = 'Sell the post with the price of';
$lang['Posting_desc']['Posts'] = 'Hide the post unless the reader\'s posts reach';
$lang['Posting_desc']['Fortune'] = 'Hide the post unless the reader have at least';

$lang['bbcode_y_help'] = 'Introduction: [intro]text[/intro] (alt+y)';

?>