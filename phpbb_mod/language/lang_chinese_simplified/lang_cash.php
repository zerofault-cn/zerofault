<?php 

/*************************************************************************** 
*                            lang_cash.php [chinese simplified] 
*                              ------------------- 
*     begin                : Sat Jul 20 2003 
*     copyright            : (C) 2003 BlueSky_Ray 
*     email                : blue_sky_ray@hotmail.com 
* 
*     $Id: lang_cash.php,v 1.0.0.0 2003/10/08 00:55:17 Xore Exp $ 
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

// 
// Admin menu 
// 
$lang['Cmcat_main'] = '主要功能'; 
$lang['Cmcat_addons'] = '附加功能'; 
$lang['Cmcat_other'] = '其他'; 
$lang['Cmcat_help'] = '帮助'; 

$lang['Cash_Configuration'] = '基本设置'; 
$lang['Cash_Currencies'] = '货币设置'; 
$lang['Cash_Exchange'] = '兑换'; 
$lang['Cash_Events'] = '事件'; 
$lang['Cash_Forums'] = '版区权限'; 
$lang['Cash_Groups'] = '群组'; 
$lang['Cash_Help'] = '帮助'; 
$lang['Cash_Logs'] = '记录'; 
$lang['Cash_Settings'] = '细节设置';
$lang['Cash_Reset'] = '重设'; 

$lang['Cmenu_cash_config'] = '所有货币的基本设定'; 
$lang['Cmenu_cash_currencies'] = '增加，删除或，再定义货币'; 
$lang['Cmenu_cash_settings'] = '每一个货币的特殊设定'; 
$lang['Cmenu_cash_events'] = '在用户事件给用户的货币总额'; 
$lang['Cmenu_cash_reset'] = '重整 / 重设货币总额'; 
$lang['Cmenu_cash_exchange'] = '开启 / 关闭货币兑换以及兑换比率'; 
$lang['Cmenu_cash_forums'] = '设定每一个版块开启或关闭货币于'; 
$lang['Cmenu_cash_groups'] = '设定群组，等级，头衔的货币'; 
$lang['Cmenu_cash_log'] = '查看 / 删除已纪录的货币设定动作'; 
$lang['Cmenu_cash_help'] = '虚拟货币帮助'; 

// Config 
$lang['Cash_config'] = '虚拟货币'; 
$lang['Cash_config'] = '虚拟货币管理选项'; 

$lang['Cash_admincp'] = '管理后台显示模式'; 
$lang['Cash_adminnavbar'] = '显示上方选单'; 
$lang['Sidebar'] = '新式选单'; 
$lang['Menu'] = '旧式选单'; 

$lang['Messages'] = '讯息'; 
$lang['Spam'] = '灌水'; 
$lang['Click_return_cash_config'] = '点选%s这里%s回到虚拟货币管理选项'; 
$lang['Cash_config_updated'] = '虚拟货币管理选项设定完成'; 
$lang['Cash_disabled'] = '关闭虚拟现金模组'; 
$lang['Cash_message'] = '在发表/回复确认画面显示赚取金额'; 
$lang['Cash_display_message'] = '会员赚取金额时显示的讯息'; 
$lang['Cash_display_message_explain'] = '其中必须包含一个"%s"';$lang['Cash_spam_disable_num'] = '发文达此数量时(防止灌水)'; 
$lang['Cash_spam_disable_time'] = '多少时间内到达此发文数量停止获得虚拟货币 (小时)'; 
$lang['Cash_spam_disable_message'] = '给过量发文者停止获得虚拟货币的通告'; 


// Currencies 
$lang['Cash_currencies'] = '流通货币'; 
$lang['Cash_currencies_explain'] = '以下表格可以设定您的论坛流通货币'; 

$lang['Click_return_cash_currencies'] = '点选%s这里%s回到流通货币管理选项'; 
$lang['Cash_currencies_updated'] = '流通货币管理选项设定完成'; 
$lang['Cash_field'] = '栏位'; 
$lang['Cash_currency'] = '货币'; 
$lang['Name_of_currency'] = '货币名称'; 
$lang['Default'] = '预设'; 
$lang['Cash_order'] = '顺序'; 
$lang['Cash_set_all'] = '设定所有人金钱至此量'; 
$lang['Cash_delete'] = '删除货币'; 
$lang['Decimals'] = '小数位数目'; 

$lang['Cash_confirm_copy'] = '复制用户%s所有资料到%s?<br />执行后是无法复原的'; 
$lang['Cash_confirm_delete'] = '删除%s?<br />执行后是无法复原的'; 

$lang['Cash_copy_currency'] = '复制货币资料';
$lang['Cash_copy_from'] = '从'; 
$lang['Cash_copy_to'] = '复制到'; 

$lang['Cash_new_currency'] = '开新货币'; 
$lang['Cash_currency_dbfield'] = '货币的资料库栏位'; 
$lang['Cash_currency_decimals'] = '货币的小数位数目'; 
$lang['Cash_currency_default'] = '货币的开始值'; 

$lang['Bad_dbfield'] = '错误的资料库栏位名称, 必须是如下的。<br /><br />%s<br /><br/>例如:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />'; 

// 0 currencies (most admin panels won't work... ) 
$lang['Insufficient_currencies'] = '您设定之前必须开新货币'; 

// 
// Add-ons ? 
// 

// Events 
$lang['Cash_events'] = '事件'; 
$lang['Cash_events_explain'] = '您可以设定一个事件，当您执行此事件可以增加 / 减少用户一定的货币'; 

$lang['No_events'] = '没有事件'; 
$lang['Existing_events'] = '事件'; 
$lang['Add_an_event'] = '增加事件'; 
$lang['Cash_events_updated'] = '事件设定完成'; 
$lang['Click_return_cash_events'] = '点选%s这里%s回到事件设定'; 

//Reset 
$lang['Cash_reset_title'] = '重设'; 
$lang['Cash_reset_explain'] = '您可以重设所有用户现有的货币'; 

$lang['Cash_resetting'] = '重设中'; 
$lang['User_of'] = '%s个用户于个%s用户'; 

$lang['Set_checked'] = '设定重设货币于这个数值'; 
$lang['Recount_checked'] = '所有货币重新开始'; 

$lang['Cash_confirm_reset'] = '货币将要重设?<br />执行后是无法复原的'; 
$lang['Cash_confirm_recount'] = '所有货币将重新开始?<br />执行后是无法复原的。<br /><br />这个动作不适用于有大数值货币的用户 或/和 主题。<br /><br />建议您先关闭您的虚拟货币。<br />关闭您的虚拟货币可到%s基本设定%s'; 

$lang['Update_successful'] = '更新完成'; 
$lang['Click_return_cash_reset'] = '点选%s这里%s回到货币重设'; 
$lang['User_updated'] = '%s 已更新<br />'; 

// 
// Others 
// 

// Exchange 
$lang['Cash_exchange'] = '兑换'; 
$lang['Cash_exchange_explain'] = '您可以设定以及开启您货币兑换的设定'; 

$lang['Exchange_insufficient_currencies'] = '您没有一个以上的货币<br />您至少有两种或以上货币'; 

// Forums 
$lang['Forum_cm_settings'] = '版区权限'; 
$lang['Forum_cm_settings_explain'] = '您可以开启 / 关闭版区是否可以增加用户货币'; 

// Groups 
$lang['Cash_groups'] = '群组设定'; 
$lang['Cash_groups_explain'] = '您可以设定每一个群组可得的货币数量等等的设定'; 

$lang['Click_return_cash_groups'] = '点选%s这里%s回到群组设定'; 
$lang['Cash_groups_updated'] = '群组设定更新完成'; 

$lang['Set'] = '设定'; 
$lang['Up'] = '上'; 
$lang['Down'] = '下'; 

// Help 
$lang['Cmh_support'] = 'Cash Mod支援'; 
$lang['Cmh_troubleshooting'] = '排解疑难'; 
$lang['Cmh_upgrading'] = '升级'; 
$lang['Cmh_addons'] = '附加功能'; 
$lang['Cmh_demo_boards'] = '演示'; 
$lang['Cmh_translations'] = '语系翻译'; 
$lang['Cmh_features'] = 'Cash Mod 资讯'; 

$lang['Cmhe_support'] = 'Cash Mod 的资料'; 
$lang['Cmhe_troubleshooting'] = '如果您有问题，您可以在这里来修正您的Cash Mod'; 
$lang['Cmhe_upgrading'] = '您的版本是%s，最新版本会帖在这里'; 
$lang['Cmhe_addons'] = 'Cash Mod 的附加功能一览'; 
$lang['Cmhe_demo_boards'] = 'Cash Mod 的演示论坛一览'; 
$lang['Cmhe_translations'] = 'Cash Mod 的语系一览'; 
$lang['Cmhe_features'] = 'Cash Mod 的版本资讯'; 

// Logs 
$lang['Logs'] = '纪录'; 
$lang['Logs_explain'] = '您可以看到您曾经更改货币的纪录'; 

// Settings 
$lang['Cash_settings'] = '设定'; 
$lang['Cash_settings_explain'] = '您可以设定您的每个货币在论坛中的仔细设定'; 


$lang['Display'] = '显示'; 
$lang['Implementation'] = '货币加减设定'; 
$lang['Allowances'] = '定期货币加减设定'; 
$lang['Allowances_explain'] = '定期货币加减设定是Cash Mod定期货币加减外挂'; 
$lang['Click_return_cash_settings'] = '这里%s这里%s回到细部设定'; 
$lang['Cash_settings_updated'] = '细部设定更新完成'; 

$lang['Cash_enabled'] = '开启货币'; 
$lang['Cash_custom_currency'] = '货币的名称'; 
$lang['Cash_image'] = '货币名称以图片显示'; 
$lang['Cash_imageurl'] = '图片 (PHPBB的根目录):'; 
$lang['Cash_imageurl_explain'] = '使用后您的货币名称将变成图片'; 
$lang['Prefix'] = '字首'; 
$lang['Postfix'] = '字尾'; 
$lang['Cash_currency_style'] = '图片显示风格'; 
$lang['Cash_currency_style_explain'] = '显示于 ' . $lang['Prefix'] . ' 或 ' . $lang['Postfix']; 
$lang['Cash_display_usercp'] = '在个人资料中显示拥有金额'; 
$lang['Cash_display_userpost'] = '在文章旁简介中显示拥有金额'; 
$lang['Cash_display_memberlist'] = '在会员列表显示拥有金额'; 

$lang['Cash_amount_per_post'] = '每篇发文可获得的金额 (开新主题)'; 
$lang['Cash_amount_post_bonus'] = '每篇回文中开题作者可得到的红利金额'; 
$lang['Cash_amount_per_reply'] = '每篇回文可获得的金额'; 
$lang['Cash_amount_per_character'] = '每个字元可获得的金额'; 
$lang['Cash_maxearn'] = '每篇发文可获得金额最大值'; 
$lang['Cash_include_quotes'] = '引言是否包含在字元计算中'; 
$lang['Cash_allow_donate'] = '允许会员将金钱赠送给其它会员'; 
$lang['Cash_allow_mod_edit'] = '允许版面管理员修改会员持有的现金'; 
$lang['Cash_allow_negative'] = '允许会员呈现负债'; 
$lang['Cash_amount_per_pm'] = '私人讯息是否可获得的金额'; 
$lang['Cash_exchangeable'] = '允许用户可以兑换此货币'; 

$lang['Cash_allowance_enabled'] = '开始定期货币加减'; 
$lang['Cash_allowance_amount'] = '可得到货币总额'; 
$lang['Cash_allownace_frequency'] = '得到货币时期'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = '日'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = '星期'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = '月'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = '年'; 
$lang['Cash_allowance_next'] = '下一次定期货币加减时间相距'; 

// Groups 
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = '预设'; 
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = '预设'; 
$lang['Cash_status_type'][CASH_GROUPS_OFF] = '关闭'; 
$lang['Cash_status'] = 'Status'; 

// Cash Mod Log Text 
// Note: there isn't really a whole lot i can do about it, if languages use a 
// grammar that requires these arguments (%s) to be in a different order, it's stuck in 
// this order. The up side is that this is about 10x more comprehensive than the 
// last way i did it. 
// 

/* argument order: [donater id][donater name][currency list][receiver id][receiver name] 

eg. 
Joe donated 14 gold, $10, 3 points to Peter 
*/ 
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> donated <b>%s</b> to <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>'; 

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list] 

eg. 
Joe modified Peter's Cash: 
Added 14 gold 
Removed $10 
Set 3 points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> edited <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>\'s Cash:<br />Added <b>%s</b><br />Removed <b>%s</b><br />Set to <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][currency name] 

eg. 
Joe created points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> created <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][currency name] 

eg. 
Joe deleted $ 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> deleted <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name] 

eg. 
Joe renamed silver to gold 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> renamed <b>%s</b> to <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name] 

eg. 
Joe copied users' gold to points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> copied users\' <b>%s</b> to <b>%s</b>'; 

$lang['Log'] = '记录'; 
$lang['Action'] = '动作'; 
$lang['Type'] = '种类'; 
$lang['Cash_all'] = '所有'; 
$lang['Cash_admin'] = '管理员'; 
$lang['Cash_user'] = '用户'; 
$lang['Delete_all_logs'] = '删除所有纪录'; 
$lang['Delete_admin_logs'] = '删除管理员纪录'; 
$lang['Delete_user_logs'] = '删除用户纪录'; 
$lang['All'] = '全部'; 
$lang['Day'] = '日'; 
$lang['Week'] = '星期'; 
$lang['Month'] = '月'; 
$lang['Year'] = '年'; 
$lang['Page'] = '页'; 
$lang['Per_page'] = '每页'; 

// 
// Now for some regular stuff... 
// 

// 
// User CP 
// 
$lang['Donate'] = '赠与货币'; 
$lang['Mod_usercash'] = '修改%s货币'; 
$lang['Exchange'] = '兑换';
$lang['Exchange_from'] = '从'; 
$lang['Exchange_to'] = '兑换成'; 

// 
// Exchange 
// 
$lang['Convert'] = '兑换金额';
$lang['Select_one'] = '选择'; 
$lang['Exchange_lack_of_currencies'] = '您没有可以足够兑换的一种以上货币<br />如果您要兑换的话，管理员必须发行两种货币以上。'; 
$lang['You_have'] = '您共有'; 
$lang['One_worth'] = '一个 %s 价值:'; 
$lang['Cannot_exchange'] = '现在您不能兑换 %s'; 

// 
// Donate 
// 
$lang['Amount'] = '总额'; 
$lang['Donate_to'] = '赠与 %s'; 
$lang['Donation_recieved'] = '您收到了 %s 赠与的货币。'; 
$lang['Has_donated'] = '%s 赠与 %s 给您。 \n\n%s 对您说:\n'; 

// 
// Mod Edit 
// 
$lang['Add'] = '增加'; 
$lang['Remove'] = '移除'; 
$lang['Omit'] = '忽略'; 
$lang['Amount'] = '总额'; 
$lang['Donate_to'] = '赠与 %s'; 
$lang['Has_moderated'] = '%s 修改您的 %s'; 
$lang['Has_added'] = '[*]增加: %s \n'; 
$lang['Has_removed'] = '[*]移除: %s \n'; 
$lang['Has_set'] = '[*]设为: %s \n'; 

// For xore's Cash MOD 2
$lang['Max_sellingprice'] = '帖子售价上限';
$lang['Min_sellingprice'] = '帖子售价下限';
$lang['Max_fortune_required'] = '现金数要求值上限';
$lang['Min_fortune_required'] = '现金数要求值下限';
$lang['Cash_max_price_explain'] = '出售帖子时可以设定本币种售价的最大值。<br />设为0则受按总体设置中的相关设定值限制。<br />这个值可以为负，但负数基本上没有实际意义。<br /><b>请注意小数位数目设置的影响</b>。';
$lang['Cash_min_price_explain'] = '出售帖子时可以设定本币种售价的最小值。<br />设为0则受按总体设置中的相关设定值限制。<br />这个值可以为负，但负数基本上没有实际意义。<br /><b>请注意小数位数目设置的影响</b>。';
$lang['Cash_max_fortune_explain'] = '发此类帖时，本币种可以设置的所需现金数的最大值。<br />设为0则受按总体设置中的相关设定值限制。<br />这个值可以为负，但负数基本上没有实际意义。<br /><b>请注意小数位数目设置的影响</b>。';
$lang['Cash_min_fortune_explain'] = '发此类帖时，本币种可以设置的所需现金数的最小值。<br />设为0则受按总体设置中的相关设定值限制。<br />这个值可以为负，但负数基本上没有实际意义。<br /><b>请注意小数位数目设置的影响</b>。';

// That's all folks! 

?>