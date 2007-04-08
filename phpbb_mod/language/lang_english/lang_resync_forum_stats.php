<?php

/*******************************************************************

 Name		: Resync Forum Statistics [English Language File]
 Copyright	: 2003, Adam Alkins
 Website	: http://www.rasadam.com
 email		: phpbb at rasadam dot com

 $Id: lang_resync_forum_stats.php,v 1.1 2003/07/16 02:03:46 rasadam Exp $: 

*******************************************************************/

/*******************************************************************

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the 
Free Software Foundation Inc., 59 Temple Place, Suite 330,
Boston, MA  02111-1307  USA

*******************************************************************/

$lang['Resync_page_title'] = 'Resync Forum Statistics';
$lang['Resync_page_desc_simple'] = "Welcome to the Resync Forum Statistics admin module addon. You are currently in <strong>simple mode</strong>. If you click the button below, this script will go through your database and set over; All your Forum's Topics and Posts counts as well as the last post made in a forum (as seen on the index), All Topic replies counts and the last post in each topic. If you would like to specify exactly which forums you want to resync and what exactly to resync, you should use the Advanced Mode."; 
$lang['Resync_page_desc_advanced'] = "Welcome to the Resync Forum Statistics admin module addon. You are currently in <strong>advanced mode</strong>. Below, you can specify exactly what you want to resync (both which forums and what do to). For very large boards, you may only want to do a couple of forums at a time."; 
$lang['Resync_all_ask'] = 'Resync all forums and their topics?';
$lang['Resync_options'] = 'Resync Options';
$lang['Resync_forum_topics'] = 'Forum Topics Count';
$lang['Resync_forum_posts'] = 'Forum Posts Count';
$lang['Resync_forum_last_post'] = 'Forum Last Post';
$lang['Resync_topic_replies'] = 'Topic Replies Counts';
$lang['Resync_topic_last_post'] = 'Topic Last Posts';
$lang['Resync_question'] = 'Resync?';
$lang['Resync_do'] = 'Start Resync';
$lang['Resync_redirect'] = '<br /><br />Return to the <a href="%s">Resync Forum Statistics</a><br /><br />Return to the <a href="%s">Admin Index</a>.';
$lang['Resync_completed'] = 'Congratulations, your forum(s) and their topic(s) are now in sync!';
$lang['Resync_no_forums'] = 'You have no forums to be resynced!';

?>