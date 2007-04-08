<?php

/***************************************************************************
 *                            lang_admin.php [chinese simplified]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.35.2.9 2003/06/10 00:31:19 psotfx Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License��or
 *  ��at your option��any later version.
 *
 ***************************************************************************/

//
// �������� phpBB���Ŀ���С���޸����  http://www.cnphpbb.com
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
// ������ 2005-01-25


$lang['General'] = '�������';
$lang['Users'] = '��Ա����';
$lang['Groups'] = '�Ŷӹ���';
$lang['Forums'] = '��̳����';
$lang['Styles'] = '������';

$lang['Configuration'] = '��������';
$lang['Permissions'] = 'Ȩ������';
$lang['Manage'] = '����ѡ��';
$lang['Disallow'] = '�����ʺ�';
$lang['Prune'] = '����ɾ��';
$lang['Mass_Email'] = '�����ʼ�֪ͨ';
$lang['Ranks'] = '�ȼ�����';
$lang['Smilies'] = '�������';
$lang['Ban_Management'] = '��������';
$lang['Word_Censor'] = '���ֹ���';
$lang['Export'] = '���';
$lang['Create_new'] = '�½�';
$lang['Add_new'] = '����';
$lang['Backup_DB'] = '�������ݿ�';
$lang['Restore_DB'] = '�ָ����ݿ�';


//
// Index
//
$lang['Admin'] = 'ϵͳ����';
$lang['Not_admin'] = '��δ��Ȩ�������Ա�������';
$lang['Welcome_phpBB'] = '��ӭ���� phpBB 2 ����Ա�������';
$lang['Admin_intro'] = '��л��ѡ�� phpBB 2 ��Ϊ������̳ϵͳ��������������������̳�ĸ���ͳ�����ϡ��κ�ʱ����������ͨ���������������Ϸ���<u>���������ҳ</u>���ص���һҳ��������ڿ���������Ϸ��� phpBB ��־ͼʾ���Իص�������̳ϵͳ��ҳ.����������󷽵���������,������������̳ϵͳ�����й���ѡ��.ÿ���������и���ܵ�ʹ����⡣';
$lang['Main_index'] = '������̳ϵͳ��ҳ';
$lang['Forum_stats'] = '��̳ϵͳ������';
$lang['Admin_Index'] = '���������ҳ';
$lang['Preview_forum'] = 'Ԥ��������̳ϵͳ';

$lang['Click_return_admin_index'] = '���%s����%s�ص����������ҳ';

$lang['Statistic'] = 'ͳ������';
$lang['Value'] = '��ֵ';
$lang['Number_posts'] = '�����ܼ�';
$lang['Posts_per_day'] = 'ƽ��ÿ�췢���������';
$lang['Number_topics'] = '�����ܼ�';
$lang['Topics_per_day'] = 'ƽ��ÿ�췢���������';
$lang['Number_users'] = 'ע���Ա�ܼ�';
$lang['Users_per_day'] = 'ƽ��ÿ��ע��Ļ�Ա��';
$lang['Board_started'] = '��̳ϵͳ��������';
$lang['Avatar_dir_size'] = 'ͷ���ļ����ļ���С';
$lang['Database_size'] = '���ݿ��ļ���С';
$lang['Gzip_compression'] ='Gzip ѹ��';
$lang['Not_available'] = '��';

$lang['ON'] = '����'; // This is for GZip compression
$lang['OFF'] = '�ر�'; 


//
// DB Utils
//
$lang['Database_Utilities'] = '���ݿ⹤�߹���';

$lang['Restore'] = '�ָ�';
$lang['Backup'] = '����';
$lang['Restore_explain'] = '�����ѡ���������Իָ� phpBB 2 ��ʹ�õ����ݱ�������ķ�����֧�� GZIP ѹ�����ļ��������������Զ���ѹ�����ϴ���ѹ���ļ���<b>ע�⣡</b> �ָ������н�����ȫ���������ִ�����ϡ����ݿ�ָ����̿��ܻỨ�ѽϳ���ʱ�䣬�ڻָ����ǰ�벻Ҫ�رջ��뿪���ҳ�档';
$lang['Backup_explain'] = '�����ѡ���������Ա��� phpBB 2 ��̳ϵͳ�������������ݡ���������������ж���ı����� phpBB 2 ��̳��ʹ�õ����ݿ��ڣ�������Ҳ�뱸����Щ�ı�������·��� <b>���ӵı��</b> �����������ǵ����ֲ��ö������𿪣����磺abc, cde)��������ķ�������֧�� GZIP ѹ����ʽ��������������ǰʹ�� GZIP ѹ������С�ļ��Ĵ�С��';

$lang['Backup_options'] = '����ѡ��';
$lang['Start_backup'] = '��ʼ����';
$lang['Full_backup'] = '��������';
$lang['Structure_backup'] = '�ṹ����';
$lang['Data_backup'] = '���ݱ���';
$lang['Additional_tables'] = '���ӵı��';
$lang['Gzip_compress'] = 'Gzip ѹ��';
$lang['Select_file'] = 'ѡ���ļ�';
$lang['Start_Restore'] = '��ʼ�ָ�';

$lang['Restore_success'] = '���ݿ�ɹ��ָ�.<br /><br />��̳ϵͳ�ѱ��ָ��ɱ���ʱ��״̬��';
$lang['Backup_download'] = '��ȴ�������׼�����ı����ļ�,���ؼ�����ʼ';
$lang['Backups_not_supported'] = '�Բ��𣡱������ݲ�֧���������ݿ�ϵͳ';

$lang['Restore_Error_uploading'] = '�ϴ��ı����ļ�����';
$lang['Restore_Error_filename'] = '�ļ����ƴ���������ѡ���ļ�';
$lang['Restore_Error_decompress'] = '�޷���ѹ Gzip �ļ������Դ��ı���ʽ�ϴ�';
$lang['Restore_Error_no_file'] = 'û���ļ����ϴ�';


//
// Auth pages
//
$lang['Select_a_User'] = 'ѡ��һ����Ա';
$lang['Select_a_Group'] = 'ѡ��һ���Ŷ�';
$lang['Select_a_Forum'] = 'ѡ��һ����̳';
$lang['Auth_Control_User'] = '��ԱȨ������'; 
$lang['Auth_Control_Group'] = '�Ŷ�Ȩ������'; 
$lang['Auth_Control_Forum'] = '��̳Ȩ������'; 
$lang['Look_up_User'] = '��ѯ��Ա'; 
$lang['Look_up_Group'] = '��ѯ�Ŷ�'; 
$lang['Look_up_Forum'] = '��ѯ��̳'; 

$lang['Group_auth_explain'] = '�����ѡ���������Ը����Ŷӵ�Ȩ�����ü�ָ������Ա�ʸ���ע�⣬�޸��Ŷ�Ȩ�����ú󣬶����Ļ�ԱȨ�޿�����Ȼ����ʹ��Ա����������̳����������������������ʾȨ�޳�ͻ�ľ��档';
$lang['User_auth_explain'] = '�����ѡ���������Ը��Ļ�Ա��Ȩ�����ü�ָ������Ա�ʸ���ע�⣬�޸Ļ�ԱȨ�����ú󣬶����Ļ�ԱȨ�޿�����Ȼ����ʹ��Ա����������̳����������������������ʾȨ�޳�ͻ�ľ��档';
$lang['Forum_auth_explain'] = '�����ѡ���������Ը�����̳��ʹ��Ȩ�ޡ�������ѡ��ʹ�ü򵥻��Ǹ߼�����ģʽ���߼�ģʽ���ṩ��������Ȩ�����ÿ��ơ���ע�⣬���еĸı䶼����Ӱ�쵽��Ա����̳ʹ��Ȩ�ޡ�';

$lang['Simple_mode'] = '��ģʽ';
$lang['Advanced_mode'] = '�߼�ģʽ';
$lang['Moderator_status'] = '����Ա�ʸ�';

$lang['Allowed_Access'] = '�������';
$lang['Disallowed_Access'] = '��ֹ����';
$lang['Is_Moderator'] = 'ӵ����̳����Ȩ��';
$lang['Not_Moderator'] = 'û����̳����Ȩ��';

$lang['Conflict_warning'] = 'Ȩ�޳�ͻ����';
$lang['Conflict_access_userauth'] = '�����Ա��Ȼ����ͨ���Ŷӳ�Ա���ʸ�����ض�����̳�������Ը����Ŷ�Ȩ�޻���ȡ�������Ա���Ŷ��ʸ�����ֹ�û�Ա�������Ƶ���̳.�Ŷ�Ȩ������:';
$lang['Conflict_mod_userauth'] = '�����Ա��Ȼ����ͨ���Ŷӳ�Ա���ʸ�ӵ����̳�����Ȩ�ޡ������Ը����Ŷ�Ȩ�޻���ȡ�������Ա��Ȩ������ֹ�û�Ա������̳����.��̳����Ȩ������:';

$lang['Conflict_access_groupauth'] = '���л�Ա��Ȼ����ͨ����ԱȨ�����ý�������ض�����̳�������Ը��Ļ�ԱȨ����ȡ�����ǽ������Ƶ���̳����ԱȨ�����£�';
$lang['Conflict_mod_groupauth'] = '���л�Ա��Ȼ����ͨ�����ǵĻ�ԱȨ��ӵ����̳�����Ȩ�ޡ������Ը��Ļ�ԱȨ����ȡ�����ǵ���̳����Ȩ�ޡ���ԱȨ�����£�';

$lang['Public'] = '����';
$lang['Private'] = '˽��';
$lang['Registered'] = 'ע���Ա';
$lang['Administrators'] = '��̳����Ա';
$lang['Hidden'] = '����';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = '�κ���';
$lang['Forum_REG'] = 'ע���Ա';
$lang['Forum_PRIVATE'] = '˽��';
$lang['Forum_MOD'] = '����';
$lang['Forum_ADMIN'] = '��̳����Ա';

$lang['View'] = '���';
$lang['Read'] = '�Ķ�';
$lang['Post'] = '����';
$lang['Reply'] = '�ظ�';
$lang['Edit'] = '�༭';
$lang['Delete'] = 'ɾ��';
$lang['Sticky'] = '�ö�';
$lang['Announce'] = '����'; 
$lang['Vote'] = 'ͶƱ';
$lang['Pollcreate'] = '����ͶƱ';

$lang['Permissions'] = 'Ȩ������';
$lang['Simple_Permission'] = '����Ȩ��';

$lang['User_Level'] = '��Ա�ȼ�'; 
$lang['Auth_User'] = '��Ա';
$lang['Auth_Admin'] = '��̳����Ա';
$lang['Group_memberships'] = '��Ա�Ŷ��б��ܼƣ�%d��';
$lang['Usergroup_members'] = '�Ŷӳ�Ա�б��ܼƣ�%d��';

$lang['Forum_auth_updated'] = '��̳Ȩ�����ø���';
$lang['User_auth_updated'] = '��ԱȨ�����ø���';
$lang['Group_auth_updated'] = '�Ŷ�Ȩ�����ø���';

$lang['Auth_updated'] = 'Ȩ�������Ѿ�����';
$lang['Click_return_userauth'] = '���%s����%s���ػ�ԱȨ������';
$lang['Click_return_groupauth'] = '���%s����%s�����Ŷ�Ȩ������';
$lang['Click_return_forumauth'] = '���%s����%s������̳Ȩ������';


//
// Banning
//
$lang['Ban_control'] = '��������';
$lang['Ban_explain'] = '�����ѡ����,���������û�Ա�ķ����������Է���һ��ָ���Ļ�Ա��һ��ָ����Χ�� IP ��ַ���Ǽ�����������ƣ���Щ������ֹ�������Ļ�Ա������̳ϵͳ��ҳ����Ҳ����ָ�����������ʼ���ַ����ֹע���Աʹ�ò�ͬ���ʺ��ظ�ע�ᡣ��ע�⵱��ֻ�Ƿ���һ�������ʼ���ַʱ������Ӱ�쵽��Ա������̳ϵͳ�ĵ�¼���Ƿ������£���Ӧ��ʹ��ǰ�����ַ�ʽ����֮һ��������һ��������������';
$lang['Ban_explain_warn'] = '��������һ��IP��ַ��Χʱ�������Χ�����е�IP��ַ�����ᱻ������������ʹ��ͳ��� * ����Ҫ������ip��ַ�����ͱ������Ŀ��ܡ������һ��Ҫ����һ����Χ�뾡�����־�����ʵ�����Ӱ��������ʹ�á�';

$lang['Select_username'] = 'ѡ��һ����Ա��';
$lang['Select_ip'] = 'ѡ��һ�� IP ��ַ';
$lang['Select_email'] = 'ѡ��һ�������ʼ���ַ';

$lang['Ban_username'] = '����һ������ָ���Ļ�Ա��';
$lang['Ban_username_explain'] = '������ʹ��������ϼ����磺Ctrl �� Shift)һ�η��������Ա��';

$lang['Ban_IP'] = '����һ������ IP ��ַ���Ǽ������������';
$lang['IP_hostname'] = 'IP ��ַ���Ǽ������������';
$lang['Ban_IP_explain'] = 'Ҫָ�������ͬ�� IP ��ַ�����������ƣ���ʹ�ö��� "," ���ָ����ǡ�Ҫָ�� IP ��ַ�ķ�Χ����ʹ�� "-" ���ָ���ʼ��ַ��������ַ������ʹ��ͳ��� "*"';

$lang['Ban_email'] = '����һ�����������ʼ���ַ';
$lang['Ban_email_explain'] = 'Ҫָ�������ͬ�ĵ����ʼ���ַ����ʹ�ö��� "," ���ָ����ǣ�����ʹ��ͨ��� "*"�����磺*@hotmail.com';

$lang['Unban_username'] = '���һ�����������Ļ�Ա��';
$lang['Unban_username_explain'] = '������ʹ����꼰��ϼ����磺Ctrl �� Shift)һ�ν����������Ļ�Ա��';

$lang['Unban_IP'] = '���һ������������ IP ��ַ';
$lang['Unban_IP_explain'] = '������ʹ����꼰��ϼ������磺Ctrl �� Shift)��һ�ν����������� IP ��ַ';

$lang['Unban_email'] = '���һ�����������ĵ����ʼ���ַ';
$lang['Unban_email_explain'] = '������ʹ����꼰��ϼ������磺Ctrl �� Shift)��һ�ν����������ĵ����ʼ���ַ';

$lang['No_banned_users'] = 'û�б������Ļ�Ա��';
$lang['No_banned_ip'] = 'û�б������� IP ��ַ';
$lang['No_banned_email'] = 'û�б������ĵ����ʼ���ַ';

$lang['Ban_update_sucessful'] = '�����б��Ѿ��ɹ�����';
$lang['Click_return_banadmin'] = '���%s����%s���ط�������';


//
// Configuration
//
$lang['General_Config'] = '��������';
$lang['Config_explain'] = '������ʹ�����б��������һ�������ѡ���Ա����̳������ʹ�û����󷽣���̳������������ӡ�';

$lang['Click_return_config'] = '���%s����%s���ػ�������';

$lang['General_settings'] = '��̳ϵͳ��������';
$lang['Server_name'] = '����';
$lang['Server_name_explain'] = '������̳ϵͳ����Ӧ������';
$lang['Script_path'] = '�ű�·��';
$lang['Script_path_explain'] = '������̳��Ӧ��������·��';
$lang['Server_port'] = '����˿�';
$lang['Server_port_explain'] = '���ķ����������еĶ˿�,Ĭ��ֵ��80,ֻ���ڷ�Ĭ��ֵʱ�ı����ѡ��';
$lang['Site_name'] = 'վ������';
$lang['Site_desc'] = 'վ������';
$lang['Board_disable'] = '�ر���̳ϵͳ';
$lang['Board_disable_explain'] = '�⽫��ر���̳ϵͳ�������ر���̳ʱ������Ա�Կ��Խ������������!';
$lang['Board_disable_msg'] = '�Զ�����̳�ر���Ϣ';
$lang['Board_disable_msg_explain'] = '�Զ�����̳�ر���Ϣֻ�е����ر���̳ϵͳ������Ϊ���ǡ���ʱ��������á�';
$lang['Board_disable_downtime'] = '��̳�ر�ʱ��';
$lang['Board_disable_downtime_explain'] = '��̳Ԥ�ƹر�ʱ�䡣';
$lang['Board_disable_notes'] = '������̳֪ͨ';
$lang['Board_disable_notes_explain'] = '��ʾ����̳�ر�ʱ������ĸ������֣���ѡ����';
$lang['Board_disable_admin_mod'] = '�����̳Ȩ��';
$lang['Board_disable_admin_mod_explain'] = '����̳�رպ����ӵ�в鿴��̳Ȩ�޵ĵȼ���';
$lang['Board_disable_settings'] = '��̳�ر�����';
$lang['Board_disable_Moderator'] = '����';
$lang['Board_disable_Admin'] = '����Ա';
$lang['Acct_activation'] = '�����ʺż���';
$lang['Acc_None'] = '�ر�'; // These three entries are the type of activation
$lang['Acc_User'] = '�ɻ�Ա���м���';
$lang['Acc_Admin'] = '�ɹ���Ա����';

$lang['Abilities_settings'] = '��Ա����̳��������';
$lang['Max_poll_options'] = 'ͶƱ��Ŀ�������Ŀ';
$lang['who_is_online_time'] = '��ʾ���ٷ��ֵַ��������';
$lang['Flood_Interval'] = '��ˮ�ж�';
$lang['Flood_Interval_explain'] = '���·���ļ��ʱ�䣨�룩'; 
$lang['Board_email_form'] = '��Ա�����ʼ��б�';
$lang['Board_email_form_explain'] = '�������̳ϵͳ��Ա���Ի��෢�͵����ʼ�';
$lang['Email_enabled'] = '������̳�����ʼ�';
$lang['Email_enabled_explain'] = '��̳���Ը��û����͵����ʼ�';
$lang['Topics_per_page'] = 'ÿҳ��ʾ������';
$lang['Posts_per_page'] = 'ÿҳ��ʾ������';
$lang['Hot_threshold'] = '���Ż���������';
$lang['Default_style'] = 'Ĭ�Ϸ��';
$lang['Override_style'] = '���ӻ�Աѡ��ķ��';
$lang['Override_style_explain'] = '����Ա��ѡ�ķ���ΪĬ�Ϸ��';
$lang['Default_language'] = 'Ĭ������';
$lang['Date_format'] = '���ڸ�ʽ';
$lang['System_timezone'] = 'ϵͳʱ��';
$lang['Enable_gzip'] = '���� GZip �ļ�ѹ����ʽ';
$lang['Enable_prune'] = '�����ƻ�ɾ��ģʽ';
$lang['Allow_HTML'] = '����ʹ�� HTML �﷨';
$lang['Allow_BBCode'] = '����ʹ�� BBCode ����';
$lang['Allowed_tags'] = '����ʹ�� HTML ��ǩ';
$lang['Allowed_tags_explain'] = '�Զ��ŷָ� HTML ��ǩ';
$lang['Allow_smilies'] = '����ʹ�ñ������';
$lang['Smilies_path'] = '������Ŵ���·��';
$lang['Smilies_path_explain'] = '���� phpBB 2 ��Ŀ¼���µ�·�������磺images/smilies';
$lang['Allow_sig'] = '����ʹ��ǩ����';
$lang['Max_sig_length'] = 'ǩ������������';
$lang['Max_sig_length_explain'] = '�û�����ǩ������ʹ������';
$lang['Allow_name_change'] = '������ĵ�¼����';
$lang['Allow_quick_reply'] = '������ٻظ�';

$lang['Avatar_settings'] = '����ͷ������';
$lang['Allow_local'] = 'ʹ��ϵͳ���';
$lang['Allow_remote'] = '��������ͷ��ͼƬ';
$lang['Allow_remote_explain'] = '��������ַ����ͷ��ͼƬ';
$lang['Allow_upload'] = '�����û��ϴ�ͷ��';
$lang['Max_filesize'] = 'ͷ���ļ���С����';
$lang['Max_filesize_explain'] = '���û��ϴ�ͷ��ͼƬ';
$lang['Max_avatar_size'] = 'ͼƬ��С���ɴ���';
$lang['Max_avatar_size_explain'] = '(�� x �� ���أ�';
$lang['Avatar_storage_path'] = '����ͷ�񴢴�·��';
$lang['Avatar_storage_path_explain'] = '���� phpBB 2 ��Ŀ¼���µ�·�������磺images/avatars';
$lang['Avatar_gallery_path'] = 'ϵͳ��ᴢ��·��';
$lang['Avatar_gallery_path_explain'] = '���� phpBB 2 ��Ŀ¼���µ�·�������磺images/avatars/gallery';

$lang['COPPA_settings'] = 'COPPA��������ͯ������˽������������';
$lang['COPPA_fax'] = 'COPPA �������';
$lang['COPPA_mail'] = 'COPPA �ʵݵ�ַ';
$lang['COPPA_mail_explain'] = '���ǹ��ҳ����� COPPA ��Աע����������ʵݵ�ַ';

$lang['Email_settings'] = '�����ʼ�����';
$lang['Admin_email'] = '��̳����Ա�����ʼ�����';
$lang['Email_sig'] = '�����ʼ�ǩ����';
$lang['Email_sig_explain'] = '���ǩ�������ᱻ��������������̳ϵͳ�ͳ��ĵ����ʼ���';
$lang['Use_SMTP'] = 'ʹ�� SMTP ���������͵����ʼ�';
$lang['Use_SMTP_explain'] = '�������Ҫʹ�� SMTP ���������͵����ʼ���ѡ�� "��"';
$lang['SMTP_server'] = 'SMTP ����������';
$lang['SMTP_username'] = 'SMTP �û���';
$lang['SMTP_username_explain'] = 'ֻ������ smtp ������Ҫ���û�ʱ����д���ѡ��';
$lang['SMTP_password'] = 'SMTP ����';
$lang['SMTP_password_explain'] = 'ֻ������ smtp ������Ҫ������ʱ����д���ѡ��';

$lang['Disable_privmsg'] = 'վ�ڶ���';
$lang['Inbox_limits'] = '�ռ����������';
$lang['Sentbox_limits'] = '�������������';
$lang['Savebox_limits'] = '�������������';

$lang['Cookie_settings'] = 'Cookie ����'; 
$lang['Cookie_settings_explain'] = '��Щ���ÿ����� Cookie �Ķ��壬��һ��������ʹ��ϵͳĬ��ֵ�Ϳ����ˡ������Ҫ������Щ���ã���������ã����������ý�Ӱ���Ա�ĵ�¼';
$lang['Cookie_domain'] = 'Cookie ����';
$lang['Cookie_name'] = 'Cookie ����';
$lang['Cookie_path'] = 'Cookie ·��';
$lang['Cookie_secure'] = 'Cookie ��ȫ';
$lang['Session_length'] = 'Session ���ʱ�� [ �� ]';
$lang['Cookie_secure'] = 'Cookie ��ȫ [ https ]';

// Visual Confirmation
$lang['Visual_confirm'] = '������ӻ�����ȷ��';
$lang['Visual_confirm_explain'] = '��ע�������Ҫ���Ա����ϵͳ�Զ����ɵ�����ȷ����.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = '�����Զ���¼';
$lang['Allow_autologin_explain'] = 'ѡ���Ƿ������û��ڷ�����̳��ʱ��ѡ���Զ���¼';
$lang['Autologin_time'] = '�Զ���¼��Ч��';
$lang['Autologin_time_explain'] = '������ܿ��������趨ʹ�����Զ��������Ч���ڣ�����������ʱ���ڶ�û�е���Ļ���ϵͳ��ȡ��ʹ�����Զ�����Ĺ��ܡ���Ϊ 0 ���Թرմ˹��ܡ�';

//
// Forum Management
//
$lang['Forum_admin'] = '��̳����';
$lang['Forum_admin_explain'] = '�����������������������ӣ�ɾ�����༭���������з�������̳���Լ�������̳�ڵ���Ӧ���ϡ�';
$lang['Edit_forum'] = '�༭��̳';
$lang['Create_forum'] = '��������̳';
$lang['Create_category'] = '�����·���';
$lang['Remove'] = 'ɾ��';
$lang['Action'] = 'ִ��';
$lang['Update_order'] = '���´���';
$lang['Config_updated'] = '��̳���óɹ�����';
$lang['Edit'] = '�༭';
$lang['Delete'] = 'ɾ��';
$lang['Move_up'] = '����';
$lang['Move_down'] = '����';
$lang['Resync'] = '����';
$lang['No_mode'] = 'û������ģʽ';
$lang['Forum_edit_delete_explain'] = '������ʹ�����б��������һ�������ѡ���Ա����̳������ʹ�û����󷽣�ϵͳ������������ӡ�';

$lang['Move_contents'] = '�ƶ���������';
$lang['Forum_delete'] = 'ɾ����̳';
$lang['Forum_delete_explain'] = '������ʹ�����б����ɾ����̳�������)�������ƶ���������̳�ڵ������������ݡ�';

$lang['Status_locked'] = '����';
$lang['Status_unlocked'] = 'δ����';
$lang['Forum_settings'] = '��̳��������';
$lang['Forum_name'] = '��̳����';
$lang['Forum_desc'] = '��̳����';
$lang['Forum_status'] = '��̳״̬';
$lang['Forum_pruning'] = '�ƻ�ɾ��';

$lang['prune_freq'] = '���ڼ������';
$lang['prune_days'] = 'ɾ���ڼ�����û�����»ظ�������';
$lang['Set_prune_data'] = '���Ѿ�������̳�Զ��ü��Ĺ��ܣ�����δ���������á���ص���һ��������ص���Ŀ';

$lang['Move_and_Delete'] = '�ƶ�/ɾ��';

$lang['Delete_all_posts'] = 'ɾ����������';
$lang['Nowhere_to_move'] = 'û���ƶ���λ��';

$lang['Edit_Category'] = '�༭��������';
$lang['Edit_Category_explain'] = 'ʹ�����±���޸ķ�������';

$lang['Forums_updated'] = '��̳���������ϳɹ�����';

$lang['Must_delete_forums'] = '��ɾ���������֮ǰ����������ɾ���������µ�������̳';

$lang['Click_return_forumadmin'] = '���%s����%s������̳����';


//
// Smiley Management
//
$lang['smiley_title'] = '������ű༭';
$lang['smile_desc'] = '�����ѡ���У����������ӣ�ɾ�����Ǳ༭������Ż������Ű��Ա��Ա�����·������վ�ڶ�����ʹ�á�';

$lang['smiley_config'] = '�����������';
$lang['smiley_code'] = '������Ŵ���';
$lang['smiley_url'] = '����ͼƬ';
$lang['smiley_emot'] = '��������';
$lang['smile_add'] = '����һ���±���';
$lang['Smile'] = '����';
$lang['Emotion'] = '��������';

$lang['Select_pak'] = 'ѡ��ı�����Ű���.pak���ļ�';
$lang['replace_existing'] = '�滻���еı������';
$lang['keep_existing'] = '�������еı������';
$lang['smiley_import_inst'] = '��Ӧ��������Ű���ѹ���ϴ����ʵ��ı������Ŀ¼�� Ȼ��ѡ����ȷ����Ŀ���������š�';
$lang['smiley_import'] = '���������Ű�';
$lang['choose_smile_pak'] = 'ѡ��һ��������Ű� .pak �ļ�';
$lang['import'] = '����������';
$lang['smile_conflicts'] = '�ڳ�ͻ���������Ӧ������ѡ��';
$lang['del_existing_smileys'] = '����ǰ��ɾ���ɵı������';
$lang['import_smile_pack'] = '���������Ű�';
$lang['export_smile_pack'] = '����������Ű�';
$lang['export_smiles'] = '����ϣ�������еı�����������ɱ�����Ű�������%s����%s���� smiles.pak �ļ�����ȷ�����׺Ϊ.pak��';

$lang['smiley_add_success'] = '�µı�������Ѿ��ɹ�����';
$lang['smiley_edit_success'] = '��������Ѿ��ɹ�����';
$lang['smiley_import_success'] = '������Ű��Ѿ��ɹ�����!';
$lang['smiley_del_success'] = '��������Ѿ��ɹ�ɾ��';
$lang['Click_return_smileadmin'] = '���%s����%s���ر�����ű༭';


//
// User Management
//
$lang['User_admin'] = '��Ա����';
$lang['User_admin_explain'] = '������������������Ա����Ա�ĸ��������Լ��ִ������ѡ������Ҫ�޸Ļ�Ա��Ȩ�ޣ���ʹ�û�Ա���Ŷӹ����Ȩ�����ù��ܡ�';

$lang['Look_up_user'] = '��ѯ��Ա';

$lang['Admin_user_fail'] = '�޷����»�Ա�ĸ�������';
$lang['Admin_user_updated'] = '��Ա�ĸ��������Ѿ��ɹ�����';
$lang['Click_return_useradmin'] = '���%s����%s���ػ�Ա����';

$lang['User_delete'] = 'ɾ����Ա';
$lang['User_delete_explain'] = '������ｫ��ɾ����Ա�����ѡ���޷��ָ�';
$lang['User_deleted'] = '��Ա���ɹ�ɾ����';

$lang['User_status'] = '��Ա�ʺ��Ѽ���';
$lang['User_allowpm'] = '����ʹ��վ�ڶ���';
$lang['User_allowavatar'] = '����ʹ�ø���ͷ��';

$lang['Admin_avatar_explain'] = '�����ѡ�������������ɾ����Ա�ִ�ĸ���ͷ��';

$lang['User_special'] = '����Աר��';
$lang['User_special_explain'] = '�����Ա����Ա���ʺż���״̬������δ��Ȩ��Ա��ѡ�����ã���ͨ��Ա�޷����иı���Щ����';


//
// Group Management
//
$lang['Group_administration'] = '�Ŷӹ���';
$lang['Group_admin_explain'] = '�������������������Թ������еĻ�Ա�Ŷӣ������Խ�����ɾ���Լ��༭�ִ�Ļ�Ա�Ŷӡ�������ָ���Ŷӹ���Ա�������Ŷ�ģʽ������/���/���أ��Լ��Ŷӵ����ƺ�������';
$lang['Error_updating_groups'] = '�ŶӸ���ʱ��������';
$lang['Updated_group'] = '�Ŷ��Ѿ��ɹ�����';
$lang['Added_new_group'] = '�µ��Ŷ��Ѿ��ɹ�����';
$lang['Deleted_group'] = '�Ŷ��ѱ��ɹ�ɾ��';
$lang['New_group'] = '�������Ŷ�';
$lang['Edit_group'] = '�༭�Ŷ�';
$lang['group_name'] = '�Ŷ�����';
$lang['group_description'] = '�Ŷ�����';
$lang['group_moderator'] = '�Ŷӹ���Ա';
$lang['group_status'] = '�Ŷ�״̬';
$lang['group_open'] = '�����Ŷ�';
$lang['group_closed'] = '����Ŷ�';
$lang['group_hidden'] = '�����Ŷ�';
$lang['group_delete'] = 'ɾ���Ŷ�';
$lang['group_delete_check'] = 'ɾ������Ŷ�';
$lang['submit_group_changes'] = '�ύ����';
$lang['reset_group_changes'] = '�������';
$lang['No_group_name'] = '������ָ���Ŷ�����';
$lang['No_group_moderator'] = '������ָ���ŶӵĹ���Ա';
$lang['No_group_mode'] = '������ָ���Ŷ�״̬������/���/���أ�';
$lang['No_group_action'] = 'û��ָ������';
$lang['delete_group_moderator'] = 'ɾ��ԭ�е��Ŷӹ���Ա?';
$lang['delete_moderator_explain'] = '�����������Ŷӹ���Ա���ҹ�ѡ���ѡ��Ὣԭ�е��Ŷӹ���Ա���Ŷ����Ƴ����粻��ѡ�������Ա����Ϊ�Ŷӵ���ͨ��Ա��';
$lang['Click_return_groupsadmin'] = '���%s����%s�����Ŷӹ���';
$lang['Select_group'] = 'ѡ���Ŷ�';
$lang['Look_up_group'] = 'ѡ���Ŷ�';


//
// Prune Administration
//
$lang['Forum_Prune'] = '��̳����ɾ��';
$lang['Forum_Prune_explain'] = '�⽫ɾ���������޶�ʱ����û�лظ������⡣�����û��ָ��ʱ�ޣ�����)�����е����ⶼ���ᱻɾ���������޷�ɾ�����ڽ����е�ͶƱ������ǹ��档�������ֶ��Ƴ���Щ���⡣';
$lang['Do_Prune'] = 'ִ��ɾ��';
$lang['All_Forums'] = '������̳';
$lang['Prune_topics_not_posted'] = 'ɾ���ڼ�����û�����»ظ�������';
$lang['Topics_pruned'] = 'ɾ��������';
$lang['Posts_pruned'] = 'ɾ��������';
$lang['Prune_success'] = '�ɹ������̳����ɾ��';


//
// Word censor
//
$lang['Words_title'] = '���ֹ���';
$lang['Words_explain'] = '�������������������Խ������༭��ɾ���������֣���Щָ�������ֽ��ᱻ���˲����滻������ʾ�������ԱҲ���޷�ʹ�ú�����Щ�޶����ֵ�������ע�ᡣ�޶�����������ʹ��ͳ�����*�������磺*test* ������� detestable�ȣ�test* ���� testing�ȣ�*test ���� detest��';
$lang['Word'] = '��������';
$lang['Edit_word_censor'] = '�༭��������';
$lang['Replacement'] = '�滻����';
$lang['Add_new_word'] = '���ӹ�������';
$lang['Update_word'] = '���¹�������';

$lang['Must_enter_word'] = '����������Ҫ���˵����ּ����滻����';
$lang['No_word_selected'] = '��û��ѡ��Ҫ�༭�Ĺ�������';

$lang['Word_updated'] = '����ѡ��Ĺ��������Ѿ��ɹ�����';
$lang['Word_added'] = '�µĹ��������Ѿ��ɹ�����';
$lang['Word_removed'] = '����ѡ��Ĺ��������ѱ��ɹ��Ƴ�';

$lang['Click_return_wordadmin'] = '���%s����%s�������ֹ���';


//
// Mass Email
//
$lang['Mass_email_explain'] = '�����ѡ���������Է��͵����ʼ�ѶϢ�����еĻ�Ա�����ض����Ŷӵĳ�Ա���������ʼ�����������ϵͳ����Ա�ṩ�ĵ����ʼ����䣬�����ܼ������ķ�ʽ���͸������ռ��ˡ�����ռ��������࣬ϵͳ��Ҫ�ϳ���ʱ����ִ��,�����ʼ��ͳ�֮�����ĵȺ�, <b>����</b>�ڳ������֮ǰֹͣ��ҳ����.';
$lang['Compose'] = 'д�ʼ�'; 

$lang['Recipients'] = '�ռ���'; 
$lang['All_users'] = '���л�Ա';

$lang['Email_successfull'] = '�ʼ��Ѿ��ĳ�';
$lang['Click_return_massemail'] = '���%s����%s���ص����ʼ�֪ͨ';


//
// Ranks admin
//
$lang['Ranks_title'] = '�ȼ�����';
$lang['Ranks_explain'] = '������������������������ӣ��༭������Լ�ɾ���ȼ�����Ҳ����ʹ�õȼ�Ӧ���ڻ�Ա�����ܡ�';

$lang['Add_new_rank'] = '�����µĵȼ�';

$lang['Rank_title'] = '�ȼ�����';
$lang['Rank_special'] = '����ȼ�';
$lang['Rank_minimum'] = '���µ���С����';
$lang['Rank_maximum'] = '���µ��������';
$lang['Rank_image'] = '�ȼ�ͼƬ';
$lang['Rank_image_explain'] = 'ʹ�����������ȼ�ͼƬ��·��';

$lang['Must_select_rank'] = '������ѡ��һ���ȼ�';
$lang['No_assigned_rank'] = 'û��ָ���ĵȼ�';

$lang['Rank_updated'] = '�ȼ��Ѿ��ɹ�����';
$lang['Rank_added'] = '�µĵȼ��Ѿ��ɹ�����';
$lang['Rank_removed'] = '�ȼ������ѳɹ����Ƴ�';
$lang['No_update_ranks'] = '�ȼ��Ѿ��ɹ�ɾ��������ʹ�ñ��ȼ����û��ʺ���δ���¡�����Ҫ�ֶ�������Щ�ʺš�';

$lang['Click_return_rankadmin'] = '���%s����%s���صȼ�����';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = '�����ʺſ���';
$lang['Disallow_explain'] = '�����ѡ���У������Կ��ƽ��õĻ�Ա�ʺ�����(��ʹ��ͨ��� "*")����ע�⣬���޷������Ѿ�ע��ʹ�õĻ�Ա������������ɾ�������Ա�ʺţ�����ʹ�ý����ʺŵĹ��ܡ�';

$lang['Delete_disallow'] = 'ɾ��';
$lang['Delete_disallow_title'] = 'ɾ�������ʵĺ�����';
$lang['Delete_disallow_explain'] = '�����Դ��б���ѡ��Ҫ�Ƴ��Ľ����ʺŵ�����';

$lang['Add_disallow'] = '����';
$lang['Add_disallow_title'] = '���ӽ��õ��ʺ�����';
$lang['Add_disallow_explain'] = '������ʹ��ͨ��� "*" �����÷�Χ�ϴ�Ļ�Ա��';

$lang['No_disallowed'] = 'û�н��õ��ʺ�����';

$lang['Disallowed_deleted'] = '����ѡ��Ľ����ʺ������ѳɹ����Ƴ�';
$lang['Disallow_successful'] = '�µĽ����ʺ������Ѿ��ɹ�����';
$lang['Disallowed_already'] = '�޷���������������ʺ����ơ����ʺ����ƿ������ڽ����б��ڻ��ѱ�ע��ʹ��';

$lang['Click_return_disallowadmin'] = '���%s����%s���ؽ����ʺſ���';


//
// Styles Admin
//
$lang['Styles_admin'] = '��̳������';
$lang['Styles_explain'] = 'ʹ������������������ӣ�ɾ����������ֲ�ͬ����̳���(ģ�������)�ṩ��Աѡ��ʹ�á�';
$lang['Styles_addnew_explain'] = '�����б�������п�ʹ�õ����⡣����б��ϵ��������δ��װ�� phpBB 2 �����ݿ��ڡ�Ҫ��װ�µ�������ֱ�Ӱ����ҷ���ִ�����ӡ�';

$lang['Select_template'] = 'ѡ��ģ������';

$lang['Style'] = '���';
$lang['Template'] = 'ģ��';
$lang['Install'] = '��װ';
$lang['Download'] = '����';

$lang['Edit_theme'] = '�༭�������';
$lang['Edit_theme_explain'] = '������ʹ�����б��༭����������á�';

$lang['Create_theme'] = '���ӷ������';
$lang['Create_theme_explain'] = '������ʹ�����б����Ϊָ����ģ�������µķ�����⡣��������ɫʱ��������ʹ��ʮ����λ�룬���磺FFFFFF����������ʼ�ַ� #���������£�CCCCCC Ϊ��ȷ�ı�ʾ����#CCCCCC ���Ǵ���ġ�';

$lang['Export_themes'] = '����������';
$lang['Export_explain'] = '�������̳����������ָ��ģ��ķ���������ϡ����б���ѡ��ָ����ģ���ϵͳ���Ὠ�������������������ļ������浽ָ����ģ��Ŀ¼����������޷����棬������������������ļ��������ϣ��ϵͳ��ֱ�Ӵ�����Щ�ļ����ݣ�������ȷ��ָ��ģ��Ŀ¼��д���������Ҫ�����ⷽ������ϣ���ο� phpBB 2 ʹ��˵��';

$lang['Theme_installed'] = 'ָ���ķ�������Ѿ���װ���';
$lang['Style_removed'] = 'ָ������̳����Ѵ����ݿ���ɾ����Ҫ������ϵͳ����ȫ��ɾ�������̳���������� /templates ��ɾ����Ӧ��ģ��Ŀ¼';
$lang['Theme_info_saved'] = 'ָ���ķ�����������Ѿ��ɹ����档�����������޸� theme_info.cfg ��ֻ�����ԣ����������ָ����ģ��Ŀ¼��';
$lang['Theme_updated'] = 'ָ���ķ�������ѱ����¡�����������µķ����������ֵ';
$lang['Theme_created'] = '�����ѱ����������������������������ļ�����ά�������Ĳ��������ϰ�ȫ';

$lang['Confirm_delete_style'] = '��ȷ��Ҫɾ�������̳�����?';

$lang['Download_theme_cfg'] = 'ϵͳ�޷�д��������������ļ��������Ե�����µİ�ť��������ļ�����������������ļ��������ɽ��ļ��Ƶ�������ģ���Ŀ¼֮�¡����°�װ����ļ����Է��л����������ط�ʹ�á�';
$lang['No_themes'] = '��ָ����ģ�岢û�а����κεķ�����⡣Ҫ�����µķ�����⣬�밴���󷽿������� "����" ����';
$lang['No_template_dir'] = '�޷���ģ��Ŀ¼�����п�������Ϊ��Ŀ¼����Ϊ���ɶ�ȡ�����Ի����ļ�����������';
$lang['Cannot_remove_style'] = '���޷��Ƴ�Ĭ�ϵ���̳������ȱ����̳��Ĭ�Ϸ���������һ��';
$lang['Style_exists'] = 'ָ������̳��������Ѿ����ڣ���ص���һ����ѡ��һ����ͬ������';

$lang['Click_return_styleadmin'] = '���%s����%s������̳������';

$lang['Theme_settings'] = '�����������';
$lang['Theme_element'] = '�������Ԫ��';
$lang['Simple_name'] = '��������';
$lang['Value'] = '��ֵ';
$lang['Save_Settings'] = '��������';

$lang['Stylesheet'] = 'CSS ����';
$lang['Stylesheet_explain'] = '���ģ��ʹ�õ�CSS����ļ�����';
$lang['Background_image'] = '����ͼ��';
$lang['Background_color'] = '������ɫ';
$lang['Theme_name'] = '��������';
$lang['Link_color'] = '������������ɫ';
$lang['Text_color'] = '������ɫ';
$lang['VLink_color'] = '�ι۹���������ɫ��visited��';
$lang['ALink_color'] = '��갴�µ�������ɫ��active��';
$lang['HLink_color'] = '����ƹ���������ɫ��hover��';
$lang['Tr_color1'] = '�������ɫһ';
$lang['Tr_color2'] = '�������ɫ��';
$lang['Tr_color3'] = '�������ɫ��';
$lang['Tr_class1'] = '������������һ';
$lang['Tr_class2'] = '�������������';
$lang['Tr_class3'] = '��������������';
$lang['Th_color1'] = '��Ŀ������ɫһ';
$lang['Th_color2'] = '��Ŀ������ɫ��';
$lang['Th_color3'] = '��Ŀ������ɫ��';
$lang['Th_class1'] = '��Ŀ�����������һ';
$lang['Th_class2'] = '��Ŀ������������';
$lang['Th_class3'] = '��Ŀ�������������';
$lang['Td_color1'] = '���ϸ���ɫһ';
$lang['Td_color2'] = '���ϸ���ɫ��';
$lang['Td_color3'] = '���ϸ���ɫ��';
$lang['Td_class1'] = '���ϸ��������һ';
$lang['Td_class2'] = '���ϸ���������';
$lang['Td_class3'] = '���ϸ����������';
$lang['fontface1'] = '��������һ';
$lang['fontface2'] = '���������';
$lang['fontface3'] = '����������';
$lang['fontsize1'] = '�����Сһ';
$lang['fontsize2'] = '�����С��';
$lang['fontsize3'] = '�����С��';
$lang['fontcolor1'] = '������ɫһ';
$lang['fontcolor2'] = '������ɫ��';
$lang['fontcolor3'] = '������ɫ��';
$lang['span_class1'] = 'Span �������һ';
$lang['span_class2'] = 'Span ��������';
$lang['span_class3'] = 'Span ���������';
$lang['img_poll_size'] = 'ͶƱͳ����ͼʾ��С [px]';
$lang['img_pm_size'] = 'վ�ڶ���ʹ����ͼʾ��С [px]';


//
// Install Process
//
$lang['Welcome_install'] = '��ӭ��װ phpBB 2 ��̳ϵͳ';
$lang['Initial_config'] = '��������';
$lang['DB_config'] = '���ݿ�����';
$lang['Admin_config'] = 'ϵͳ����Ա����';
$lang['continue_upgrade'] = '����������ϵͳ�����ļ���config.php��֮�������԰��¡������������İ�ť������һ����������������������ɺ����ϴ������ļ���';
$lang['upgrade_submit'] = '��������';

$lang['Installer_Error'] = '��װ�����з�������';
$lang['Previous_Install'] = '��⵽��ǰ�İ�װ�汾';
$lang['Install_db_error'] = '�������ݿⷢ������';

$lang['Re_install'] = '����ǰ��װ�� phpBB 2 ��̳ϵͳ����ʹ���С�<br /><br />�����ϣ�����°�װ phpBB 2 ��̳ϵͳ��ѡ�� "��" �İ�ť�� ��ע�⣬ִ�к󽫻��Ƴ����е��ִ����ϣ����Ҳ������κα��ݣ�ϵͳ����Ա�ʺż����뽫�����½�������������Ҳ�����ᱻ������<br /><br />���������� "��" �İ�ťǰ��������!';

$lang['Inst_Step_0'] = '��л��ѡ�� phpBB 2 ��̳ϵͳ����������д������������ɰ�װ�����ڰ�װǰ������ȷ������Ҫʹ�õ����ݿ��Ѿ�������';

$lang['Start_Install'] = '��ʼ��װ';
$lang['Finish_Install'] = '��ɰ�װ';

$lang['Default_lang'] = 'Ĭ����̳ϵͳ����';
$lang['DB_Host'] = '���ݿ��������������';
$lang['DB_Name'] = '�������ݿ�����';
$lang['DB_Username'] = '���ݿ��û��ʺ�';
$lang['DB_Password'] = '���ݿ�����';
$lang['Database'] = '�������ݿ�';
$lang['Install_lang'] = 'ѡ��Ҫ��װ������';
$lang['dbms'] = '���ݿ��ʽ';
$lang['Table_Prefix'] = '���ݿ�ı��ǰ׺��Prefix��';
$lang['Admin_Username'] = 'ϵͳ����Ա�ʺ�����';
$lang['Admin_Password'] = 'ϵͳ����Ա����';
$lang['Admin_Password_confirm'] = 'ϵͳ����Ա���� [ ȷ�� ]';

$lang['Inst_Step_2'] = '����ϵͳ����Ա�ʺ��ѱ���������̳�Ļ�����װ�Ѿ���ɣ��Ժ������ִ���̳ϵͳ�Ĺ���ҳ�档 ��ȷ�����Ѽ��������õ����ò����ʵ����޸ġ���һ�θ�л��ѡ��ʹ�� phpBB 2 ��̳ϵͳ��';

$lang['Unwriteable_config'] = '����ϵͳ�����ļ��޷�д�룬�����Ե���·���ť���������ļ����ٽ�����ļ��ϴ��� phpBB 2 ��̳�����ϼС�����ɺ�������ʹ�ù���Ա�ʺŸ������¼������ϵͳ���������壨������¼���·�������һ������\'ϵͳ����������\'�����ӣ�������Ļ����������á�����л��ѡ��ʹ�ð�װ phpBB 2 ��̳ϵͳ��';
$lang['Download_config'] = '���������ļ�';

$lang['ftp_choose'] = 'ѡ�����ط�ʽ';
$lang['ftp_option'] = '<br />�� FTP ������ɺ�������ʹ���Զ��ϴ��Ĺ��ܡ�';
$lang['ftp_instructs'] = '���Ѿ�ѡ��ʹ�� FTP ȥ�Զ���װ���� phpBB 2 ��̳�� ������������������������̡���ע�⣺FTP ·���������װ phpBB 2 �� FTP ·����ȫ��ͬ��';
$lang['ftp_info'] = '�������� FTP ��Ϣ';
$lang['Attempt_ftp'] = 'ʹ�� FTP �ϴ������ļ�:';
$lang['Send_file'] = '�����ϴ������ļ�';
$lang['ftp_path'] = '��װ phpBB 2 �� FTP ·��:';
$lang['ftp_username'] = '���� FTP ��¼����:';
$lang['ftp_password'] = '���� FTP ��¼����:';
$lang['Transfer_config'] = '��ʼ����';
$lang['NoFTP_config'] = 'FTP �ϴ������ļ�ʧ�ܡ������������ļ���ʹ���ֶ��ϴ���';

$lang['Install'] = '������װ';
$lang['Upgrade'] = 'ϵͳ����';

$lang['Install_Method'] = '��ѡ��װģʽ';

$lang['Install_No_Ext'] = '���������ϵ� php ���ò�֧����ѡ������͵����ݿ⡣';

$lang['Install_No_PCRE'] = 'phpBB2 ��Ҫ Perl ���ݵı�׼���ģ�飨Regular Expressions Module���������� php ���ò�֧�ִ����!';


//
// Online/Offline/Hidden Mod
//
$lang['Online_setting'] = '����״̬����';
$lang['Online_color'] = '��������ɫ��';
$lang['Offline_color'] = '��������ɫ��';
$lang['Hidden_color'] = '��������ɫ��';

//
// Yellow card admin MOD
//
$lang['Ban'] = '��ֹ'; 
$lang['Max_user_bancard'] = '��󾯸����'; 
$lang['Max_user_bancard_explain'] = '���һ����Ա�õ��ľ��������������, �˻�Ա����ϵͳ��ֹ'; 
$lang['ban_card'] = '����'; 
$lang['ban_card_explain'] = '����������ޣ�%d�Ż��ƣ�����ϵͳ��ֹ'; 
$lang['Greencard'] = 'ȡ����ֹ'; 
$lang['Bluecard'] = '��������'; 
$lang['Bluecard_limit'] = '���Ƽ������'; 
$lang['Bluecard_limit_explain'] = '��һ������ÿ�õ�����������ʱ�����ٴ���ʾ����'; 
$lang['Bluecard_limit_2'] = '�����޶�'; 
$lang['Bluecard_limit_2_explain'] = '�����ӵõ����޶�涨�������������ͽ���ʾ����'; 
$lang['Report_forum']= '������̳';
$lang['Report_forum_explain'] = '��д��̳ID�ű�Ǵ���̳�����ɻ�Ա��������, ����0��ʾ��ֹ�˹���, ��Ա�ڴ���̳�б��������з���ͻظ���Ȩ��';

//
// SQR
//
$lang['SQR_settings'] = '���ٻظ�����';
$lang['Allow_quick_reply'] = '������ٻظ�';
$lang['Anonymous_show_SQR'] = '�ο�ʹ�ÿ��ٻظ���';
$lang['Anonymous_SQR_mode'] = '�οͿ��ٻظ�ģʽ';
$lang['Anonymous_open_SQR'] = '�οͿ��ٻظ����Զ���';

//
//  Global announcement MOD
//
$lang['Globalannounce'] ='��̳ͨ��'; 

//
// Birthday MOD
//
$lang['Birthday_required'] = 'ǿ���û���������';
$lang['Enable_birthday_greeting'] = '��������ף��'; 
$lang['Birthday_greeting_expain'] = '��Ա����ύ�����ǵ����ս����������̳ʱ�õ�����ף��'; 
$lang['Next_birthday_greeting'] = '��һ��ף�����յ����'; 
$lang['Next_birthday_greeting_expain'] = '������һ��ݵ�����ף��'; 
$lang['Wrong_next_birthday_greeting'] = '��д����һף��������ݲ���ȷ��������'; 
$lang['Max_user_age'] = '���������ֵ'; 
$lang['Min_user_age'] = '������С��ֵ'; 
$lang['Birthday_lookforward'] = '����Ԥ��'; 
$lang['Birthday_lookforward_explain'] = '����Ԥ������'; 

$lang['Links'] ='�������ӹ���';

//
// Version Check
//
$lang['Version_up_to_date'] = '����װ�ĳ��������µģ�û�п���������phpBB�ĸ��¡�';
$lang['Version_not_up_to_date'] = '����װ�ĳ���<b>����</b>���µģ������ <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> ��ʱ���¡�';
$lang['Latest_version_info'] = '���µİ汾�� <b>phpBB %s</b>��';
$lang['Current_version_info'] = '������ʹ�õ��� <b>phpBB %s</b>��';
$lang['Connect_socket_error'] = '�޷����ӵ�phpBB���������������Ϊ��<br />%s';
$lang['Socket_functions_disabled'] = '�޷�ʹ�� socket ������';
$lang['Mailing_list_subscribe_reminder'] = '����phpBB���°汾������Ϣ��<a href="http://www.phpbb.com/support/" target="_new">��Ԥ�����ǵ��ʼ�֪ͨ</a>��';
$lang['Version_information'] = '�汾��Ϣ';
$lang['Commend'] = '����';

//
// Auto Group MOD
//
$lang['group_count'] = '����ķ�����';
$lang['group_count_max'] = '�������';
$lang['group_count_updated'] = '%d λ��Ա�Ѿ����Ƴ���%d λ��Ա�������Ŷ�';
$lang['Group_count_enable'] = '�û�����ʱ�Զ�����';
$lang['Group_count_update'] = '����/�������û�';
$lang['Group_count_delete'] = 'ɾ��/�������û�';
$lang['User_allow_ag'] = "�����Զ��Ŷ�";
$lang['group_count_explain'] = '���û�������<i>�������а��棩</i>�������ֵʱ������������Ŷ�<br/> ��ֻ����"'.$lang['Group_count_enable'].'"��ʱ�Ż�������';

$lang['Resync_Stats'] = 'ͬ��ͳ��';
$lang['Resync_Post_counts'] = 'ͬ��������';
$lang['Prune_Posts'] = '��������';
$lang['Forum_sub'] = "<br>�Ӱ���";
$lang['Forum_icon'] = '����ͼƬ';
$lang['Forum_icon_explain'] = '����ͼƬλ���� ../images/icons/����ȷ������ͼƬ�����ϼ�֮�С�';
$lang['Forum_icon_none'] = '��ʹ��';
$lang['Prune_users'] = '�����û�';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = '����ĵ�½����';
$lang['Max_login_attempts_explain'] = '�����Ե�½��̳�Ĵ�����';
$lang['Login_reset_time'] = '��½����ʱ��';
$lang['Login_reset_time_explain'] = '���û��������Ե�½�����������ٴε�½����Ҫ��ʱ�䣨���ӣ���';

//
// That's all Folks!
// -------------------------------------------------
?>