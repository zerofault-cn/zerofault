<?php
/***************************************************************************
 *                            lang_main.php [中文]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_main.php,v 1.85.2.15 2003/06/10 00:31:19 psotfx Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License，or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// 简体中文 由phpBB中文开发小组修改完成  http://www.cnphpbb.com
//最后更新 2005-01-25

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//



$lang['ENCODING'] = 'gb2312';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';    
$lang['DATE_FORMAT'] =  'Y/m/d'; // This should be changed to the default date format for your language，php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
// $lang['TRANSLATION'] = '';

//
// Common，these terms are used
// extensively on several pages
//
$lang['Forum'] = '论坛';
$lang['Category'] = '分区';
$lang['Topic'] = '主题';
$lang['Topics'] = '主题';
$lang['Replies'] = '回复';
$lang['Views'] = '阅读';
$lang['Post'] = '文章';
$lang['Posts'] = '文章';
$lang['Posted'] = '时间';
$lang['Username'] = '会员名';
$lang['Password'] = '密码';
$lang['Email'] = '电子邮件';
$lang['Poster'] = '发表者';
$lang['Author'] = '作者';
$lang['Time'] = '时间';
$lang['Hours'] = '小时';
$lang['Message'] = '正文';

$lang['1_Day'] = '1天';
$lang['7_Days'] = '7天';
$lang['2_Weeks'] = '2周';
$lang['1_Month'] = '1个月';
$lang['3_Months'] = '3个月';
$lang['6_Months'] = '6个月';
$lang['1_Year'] = '1年';

$lang['Go'] = '确定';
$lang['Jump_to'] = '论坛转跳';
$lang['Submit'] = '提交';
$lang['Reset'] = '重填';
$lang['Cancel'] = '取消';
$lang['Preview'] = '预览';
$lang['Confirm'] = '确定';
$lang['Spellcheck'] = '拼写检查';
$lang['Yes'] = '是';
$lang['No'] = '否';
$lang['Enabled'] = '允许';
$lang['Disabled'] = '禁止';
$lang['Error'] = '错误';

$lang['Next'] = '下一页';
$lang['Previous'] = '上一页';
$lang['Goto_page'] = '分页';
$lang['Joined'] = '加入时间';
$lang['IP_Address'] = 'IP地址';

$lang['Select_forum'] = '选择一个论坛';
$lang['View_latest_post'] = '浏览最新的文章';
$lang['View_newest_post'] = '浏览最新的文章';
$lang['Page_of'] = '第<b>%d</b>页，共<b>%d</b>页'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ号码';
$lang['AIM'] = 'AIM地址';
$lang['MSNM'] = 'MSN';
$lang['YIM'] = '雅虎讯息通';
$lang['SKYPE'] = 'Skype';
$lang['Forum_Index'] = '%s首页';  // eg.sitename Forum Index，%s can be removed if you prefer

$lang['Post_new_topic'] = '发表新主题';
$lang['Reply_to_topic'] = '回复主题';
$lang['Reply_with_quote'] = '引用回复';

$lang['Click_return_topic'] = '点击%s这里%s返回主题'; // %s's here are for uris，do not remove！
$lang['Click_return_login'] = '点击%s这里%s再试一次';
$lang['Click_return_forum'] = '点击%s这里%s返回论坛';
$lang['Click_view_message'] = '点击%s这里%s阅读您的文章';
$lang['Click_return_modcp'] = '点击%s这里%s返回版主管理区';
$lang['Click_return_group'] = '点击%s这里%s返回团队信息区';

$lang['Admin_panel'] = '管理员控制面板';

$lang['Board_disable'] = '对不起，本论坛系统暂时不能访问，请稍候再试。';


//
// Global Header strings
//
$lang['Registered_users'] = '注册会员：';
$lang['Browsing_forum'] = '浏览本论坛的会员：';
$lang['Online_users_zero_total'] = '目前共有 <b>0</b> 位朋友在线 :: ';
$lang['Online_users_total'] = '目前共有 <b>%d</b> 位朋友在线 :: ';
$lang['Online_user_total'] = '目前共有 <b>%d</b> 位朋友在线 :: ';
$lang['Reg_users_zero_total'] = '没有会员，';
$lang['Reg_users_total'] = '%d 位会员，';
$lang['Reg_user_total'] = '%d 位会员，';
$lang['Hidden_users_zero_total'] = '没有隐身会员';
$lang['Hidden_user_total'] = '%d 位隐身会员';
$lang['Hidden_users_total'] = '%d 位隐身会员';
$lang['Guest_users_zero_total'] = '，没有游客';
$lang['Guest_users_total'] = '和 %d 位游客';
$lang['Guest_user_total'] = '和 %d 位游客';
$lang['Record_online_users'] = "最高在线纪录是 <b>%s</b> 人 %s"; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%s论坛管理员%s';
$lang['Mod_online_color'] = '%s版主%s';

$lang['You_last_visit'] = '您上次访问时间是%s'; // %s replaced by date/time
$lang['Current_time'] = '现在的时间是%s'; // %s replaced by time

$lang['Search_new'] = '阅读新文章';
$lang['Search_your_posts'] = '阅读您发表的文章';
$lang['Search_unanswered'] = '阅读尚未回复的主题';

$lang['Register'] = '注册';
$lang['Profile'] = '个人资料';
$lang['Edit_profile'] = '编辑您的个人资料';
$lang['Search'] = '搜索';
$lang['Memberlist'] = '会员列表';
$lang['FAQ'] = '帮助';
$lang['BBCode_guide'] = 'BBCode 代码说明';
$lang['Usergroups'] = '团队';
$lang['Last_Post'] = '最新文章';
$lang['Moderator'] = '版主';
$lang['Moderators'] = '版主';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = '目前还没有文章'; // Number of posts
$lang['Posted_articles_total'] = '共有 <b>%d</b> 篇文章'; // Number of posts
$lang['Posted_article_total'] = '共有 <b>%d</b> 篇文章'; // Number of posts
$lang['Registered_users_zero_total'] = '目前还没有注册会员'; // # registered users
$lang['Registered_users_total'] = '共有 <b>%d</b> 位注册会员'; // # registered users
$lang['Registered_user_total'] = '共有 <b>%d</b> 位注册会员'; // # registered users
$lang['Newest_user'] = '最新注册的会员是<b>%s%s%s</b>'; // a href，username，/a 

$lang['No_new_posts_last_visit'] = '上次访问后没有新文章';
$lang['No_new_posts'] = '没有新文章';
$lang['New_posts'] = '有新文章';
$lang['New_post'] = '有新文章';
$lang['No_new_posts_hot'] = '没有新文章 [ 热门 ]';
$lang['New_posts_hot'] = '有新文章 [ 热门 ]';
$lang['No_new_posts_locked'] = '没有新文章 [ 关闭 ]';
$lang['New_posts_locked'] = '有新文章 [ 关闭 ]';
$lang['Forum_is_locked'] = '关闭的论坛';


//
// Login
//
$lang['Enter_password'] = '请输入您的会员名和密码登录';
$lang['Login'] = '登录';
$lang['Logout'] = '注销';

$lang['Forgotten_password'] = '我忘记了密码';

$lang['Log_me_in'] = '自动登录';

$lang['Error_login'] = '您提供的会员名或密码不正确';


//
// Index page
//
$lang['Index'] = '首页';
$lang['No_Posts'] = '没有文章';
$lang['No_forums'] = '这个论坛还没有文章';

$lang['Private_Message'] = '站内短信';
$lang['Private_Messages'] = '站内短信';
$lang['Who_is_Online'] = '当前在线状态';

$lang['Mark_all_forums'] = '标记所有论坛为已读';
$lang['Forums_marked_read'] = '所有论坛已标记为已读';


//
// Viewforum
//
$lang['View_forum'] = '浏览论坛';

$lang['Forum_not_exist'] = '您选择的论坛不存在';
$lang['Reached_on_error'] = '您选择的论坛出错了';

$lang['Display_topics'] = '显示主题';
$lang['All_Topics'] = '所有的文章';

$lang['Topic_Announcement'] = '<b>声明:</b>';
$lang['Topic_Sticky'] = '<b>置顶:</b>';
$lang['Topic_Moved'] = '<b>移动:</b>';
$lang['Topic_Poll'] = '<b>[投票]</b>';

$lang['Mark_all_topics'] = '标记所有文章为已读';
$lang['Topics_marked_read'] = '这个论坛的所有文章已标记为已读';

$lang['Rules_post_can'] = '您<b>可以</b>在本论坛发表新主题';
$lang['Rules_post_cannot'] = '您<b>不能</b>在本论坛发表新主题';
$lang['Rules_reply_can'] = '您<b>可以</b>在本论坛回复主题';
$lang['Rules_reply_cannot'] = '您<b>不能</b>在本论坛回复主题';
$lang['Rules_edit_can'] = '您<b>可以</b>在本论坛编辑自己的文章';
$lang['Rules_edit_cannot'] = '您<b>不能</b>在本论坛编辑自己的文章';
$lang['Rules_delete_can'] = '您<b>可以</b>在本论坛删除自己的文章';
$lang['Rules_delete_cannot'] = '您<b>不能</b>在本论坛删除自己的文章';
$lang['Rules_vote_can'] = '您<b>可以</b>在本论坛发表投票';
$lang['Rules_vote_cannot'] = '您<b>不能</b>在本论坛发表投票';
$lang['Rules_moderate'] = '您<b>可以</b>%s管理%s本论坛'; // %s replaced by a href links，do not remove！ 

$lang['No_topics_post_one'] = '这个论坛里还没有文章<br />点击<b>发表新贴</b>发表第一篇文章';


//
// Viewtopic
//
$lang['View_topic'] = '阅读主题';

$lang['Guest'] = '游客';
$lang['Post_subject'] = '标题';
$lang['View_next_topic'] = '阅读下一个主题';
$lang['View_previous_topic'] = '阅读上一个主题';
$lang['Submit_vote'] = '投票';
$lang['View_results'] = '查看结果';

$lang['No_newer_topics'] = '这个论坛没有更新的主题';
$lang['No_older_topics'] = '这个论坛没有更旧的主题';
$lang['Topic_post_not_exist'] = '您选择的主题或文章不存在';
$lang['No_posts_topic'] = '这个主题里没有回复文章';

$lang['Display_posts'] = '显示文章';
$lang['All_Posts'] = '所有文章';
$lang['Newest_First'] = '时间逆序';
$lang['Oldest_First'] = '时间顺序';

$lang['Back_to_top'] = '返回顶端';

$lang['Read_profile'] = '阅读会员资料'; 
$lang['Send_email'] = '给会员发电子邮件';
$lang['Visit_website'] = '浏览发表者的主页';
$lang['ICQ_status'] = 'ICQ状态';
$lang['Edit_delete_post'] = '编辑/删除文章';
$lang['View_IP'] = '查看作者IP';
$lang['Delete_post'] = '删除这篇文章';

$lang['wrote'] = '写道'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = '引用'; // comes before BBCode quote output.
$lang['Code'] = '代码'; // comes before BBCode code output.

$lang['Edited_time_total'] = '上一次由%s于%s修改，总共修改了%d次'; // Last edited by me on 12 Oct 2001，edited 1 time in total
$lang['Edited_times_total'] = '上一次由%s于%s修改，总共修改了%d次'; // Last edited by me on 12 Oct 2001，edited 2 times in total

$lang['Lock_topic'] = '锁定主题';
$lang['Unlock_topic'] = '解除锁定';
$lang['Move_topic'] = '移动主题';
$lang['Delete_topic'] = '删除主题';
$lang['Split_topic'] = '分割主题';

$lang['Stop_watching_topic'] = '取消订阅这个主题(回复通知)';
$lang['Start_watching_topic'] = '订阅这个主题 (回复通知)';
$lang['No_longer_watching'] = '此后当本主题有新的回复时，系统不会再发送电子邮件请通知您。';
$lang['You_are_watching'] = '此后当本主题有新的回复时，系统会自动发送电子邮件请通知您。';

$lang['Total_votes'] = '总投票数';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = '正文';
$lang['Topic_review'] = '主题回顾';

$lang['No_post_mode'] = '没有指定发表模式'; // If posting.php is called without a mode (newtopic/reply/delete/etc，shouldn't be shown normaly)

$lang['Post_a_new_topic'] = '发表新主题';
$lang['Post_a_reply'] = '发表回复';
$lang['Post_topic_as'] = '发表主题为';
$lang['Edit_Post'] = '编辑文章';
$lang['Options'] = '选项';

$lang['Post_Announcement'] = '公告';
$lang['Post_Sticky'] = '置顶';
$lang['Post_Normal'] = '普通';

$lang['Confirm_delete'] = '您确定要删除这篇文章吗？';
$lang['Confirm_delete_poll'] = '您确定要删除这个投票吗？';

$lang['Flood_Error'] = '您发表文章速度过快，请稍候再试。';
$lang['Empty_subject'] = '您发表的文章必须有一个主题。';
$lang['Empty_message'] = '您发表的文章必须有内容。';
$lang['Forum_locked'] = '这个论坛已经被锁定，您不能发表，回复或者编辑文章。';
$lang['Topic_locked'] = '这个主题已经被锁定，您不能发表，回复或者编辑文章。';
$lang['No_post_id'] = '请选择您要编辑的主题';
$lang['No_topic_id'] = '请选择您要回复的主题';
$lang['No_valid_mode'] = '您只可以选择发表，回复或者引用文章，请后退重试。';
$lang['No_such_post'] = '没有符合的文章，请后退重试。';
$lang['Edit_own_posts'] = '对不起!您只可以编辑自己的文章。';
$lang['Delete_own_posts'] = '对不起!您只可以删除自己的文章。';
$lang['Cannot_delete_replied'] = '对不起!您不可以删除已经有回复文章的主题。';
$lang['Cannot_delete_poll'] = '对不起!您不可以删除正处于活动状态的投票。';
$lang['Empty_poll_title'] = '您必须给您发表的投票建立一个主题。';
$lang['To_few_poll_options'] = '您必须要建立至少两个投票的选项。';
$lang['To_many_poll_options'] = '您选择建立太多的投票的选项';
$lang['Post_has_no_poll'] = '这个主题没有建立投票';
$lang['Already_voted'] = '您已经投过票了';
$lang['No_vote_option'] = '请指定一个投票选项';

$lang['Add_poll'] = '建立一个投票';
$lang['Add_poll_explain'] = '如果您不想建立投票请不要填写这个选项。';
$lang['Poll_question'] = '投票问题';
$lang['Poll_option'] = '投票选项';
$lang['Add_option'] = '建立选项';
$lang['Update'] = '更新';
$lang['Delete'] = '删除';
$lang['Poll_for'] = '投票持续时间';
$lang['Days'] = '天'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[选择0或者不选择这个选项表示投票永远有效]';
$lang['Delete_poll'] = '删除投票';

$lang['Disable_HTML_post'] = '在这篇文章里禁止HTML标签';
$lang['Disable_BBCode_post'] = '在这篇文章里禁止BBCode 代码功能';
$lang['Disable_Smilies_post'] = '在这篇文章里禁止表情符号';

$lang['HTML_is_ON'] = '<u>允许</u>HTML标签';
$lang['HTML_is_OFF'] = '<u>禁止</u>HTML标签';
$lang['BBCode_is_ON'] = '<u>允许</u>%s风格标签%s'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '<u>禁止</u>%s风格标签%s';
$lang['Smilies_are_ON'] = '<u>允许</u>表情图标';
$lang['Smilies_are_OFF'] = '<u>禁止</u>表情图标';

$lang['Attach_signature'] = '附加签名（您的签名可以在个人资料里更改）';
$lang['Notify'] = '有人回复时发送电子邮件提醒我';
$lang['Delete_post'] = '删除这篇文章';

$lang['Stored'] = '您的文章已经成功发表';
$lang['Deleted'] = '您的文章已经成功删除';
$lang['Poll_delete'] = '您建立的投票已经成功删除';
$lang['Vote_cast'] = '感谢您参与投票';

$lang['Topic_reply_notification'] = '主题回复通知';

$lang['bbcode_b_help'] = '粗体: [b]文字[/b]  (alt+b)';
$lang['bbcode_i_help'] = '斜体: [i]文字[/i]  (alt+i)';
$lang['bbcode_u_help'] = '下划线: [u]文字[/u]  (alt+u)';
$lang['bbcode_q_help'] = '引用文字: [quote]文字[/quote]  (alt+q)';
$lang['bbcode_c_help'] = '程序代码: [code]代码[/code]  (alt+c)';
$lang['bbcode_l_help'] = '列表: [list]文字[/list] (alt+l)';
$lang['bbcode_o_help'] = '顺序列表: [list=]文字[/list]  (alt+o)';
$lang['bbcode_p_help'] = '插入图像: [img]http://image_url[/img]  (alt+p)';
$lang['bbcode_w_help'] = '插入URL: [url]http://url[/url] 或 [url=http://url]URL文字[/url]  (alt+w)';
$lang['bbcode_a_help'] = '关闭所有开启的 BBCode 标签';
$lang['bbcode_s_help'] = '字体颜色: [color=red]文字[/color]  提示：您可以使用 color=#FF0000';
$lang['bbcode_f_help'] = '字体大小: [size=x-small]小字体文字[/size]';

$lang['Emoticons'] = '表情符号';
$lang['More_emoticons'] = '更多表情符号';

$lang['Font_color'] = '字体颜色';
$lang['color_default'] = '标准';
$lang['color_dark_red'] = '深红';
$lang['color_red'] = '红色';
$lang['color_orange'] = '橙色';
$lang['color_brown'] = '棕色';
$lang['color_yellow'] = '黄色';
$lang['color_green'] = '绿色';
$lang['color_olive'] = '橄榄';
$lang['color_cyan'] = '青色';
$lang['color_blue'] = '蓝色';
$lang['color_dark_blue'] = '深蓝';
$lang['color_indigo'] = '靛蓝';
$lang['color_violet'] = '紫色';
$lang['color_white'] = '白色';
$lang['color_black'] = '黑色';

$lang['Font_size'] = '字体大小';
$lang['font_tiny'] = '最小';
$lang['font_small'] = '小';
$lang['font_normal'] = '标准';
$lang['font_large'] = '大';
$lang['font_huge'] = '最大';

$lang['Close_Tags'] = '结束标签';
$lang['Styles_tip'] = '提示：选择您需要装饰的文字，按上列按钮即可添加上相应的。';


//
// Private Messaging
//
$lang['Private_Messaging'] = '站内短信';

$lang['Login_check_pm'] = '登录并检查站内短信';
$lang['New_pms'] = '您有%d条新的站内短信'; // You have 2 new messages
$lang['New_pm'] = '您有%d条新的站内短信'; // You have 1 new message
$lang['No_new_pm'] = '站内短信';
$lang['Unread_pms'] = '您有%d条未读的站内短信';
$lang['Unread_pm'] = '您有%d条未读的站内短信';
$lang['No_unread_pm'] = '您没有未读的站内短信';
$lang['You_new_pm'] = '您的收件箱里有一条新的站内短信';
$lang['You_new_pms'] = '您的收件箱里有数条新的站内短信';
$lang['You_no_new_pm'] = '您没有新的短信';

$lang['Unread_message'] = '未阅读的短信';
$lang['Read_message'] = '阅读短信';

$lang['Read_pm'] = '阅读短信';
$lang['Post_new_pm'] = '发送短信';
$lang['Post_reply_pm'] = '恢复短信';
$lang['Post_quote_pm'] = '引用短信';
$lang['Edit_pm'] = '编辑短信';

$lang['Inbox'] = '收件夹';
$lang['Outbox'] = '寄件夹';
$lang['Savebox'] = '储存夹';
$lang['Sentbox'] = '已发件';
$lang['Flag'] = '状态';
$lang['Subject'] = '主题';
$lang['From'] = '来自';
$lang['To'] = '发件人';
$lang['Date'] = '日期';
$lang['Mark'] = '选择';
$lang['Sent'] = '已发送';
$lang['Saved'] = '保存';
$lang['Delete_marked'] = '删除选择的短信';
$lang['Delete_all'] = '删除所有的短信';
$lang['Save_marked'] = '保存选择的短信'; 
$lang['Save_message'] = '保存短信';
$lang['Delete_message'] = '删除短信';

$lang['Display_messages'] = '显示以前的短信'; // Followed by number of days/weeks/months
$lang['All_Messages'] = '所有的站内短信';

$lang['No_messages_folder'] = '这个文件夹里没有短信';

$lang['PM_disabled'] = '本论坛的站内短信功能已经被关闭';
$lang['Cannot_send_privmsg'] = '对不起论坛管理员禁止您发送站内短信';
$lang['No_to_user'] = '您必须指定站内短信发送的对象';
$lang['No_such_user'] = '对不起这个会员不存在';

$lang['Disable_HTML_pm'] = '在这则短信里禁止HTML语言';
$lang['Disable_BBCode_pm'] = '在这则短信里禁止风格标签';
$lang['Disable_Smilies_pm'] = '在这则短信里禁止表情符号';

$lang['Message_sent'] = '您的站内短信发送成功';

$lang['Click_return_inbox'] = '点击%s这里%s返回您的收件夹';
$lang['Click_return_index'] = '点击%s这里%s返回首页';

$lang['Send_a_new_message'] = '发送一个新的站内短信';
$lang['Send_a_reply'] = '回复站内短信';
$lang['Edit_message'] = '编辑站内';

$lang['Notification_subject'] = '新的站内短信';

$lang['Find_username'] = '会员查询';
$lang['Find'] = '查找';
$lang['No_match'] = '找不到符合的会员';

$lang['No_post_id'] = '没有指定主题';
$lang['No_such_folder'] = '没有这样的文件夹存在';
$lang['No_folder'] = '没有指定文件夹';

$lang['Mark_all'] = '选择所有短信';
$lang['Unmark_all'] = '取消所有选择';

$lang['Confirm_delete_pm'] = '您确定要删除这则站内短信吗？';
$lang['Confirm_delete_pms'] = '您确定要删除这些站内短信吗？';

$lang['Inbox_size'] = '您的收件夹已使用了%d%%'; // eg.Your Inbox is 50% full
$lang['Sentbox_size'] = '您的寄件夹已使用了%d%%'; 
$lang['Savebox_size'] = '您的储存夹已使用了%d%%'; 

$lang['Click_view_privmsg'] = '点击%s这里%s浏览您的收件夹';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = '浏览 :: %s的个人资料'; // %s is username 
$lang['About_user'] = '关于 %s'; // %s is username

$lang['Preferences'] = '选项';
$lang['Items_required'] = '带 * 的项目是必须填写的，除非特殊说明';
$lang['Registration_info'] = '注册信息';
$lang['Profile_info'] = '个人资料';
$lang['Profile_info_warn'] = '注意，以下信息将被公开';
$lang['Avatar_panel'] = '头像控制面板';
$lang['Avatar_gallery'] = '头像画册';

$lang['Website'] = '个人主页';
$lang['Location'] = '来自';
$lang['Contact'] = '联络';
$lang['Email_address'] = '电子邮件地址';
$lang['Email'] = '电子邮件';
$lang['Send_private_message'] = '发送站内短信';
$lang['Hidden_email'] = '[ 隐藏 ]';
$lang['Search_user_posts'] = '搜索会员的所有文章';
$lang['Interests'] = '兴趣爱好';
$lang['Occupation'] = '职业'; 
$lang['Poster_rank'] = '会员级别';

$lang['Total_posts'] = '发表文章';
$lang['User_post_pct_stats'] = '发表文章占论坛总文章数的%.2f%%'; // 1.25% of total
$lang['User_post_day_stats'] = '平均每天%.2f篇文章'; // 1.5 posts per day
$lang['Search_user_posts'] = '查找%s发表的所有文章'; // Find all posts by username

$lang['No_user_id_specified'] = '对不起这个会员不存在';
$lang['Wrong_Profile'] = '您不可以编辑去他会员的个人资料';

$lang['Only_one_avatar'] = '您只能选择一个头像';
$lang['File_no_data'] = '您提供的连接地址不存在数据';
$lang['No_connection_URL'] = '无法连接您提供的连接地址';
$lang['Incomplete_URL'] = '您提供的连接地址不完整';
$lang['Wrong_remote_avatar_format'] = '您提供的头像连接地址无效';
$lang['No_send_account_inactive'] = '对不起无法找回您的密码因为您的帐号目前处于停用状态，请联络论坛管理员得到更多的信息。';

$lang['Always_smile'] = '使用表情符号';
$lang['Always_html'] = '使用HTML标签';
$lang['Always_bbcode'] = '使用 BBCode 代码';
$lang['Always_add_sig'] = '在文章内附加我的个性签名';
$lang['Always_notify'] = '当有人回复我的文章提醒我';
$lang['Always_notify_explain'] = '当有人回复我的文章时发送一封电子邮件提醒我。在您发表主题时还可以更改这个选项';

$lang['Board_style'] = '论坛风格';
$lang['Board_lang'] = '论坛语言';
$lang['No_themes'] = '数据库里没有装饰主题';
$lang['Timezone'] = '时区';
$lang['Date_format'] = '日期格式';
$lang['Date_format_explain'] = '日期格式的语法和 PHP <a href=\'http://www.php.net/date\' target=\'_other\'>date() 语句</a> 一致';
$lang['Signature'] = '个性签名';
$lang['Signature_explain'] = '您填写的个性签名自动附带在您的发表的文章底部。个性签名有%d个字符的限制。';
$lang['Public_view_email'] = '公开我的电子邮件地址';

$lang['Current_password'] = '当前的密码';
$lang['New_password'] = '新密码';
$lang['Confirm_password'] = '密码确认';
$lang['Confirm_password_explain'] = '如果您要修改密码或者电子邮件地址，您必须确认您的当前密码';
$lang['password_if_changed'] = '只有当您希望更改密码时才需要提供现在使用的密码';
$lang['password_confirm_if_changed'] = '只有当您希望更改密码时才需要确认新的密码';

$lang['Avatar'] = '头像';
$lang['Avatar_explain'] = '您的个人头像将会显示在您所发表的文章旁边，同一时间只能显示一个图片。图片宽度不能超过%d像素，高度不能超过%d像素，图片大小不能超过%dkB。';
$lang['Upload_Avatar_file'] = "从您的计算机上传图片";
$lang['Upload_Avatar_URL'] = '从一个链接上传图片';
$lang['Upload_Avatar_URL_explain'] = '提供一个图片的链接地址，图片将被复制到本论坛。';
$lang['Pick_local_Avatar'] = '从画册集里选择一个头像';
$lang['Link_remote_Avatar'] = '链接其他位置的头像';
$lang['Link_remote_Avatar_explain'] = '提供您想链接头像图像的地址';
$lang['Avatar_URL'] = '图片链接地址';
$lang['Select_from_gallery'] = '从画册里选择一个头像';
$lang['View_avatar_gallery'] = '显示画册';

$lang['Select_avatar'] = '选择头像';
$lang['Return_profile'] = '取消选择头像';
$lang['Select_category'] = '选择一个画册';

$lang['Delete_Image'] = '删除图片';
$lang['Current_Image'] = '现在使用的图片';

$lang['Notify_on_privmsg'] = '新的站内短信提示';
$lang['Popup_on_privmsg'] = '当有新的站内短信时弹出窗口'; 
$lang['Popup_on_privmsg_explain'] = '当您有新的站内短信时将弹出一个新的小窗口来提醒您'; 
$lang['Hide_user'] = '隐藏我的在线状态';

$lang['Profile_updated'] = '您的个人资料已经更新';
$lang['Profile_updated_inactive'] = '您的个人资料已经更新。但是由于您更改了账号状态，您的账号现在处于冻结状态。查看您的电子邮件理解如何重新激活您的账号。如果论坛规定需要管理员激活，请等待管理员重新激活您的账号。';

$lang['Password_mismatch'] = '您提供的密码不匹配';
$lang['Current_password_mismatch'] = '您现在使用的密码与注册时提供的不匹配';
$lang['Password_long'] = '您的密码不能超过32个英文字符，或者16个汉字';
$lang['Too_many_registers'] = '您已进行太多的注册尝试. 请稍后重试.';
$lang['Username_taken'] = '对不起，您的会员名已被使用';
$lang['Username_invalid'] = '对不起，会员名不能包含非法字符，例如 \'';
$lang['Username_disallowed'] = '对不起，您选择的会员名被系统禁用';
$lang['Email_taken'] = '对不起，您的电子邮件地址已被另一个成员使用';
$lang['Email_banned'] = '对不起，您的电子邮件地址已被系统禁止';
$lang['Email_invalid'] = '对不起，您的电子邮件地址格式无效';
$lang['Signature_too_long'] = '您的个性签名太长了';
$lang['Fields_empty'] = '您必须填写必填项目(*)';
$lang['Avatar_filetype'] = '头像图片的类型必须是 .jpg，.gif 或 .png';
$lang['Avatar_filesize'] = '头像图片的大小必须小于%dkB'; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = '头像图片的宽度必须小于%d像素而且高度必须小于%d像素'; 

$lang['Welcome_subject'] = '欢迎访问%s论坛系统'; // Welcome to my.com forums
$lang['New_account_subject'] = '新会员帐户';
$lang['Account_activated_subject'] = '账号激活';

$lang['Account_added'] = '感谢您注册。您的账号已经被建立。您现在就可以使用您的会员名和密码登录。';
$lang['Account_inactive'] = '感谢您注册，您的账号已经被建立。但是本论坛需要激活账号。请查看您的电子邮件了解更多的信息。';
$lang['Account_inactive_admin'] = '感谢您注册，您的账号已经被建立。但是本论坛需要论坛管理员手动激活账号。系统已经给管理员发送了电子邮件。您的账号被激活时您将收到通知。';
$lang['Account_active'] = '感谢您注册，您的账号已经被建立。';
$lang['Account_active_admin'] = '账号现在已经被成功激活';
$lang['Reactivate'] = '重新激活您的账号！';
$lang['Already_activated'] = '您的账号已经激活了';
$lang['COPPA'] = '您的账号已经被建立但是需要被批准，请查看您的电子邮件了解详细信息。';

$lang['Registration'] = '注册服务条款';
$lang['Reg_agreement'] = '尽管论坛管理成员会尽可能尽快删除或编辑有争议或是不健康的文章，但是他们不可能阅读所有的文章内容。因此您因该承认这个论坛上所有的主题只由它的发表者承担责任，而不是论坛的管理成员们（除非是由他们发表的）。<br /><br />您必需同意不发表带有辱骂，淫秽，粗俗，诽谤，带有仇恨性，恐吓的，不健康的或是任何违反法律的内容。如果您这样做将导致您的账号将立即和永久性的被封锁。(您的网络服务提供商也会被通知)。在这个情况下，这个IP地址的所有会员都将被记录。您必须同意系统管理成员们有在任何时间删除，修改，移动或关闭任何主题的权力。作为一个使用者，您必须同意您所提供的任何资料都将被存入数据库中，这些资料除非有您的同意，系统管理员们绝不会对第三方公开，然而我们不能保证任何可能导致资料泄露的骇客入侵行为。<br /><br />这个讨论区系统使用cookie来储存您的个人信息(在您使用的本地计算机)，这些cookie不包含任何您曾经输入过的信息，它们只为了方便您能更方便的浏览。电子邮件地址只用来确认您的注册和发送密码使用。(如果您忘记了密码，将会发送新密码的地址)<br /><br />点击下面的链接代表您同意受到这些服务条款的约束。';

$lang['Agree_under_13'] = '我同意以上条文(但是我<b>未满13岁</b>)';
$lang['Agree_over_13'] = '我同意以上条文(而且我<b>已满13岁</b>)';
$lang['Agree_not'] = '我不同意';

$lang['Wrong_activation'] = '您提供的激活密码和数据库中的不匹配';
$lang['Send_password'] = '发送一个新的激活密码给我'; 
$lang['Password_updated'] = '一个新的激活密码已经被建立，请查看您的电子邮件了解如何激活';
$lang['No_email_match'] = '您提供的电子邮件地址和数据库中的不匹配';
$lang['New_password_activation'] = '新密码激活';
$lang['Password_activated'] = '您的账号已经被重新激活。请使用您收到的电子邮件中的密码登录';

$lang['Send_email_msg'] = '发送一封电子邮件';
$lang['No_user_specified'] = '没有选择会员';
$lang['user_prevent_email'] = '这名会员不希望收到电子邮件，您可以发送站内短信给这名会员';
$lang['user_not_exist'] = '会员不存在';
$lang['CC_email'] = '将这封电子邮件的一份副本发送给自己';
$lang['Email_message_desc'] = '这封邮件将被以纯文本格式发送，请不要包含任何HTML或者风格标签。这篇邮件的回复地址将指向您的电子邮件地址。';
$lang['Flood_email_limit'] = '您不能现在发送其他的电子邮件，请过一会再试。';
$lang['Recipient'] = '收信人';
$lang['Email_sent'] = '邮件已经被发送';
$lang['Send_email'] = '发送电子邮件';
$lang['Empty_subject_email'] = '您的电子邮件必须拥有一个主题';
$lang['Empty_message_email'] = '您必须填写电子邮件征文内容';


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = '您输入的确认码不正确';
$lang['Too_many_registers'] = '您超出了同一时间内重复尝试的最大次数. 请稍后重试.';
$lang['Confirm_code_impaired'] = '如果您视力有问题或是无法读出这些代码请与管理员联系取得帮助.';
$lang['Confirm_code'] = '确认码';
$lang['Confirm_code_explain'] = '输入您看到的确认码. 代码是区分大小写的，同时，数字0会有一条线穿过以与字母O区别.';
// Memberslist
//
$lang['Select_sort_method'] = '请选择一种排序方法';
$lang['Sort'] = '排列';
$lang['Sort_Top_Ten'] = '十大排行';
$lang['Sort_Joined'] = '注册日期';
$lang['Sort_Username'] = '会员名';
$lang['Sort_Location'] = '来自地区';
$lang['Sort_Posts'] = '发表文章总数';
$lang['Sort_Email'] = '电子邮件';
$lang['Sort_Website'] = '个人主页';
$lang['Sort_Ascending'] = '递增';
$lang['Sort_Descending'] = '递减';
$lang['Order'] = '顺序';


//
// Group control panel
//
$lang['Group_Control_Panel'] = '团队控制面板';
$lang['Group_member_details'] = '团队成员细节';
$lang['Group_member_join'] = '加入一个团队';

$lang['Group_Information'] = '团队信息';
$lang['Group_name'] = '团队名称';
$lang['Group_description'] = '团队描述';
$lang['Group_membership'] = '团队成员';
$lang['Group_Members'] = '团队成员';
$lang['Group_Moderator'] = '团队管理员';
$lang['Pending_members'] = '审核中的成员';

$lang['Group_type'] = '团队类型';
$lang['Group_open'] = '开放团队';
$lang['Group_closed'] = '封闭团队';
$lang['Group_hidden'] = '隐形团队';

$lang['Current_memberships'] = '目前的成员';
$lang['Non_member_groups'] = '无成员的团队';
$lang['Memberships_pending'] = '审核中的成员';

$lang['No_groups_exist'] = '没有团队存在';
$lang['Group_not_exist'] = '不存在这个团队';

$lang['Join_group'] = '加入团队';
$lang['No_group_members'] = '这个团队没有成员';
$lang['Group_hidden_members'] = '这个团队处于隐藏状态，您不能浏览它的成员';
$lang['No_pending_group_members'] = '这个团队不存在审核中成员';
$lang['Group_joined'] = '您已经申请加入这个团队，<br />当您的申请通过审核您将受到提醒';
$lang['Group_request'] = '加入这个团队的申请已经建立';
$lang['Group_approved'] = '您的申请已经被批准了';
$lang['Group_added'] = '您已经被加入这个团队'; 
$lang['Already_member_group'] = '您已经是这个团队的成员';
$lang['user_is_member_group'] = '会员已经是这个团队的成员';
$lang['Group_type_updated'] = '成功更新团队类型';

$lang['Could_not_add_user'] = '您选择的会员不存在';
$lang['Could_not_anon_user'] = '您不能将访客列为团队成员';

$lang['Confirm_unsub'] = '您确定要从这个团队解除申请吗？';
$lang['Confirm_unsub_pending'] = '您的团队申请还没有被批准，您确定要解除申请吗？';

$lang['Unsub_success'] = '您已经从这个团队解除了申请。';

$lang['Approve_selected'] = '批准选择';
$lang['Deny_selected'] = '拒绝选择';
$lang['Not_logged_in'] = '您必须首先登录方能加入团队。';
$lang['Remove_selected'] = '删除选择';
$lang['Add_member'] = '增加成员';
$lang['Not_group_moderator'] = '您不是这个团队的管理员，您无法执行团队的管理功能。';

$lang['Login_to_join'] = '欲加入或者管理团队成员，请先登录';
$lang['This_open_group'] = '这是一个开放的团队，点击申请成员';
$lang['This_closed_group'] = '这是一个关闭的团队，不接受新的成员';
$lang['This_hidden_group'] = '这是一个隐藏的团队，不允许自动增加成员';
$lang['Member_this_group'] = '您是这个团队的成员';
$lang['Pending_this_group'] = '您的申请正在审核中';
$lang['Are_group_moderator'] = '您是团队管理员';
$lang['None'] = '无';

$lang['Subscribe'] = '申请';
$lang['Unsubscribe'] = '取消申请';
$lang['View_Information'] = '查看信息';


//
// Search
//
$lang['Search_query'] = '搜索目标';
$lang['Search_options'] = '搜索选项';

$lang['Search_keywords'] = '搜索关键字';
$lang['Search_keywords_explain'] = '您可以使用<u>AND</u>来标记您希望结果里必须出现的关键字，或者使用<u>OR</u>来标记您希望结果里可能出现的关键字和<u>NOT</u>来标记您不希望结果里出现的关键字。使用通配符 * 标记批量符合的结果';
$lang['Search_author'] = '搜索作者';
$lang['Search_author_explain'] = '使用通配符 * 批量符合的结果';

$lang['Search_for_any'] = '搜索符合以上任一关键字的资料';
$lang['Search_for_all'] = '搜索符合以上所有关键字的资料';
$lang['Search_title_msg'] = '搜索主题标题和文章内容';
$lang['Search_msg_only'] = '仅搜索文章内容';

$lang['Return_first'] = '显示最先的'; // followed by xxx characters in a select box
$lang['characters_posts'] = '个符合的项目';

$lang['Search_previous'] = '搜索以前的文章'; // followed by days，weeks，months，year，all in a select box

$lang['Sort_by'] = '排序方法';
$lang['Sort_Time'] = '发表时间';
$lang['Sort_Post_Subject'] = '主题';
$lang['Sort_Topic_Title'] = '文章标题';
$lang['Sort_Author'] = '作者';
$lang['Sort_Forum'] = '论坛';

$lang['Display_results'] = '显示模式';
$lang['All_available'] = '所有';
$lang['No_searchable_forums'] = '您没有搜索文章的权限';

$lang['No_search_match'] = '没有符合您要求的主题或文章';
$lang['Found_search_match'] = '搜索到 %d 个符合的内容'; // eg。Search found 1 match
$lang['Found_search_matches'] = '搜索到 %d 个符合的内容'; // eg。Search found 24 matches

$lang['Close_window'] = '关闭窗口';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = '对不起，只有%s可以在这个论坛发表公告';
$lang['Sorry_auth_sticky'] = '对不起，只有%s可以在这个论坛发表置顶文章'; 
$lang['Sorry_auth_read'] = '对不起，只有%s可以在这个论坛浏览主题'; 
$lang['Sorry_auth_post'] = '对不起，只有%s可以在这个论坛发表主题'; 
$lang['Sorry_auth_reply'] = '对不起，只有%s可以在这个论坛回复主题'; 
$lang['Sorry_auth_edit'] = '对不起，只有%s可以在这个论坛编辑主题'; 
$lang['Sorry_auth_delete'] = '对不起，只有%s可以在这个论坛删除主题'; 
$lang['Sorry_auth_vote'] = '对不起，只有%s可以在这个论坛发表投票'; 

// These replace the %s in the above strings
$lang['Auth_Anonymous_users'] = '<b>游客</b>';
$lang['Auth_Registered_users'] = '<b>注册会员</b>';
$lang['Auth_users_granted_access'] = '<b>特殊会员</b>';
$lang['Auth_Moderators'] = '<b>版主</b>';
$lang['Auth_Administrators'] = '<b>论坛管理员</b>';

$lang['Not_Moderator'] = '您没有管理这个版面的权力';
$lang['Not_Authorised'] = '未经授权';

$lang['You_been_banned'] = '这个论坛已经禁止您访问<br />请联络论坛管理员了解细节';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = "现在有 0 位注册有户和 "; // There ae 5 Registered and
$lang['Reg_users_online'] = "现在有 %d 位注册有户和 "; // There ae 5 Registered and
$lang['Reg_user_online'] = "现在有 %d 位注册有户和 "; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = "0 位隐身用户和"; // 6 Hidden users online
$lang['Hidden_users_online'] = "%d 位隐身用户在线"; // 6 Hidden users online
$lang['Hidden_user_online'] = "%d 位隐身用户在线"; // 6 Hidden users online
$lang['Guest_users_online'] = "现在有 %d 位游客在线"; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = "现在有 0 位注册用户在线"; // There are 10 Guest users online
$lang['Guest_user_online'] = "现在有 %d 位游客在线"; // There is 1 Guest user online
$lang['No_users_browsing'] = "现在没有用户在这个论坛浏览";

$lang['Online_explain'] = "这是5分钟之内的论坛在线情况";
$lang['linkfriend']= "友情论坛";
$lang['Forum_Location'] = '论坛位置';
$lang['Last_updated'] = '最近更新';

$lang['Forum_index'] = '论坛系统首页';
$lang['Logging_on'] = '登录';
$lang['Posting_message'] = '发表文章';
$lang['Searching_forums'] = '搜索论坛';
$lang['Viewing_profile'] = '查看个人资料';
$lang['Viewing_online'] = '浏览在线情况';
$lang['Viewing_member_list'] = '浏览成员列表';
$lang['Viewing_priv_msgs'] = '阅读站内短信';
$lang['Viewing_FAQ'] = '阅读常见问题解答';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = '版主控制面板';
$lang['Mod_CP_explain'] = '使用以下的选项您可以在这个论坛运行众多论坛管理操作。您可以关闭，开放，移动或者删除任意数量的主题。';

$lang['Select'] = '选择';
$lang['Delete'] = '删除';
$lang['Move'] = '移动';
$lang['Lock'] = '锁定';
$lang['Unlock'] = '解锁';

$lang['Topics_Removed'] = '选择的主题已经成功地从数据库中删除';
$lang['Topics_Locked'] = '选择的主题已经成功的锁定';
$lang['Topics_Moved'] = '选择的主题已经成功的移动';
$lang['Topics_Unlocked'] = '选择的主题已经成功的解除锁定';
$lang['No_Topics_Moved'] = '没有主题被移动';

$lang['Confirm_delete_topic'] = '您确定要删除选择的主题吗？';
$lang['Confirm_lock_topic'] = '您确定要锁定选择的主题吗？';
$lang['Confirm_unlock_topic'] = '您确定要解锁选择的主题吗？';
$lang['Confirm_move_topic'] = '您确定要移动选择的主题吗？';

$lang['Move_to_forum'] = '移动到另一个论坛';
$lang['Leave_shadow_topic'] = '复制主题保留在旧论坛';

$lang['Split_Topic'] = '主题分割控制面板';
$lang['Split_Topic_explain'] = '使用以下的选项您可以分割文章变成两个，您可以选择分割一个或多篇文章';
$lang['Split_title'] = '新主题名';
$lang['Split_forum'] = '要分割主题到新的论坛';
$lang['Split_posts'] = '分割选择的文章';
$lang['Split_after'] = '分割自选择以下的文章(包含选择的文章)';
$lang['Topic_split'] = '选择的文章已经成功地分割';

$lang['Too_many_error'] = '您选择了太多的文章。您只能选择一篇文章来分割以下的文章！';

$lang['None_selected'] = '您没有选择任何的文章来运行这个操作。请后退选择至少一篇文章。';
$lang['New_forum'] = '新论坛';

$lang['This_posts_IP'] = '这篇人的IP地址';
$lang['Other_IP_this_user'] = '这个作者的其他的IP地址';
$lang['users_this_IP'] = '来自这个IP的会员';
$lang['IP_info'] = 'IP地址信息';
$lang['Lookup_IP'] = '查询IP地址';


//
// Timezones ... for display on each page
//
$lang['All_times'] = '所有的时间均为 %s'; // eg.All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12小时';
$lang['-11'] = 'GMT - 11小时';
$lang['-10'] = '夏威夷时间';
$lang['-9'] = 'GMT - 9 小时';
$lang['-8'] = '美国太平洋时间';
$lang['-7'] = '美国山区时间';
$lang['-6'] = '美国中部时间';
$lang['-5'] = '美国东部时间';
$lang['-4'] = 'GMT - 4小时';
$lang['-3.5'] = 'GMT - 3.5小时';
$lang['-3'] = 'GMT - 3小时';
$lang['-2'] = '大西洋中部时间';
$lang['-1'] = 'GMT - 1小时';
$lang['0'] = '格林威治标准时间';
$lang['1'] = '中部欧洲时间';
$lang['2'] = '东部欧洲时间';
$lang['3'] = 'GMT + 3小时';
$lang['3.5'] = 'GMT + 3.5小时';
$lang['4'] = 'GMT + 4小时';
$lang['4.5'] = 'GMT + 4.5小时';
$lang['5'] = 'GMT + 5小时';
$lang['5.5'] = 'GMT + 5.5小时';
$lang['6'] = 'GMT + 6小时';
$lang['6.5'] = 'GMT + 6.5小时';
$lang['7'] = 'GMT + 7小时';
$lang['8'] = '北京时间';
$lang['9'] = 'GMT + 9小时';
$lang['9.5'] = '澳大利亚中部时间';
$lang['10'] = '澳大利亚东部时间';
$lang['11'] = 'GMT + 11小时';
$lang['12'] = 'GMT + 12小时';
$lang['13'] = 'GMT + 13小时';

// These are displayed in the timezone select box
$lang['tz']['-12'] = '(GMT -12:00) 埃尼威托克岛，夸贾林环礁';
$lang['tz']['-11'] = '(GMT -11:00) 中途岛，萨摩亚群岛';
$lang['tz']['-10'] = '(GMT -10:00) 夏威夷';
$lang['tz']['-9'] = '(GMT -9:00) 阿拉斯加';
$lang['tz']['-8'] = '(GMT -8:00) 太平洋时间 (美国和加拿大)，提华纳';
$lang['tz']['-7'] = '(GMT -7:00) 山区时间 (美国和加拿大)，亚利桑那';
$lang['tz']['-6'] = '(GMT -6:00) 中部时间 (美国和加拿大)，墨西哥城';
$lang['tz']['-5'] = '(GMT -5:00) 东部时间 (美国和加拿大)，波哥大，利马，基多';
$lang['tz']['-4'] = '(GMT -4:00) 大西洋时间 (加拿大），加拉加斯，拉巴斯';
$lang['tz']['-3.5'] = '(GMT -3:30) 纽芬兰';
$lang['tz']['-3'] = '(GMT -3:00) 巴西利亚，布宜诺斯艾利斯，乔治敦，福克兰群岛';
$lang['tz']['-2'] = '(GMT -2:00) 中大西洋，阿森松群岛，赫勒您';
$lang['tz']['-1'] = '(GMT -1:00) 亚速群岛，佛得角群岛';
$lang['tz']['0'] = '(GMT) 卡萨布兰卡，都柏林，爱丁堡，伦敦，里斯本，蒙罗维亚';
$lang['tz']['1'] = '(GMT +1:00) 阿姆斯特丹，柏林，布鲁塞尔，哥本哈根，马德里，巴黎，罗马';
$lang['tz']['2'] = '(GMT +2:00) 开罗，赫尔辛基，加里宁格勒，南非，华沙';
$lang['tz']['3'] = '(GMT +3:00) 巴格达，利雅得，莫斯科，奈洛比';
$lang['tz']['3.'] = '(GMT +3:30) 德黑兰';
$lang['tz']['4'] = '(GMT +4:00) 阿布扎比，巴库，马斯喀特，特比利斯';
$lang['tz']['4.5'] = '(GMT +4:30) 坎布尔';
$lang['tz']['5'] = '(GMT +5:00) 叶卡特琳堡，伊斯兰堡，卡拉奇，塔什干';
$lang['tz']['5.5'] = '(GMT +5:30) 孟买，加尔各答，马德拉斯，新德里';
$lang['tz']['6'] = '(GMT +6:00) 阿拉木图，科伦坡，达卡，新西伯利亚';
$lang['tz']['6.5'] = '(GMT +6:30) 仰光';
$lang['tz']['7'] = '(GMT +7:00) 曼谷，河内，雅加达';
$lang['tz']['8'] = '(GMT +8:00) 北京，香港，帕斯，新加坡，台北';
$lang['tz']['9'] = '(GMT +9:00) 大阪，札幌，汉城，东京，雅库茨克';
$lang['tz']['9.5'] = '(GMT +9:30) 阿德莱德，达尔文';
$lang['tz']['10'] = '(GMT +10:00) 堪培拉，关岛，墨尔本，悉尼，海参崴';
$lang['tz']['11'] = '(GMT +11:00) 马加丹，新喀里多尼亚，所罗门群岛';
$lang['tz']['12'] = '(GMT +12:00) 奥克兰，惠灵顿，斐济，马绍尔群岛';
$lang['tz']['13'] = 'GMT + 13 小时';

$lang['datetime']['Sunday'] = "周日";
$lang['datetime']['Monday'] = "周一";
$lang['datetime']['Tuesday'] = "周二";
$lang['datetime']['Wednesday'] = "周三";
$lang['datetime']['Thursday'] = "周四";
$lang['datetime']['Friday'] = "周五";
$lang['datetime']['Saturday'] = "周六";
$lang['datetime']['Sun'] = "周日";
$lang['datetime']['Mon'] = "周一";
$lang['datetime']['Tue'] = "周二";
$lang['datetime']['Wed'] = "周三";
$lang['datetime']['Thu'] = "周四";
$lang['datetime']['Fri'] = "周五";
$lang['datetime']['Sat'] = "周六";
$lang['datetime']['January'] = "1";
$lang['datetime']['February'] = "2";
$lang['datetime']['March'] = "3";
$lang['datetime']['April'] = "4";
$lang['datetime']['May'] = "5";
$lang['datetime']['June'] = "6";
$lang['datetime']['July'] = "7";
$lang['datetime']['August'] = "8";
$lang['datetime']['September'] = "9";
$lang['datetime']['October'] = "10";
$lang['datetime']['November'] = "11";
$lang['datetime']['December'] = "12";
$lang['datetime']['am'] = "上午";
$lang['datetime']['pm'] = "下午";
$lang['datetime']['Jan'] = "1";
$lang['datetime']['Feb'] = "2";
$lang['datetime']['Mar'] = "3";
$lang['datetime']['Apr'] = "4";
$lang['datetime']['May'] = "5";
$lang['datetime']['Jun'] = "6";
$lang['datetime']['Jul'] = "7";
$lang['datetime']['Aug'] = "8";
$lang['datetime']['Sep'] = "9";
$lang['datetime']['Oct'] = "10";
$lang['datetime']['Nov'] = "11";
$lang['datetime']['Dec'] = "12";

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = '信息提示';
$lang['Critical_Information'] = '重要信息';

$lang['General_Error'] = '普通错误';
$lang['Critical_Error'] = '严重错误';
$lang['An_error_occured'] = '发生了一个错误';
$lang['A_critical_error'] = '发生了一个严重错误';


//
// That's all, Folks!
// -------------------------------------------------

?>