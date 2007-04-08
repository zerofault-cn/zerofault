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

$lang['Resync_page_title'] = '同步论坛统计';
$lang['Resync_page_desc_simple'] = "欢迎使用同步论坛统计功能。您现在使用的是<strong>简单模式</strong>。如果您点击下面的按键，这个脚本将会查询数据库并且进行如下处理；您所有版面的主题和发贴数及最后发贴同步（在首页显示），所有主题的回复数和最新回复。如果您想要指定特定的版面和同步特定的内容，请使用高级模式。"; 
$lang['Resync_page_desc_advanced'] = "欢迎使用同步论坛统计功能。您现在使用的是<strong>高级模式</strong>。在下面，您可以指定同步特定的内容（包括哪些版面和需要做什么）。对于一个大型的论坛，最好一次处理一部分版面。"; 
$lang['Resync_all_ask'] = '同步所有的版面及其主题？';
$lang['Resync_options'] = '同步选项';
$lang['Resync_forum_topics'] = '版面主题数';
$lang['Resync_forum_posts'] = '版面帖子数';
$lang['Resync_forum_last_post'] = '版面最后发贴';
$lang['Resync_topic_replies'] = '主题回复数';
$lang['Resync_topic_last_post'] = '主题最后回复';
$lang['Resync_question'] = '同步？';
$lang['Resync_do'] = '开始同步';
$lang['Resync_redirect'] = '<br /><br />返回 <a href="%s">同步论坛统计工具</a><br /><br />返回 <a href="%s">管理员控制面板首页</a>';
$lang['Resync_completed'] = '您的版面及其主题已经同步成功！';
$lang['Resync_no_forums'] = '没有版面被同步！';

?>