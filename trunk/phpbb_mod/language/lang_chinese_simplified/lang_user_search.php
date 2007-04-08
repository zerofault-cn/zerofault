<?php

/***************************************************************************
 *                            lang_user_search.php (English)
 *                              -------------------
 *     begin                : Sat Apr 10, 2004
 *     copyright            : (C) 2004 Adam Alkins
 *     email                : phpbb at rasadam dot com
 *	   $Id: lang_user_search.php,v 1.10 2004/12/31 05:26:54 rasadam Exp $
 *    
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

$lang['Search_invalid_username'] = '在搜索时输入了错误的用户名';
$lang['Search_invalid_email'] = '在搜索时输入了错误的电子邮件信箱';
$lang['Search_invalid_ip'] = '在搜索时输入了错误的IP地址';
$lang['Search_invalid_group'] = '在搜索时输入了错误的用户组';
$lang['Search_invalid_date'] = '在搜索时输入了错误的日期';
$lang['Search_invalid_postcount'] = '在搜索时输入了错误的发贴数';
$lang['Search_invalid_userfield'] = '在搜索时输入了错误的用户资料数据';
$lang['Search_invalid_lastvisited'] = '在最后访问搜索时所入了错误的数据';
$lang['Search_invalid_language'] = '选择的语言错误';
$lang['Search_invalid_style'] = '选择的版面风格错误';
$lang['Search_invalid_timezone'] = '选择的时区错误';
$lang['Search_invalid_moderators'] = '选择的讨论区错误';
$lang['Search_invalid'] = '搜索错误';
$lang['Search_invalid_day'] = '您输入的日期（日）是错误的';
$lang['Search_invalid_month'] = '您输入的日期（月）是错误的';
$lang['Search_invalid_year'] = '您输入的日期（年）是错误的';
$lang['Search_no_regexp'] = '您的数据库不支持正规表达式搜索。';
$lang['Search_for_username'] = '搜索的用户名为 %s';
$lang['Search_for_email'] = '搜索的电子邮件信箱为 %s';
$lang['Search_for_ip'] = '搜索的IP地址为 %s';
$lang['Search_for_date'] = '搜索的用户注册时间为 %s %d/%d/%d';
$lang['Search_for_group'] = '搜索的用户组 %s 中的会员';
$lang['Search_for_banned'] = '搜索的已禁用的用户';
$lang['Search_for_admins'] = '搜索的管理员';
$lang['Search_for_mods'] = '搜索的版主';
$lang['Search_for_disabled'] = '搜索的未激活会员';
$lang['Search_for_disabled_pms'] = '搜索的关闭站内短信的会员';
$lang['Search_for_postcount_greater'] = '搜索的发贴数多余 %d 的会员';
$lang['Search_for_postcount_lesser'] = '搜索的发贴数少于 %d 的会员';
$lang['Search_for_postcount_range'] = '搜索的发贴数在 %d 到 %d 之间的用户';
$lang['Search_for_postcount_equals'] = '搜索的发贴数为 %d 的用户';
$lang['Search_for_userfield_icq'] = '搜索的使用QQ（ICQ）为 %s 的用户';
$lang['Search_for_userfield_yahoo'] = '搜索的使用Yahoo IM为 %s 的用户';
$lang['Search_for_userfield_aim'] = '搜索的使用QQ为 %s 的用户';
$lang['Search_for_userfield_msn'] = '搜索的使用MSN Messenger为 %s 的用户';
$lang['Search_for_userfield_website'] = '搜索的个人网站地址为 %s 的用户';
$lang['Search_for_userfield_location'] = '搜索的来自 %s 的用户';
$lang['Search_for_userfield_interests'] = '搜索的兴趣为 %s 的用户';
$lang['Search_for_userfield_occupation'] = '搜索的职业为 %s 的用户';
$lang['Search_for_lastvisited_inthelast'] = '搜索的在最近 %s %s 访问的用户';
$lang['Search_for_lastvisited_afterthelast'] = '搜索的早于最近 %s %s 访问的用户';
$lang['Search_for_language'] = '搜索的将语言设置为 %s 的用户';
$lang['Search_for_timezone'] = '搜索的将时区设置为 %s 的用户';
$lang['Search_for_style'] = '搜索的将版面风格设置为 %s 的用户';
$lang['Search_for_moderators'] = '搜索的这个讨论区的版主 -> %s';
$lang['Search_users_advanced'] = '高级用户搜索';
$lang['Search_users_explain'] = '这个模块允许您在一个较宽的范围内对用户进行高级搜索。请阅读每一个域下面的说明以明白每一个搜索选项的作用。';
$lang['Search_username_explain'] = '在这里您可以执行一个对于用户名非严格规范的搜索。如果您想要匹配用户名中的一部分，使用 *（星号）作为通配符。选择正则表达式复选框可以允许您基于正则表达式进行搜索。 <strong>说明：</strong> 正则表达式只可以在 MySQL, PostgreSQL 和 Oracle 10g+ 中使用。';
$lang['Search_email_explain'] = '输入一个表达式来匹配用户的电子邮件信箱地址。这个搜索的规范是非严格的。如果您想进行部分匹配，使用 *（星号）作为通配符。选择正则表达式复选框可以允许您基于正则表达式进行搜索。 <strong>说明：</strong> 正则表达式只可以在 MySQL, PostgreSQL 和 Oracle 10g+ 中使用。';
$lang['Search_ip_explain'] = '搜索使用特定IP地址(xxx.xxx.xxx.xxx)发贴的用户，允许通配符 (xxx.xxx.xxx.*) 或范围 (xxx.xxx.xxx.xxx-yyy.yyy.yyy.yyy)。 说明: 最后四分之一是 .255 表示所有在这个子网内的IP地址。如果您输入 10.0.0.255，这等同于输入 10.0.0.* （没有IP会使用 .255 ，这是一个保留数字）。 如果您输入这样一个范围10.0.0.5-10.0.0.255这是和"10.0.0.*"效果是一样的。 正确的方法是10.0.0.5-10.0.0.254。';
$lang['Search_users_joined'] = '用户注册时间';
$lang['Search_users_lastvisited'] = '用户访问';
$lang['in_the_last'] = '最近';
$lang['after_the_last'] = '早于最近';
$lang['Before'] = '之前';
$lang['After'] = '之后';
$lang['Search_users_joined_explain'] = '搜索注册时间早于或者晚于（包含）特定日期的用户。时间格式是 YYYY/MM/DD.';
$lang['Search_users_groups_explain'] = '查看选择的用户组中所有的成员。';
$lang['Administrators'] = '管理员';
$lang['Banned_users'] = '已禁用的用户';
$lang['Disabled_users'] = '未激活的用户';
$lang['Users_disabled_pms'] = '关闭PM功能的用户';
$lang['Search_users_misc_explain'] = '管理员 - 所有拥有管理员权力的用户；版主 - 所有讨论区的版主；已禁用的用户 -所有被论坛禁用的帐户；未激活用户 - 所有帐号未被激活的用户（包含手动设置或没有进行电子邮件信箱认证)；关闭PM功能的用户 - PM权限被关闭的用户（使用管理选项功能管理）';
$lang['Postcount'] = '发贴数';
$lang['Equals'] = '等于';
$lang['Greater_than'] = '多于';
$lang['Less_than'] = '少于';
$lang['Search_users_postcount_explain'] = '您可以基于发贴数对用户进行搜索。您可以选择特定的值、多于、少于或者在两个值之间作为标准进行搜索。 在做一定范围内的搜索时，选择“等于”将开始的的值和结束的值中间使用一个横线 (-)分开，例如 10-15';
$lang['Userfield'] = '用户资料';
$lang['Search_users_userfield_explain'] = '基于不同的个人资料域搜索用户。 支持使用星号（*）作为通配符。选择正则表达式复选框可以允许您基于正则表达式进行搜索。 <strong>说明：</strong> 正则表达式只可以在 MySQL, PostgreSQL 和 Oracle 10g+ 中使用。';
$lang['Search_users_lastvisited_explain'] = '使用这个搜索选项您可以基于用户的最后登陆时间进行搜索';
$lang['Search_users_language_explain'] = '显示在他们的个人资料中选择了特定语言的用户';
$lang['Search_users_timezone_explain'] = '在他们的个人资料中选择了特定时区的用户';
$lang['Search_users_style_explain'] = '显示选择了特定版面风格的用户。';
$lang['Moderators_of'] = '版主';
$lang['Search_users_moderators_explain'] = '搜索特定讨论区中拥有版主权限的用户。版主权限包含设置了用户权限或者在一个有正确权限的用户组之中。';
$lang['Regular_expression'] = '正则表达式?';

$lang['Manage'] = '管理';
$lang['Search_users_new'] = '%s 获得 %d 结果。进行<a href="%s">其他的搜索</a>.';
$lang['Banned'] = '已禁用';
$lang['Not_banned'] = '未禁用';
$lang['Search_no_results'] = '没有用户匹配您所选择的标准。请尝试其他的搜索。如果您搜索的是用户名或者电子邮件信箱，对于局部的匹配必须使用通配符 *（星号）。';
$lang['Account_status'] = '帐号状态';
$lang['Sort_options'] = '分类选项：';
$lang['Last_visit'] = '最近访问';
$lang['Day'] = '天';

?>