<?php
/***************************************************************************
 *                            lang_main.php [����]
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
 *   the Free Software Foundation; either version 2 of the License��or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// �������� ��phpBB���Ŀ���С���޸����  http://www.cnphpbb.com
//������ 2005-01-25

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
$lang['DATE_FORMAT'] =  'Y/m/d'; // This should be changed to the default date format for your language��php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
// $lang['TRANSLATION'] = '';

//
// Common��these terms are used
// extensively on several pages
//
$lang['Forum'] = '��̳';
$lang['Category'] = '����';
$lang['Topic'] = '����';
$lang['Topics'] = '����';
$lang['Replies'] = '�ظ�';
$lang['Views'] = '�Ķ�';
$lang['Post'] = '����';
$lang['Posts'] = '����';
$lang['Posted'] = 'ʱ��';
$lang['Username'] = '��Ա��';
$lang['Password'] = '����';
$lang['Email'] = '�����ʼ�';
$lang['Poster'] = '������';
$lang['Author'] = '����';
$lang['Time'] = 'ʱ��';
$lang['Hours'] = 'Сʱ';
$lang['Message'] = '����';

$lang['1_Day'] = '1��';
$lang['7_Days'] = '7��';
$lang['2_Weeks'] = '2��';
$lang['1_Month'] = '1����';
$lang['3_Months'] = '3����';
$lang['6_Months'] = '6����';
$lang['1_Year'] = '1��';

$lang['Go'] = 'ȷ��';
$lang['Jump_to'] = '��̳ת��';
$lang['Submit'] = '�ύ';
$lang['Reset'] = '����';
$lang['Cancel'] = 'ȡ��';
$lang['Preview'] = 'Ԥ��';
$lang['Confirm'] = 'ȷ��';
$lang['Spellcheck'] = 'ƴд���';
$lang['Yes'] = '��';
$lang['No'] = '��';
$lang['Enabled'] = '����';
$lang['Disabled'] = '��ֹ';
$lang['Error'] = '����';

$lang['Next'] = '��һҳ';
$lang['Previous'] = '��һҳ';
$lang['Goto_page'] = '��ҳ';
$lang['Joined'] = '����ʱ��';
$lang['IP_Address'] = 'IP��ַ';

$lang['Select_forum'] = 'ѡ��һ����̳';
$lang['View_latest_post'] = '������µ�����';
$lang['View_newest_post'] = '������µ�����';
$lang['Page_of'] = '��<b>%d</b>ҳ����<b>%d</b>ҳ'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ����';
$lang['AIM'] = 'AIM��ַ';
$lang['MSNM'] = 'MSN';
$lang['YIM'] = '�Ż�ѶϢͨ';
$lang['SKYPE'] = 'Skype';
$lang['Forum_Index'] = '%s��ҳ';  // eg.sitename Forum Index��%s can be removed if you prefer

$lang['Post_new_topic'] = '����������';
$lang['Reply_to_topic'] = '�ظ�����';
$lang['Reply_with_quote'] = '���ûظ�';

$lang['Click_return_topic'] = '���%s����%s��������'; // %s's here are for uris��do not remove��
$lang['Click_return_login'] = '���%s����%s����һ��';
$lang['Click_return_forum'] = '���%s����%s������̳';
$lang['Click_view_message'] = '���%s����%s�Ķ���������';
$lang['Click_return_modcp'] = '���%s����%s���ذ���������';
$lang['Click_return_group'] = '���%s����%s�����Ŷ���Ϣ��';

$lang['Admin_panel'] = '����Ա�������';

$lang['Board_disable'] = '�Բ��𣬱���̳ϵͳ��ʱ���ܷ��ʣ����Ժ����ԡ�';


//
// Global Header strings
//
$lang['Registered_users'] = 'ע���Ա��';
$lang['Browsing_forum'] = '�������̳�Ļ�Ա��';
$lang['Online_users_zero_total'] = 'Ŀǰ���� <b>0</b> λ�������� :: ';
$lang['Online_users_total'] = 'Ŀǰ���� <b>%d</b> λ�������� :: ';
$lang['Online_user_total'] = 'Ŀǰ���� <b>%d</b> λ�������� :: ';
$lang['Reg_users_zero_total'] = 'û�л�Ա��';
$lang['Reg_users_total'] = '%d λ��Ա��';
$lang['Reg_user_total'] = '%d λ��Ա��';
$lang['Hidden_users_zero_total'] = 'û�������Ա';
$lang['Hidden_user_total'] = '%d λ�����Ա';
$lang['Hidden_users_total'] = '%d λ�����Ա';
$lang['Guest_users_zero_total'] = '��û���ο�';
$lang['Guest_users_total'] = '�� %d λ�ο�';
$lang['Guest_user_total'] = '�� %d λ�ο�';
$lang['Record_online_users'] = "������߼�¼�� <b>%s</b> �� %s"; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = '%s��̳����Ա%s';
$lang['Mod_online_color'] = '%s����%s';

$lang['You_last_visit'] = '���ϴη���ʱ����%s'; // %s replaced by date/time
$lang['Current_time'] = '���ڵ�ʱ����%s'; // %s replaced by time

$lang['Search_new'] = '�Ķ�������';
$lang['Search_your_posts'] = '�Ķ������������';
$lang['Search_unanswered'] = '�Ķ���δ�ظ�������';

$lang['Register'] = 'ע��';
$lang['Profile'] = '��������';
$lang['Edit_profile'] = '�༭���ĸ�������';
$lang['Search'] = '����';
$lang['Memberlist'] = '��Ա�б�';
$lang['FAQ'] = '����';
$lang['BBCode_guide'] = 'BBCode ����˵��';
$lang['Usergroups'] = '�Ŷ�';
$lang['Last_Post'] = '��������';
$lang['Moderator'] = '����';
$lang['Moderators'] = '����';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Ŀǰ��û������'; // Number of posts
$lang['Posted_articles_total'] = '���� <b>%d</b> ƪ����'; // Number of posts
$lang['Posted_article_total'] = '���� <b>%d</b> ƪ����'; // Number of posts
$lang['Registered_users_zero_total'] = 'Ŀǰ��û��ע���Ա'; // # registered users
$lang['Registered_users_total'] = '���� <b>%d</b> λע���Ա'; // # registered users
$lang['Registered_user_total'] = '���� <b>%d</b> λע���Ա'; // # registered users
$lang['Newest_user'] = '����ע��Ļ�Ա��<b>%s%s%s</b>'; // a href��username��/a 

$lang['No_new_posts_last_visit'] = '�ϴη��ʺ�û��������';
$lang['No_new_posts'] = 'û��������';
$lang['New_posts'] = '��������';
$lang['New_post'] = '��������';
$lang['No_new_posts_hot'] = 'û�������� [ ���� ]';
$lang['New_posts_hot'] = '�������� [ ���� ]';
$lang['No_new_posts_locked'] = 'û�������� [ �ر� ]';
$lang['New_posts_locked'] = '�������� [ �ر� ]';
$lang['Forum_is_locked'] = '�رյ���̳';


//
// Login
//
$lang['Enter_password'] = '���������Ļ�Ա���������¼';
$lang['Login'] = '��¼';
$lang['Logout'] = 'ע��';

$lang['Forgotten_password'] = '������������';

$lang['Log_me_in'] = '�Զ���¼';

$lang['Error_login'] = '���ṩ�Ļ�Ա�������벻��ȷ';


//
// Index page
//
$lang['Index'] = '��ҳ';
$lang['No_Posts'] = 'û������';
$lang['No_forums'] = '�����̳��û������';

$lang['Private_Message'] = 'վ�ڶ���';
$lang['Private_Messages'] = 'վ�ڶ���';
$lang['Who_is_Online'] = '��ǰ����״̬';

$lang['Mark_all_forums'] = '���������̳Ϊ�Ѷ�';
$lang['Forums_marked_read'] = '������̳�ѱ��Ϊ�Ѷ�';


//
// Viewforum
//
$lang['View_forum'] = '�����̳';

$lang['Forum_not_exist'] = '��ѡ�����̳������';
$lang['Reached_on_error'] = '��ѡ�����̳������';

$lang['Display_topics'] = '��ʾ����';
$lang['All_Topics'] = '���е�����';

$lang['Topic_Announcement'] = '<b>����:</b>';
$lang['Topic_Sticky'] = '<b>�ö�:</b>';
$lang['Topic_Moved'] = '<b>�ƶ�:</b>';
$lang['Topic_Poll'] = '<b>[ͶƱ]</b>';

$lang['Mark_all_topics'] = '�����������Ϊ�Ѷ�';
$lang['Topics_marked_read'] = '�����̳�����������ѱ��Ϊ�Ѷ�';

$lang['Rules_post_can'] = '��<b>����</b>�ڱ���̳����������';
$lang['Rules_post_cannot'] = '��<b>����</b>�ڱ���̳����������';
$lang['Rules_reply_can'] = '��<b>����</b>�ڱ���̳�ظ�����';
$lang['Rules_reply_cannot'] = '��<b>����</b>�ڱ���̳�ظ�����';
$lang['Rules_edit_can'] = '��<b>����</b>�ڱ���̳�༭�Լ�������';
$lang['Rules_edit_cannot'] = '��<b>����</b>�ڱ���̳�༭�Լ�������';
$lang['Rules_delete_can'] = '��<b>����</b>�ڱ���̳ɾ���Լ�������';
$lang['Rules_delete_cannot'] = '��<b>����</b>�ڱ���̳ɾ���Լ�������';
$lang['Rules_vote_can'] = '��<b>����</b>�ڱ���̳����ͶƱ';
$lang['Rules_vote_cannot'] = '��<b>����</b>�ڱ���̳����ͶƱ';
$lang['Rules_moderate'] = '��<b>����</b>%s����%s����̳'; // %s replaced by a href links��do not remove�� 

$lang['No_topics_post_one'] = '�����̳�ﻹû������<br />���<b>��������</b>�����һƪ����';


//
// Viewtopic
//
$lang['View_topic'] = '�Ķ�����';

$lang['Guest'] = '�ο�';
$lang['Post_subject'] = '����';
$lang['View_next_topic'] = '�Ķ���һ������';
$lang['View_previous_topic'] = '�Ķ���һ������';
$lang['Submit_vote'] = 'ͶƱ';
$lang['View_results'] = '�鿴���';

$lang['No_newer_topics'] = '�����̳û�и��µ�����';
$lang['No_older_topics'] = '�����̳û�и��ɵ�����';
$lang['Topic_post_not_exist'] = '��ѡ�����������²�����';
$lang['No_posts_topic'] = '���������û�лظ�����';

$lang['Display_posts'] = '��ʾ����';
$lang['All_Posts'] = '��������';
$lang['Newest_First'] = 'ʱ������';
$lang['Oldest_First'] = 'ʱ��˳��';

$lang['Back_to_top'] = '���ض���';

$lang['Read_profile'] = '�Ķ���Ա����'; 
$lang['Send_email'] = '����Ա�������ʼ�';
$lang['Visit_website'] = '��������ߵ���ҳ';
$lang['ICQ_status'] = 'ICQ״̬';
$lang['Edit_delete_post'] = '�༭/ɾ������';
$lang['View_IP'] = '�鿴����IP';
$lang['Delete_post'] = 'ɾ����ƪ����';

$lang['wrote'] = 'д��'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = '����'; // comes before BBCode quote output.
$lang['Code'] = '����'; // comes before BBCode code output.

$lang['Edited_time_total'] = '��һ����%s��%s�޸ģ��ܹ��޸���%d��'; // Last edited by me on 12 Oct 2001��edited 1 time in total
$lang['Edited_times_total'] = '��һ����%s��%s�޸ģ��ܹ��޸���%d��'; // Last edited by me on 12 Oct 2001��edited 2 times in total

$lang['Lock_topic'] = '��������';
$lang['Unlock_topic'] = '�������';
$lang['Move_topic'] = '�ƶ�����';
$lang['Delete_topic'] = 'ɾ������';
$lang['Split_topic'] = '�ָ�����';

$lang['Stop_watching_topic'] = 'ȡ�������������(�ظ�֪ͨ)';
$lang['Start_watching_topic'] = '����������� (�ظ�֪ͨ)';
$lang['No_longer_watching'] = '�˺󵱱��������µĻظ�ʱ��ϵͳ�����ٷ��͵����ʼ���֪ͨ����';
$lang['You_are_watching'] = '�˺󵱱��������µĻظ�ʱ��ϵͳ���Զ����͵����ʼ���֪ͨ����';

$lang['Total_votes'] = '��ͶƱ��';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = '����';
$lang['Topic_review'] = '����ع�';

$lang['No_post_mode'] = 'û��ָ������ģʽ'; // If posting.php is called without a mode (newtopic/reply/delete/etc��shouldn't be shown normaly)

$lang['Post_a_new_topic'] = '����������';
$lang['Post_a_reply'] = '����ظ�';
$lang['Post_topic_as'] = '��������Ϊ';
$lang['Edit_Post'] = '�༭����';
$lang['Options'] = 'ѡ��';

$lang['Post_Announcement'] = '����';
$lang['Post_Sticky'] = '�ö�';
$lang['Post_Normal'] = '��ͨ';

$lang['Confirm_delete'] = '��ȷ��Ҫɾ����ƪ������';
$lang['Confirm_delete_poll'] = '��ȷ��Ҫɾ�����ͶƱ��';

$lang['Flood_Error'] = '�����������ٶȹ��죬���Ժ����ԡ�';
$lang['Empty_subject'] = '����������±�����һ�����⡣';
$lang['Empty_message'] = '����������±��������ݡ�';
$lang['Forum_locked'] = '�����̳�Ѿ��������������ܷ����ظ����߱༭���¡�';
$lang['Topic_locked'] = '��������Ѿ��������������ܷ����ظ����߱༭���¡�';
$lang['No_post_id'] = '��ѡ����Ҫ�༭������';
$lang['No_topic_id'] = '��ѡ����Ҫ�ظ�������';
$lang['No_valid_mode'] = '��ֻ����ѡ�񷢱��ظ������������£���������ԡ�';
$lang['No_such_post'] = 'û�з��ϵ����£���������ԡ�';
$lang['Edit_own_posts'] = '�Բ���!��ֻ���Ա༭�Լ������¡�';
$lang['Delete_own_posts'] = '�Բ���!��ֻ����ɾ���Լ������¡�';
$lang['Cannot_delete_replied'] = '�Բ���!��������ɾ���Ѿ��лظ����µ����⡣';
$lang['Cannot_delete_poll'] = '�Բ���!��������ɾ�������ڻ״̬��ͶƱ��';
$lang['Empty_poll_title'] = '��������������ͶƱ����һ�����⡣';
$lang['To_few_poll_options'] = '������Ҫ������������ͶƱ��ѡ�';
$lang['To_many_poll_options'] = '��ѡ����̫���ͶƱ��ѡ��';
$lang['Post_has_no_poll'] = '�������û�н���ͶƱ';
$lang['Already_voted'] = '���Ѿ�Ͷ��Ʊ��';
$lang['No_vote_option'] = '��ָ��һ��ͶƱѡ��';

$lang['Add_poll'] = '����һ��ͶƱ';
$lang['Add_poll_explain'] = '��������뽨��ͶƱ�벻Ҫ��д���ѡ�';
$lang['Poll_question'] = 'ͶƱ����';
$lang['Poll_option'] = 'ͶƱѡ��';
$lang['Add_option'] = '����ѡ��';
$lang['Update'] = '����';
$lang['Delete'] = 'ɾ��';
$lang['Poll_for'] = 'ͶƱ����ʱ��';
$lang['Days'] = '��'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[ѡ��0���߲�ѡ�����ѡ���ʾͶƱ��Զ��Ч]';
$lang['Delete_poll'] = 'ɾ��ͶƱ';

$lang['Disable_HTML_post'] = '����ƪ�������ֹHTML��ǩ';
$lang['Disable_BBCode_post'] = '����ƪ�������ֹBBCode ���빦��';
$lang['Disable_Smilies_post'] = '����ƪ�������ֹ�������';

$lang['HTML_is_ON'] = '<u>����</u>HTML��ǩ';
$lang['HTML_is_OFF'] = '<u>��ֹ</u>HTML��ǩ';
$lang['BBCode_is_ON'] = '<u>����</u>%s����ǩ%s'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '<u>��ֹ</u>%s����ǩ%s';
$lang['Smilies_are_ON'] = '<u>����</u>����ͼ��';
$lang['Smilies_are_OFF'] = '<u>��ֹ</u>����ͼ��';

$lang['Attach_signature'] = '����ǩ��������ǩ�������ڸ�����������ģ�';
$lang['Notify'] = '���˻ظ�ʱ���͵����ʼ�������';
$lang['Delete_post'] = 'ɾ����ƪ����';

$lang['Stored'] = '���������Ѿ��ɹ�����';
$lang['Deleted'] = '���������Ѿ��ɹ�ɾ��';
$lang['Poll_delete'] = '��������ͶƱ�Ѿ��ɹ�ɾ��';
$lang['Vote_cast'] = '��л������ͶƱ';

$lang['Topic_reply_notification'] = '����ظ�֪ͨ';

$lang['bbcode_b_help'] = '����: [b]����[/b]  (alt+b)';
$lang['bbcode_i_help'] = 'б��: [i]����[/i]  (alt+i)';
$lang['bbcode_u_help'] = '�»���: [u]����[/u]  (alt+u)';
$lang['bbcode_q_help'] = '��������: [quote]����[/quote]  (alt+q)';
$lang['bbcode_c_help'] = '�������: [code]����[/code]  (alt+c)';
$lang['bbcode_l_help'] = '�б�: [list]����[/list] (alt+l)';
$lang['bbcode_o_help'] = '˳���б�: [list=]����[/list]  (alt+o)';
$lang['bbcode_p_help'] = '����ͼ��: [img]http://image_url[/img]  (alt+p)';
$lang['bbcode_w_help'] = '����URL: [url]http://url[/url] �� [url=http://url]URL����[/url]  (alt+w)';
$lang['bbcode_a_help'] = '�ر����п����� BBCode ��ǩ';
$lang['bbcode_s_help'] = '������ɫ: [color=red]����[/color]  ��ʾ��������ʹ�� color=#FF0000';
$lang['bbcode_f_help'] = '�����С: [size=x-small]С��������[/size]';

$lang['Emoticons'] = '�������';
$lang['More_emoticons'] = '����������';

$lang['Font_color'] = '������ɫ';
$lang['color_default'] = '��׼';
$lang['color_dark_red'] = '���';
$lang['color_red'] = '��ɫ';
$lang['color_orange'] = '��ɫ';
$lang['color_brown'] = '��ɫ';
$lang['color_yellow'] = '��ɫ';
$lang['color_green'] = '��ɫ';
$lang['color_olive'] = '���';
$lang['color_cyan'] = '��ɫ';
$lang['color_blue'] = '��ɫ';
$lang['color_dark_blue'] = '����';
$lang['color_indigo'] = '����';
$lang['color_violet'] = '��ɫ';
$lang['color_white'] = '��ɫ';
$lang['color_black'] = '��ɫ';

$lang['Font_size'] = '�����С';
$lang['font_tiny'] = '��С';
$lang['font_small'] = 'С';
$lang['font_normal'] = '��׼';
$lang['font_large'] = '��';
$lang['font_huge'] = '���';

$lang['Close_Tags'] = '������ǩ';
$lang['Styles_tip'] = '��ʾ��ѡ������Ҫװ�ε����֣������а�ť�����������Ӧ�ġ�';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'վ�ڶ���';

$lang['Login_check_pm'] = '��¼�����վ�ڶ���';
$lang['New_pms'] = '����%d���µ�վ�ڶ���'; // You have 2 new messages
$lang['New_pm'] = '����%d���µ�վ�ڶ���'; // You have 1 new message
$lang['No_new_pm'] = 'վ�ڶ���';
$lang['Unread_pms'] = '����%d��δ����վ�ڶ���';
$lang['Unread_pm'] = '����%d��δ����վ�ڶ���';
$lang['No_unread_pm'] = '��û��δ����վ�ڶ���';
$lang['You_new_pm'] = '�����ռ�������һ���µ�վ�ڶ���';
$lang['You_new_pms'] = '�����ռ������������µ�վ�ڶ���';
$lang['You_no_new_pm'] = '��û���µĶ���';

$lang['Unread_message'] = 'δ�Ķ��Ķ���';
$lang['Read_message'] = '�Ķ�����';

$lang['Read_pm'] = '�Ķ�����';
$lang['Post_new_pm'] = '���Ͷ���';
$lang['Post_reply_pm'] = '�ָ�����';
$lang['Post_quote_pm'] = '���ö���';
$lang['Edit_pm'] = '�༭����';

$lang['Inbox'] = '�ռ���';
$lang['Outbox'] = '�ļ���';
$lang['Savebox'] = '�����';
$lang['Sentbox'] = '�ѷ���';
$lang['Flag'] = '״̬';
$lang['Subject'] = '����';
$lang['From'] = '����';
$lang['To'] = '������';
$lang['Date'] = '����';
$lang['Mark'] = 'ѡ��';
$lang['Sent'] = '�ѷ���';
$lang['Saved'] = '����';
$lang['Delete_marked'] = 'ɾ��ѡ��Ķ���';
$lang['Delete_all'] = 'ɾ�����еĶ���';
$lang['Save_marked'] = '����ѡ��Ķ���'; 
$lang['Save_message'] = '�������';
$lang['Delete_message'] = 'ɾ������';

$lang['Display_messages'] = '��ʾ��ǰ�Ķ���'; // Followed by number of days/weeks/months
$lang['All_Messages'] = '���е�վ�ڶ���';

$lang['No_messages_folder'] = '����ļ�����û�ж���';

$lang['PM_disabled'] = '����̳��վ�ڶ��Ź����Ѿ����ر�';
$lang['Cannot_send_privmsg'] = '�Բ�����̳����Ա��ֹ������վ�ڶ���';
$lang['No_to_user'] = '������ָ��վ�ڶ��ŷ��͵Ķ���';
$lang['No_such_user'] = '�Բ��������Ա������';

$lang['Disable_HTML_pm'] = '������������ֹHTML����';
$lang['Disable_BBCode_pm'] = '������������ֹ����ǩ';
$lang['Disable_Smilies_pm'] = '������������ֹ�������';

$lang['Message_sent'] = '����վ�ڶ��ŷ��ͳɹ�';

$lang['Click_return_inbox'] = '���%s����%s���������ռ���';
$lang['Click_return_index'] = '���%s����%s������ҳ';

$lang['Send_a_new_message'] = '����һ���µ�վ�ڶ���';
$lang['Send_a_reply'] = '�ظ�վ�ڶ���';
$lang['Edit_message'] = '�༭վ��';

$lang['Notification_subject'] = '�µ�վ�ڶ���';

$lang['Find_username'] = '��Ա��ѯ';
$lang['Find'] = '����';
$lang['No_match'] = '�Ҳ������ϵĻ�Ա';

$lang['No_post_id'] = 'û��ָ������';
$lang['No_such_folder'] = 'û���������ļ��д���';
$lang['No_folder'] = 'û��ָ���ļ���';

$lang['Mark_all'] = 'ѡ�����ж���';
$lang['Unmark_all'] = 'ȡ������ѡ��';

$lang['Confirm_delete_pm'] = '��ȷ��Ҫɾ������վ�ڶ�����';
$lang['Confirm_delete_pms'] = '��ȷ��Ҫɾ����Щվ�ڶ�����';

$lang['Inbox_size'] = '�����ռ�����ʹ����%d%%'; // eg.Your Inbox is 50% full
$lang['Sentbox_size'] = '���ļļ�����ʹ����%d%%'; 
$lang['Savebox_size'] = '���Ĵ������ʹ����%d%%'; 

$lang['Click_view_privmsg'] = '���%s����%s��������ռ���';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = '��� :: %s�ĸ�������'; // %s is username 
$lang['About_user'] = '���� %s'; // %s is username

$lang['Preferences'] = 'ѡ��';
$lang['Items_required'] = '�� * ����Ŀ�Ǳ�����д�ģ���������˵��';
$lang['Registration_info'] = 'ע����Ϣ';
$lang['Profile_info'] = '��������';
$lang['Profile_info_warn'] = 'ע�⣬������Ϣ��������';
$lang['Avatar_panel'] = 'ͷ��������';
$lang['Avatar_gallery'] = 'ͷ�񻭲�';

$lang['Website'] = '������ҳ';
$lang['Location'] = '����';
$lang['Contact'] = '����';
$lang['Email_address'] = '�����ʼ���ַ';
$lang['Email'] = '�����ʼ�';
$lang['Send_private_message'] = '����վ�ڶ���';
$lang['Hidden_email'] = '[ ���� ]';
$lang['Search_user_posts'] = '������Ա����������';
$lang['Interests'] = '��Ȥ����';
$lang['Occupation'] = 'ְҵ'; 
$lang['Poster_rank'] = '��Ա����';

$lang['Total_posts'] = '��������';
$lang['User_post_pct_stats'] = '��������ռ��̳����������%.2f%%'; // 1.25% of total
$lang['User_post_day_stats'] = 'ƽ��ÿ��%.2fƪ����'; // 1.5 posts per day
$lang['Search_user_posts'] = '����%s�������������'; // Find all posts by username

$lang['No_user_id_specified'] = '�Բ��������Ա������';
$lang['Wrong_Profile'] = '�������Ա༭ȥ����Ա�ĸ�������';

$lang['Only_one_avatar'] = '��ֻ��ѡ��һ��ͷ��';
$lang['File_no_data'] = '���ṩ�����ӵ�ַ����������';
$lang['No_connection_URL'] = '�޷��������ṩ�����ӵ�ַ';
$lang['Incomplete_URL'] = '���ṩ�����ӵ�ַ������';
$lang['Wrong_remote_avatar_format'] = '���ṩ��ͷ�����ӵ�ַ��Ч';
$lang['No_send_account_inactive'] = '�Բ����޷��һ�����������Ϊ�����ʺ�Ŀǰ����ͣ��״̬����������̳����Ա�õ��������Ϣ��';

$lang['Always_smile'] = 'ʹ�ñ������';
$lang['Always_html'] = 'ʹ��HTML��ǩ';
$lang['Always_bbcode'] = 'ʹ�� BBCode ����';
$lang['Always_add_sig'] = '�������ڸ����ҵĸ���ǩ��';
$lang['Always_notify'] = '�����˻ظ��ҵ�����������';
$lang['Always_notify_explain'] = '�����˻ظ��ҵ�����ʱ����һ������ʼ������ҡ�������������ʱ�����Ը������ѡ��';

$lang['Board_style'] = '��̳���';
$lang['Board_lang'] = '��̳����';
$lang['No_themes'] = '���ݿ���û��װ������';
$lang['Timezone'] = 'ʱ��';
$lang['Date_format'] = '���ڸ�ʽ';
$lang['Date_format_explain'] = '���ڸ�ʽ���﷨�� PHP <a href=\'http://www.php.net/date\' target=\'_other\'>date() ���</a> һ��';
$lang['Signature'] = '����ǩ��';
$lang['Signature_explain'] = '����д�ĸ���ǩ���Զ����������ķ�������µײ�������ǩ����%d���ַ������ơ�';
$lang['Public_view_email'] = '�����ҵĵ����ʼ���ַ';

$lang['Current_password'] = '��ǰ������';
$lang['New_password'] = '������';
$lang['Confirm_password'] = '����ȷ��';
$lang['Confirm_password_explain'] = '�����Ҫ�޸�������ߵ����ʼ���ַ��������ȷ�����ĵ�ǰ����';
$lang['password_if_changed'] = 'ֻ�е���ϣ����������ʱ����Ҫ�ṩ����ʹ�õ�����';
$lang['password_confirm_if_changed'] = 'ֻ�е���ϣ����������ʱ����Ҫȷ���µ�����';

$lang['Avatar'] = 'ͷ��';
$lang['Avatar_explain'] = '���ĸ���ͷ�񽫻���ʾ����������������Աߣ�ͬһʱ��ֻ����ʾһ��ͼƬ��ͼƬ��Ȳ��ܳ���%d���أ��߶Ȳ��ܳ���%d���أ�ͼƬ��С���ܳ���%dkB��';
$lang['Upload_Avatar_file'] = "�����ļ�����ϴ�ͼƬ";
$lang['Upload_Avatar_URL'] = '��һ�������ϴ�ͼƬ';
$lang['Upload_Avatar_URL_explain'] = '�ṩһ��ͼƬ�����ӵ�ַ��ͼƬ�������Ƶ�����̳��';
$lang['Pick_local_Avatar'] = '�ӻ��Ἧ��ѡ��һ��ͷ��';
$lang['Link_remote_Avatar'] = '��������λ�õ�ͷ��';
$lang['Link_remote_Avatar_explain'] = '�ṩ��������ͷ��ͼ��ĵ�ַ';
$lang['Avatar_URL'] = 'ͼƬ���ӵ�ַ';
$lang['Select_from_gallery'] = '�ӻ�����ѡ��һ��ͷ��';
$lang['View_avatar_gallery'] = '��ʾ����';

$lang['Select_avatar'] = 'ѡ��ͷ��';
$lang['Return_profile'] = 'ȡ��ѡ��ͷ��';
$lang['Select_category'] = 'ѡ��һ������';

$lang['Delete_Image'] = 'ɾ��ͼƬ';
$lang['Current_Image'] = '����ʹ�õ�ͼƬ';

$lang['Notify_on_privmsg'] = '�µ�վ�ڶ�����ʾ';
$lang['Popup_on_privmsg'] = '�����µ�վ�ڶ���ʱ��������'; 
$lang['Popup_on_privmsg_explain'] = '�������µ�վ�ڶ���ʱ������һ���µ�С������������'; 
$lang['Hide_user'] = '�����ҵ�����״̬';

$lang['Profile_updated'] = '���ĸ��������Ѿ�����';
$lang['Profile_updated_inactive'] = '���ĸ��������Ѿ����¡������������������˺�״̬�������˺����ڴ��ڶ���״̬���鿴���ĵ����ʼ����������¼��������˺š������̳�涨��Ҫ����Ա�����ȴ�����Ա���¼��������˺š�';

$lang['Password_mismatch'] = '���ṩ�����벻ƥ��';
$lang['Current_password_mismatch'] = '������ʹ�õ�������ע��ʱ�ṩ�Ĳ�ƥ��';
$lang['Password_long'] = '�������벻�ܳ���32��Ӣ���ַ�������16������';
$lang['Too_many_registers'] = '���ѽ���̫���ע�᳢��. ���Ժ�����.';
$lang['Username_taken'] = '�Բ������Ļ�Ա���ѱ�ʹ��';
$lang['Username_invalid'] = '�Բ��𣬻�Ա�����ܰ����Ƿ��ַ������� \'';
$lang['Username_disallowed'] = '�Բ�����ѡ��Ļ�Ա����ϵͳ����';
$lang['Email_taken'] = '�Բ������ĵ����ʼ���ַ�ѱ���һ����Աʹ��';
$lang['Email_banned'] = '�Բ������ĵ����ʼ���ַ�ѱ�ϵͳ��ֹ';
$lang['Email_invalid'] = '�Բ������ĵ����ʼ���ַ��ʽ��Ч';
$lang['Signature_too_long'] = '���ĸ���ǩ��̫����';
$lang['Fields_empty'] = '��������д������Ŀ(*)';
$lang['Avatar_filetype'] = 'ͷ��ͼƬ�����ͱ����� .jpg��.gif �� .png';
$lang['Avatar_filesize'] = 'ͷ��ͼƬ�Ĵ�С����С��%dkB'; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = 'ͷ��ͼƬ�Ŀ�ȱ���С��%d���ض��Ҹ߶ȱ���С��%d����'; 

$lang['Welcome_subject'] = '��ӭ����%s��̳ϵͳ'; // Welcome to my.com forums
$lang['New_account_subject'] = '�»�Ա�ʻ�';
$lang['Account_activated_subject'] = '�˺ż���';

$lang['Account_added'] = '��л��ע�ᡣ�����˺��Ѿ��������������ھͿ���ʹ�����Ļ�Ա���������¼��';
$lang['Account_inactive'] = '��л��ע�ᣬ�����˺��Ѿ������������Ǳ���̳��Ҫ�����˺š���鿴���ĵ����ʼ��˽�������Ϣ��';
$lang['Account_inactive_admin'] = '��л��ע�ᣬ�����˺��Ѿ������������Ǳ���̳��Ҫ��̳����Ա�ֶ������˺š�ϵͳ�Ѿ�������Ա�����˵����ʼ��������˺ű�����ʱ�����յ�֪ͨ��';
$lang['Account_active'] = '��л��ע�ᣬ�����˺��Ѿ���������';
$lang['Account_active_admin'] = '�˺������Ѿ����ɹ�����';
$lang['Reactivate'] = '���¼��������˺ţ�';
$lang['Already_activated'] = '�����˺��Ѿ�������';
$lang['COPPA'] = '�����˺��Ѿ�������������Ҫ����׼����鿴���ĵ����ʼ��˽���ϸ��Ϣ��';

$lang['Registration'] = 'ע���������';
$lang['Reg_agreement'] = '������̳�����Ա�ᾡ���ܾ���ɾ����༭��������ǲ����������£��������ǲ������Ķ����е��������ݡ��������ó��������̳�����е�����ֻ�����ķ����߳е����Σ���������̳�Ĺ����Ա�ǣ������������Ƿ���ģ���<br /><br />������ͬ�ⲻ�������������࣬���ף��̰������г���ԣ����ŵģ��������Ļ����κ�Υ�����ɵ����ݡ�����������������������˺Ž������������Եı�������(������������ṩ��Ҳ�ᱻ֪ͨ)�����������£����IP��ַ�����л�Ա��������¼��������ͬ��ϵͳ�����Ա�������κ�ʱ��ɾ�����޸ģ��ƶ���ر��κ������Ȩ������Ϊһ��ʹ���ߣ�������ͬ�������ṩ���κ����϶������������ݿ��У���Щ���ϳ���������ͬ�⣬ϵͳ����Ա�Ǿ�����Ե�����������Ȼ�����ǲ��ܱ�֤�κο��ܵ�������й¶�ĺ���������Ϊ��<br /><br />���������ϵͳʹ��cookie���������ĸ�����Ϣ(����ʹ�õı��ؼ����)����Щcookie�������κ����������������Ϣ������ֻΪ�˷������ܸ����������������ʼ���ַֻ����ȷ������ע��ͷ�������ʹ�á�(��������������룬���ᷢ��������ĵ�ַ)<br /><br />�����������Ӵ�����ͬ���ܵ���Щ���������Լ����';

$lang['Agree_under_13'] = '��ͬ����������(������<b>δ��13��</b>)';
$lang['Agree_over_13'] = '��ͬ����������(������<b>����13��</b>)';
$lang['Agree_not'] = '�Ҳ�ͬ��';

$lang['Wrong_activation'] = '���ṩ�ļ�����������ݿ��еĲ�ƥ��';
$lang['Send_password'] = '����һ���µļ����������'; 
$lang['Password_updated'] = 'һ���µļ��������Ѿ�����������鿴���ĵ����ʼ��˽���μ���';
$lang['No_email_match'] = '���ṩ�ĵ����ʼ���ַ�����ݿ��еĲ�ƥ��';
$lang['New_password_activation'] = '�����뼤��';
$lang['Password_activated'] = '�����˺��Ѿ������¼����ʹ�����յ��ĵ����ʼ��е������¼';

$lang['Send_email_msg'] = '����һ������ʼ�';
$lang['No_user_specified'] = 'û��ѡ���Ա';
$lang['user_prevent_email'] = '������Ա��ϣ���յ������ʼ��������Է���վ�ڶ��Ÿ�������Ա';
$lang['user_not_exist'] = '��Ա������';
$lang['CC_email'] = '���������ʼ���һ�ݸ������͸��Լ�';
$lang['Email_message_desc'] = '����ʼ������Դ��ı���ʽ���ͣ��벻Ҫ�����κ�HTML���߷���ǩ����ƪ�ʼ��Ļظ���ַ��ָ�����ĵ����ʼ���ַ��';
$lang['Flood_email_limit'] = '���������ڷ��������ĵ����ʼ������һ�����ԡ�';
$lang['Recipient'] = '������';
$lang['Email_sent'] = '�ʼ��Ѿ�������';
$lang['Send_email'] = '���͵����ʼ�';
$lang['Empty_subject_email'] = '���ĵ����ʼ�����ӵ��һ������';
$lang['Empty_message_email'] = '��������д�����ʼ���������';


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = '�������ȷ���벻��ȷ';
$lang['Too_many_registers'] = '��������ͬһʱ�����ظ����Ե�������. ���Ժ�����.';
$lang['Confirm_code_impaired'] = '�������������������޷�������Щ�����������Ա��ϵȡ�ð���.';
$lang['Confirm_code'] = 'ȷ����';
$lang['Confirm_code_explain'] = '������������ȷ����. ���������ִ�Сд�ģ�ͬʱ������0����һ���ߴ���������ĸO����.';
// Memberslist
//
$lang['Select_sort_method'] = '��ѡ��һ�����򷽷�';
$lang['Sort'] = '����';
$lang['Sort_Top_Ten'] = 'ʮ������';
$lang['Sort_Joined'] = 'ע������';
$lang['Sort_Username'] = '��Ա��';
$lang['Sort_Location'] = '���Ե���';
$lang['Sort_Posts'] = '������������';
$lang['Sort_Email'] = '�����ʼ�';
$lang['Sort_Website'] = '������ҳ';
$lang['Sort_Ascending'] = '����';
$lang['Sort_Descending'] = '�ݼ�';
$lang['Order'] = '˳��';


//
// Group control panel
//
$lang['Group_Control_Panel'] = '�Ŷӿ������';
$lang['Group_member_details'] = '�Ŷӳ�Աϸ��';
$lang['Group_member_join'] = '����һ���Ŷ�';

$lang['Group_Information'] = '�Ŷ���Ϣ';
$lang['Group_name'] = '�Ŷ�����';
$lang['Group_description'] = '�Ŷ�����';
$lang['Group_membership'] = '�Ŷӳ�Ա';
$lang['Group_Members'] = '�Ŷӳ�Ա';
$lang['Group_Moderator'] = '�Ŷӹ���Ա';
$lang['Pending_members'] = '����еĳ�Ա';

$lang['Group_type'] = '�Ŷ�����';
$lang['Group_open'] = '�����Ŷ�';
$lang['Group_closed'] = '����Ŷ�';
$lang['Group_hidden'] = '�����Ŷ�';

$lang['Current_memberships'] = 'Ŀǰ�ĳ�Ա';
$lang['Non_member_groups'] = '�޳�Ա���Ŷ�';
$lang['Memberships_pending'] = '����еĳ�Ա';

$lang['No_groups_exist'] = 'û���ŶӴ���';
$lang['Group_not_exist'] = '����������Ŷ�';

$lang['Join_group'] = '�����Ŷ�';
$lang['No_group_members'] = '����Ŷ�û�г�Ա';
$lang['Group_hidden_members'] = '����ŶӴ�������״̬��������������ĳ�Ա';
$lang['No_pending_group_members'] = '����ŶӲ���������г�Ա';
$lang['Group_joined'] = '���Ѿ������������Ŷӣ�<br />����������ͨ����������ܵ�����';
$lang['Group_request'] = '��������Ŷӵ������Ѿ�����';
$lang['Group_approved'] = '���������Ѿ�����׼��';
$lang['Group_added'] = '���Ѿ�����������Ŷ�'; 
$lang['Already_member_group'] = '���Ѿ�������Ŷӵĳ�Ա';
$lang['user_is_member_group'] = '��Ա�Ѿ�������Ŷӵĳ�Ա';
$lang['Group_type_updated'] = '�ɹ������Ŷ�����';

$lang['Could_not_add_user'] = '��ѡ��Ļ�Ա������';
$lang['Could_not_anon_user'] = '�����ܽ��ÿ���Ϊ�Ŷӳ�Ա';

$lang['Confirm_unsub'] = '��ȷ��Ҫ������Ŷӽ��������';
$lang['Confirm_unsub_pending'] = '�����Ŷ����뻹û�б���׼����ȷ��Ҫ���������';

$lang['Unsub_success'] = '���Ѿ�������Ŷӽ�������롣';

$lang['Approve_selected'] = '��׼ѡ��';
$lang['Deny_selected'] = '�ܾ�ѡ��';
$lang['Not_logged_in'] = '���������ȵ�¼���ܼ����Ŷӡ�';
$lang['Remove_selected'] = 'ɾ��ѡ��';
$lang['Add_member'] = '���ӳ�Ա';
$lang['Not_group_moderator'] = '����������ŶӵĹ���Ա�����޷�ִ���ŶӵĹ����ܡ�';

$lang['Login_to_join'] = '��������߹����Ŷӳ�Ա�����ȵ�¼';
$lang['This_open_group'] = '����һ�����ŵ��Ŷӣ���������Ա';
$lang['This_closed_group'] = '����һ���رյ��Ŷӣ��������µĳ�Ա';
$lang['This_hidden_group'] = '����һ�����ص��Ŷӣ��������Զ����ӳ�Ա';
$lang['Member_this_group'] = '��������Ŷӵĳ�Ա';
$lang['Pending_this_group'] = '�����������������';
$lang['Are_group_moderator'] = '�����Ŷӹ���Ա';
$lang['None'] = '��';

$lang['Subscribe'] = '����';
$lang['Unsubscribe'] = 'ȡ������';
$lang['View_Information'] = '�鿴��Ϣ';


//
// Search
//
$lang['Search_query'] = '����Ŀ��';
$lang['Search_options'] = '����ѡ��';

$lang['Search_keywords'] = '�����ؼ���';
$lang['Search_keywords_explain'] = '������ʹ��<u>AND</u>�������ϣ������������ֵĹؼ��֣�����ʹ��<u>OR</u>�������ϣ���������ܳ��ֵĹؼ��ֺ�<u>NOT</u>���������ϣ���������ֵĹؼ��֡�ʹ��ͨ��� * ����������ϵĽ��';
$lang['Search_author'] = '��������';
$lang['Search_author_explain'] = 'ʹ��ͨ��� * �������ϵĽ��';

$lang['Search_for_any'] = '��������������һ�ؼ��ֵ�����';
$lang['Search_for_all'] = '���������������йؼ��ֵ�����';
$lang['Search_title_msg'] = '��������������������';
$lang['Search_msg_only'] = '��������������';

$lang['Return_first'] = '��ʾ���ȵ�'; // followed by xxx characters in a select box
$lang['characters_posts'] = '�����ϵ���Ŀ';

$lang['Search_previous'] = '������ǰ������'; // followed by days��weeks��months��year��all in a select box

$lang['Sort_by'] = '���򷽷�';
$lang['Sort_Time'] = '����ʱ��';
$lang['Sort_Post_Subject'] = '����';
$lang['Sort_Topic_Title'] = '���±���';
$lang['Sort_Author'] = '����';
$lang['Sort_Forum'] = '��̳';

$lang['Display_results'] = '��ʾģʽ';
$lang['All_available'] = '����';
$lang['No_searchable_forums'] = '��û���������µ�Ȩ��';

$lang['No_search_match'] = 'û�з�����Ҫ������������';
$lang['Found_search_match'] = '������ %d �����ϵ�����'; // eg��Search found 1 match
$lang['Found_search_matches'] = '������ %d �����ϵ�����'; // eg��Search found 24 matches

$lang['Close_window'] = '�رմ���';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = '�Բ���ֻ��%s�����������̳������';
$lang['Sorry_auth_sticky'] = '�Բ���ֻ��%s�����������̳�����ö�����'; 
$lang['Sorry_auth_read'] = '�Բ���ֻ��%s�����������̳�������'; 
$lang['Sorry_auth_post'] = '�Բ���ֻ��%s�����������̳��������'; 
$lang['Sorry_auth_reply'] = '�Բ���ֻ��%s�����������̳�ظ�����'; 
$lang['Sorry_auth_edit'] = '�Բ���ֻ��%s�����������̳�༭����'; 
$lang['Sorry_auth_delete'] = '�Բ���ֻ��%s�����������̳ɾ������'; 
$lang['Sorry_auth_vote'] = '�Բ���ֻ��%s�����������̳����ͶƱ'; 

// These replace the %s in the above strings
$lang['Auth_Anonymous_users'] = '<b>�ο�</b>';
$lang['Auth_Registered_users'] = '<b>ע���Ա</b>';
$lang['Auth_users_granted_access'] = '<b>�����Ա</b>';
$lang['Auth_Moderators'] = '<b>����</b>';
$lang['Auth_Administrators'] = '<b>��̳����Ա</b>';

$lang['Not_Moderator'] = '��û�й�����������Ȩ��';
$lang['Not_Authorised'] = 'δ����Ȩ';

$lang['You_been_banned'] = '�����̳�Ѿ���ֹ������<br />��������̳����Ա�˽�ϸ��';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = "������ 0 λע���л��� "; // There ae 5 Registered and
$lang['Reg_users_online'] = "������ %d λע���л��� "; // There ae 5 Registered and
$lang['Reg_user_online'] = "������ %d λע���л��� "; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = "0 λ�����û���"; // 6 Hidden users online
$lang['Hidden_users_online'] = "%d λ�����û�����"; // 6 Hidden users online
$lang['Hidden_user_online'] = "%d λ�����û�����"; // 6 Hidden users online
$lang['Guest_users_online'] = "������ %d λ�ο�����"; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = "������ 0 λע���û�����"; // There are 10 Guest users online
$lang['Guest_user_online'] = "������ %d λ�ο�����"; // There is 1 Guest user online
$lang['No_users_browsing'] = "����û���û��������̳���";

$lang['Online_explain'] = "����5����֮�ڵ���̳�������";
$lang['linkfriend']= "������̳";
$lang['Forum_Location'] = '��̳λ��';
$lang['Last_updated'] = '�������';

$lang['Forum_index'] = '��̳ϵͳ��ҳ';
$lang['Logging_on'] = '��¼';
$lang['Posting_message'] = '��������';
$lang['Searching_forums'] = '������̳';
$lang['Viewing_profile'] = '�鿴��������';
$lang['Viewing_online'] = '����������';
$lang['Viewing_member_list'] = '�����Ա�б�';
$lang['Viewing_priv_msgs'] = '�Ķ�վ�ڶ���';
$lang['Viewing_FAQ'] = '�Ķ�����������';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = '�����������';
$lang['Mod_CP_explain'] = 'ʹ�����µ�ѡ���������������̳�����ڶ���̳��������������Թرգ����ţ��ƶ�����ɾ���������������⡣';

$lang['Select'] = 'ѡ��';
$lang['Delete'] = 'ɾ��';
$lang['Move'] = '�ƶ�';
$lang['Lock'] = '����';
$lang['Unlock'] = '����';

$lang['Topics_Removed'] = 'ѡ��������Ѿ��ɹ��ش����ݿ���ɾ��';
$lang['Topics_Locked'] = 'ѡ��������Ѿ��ɹ�������';
$lang['Topics_Moved'] = 'ѡ��������Ѿ��ɹ����ƶ�';
$lang['Topics_Unlocked'] = 'ѡ��������Ѿ��ɹ��Ľ������';
$lang['No_Topics_Moved'] = 'û�����ⱻ�ƶ�';

$lang['Confirm_delete_topic'] = '��ȷ��Ҫɾ��ѡ���������';
$lang['Confirm_lock_topic'] = '��ȷ��Ҫ����ѡ���������';
$lang['Confirm_unlock_topic'] = '��ȷ��Ҫ����ѡ���������';
$lang['Confirm_move_topic'] = '��ȷ��Ҫ�ƶ�ѡ���������';

$lang['Move_to_forum'] = '�ƶ�����һ����̳';
$lang['Leave_shadow_topic'] = '�������Ᵽ���ھ���̳';

$lang['Split_Topic'] = '����ָ�������';
$lang['Split_Topic_explain'] = 'ʹ�����µ�ѡ�������Էָ����±��������������ѡ��ָ�һ�����ƪ����';
$lang['Split_title'] = '��������';
$lang['Split_forum'] = 'Ҫ�ָ����⵽�µ���̳';
$lang['Split_posts'] = '�ָ�ѡ�������';
$lang['Split_after'] = '�ָ���ѡ�����µ�����(����ѡ�������)';
$lang['Topic_split'] = 'ѡ��������Ѿ��ɹ��طָ�';

$lang['Too_many_error'] = '��ѡ����̫������¡���ֻ��ѡ��һƪ�������ָ����µ����£�';

$lang['None_selected'] = '��û��ѡ���κε�������������������������ѡ������һƪ���¡�';
$lang['New_forum'] = '����̳';

$lang['This_posts_IP'] = '��ƪ�˵�IP��ַ';
$lang['Other_IP_this_user'] = '������ߵ�������IP��ַ';
$lang['users_this_IP'] = '�������IP�Ļ�Ա';
$lang['IP_info'] = 'IP��ַ��Ϣ';
$lang['Lookup_IP'] = '��ѯIP��ַ';


//
// Timezones ... for display on each page
//
$lang['All_times'] = '���е�ʱ���Ϊ %s'; // eg.All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12Сʱ';
$lang['-11'] = 'GMT - 11Сʱ';
$lang['-10'] = '������ʱ��';
$lang['-9'] = 'GMT - 9 Сʱ';
$lang['-8'] = '����̫ƽ��ʱ��';
$lang['-7'] = '����ɽ��ʱ��';
$lang['-6'] = '�����в�ʱ��';
$lang['-5'] = '��������ʱ��';
$lang['-4'] = 'GMT - 4Сʱ';
$lang['-3.5'] = 'GMT - 3.5Сʱ';
$lang['-3'] = 'GMT - 3Сʱ';
$lang['-2'] = '�������в�ʱ��';
$lang['-1'] = 'GMT - 1Сʱ';
$lang['0'] = '�������α�׼ʱ��';
$lang['1'] = '�в�ŷ��ʱ��';
$lang['2'] = '����ŷ��ʱ��';
$lang['3'] = 'GMT + 3Сʱ';
$lang['3.5'] = 'GMT + 3.5Сʱ';
$lang['4'] = 'GMT + 4Сʱ';
$lang['4.5'] = 'GMT + 4.5Сʱ';
$lang['5'] = 'GMT + 5Сʱ';
$lang['5.5'] = 'GMT + 5.5Сʱ';
$lang['6'] = 'GMT + 6Сʱ';
$lang['6.5'] = 'GMT + 6.5Сʱ';
$lang['7'] = 'GMT + 7Сʱ';
$lang['8'] = '����ʱ��';
$lang['9'] = 'GMT + 9Сʱ';
$lang['9.5'] = '�Ĵ������в�ʱ��';
$lang['10'] = '�Ĵ����Ƕ���ʱ��';
$lang['11'] = 'GMT + 11Сʱ';
$lang['12'] = 'GMT + 12Сʱ';
$lang['13'] = 'GMT + 13Сʱ';

// These are displayed in the timezone select box
$lang['tz']['-12'] = '(GMT -12:00) �������п˵�������ֻ���';
$lang['tz']['-11'] = '(GMT -11:00) ��;������Ħ��Ⱥ��';
$lang['tz']['-10'] = '(GMT -10:00) ������';
$lang['tz']['-9'] = '(GMT -9:00) ����˹��';
$lang['tz']['-8'] = '(GMT -8:00) ̫ƽ��ʱ�� (�����ͼ��ô�)���Ừ��';
$lang['tz']['-7'] = '(GMT -7:00) ɽ��ʱ�� (�����ͼ��ô�)������ɣ��';
$lang['tz']['-6'] = '(GMT -6:00) �в�ʱ�� (�����ͼ��ô�)��ī�����';
$lang['tz']['-5'] = '(GMT -5:00) ����ʱ�� (�����ͼ��ô�)���������������';
$lang['tz']['-4'] = '(GMT -4:00) ������ʱ�� (���ô󣩣�������˹������˹';
$lang['tz']['-3.5'] = '(GMT -3:30) Ŧ����';
$lang['tz']['-3'] = '(GMT -3:00) �������ǣ�����ŵ˹����˹�����ζأ�������Ⱥ��';
$lang['tz']['-2'] = '(GMT -2:00) �д����󣬰�ɭ��Ⱥ����������';
$lang['tz']['-1'] = '(GMT -1:00) ����Ⱥ������ý�Ⱥ��';
$lang['tz']['0'] = '(GMT) �����������������֣����������׶أ���˹��������ά��';
$lang['tz']['1'] = '(GMT +1:00) ��ķ˹�ص������֣���³�������籾�������������裬����';
$lang['tz']['2'] = '(GMT +2:00) ���ޣ��ն����������������գ��Ϸǣ���ɳ';
$lang['tz']['3'] = '(GMT +3:00) �͸����ŵã�Ī˹�ƣ������';
$lang['tz']['3.'] = '(GMT +3:30) �º���';
$lang['tz']['4'] = '(GMT +4:00) �������ȣ��Ϳ⣬��˹���أ��ر���˹';
$lang['tz']['4.5'] = '(GMT +4:30) ������';
$lang['tz']['5'] = '(GMT +5:00) Ҷ�����ձ�����˹�����������棬��ʲ��';
$lang['tz']['5.5'] = '(GMT +5:30) ���򣬼Ӷ����������˹���µ���';
$lang['tz']['6'] = '(GMT +6:00) ����ľͼ�������£��￨������������';
$lang['tz']['6.5'] = '(GMT +6:30) ����';
$lang['tz']['7'] = '(GMT +7:00) ���ȣ����ڣ��żӴ�';
$lang['tz']['8'] = '(GMT +8:00) ��������ۣ���˹���¼��£�̨��';
$lang['tz']['9'] = '(GMT +9:00) ���棬���ϣ����ǣ��������ſ�Ŀ�';
$lang['tz']['9.5'] = '(GMT +9:30) �������£������';
$lang['tz']['10'] = '(GMT +10:00) ���������ص���ī������Ϥ�ᣬ������';
$lang['tz']['11'] = '(GMT +11:00) ��ӵ����¿�������ǣ�������Ⱥ��';
$lang['tz']['12'] = '(GMT +12:00) �¿���������٣�쳼ã����ܶ�Ⱥ��';
$lang['tz']['13'] = 'GMT + 13 Сʱ';

$lang['datetime']['Sunday'] = "����";
$lang['datetime']['Monday'] = "��һ";
$lang['datetime']['Tuesday'] = "�ܶ�";
$lang['datetime']['Wednesday'] = "����";
$lang['datetime']['Thursday'] = "����";
$lang['datetime']['Friday'] = "����";
$lang['datetime']['Saturday'] = "����";
$lang['datetime']['Sun'] = "����";
$lang['datetime']['Mon'] = "��һ";
$lang['datetime']['Tue'] = "�ܶ�";
$lang['datetime']['Wed'] = "����";
$lang['datetime']['Thu'] = "����";
$lang['datetime']['Fri'] = "����";
$lang['datetime']['Sat'] = "����";
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
$lang['datetime']['am'] = "����";
$lang['datetime']['pm'] = "����";
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
$lang['Information'] = '��Ϣ��ʾ';
$lang['Critical_Information'] = '��Ҫ��Ϣ';

$lang['General_Error'] = '��ͨ����';
$lang['Critical_Error'] = '���ش���';
$lang['An_error_occured'] = '������һ������';
$lang['A_critical_error'] = '������һ�����ش���';


//
// That's all, Folks!
// -------------------------------------------------

?>