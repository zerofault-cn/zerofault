<?php

/*******************************************************************

 Name		: Prune User Posts [English Language]
 Copyright	: 2003, Adam Alkins
 Website	: http://www.rasadam.com
 email		: phpbb at rasadam dot com

 $Id: lang_prune_user_posts.php,v 1.4 2003/10/05 01:10:18 rasadam Exp $: 

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

$lang['Prune_user_posts'] = '清理用户贴子';
$lang['Prune_explain'] = '欢迎使用 phpbb 清理用户贴子的管理组件。这个工具可以使您以大范围的标准为基础删除论坛的贴子。';
$lang['Forums_to_prune'] = '清理版区';
$lang['Forums_to_prune_explain'] = '选择需要清理贴子的版区。您可以选择多个版区。（大论坛用户注意： 如果您要清理大量的贴子您最好最多选择两个版区）';
$lang['Users_to_prune'] = '清理用户的贴子';
$lang['Username_explain'] = '清理特定用户发的贴子';
$lang['All_users_explain'] = '清理所有用户的贴子';
$lang['Banned_users'] = '禁用的用户';
$lang['Banned_users_explain'] = '清理已经禁用的所有的用户的贴子(禁用列表的每一个)';
$lang['Group'] = '团队';
$lang['Group_explain'] = '清理体定团队的所有用户的贴子';
$lang['IP_explain'] = '清理特定IP地址 (xxx.xxx.xxx.xxx), 子网 (xxx.xxx.xxx.*) 或 范围 (xxx.xxx.xxx.xxx-yyy.yyy.yyy.yyy) 的贴子。 注意: 最后一段使用 .255 包含了这个子网的所有IP。 如果您输入 10.0.0.255，这和输入 10.0.0.* 是一样的（因此没有一个IP会被分配到 .255 ，这个是保留的）。当您遇到这个区域， 10.0.0.5-10.0.0.255 这和 "10.0.0.*" 作用是一样。您应该输入 10.0.0.5-10.0.0.254 。';
$lang['Banned_IPs'] = '屏蔽的IP地址';
$lang['Banned_IPs_explain'] = '清理屏蔽列表中所有IP所发的贴子。';
$lang['Guest_posters'] = '游客的贴子';
$lang['Guest_posters_explain'] = '清理游客发表的贴子（未登陆用户）。';
$lang['Date_criteria'] = '数据标准';
$lang['Before'] = '早于';
$lang['On'] = '在';
$lang['After'] = '晚于';
$lang['the_last'] = '过去的';
$lang['Seconds'] = '秒';
$lang['Minutes'] = '分';
$lang['By_time_explain'] = '基于上述的时间清理贴子。 请注意这里只支持整数，这里没有任何使用小数的理由。（如果您需要 .5 天, 输入 12 选择 小时).';
$lang['ddmmyyyy'] = '(dd/mm/yyyy)';
$lang['Date_explain'] = '基于上面的标准清理贴子。注意日其只能位于 1970 - 2038 内（4 位 unix 时间戳限制）';
$lang['to'] = '到';
$lang['Range_explain'] = '清理这两时间之间发布的贴子。日期同样受上面提到的限制影响。';
$lang['All_posts_explain'] = '不管是清理所有的贴子。';
$lang['Pruning_options'] = '清理选项';
$lang['Prune_remove_topics'] = '删除用户主题？';
$lang['Prune_remove_topics_explain'] = '如果您选择的用户发布了一个主题并且有其他用户的回复，您还要删除全部的主题吗？';
$lang['Exempt_stickies'] = '不包括置顶？';
$lang['Exempt_stickies_explain'] = '不删除置顶贴中的贴子。';
$lang['Exempt_announcements'] = '不包括公告？';
$lang['Exempt_announcements_explain'] = '不删除公告中的贴子。';
$lang['Exempt_open'] = '不包括开放主题？';
$lang['Exempt_open_explain'] = '不包括现在开放的主题。（选择了 是 就是只删除锁定的贴子）';
$lang['Exempt_polls'] = '不包括投票？';
$lang['Exempt_polls_explain'] = '不删除投票贴中的贴子。';
$lang['Adjust_post_counts'] = '调整贴子的计数？';
$lang['Adjust_post_counts_explain'] = '更新贴子数以表现已经进行了删除。';
$lang['Update_search'] = '更新搜索表？';
$lang['Update_search_explain'] = '是否从搜索表中移除贴子。如果您选择了 否 ，您将需要手动重建搜索表。您仅需要在如果您有一个非常大的论坛是应在一个非常慢的服务器上，并且清理大量的贴子事选择 否 。';

$lang['Prune_invalid_mode'] = '无法清理 - 错误模式';
$lang['Prune_invalid_IP'] = '提交了错误的IP地址';
$lang['Prune_invalid_date'] = '提交了错误的数据.';
$lang['Prune_invalid_range'] = '提交了错误的IP范围';
$lang['No_banned_IPs'] = '没有屏蔽的IP地址';
$lang['No_forums_selected'] = '无法开始清理 - 没有选择版区';
$lang['Prune_no_posts'] = '无法开始清理 - 没有需要清理的贴子';

$lang['Prune_finished'] = '清理成功的完成。<br /><br />返回 <a href="%s">清理用户的贴子</a> 页面，.<br /><br />返回 <a href="%s">控制台首页</a>.';


?>