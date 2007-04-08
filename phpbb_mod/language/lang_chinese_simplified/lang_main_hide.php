<?php
/***************************************************************************
 *                            lang_main_hide.php [chinese simplified]
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

$lang['Login_to_buy'] = '请先登陆再行购买';
$lang['Not_enough_cash'] = '您的 %s 不够购买此帖';
$lang['Buy_post_fail'] = '您购买帖子的 %s 已经付出，但无法成功购买，请与管理员联系';
$lang['Buy_post_success'] = '您已成功购买此帖';
$lang['Selling_price'] = '售价：';
$lang['Buy'] = '购买';
$lang['Not_for_sale'] = '本帖并没有出售，无需购买。';
$lang['Introduction'] = '隐藏部分的说明';

// messages used in hiding information box when reading a post
$lang['Sale_info']['Can_read'] = '您已经购买过该帖子';
$lang['Sale_info']['Cannot_read'] = '此帖内容已被隐藏，您必须购买后才能阅读。';
$lang['Sale_info']['Poster'] = '您正在出售此帖';
$lang['Reply_info']['Can_read'] = '此帖内容要求回复后才能阅读。<br />您现在可以阅读所有内容。';
$lang['Reply_info']['Cannot_read'] = '此帖内容已被隐藏，您必须登录并回复后才能阅读。';
$lang['Reply_info']['Poster'] = '只有在您之后回复了本主题的用户才能阅读您的帖子全部内容。';
$lang['Posts_info']['Can_read'] = '阅读此帖要求发帖数达到 <b>%s</b> 及以上。<br />您现在可以阅读所有内容。';
$lang['Posts_info']['Cannot_read'] = '此帖内容已被隐藏，您必须登录并且发帖数超过 <b>%s</b> 才能阅读全文。';
$lang['Posts_info']['Poster'] = '只有发帖数达到 <b>%s</b> 及以上的用户才能阅读您的帖子全部内容。';
$lang['Fortune_info']['Can_read'] = '阅读此帖要求现金数达到 <b>%s</b> 及以上。<br />您现在可以阅读所有内容。';
$lang['Fortune_info']['Cannot_read'] = '此帖内容已被隐藏，您必须登录并且现金数超过 <b>%s</b> 才能阅读全文。';
$lang['Fortune_info']['Poster'] = '只有现金数达到 <b>%s</b> 及以上的用户才能阅读您的帖子全部内容。';

// validation check
$lang['Sorry_high']['Sale'] = '对不起，您指定的售价 <b>%s</b> 超出了论坛允许的上限：<b>%s</b>';
$lang['Sorry_low']['Sale'] = '对不起，您指定的售价 <b>%s</b> 超出了论坛允许的下限：<b>%s</b>';
$lang['Sorry_high']['Posts'] = '对不起，您要求的发帖数 <b>%s</b> 超出了论坛允许的上限：<b>%s</b>';
$lang['Sorry_low']['Posts'] = '对不起，您要求的发帖数 <b>%s</b> 超出了论坛允许的下限：<b>%s</b>';
$lang['Sorry_high']['Fortune'] = '对不起，您要求的现金数 <b>%s</b> 超出了论坛允许的上限：<b>%s</b>';
$lang['Sorry_low']['Fortune'] = '对不起，您要求的现金数 <b>%s</b> 超出了论坛允许的下限：<b>%s</b>';
$lang['Sorry_auth']['Reply'] = '对不起，您无权要求用户必须回复才能看帖';
$lang['Sorry_auth']['Sale'] = '对不起，您无权出售帖子';
$lang['Sorry_auth']['Posts'] = '对不起，您无权要求用户有一定的发帖数才能看帖';
$lang['Sorry_auth']['Fortune'] = '对不起，您无权要求用户有一定的现金才能看帖';
$lang['No_cash_system'] = '论坛打开了出售帖子/要求现金数看帖的功能，但却找不到现金/积分系统，请与论坛管理员联系。';
$lang['No_valid_cash_type'] = '找不到指定的有效现金，请与论坛管理员联系。';
$lang['Invalid_hiding_type'] = '指定的隐藏方式无效。';

// Select hiding type when posting
$lang['Posting_desc']['Normal'] = '普通帖子';
$lang['Posting_desc']['Reply'] = '隐藏此帖，除非用户发表回复';
$lang['Posting_desc']['Sale'] = '出售此帖，售价：';
$lang['Posting_desc']['Posts'] = '隐藏此帖，除非用户发帖数达到：';
$lang['Posting_desc']['Fortune'] = '隐藏此帖，除非用户现金数达到：';

$lang['bbcode_y_help'] = '隐藏内容介绍: [intro]text[/intro] (alt+y)';

?>