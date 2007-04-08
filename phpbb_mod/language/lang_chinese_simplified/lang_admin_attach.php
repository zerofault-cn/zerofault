<?php
/** 
*
* attachment mod admin [English]
*
* @package attachment_mod
* @version $Id: lang_admin_attach.php,v 1.3 2005/11/20 13:38:55 acydburn Exp $
* @copyright (c) 2002 Meik Sievertsen
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (!isset($lang) || !is_array($lang))
{
	$lang = array();
}

//
// Attachment Mod Admin Language Variables
//

// Modules, this replaces the keys used
$lang['Control_Panel'] = '����̨';
$lang['Shadow_attachments'] = '�����ļ�';
$lang['Forbidden_extensions'] = '��ֹ��չ��';
$lang['Extension_control'] = '��չ������';
$lang['Extension_group_manage'] = '��չ��Ⱥ�����';
$lang['Special_categories'] = '�������';
$lang['Sync_attachments'] = 'ͬ������';
$lang['Quota_limits'] = '�޶��趨';

// Attachments -> Management
$lang['Attach_settings'] = '�����趨';
$lang['Manage_attachments_explain'] = '������������趨�������ܵ���Ҫ�趨��������������趨��ť���������ܿ�����Щϵͳ������ȷ���ǹ��ܻ���ȷ����������������ϴ��ļ������⣬��ִ��������ԣ��������ϸ�Ĵ���ѶϢ��';
$lang['Attach_filesize_settings'] = '�����ļ���С�趨';
$lang['Attach_number_settings'] = '���������趨';
$lang['Attach_options_settings'] = '����ѡ��';

$lang['Upload_directory'] = '�ϴ��ļ���';
$lang['Upload_directory_explain'] = '�������·��������� phpBB2 ��װ�������ϴ��ļ��С����磬���� \'files\' ������ phpBB2 ��װ��λ���� http://www.yourdomain.com/phpBB2 �������ϴ��ļ��е�λ���� http://www.yourdomain.com/phpBB2/files��';
$lang['Attach_img_path'] = '��������ͼʾ';
$lang['Attach_img_path_explain'] = '�ڵ����ķ������ͼƬ����ʾ�ڸ��������ǰ�档���������λ�հ׵�����㲻��Ҫͼʾ����ʾ������趨���Ḳд���趨����չ��Ⱥ�����';
$lang['Attach_topic_icon'] = '��������ͼʾ';
$lang['Attach_topic_icon_explain'] = '���ͼƬ����ʾ���и����������ǰ�档���������λ�հ�����㲻��Ҫͼʾ����ʾ��';
$lang['Attach_display_order'] = '������ʾ����';
$lang['Attach_display_order_explain'] = '�����ﲻ�����ڷ�������/վ�ڶ��� ��ʾ�����ѡ�񸽼������������ӵ�ʱ����������ʾ����:��[�ݼ�]���ļ�ʱ�����(����ĸ�����������ʾ)����[����]���ļ�ʱ�����(����ĸ�����������ʾ)����';
$lang['Show_apcp'] = '��ʾ�°渽���������̨';
$lang['Show_apcp_explain'] = 'ѡ�� 2.32 ��������°渽���������̨(ѡ��:��)������ѡ 2.24 ��ǰ�ɰ�ĸ����������̨(ѡ��:��)������е����Խ��ͣ�����������Լ�ȥ��һ����!';

$lang['Max_filesize_attach'] = '�ļ���С';
$lang['Max_filesize_attach_explain'] = '�����������ļ���С(�ֽ�)����ֵ 0 ����\'û������\'������趨�������Ƶı���ķ�������̬�����磬������ php ��ֻ̬��������ϴ��Ĵ�С 2 MB������޷����⹦�ܸ�д��';
$lang['Attach_quota'] = '�����޶�';
$lang['Attach_quota_explain'] = '�������վ�ռ����ά�����Ĵ��̿ռ�ȫ���ĸ�����';
$lang['Max_filesize_pm'] = '��վ�ڶ����ļ��е�����ļ���С';
$lang['Max_filesize_pm_explain'] = '�����̿ռ丽������ʹ�õ���ÿ��ʹ���ߵ�վ�ڶ����ռ�ϻ��'; 
$lang['Default_quota_limit'] = 'Ĭ���޶�';
$lang['Default_quota_limit_explain'] = '���������ѡ��һ��Ĭ���޶����ע����û���û��ָ���޿͵��û���ѡ����޶��趨����ʾû���޶��趨����ʹ������ĸ�����С�趨��';

$lang['Max_attachments'] = '�������������';
$lang['Max_attachments_explain'] = '��һ�����������������Ը�����������';
$lang['Max_attachments_pm'] = 'վ�ڶ��������ĸ���������';
$lang['Max_attachments_pm_explain'] = '����ʹ������������һ��վ�ڶ����������฽����������';

$lang['Disable_mod'] = '�رո�������';
$lang['Disable_mod_explain'] = '���ѡ������Ҫ�������µ���������⣬���ر�ȫ�������Ĺ��ܳ����ڹ������̨֮�⡣';
$lang['PM_Attachments'] = '������վ�ڶ����︽��';
$lang['PM_Attachments_explain'] = '����/����������վ�ڶ����';
$lang['Ftp_upload'] = '���� FTP �ϴ�';
$lang['Ftp_upload_explain'] = '����/ͣ�� FTP �ϴ�ѡ�������趨��Ϊ���ǡ�������붨�帽�� FTP �趨���ϴ��ļ����ǲ���ʹ�õġ�';
$lang['Attachment_topic_review'] = '����Ҫ��ʾ�����ڲ鿴�����Ӵ���?';
$lang['Attachment_topic_review_explain'] = '�����ѡ���ǡ�������ظ�����ʱȫ���Ѹ��ӵ��ļ������ڲ鿴��������ʾ��';

$lang['Ftp_server'] = 'FTP �ϴ�������';
$lang['Ftp_server_explain'] = '��������������� IP-λַ�������ʹ�õ� FTP-����������Ϊ����ϴ����ļ�λַ������㱣�������λ�հ׵ģ��������ڵ���� phpBB2 �������ѱ���װʱ��ʹ�õ�����ע�������ǲ�������롸ftp://����λַ��ǰ�棬ֻҪ��ȫ�� ftp.foo.com����Ҫ�Ͽ��ʱ��,ֻҪʹ����ȫ�� IP λַ���ɡ�';

$lang['Attach_ftp_path'] = 'FTP ·��������ϴ��ļ���';
$lang['Attach_ftp_path_explain'] = '��ĸ���Ҫ������ļ��С�����ļ��в���Ҫ������ԡ��벻Ҫ������������� IP �� FTP-λַ�����������λֻҪ�ṩ FTP ·����<br />����: /home/web/uploads';
$lang['Ftp_download_path'] = '�������ᵽ FTP ·��';
$lang['Ftp_download_path_explain'] = '����·������� FTP ·������ĸ�������ĵط���������������·�������� http://www.mystorage.com/phpBB2/upload�����ŵ�б�ߡ�/�������Ƴ���<br />���������λ�հ׵ģ��������·������������վ��Ŀ¼�������������λ�հ׵����޷�ʹ��ʵ������ط�ʽ��';
$lang['Ftp_passive_mode'] = '����FTP����ģʽ';
$lang['Ftp_passive_mode_explain'] = 'PASV����Ҫ��Զ�̷�������һ���˿���������ͨѶ���ӣ������ض˿ڵĵ�ַ�����Զ�̷��������Ǹ��˿��������û������ӡ�';

$lang['No_ftp_extensions_installed'] = '�㲻��ʹ��FTP�ϴ����ܣ���Ϊ�㰲װ��PHP��֧��FTP���ܡ�';

// Attachments -> Shadow Attachments
$lang['Shadow_attachments_explain'] = '�����������ɾ���������ϴӷ��������е��ļ�������ļ�ϵͳ��ʧ��ʱ�򣬲���ɾ����Щ�Ͼ�û�и��ӵ��κη������µ��ļ��������������������������ػ�鿴�ļ�; ���Ŀǰ��û������ģ��ļ��Ͳ�����ڡ�';
$lang['Shadow_attachments_file_explain'] = 'ɾ��ȫ���ĸ�����Щ������ļ�ϵͳ������û��ָ�������ڵķ������¡�';
$lang['Shadow_attachments_row_explain'] = 'ɾ��ȫ������������ĸ������϶����ļ���Щ����������ļ�ϵͳ��';
$lang['Empty_file_entry'] = '���ļ�';

// Attachments -> Sync
$lang['Sync_thumbnail_resetted'] = '����ͼ�����������: %s';
$lang['Attach_sync_finished'] = '����ͬ����ɡ�';
$lang['Sync_topics'] = 'ͬ������';
$lang['Sync_posts'] = 'ͬ������';
$lang['Sync_thumbnails'] = 'ͬ������ͼ';

// Extensions -> Extension Control
$lang['Manage_extensions'] = '������չ��';
$lang['Manage_extensions_explain'] = '����������Թ�������ļ���չ����������������������ϵ�����չ������ʹ����չ��Ⱥ�����';
$lang['Explanation'] = '����';
$lang['Extension_group'] = '��չ��Ⱥ��';
$lang['Invalid_extension'] = '��Ч��չ��';
$lang['Extension_exist'] = '��չ�� %s �Ѿ�����'; // replace %s with the Extension
$lang['Unable_add_forbidden_extension'] = '��չ�� %s �ǽ�ֹ�ϴ��ģ���û�н����������������չ��Ⱥ���';

// Extensions -> Extension Groups Management
$lang['Manage_extension_groups'] = '������չ��Ⱥ��';
$lang['Manage_extension_groups_explain'] = '����������Լ��룬ɾ�����޸������չ��Ⱥ�飬�����ͣ����չ��Ⱥ�飬ָ�������������ǣ�������ذ취��������Զ����ϴ�ͼʾ��������ʾ�ڸ������õ�Ⱥ�����ǰ��ʱ��';
$lang['Special_category'] = '�������';
$lang['Category_images'] = 'ͼƬ';
$lang['Category_stream_files'] = '�����ļ�';
$lang['Category_swf_files'] = 'Flash �ļ�';
$lang['Allowed'] = '�����';
$lang['Allowed_forums'] = '���������̳';
$lang['Ext_group_permissions'] = 'Ⱥ��Ȩ��';
$lang['Download_mode'] = '����ģʽ';
$lang['Upload_icon'] = '�ϴ�ͼʾ';
$lang['Max_groups_filesize'] = '�����ļ���С';
$lang['Extension_group_exist'] = '��չ��Ⱥ�� %s �Ѿ�����'; // replace %s with the group name
$lang['Collapse'] = '+';
$lang['Decollapse'] = '-';

// Extensions -> Special Categories
$lang['Manage_categories'] = '�����������';
$lang['Manage_categories_explain'] = '�������������̬�������������趨�����������������������ָ������չ��Ⱥ�顣';
$lang['Settings_cat_images'] = '��������趨: ͼƬ';
$lang['Settings_cat_streams'] = '��������趨: �����ļ�';
$lang['Settings_cat_flash'] = '��������趨: Flash �ļ�';
$lang['Display_inlined'] = '������ʾͼƬ';
$lang['Display_inlined_explain'] = '��ѡ��ͼƬ����ʾ��ʽ:ֱ���ڷ�����������ʾͼƬ(ѡ��:��)�����߽�ͼƬ��ʾ��һ������(ѡ��:��)?';
$lang['Max_image_size'] = '����ͼƬ�ߴ�';
$lang['Max_image_size_explain'] = '����������Զ�����������ͼƬ�ߴ絽�����(��� x �߶�,��λ:����)��<br />��������趨Ϊ 0x0����������Ǳ�ͣ�õġ���������PHP�е�ĳЩͼƬ������ܽ��������á�';
$lang['Image_link_size'] = 'ͼƬ�����ʾ�ߴ�';
$lang['Image_link_size_explain'] = '���������ʾ�鿴�����õģ���ͼƬ�ߴ糬�����ﶨ��ĳߴ磬<br />ͼƬ��������ԭʼ�����Զ���С(��� x �߶�,��λ:����)��<br />��������趨�� 0x0 �򲻻�����ͼƬ�Ĵ�С����������PHP�е�ĳЩͼƬ������ܽ��������á�';
$lang['Assigned_group'] = 'ָ����Ⱥ��';

$lang['Image_create_thumbnail'] = '��������ͼ';
$lang['Image_create_thumbnail_explain'] = '��Զʹ�ý�������ͼ��������ܼ����Ʒ�������������ȫ�����趨���������ͼƬ�ߴ�֮�⡣ʹ��������ܽ�ʹ����ͼ����ʾ�ڷ���������У�ʹ���߿��Ե������ͼ������ͼƬ��<br />��ע���⹦����Ҫ��װ Imagick�����û�а�װ Imagick ���Ҽ��������ð�ȫģʽ���� PHP �� GD-Extention ����ʹ�á����ͼƬ������ PHP ��֧Ԯ�ģ�������ܽ��޷�ʹ�á�';
$lang['Image_min_thumb_filesize'] = '��С������ͼ�ļ���С';
$lang['Image_min_thumb_filesize_explain'] = '���ͼƬС�����������ļ���С��û������ͼ�ᱻ��������Ϊ���Ѿ���С�ˡ�';
$lang['Image_imagick_path'] = 'Imagick ����ͼ��ʽ (����·��)';
$lang['Image_imagick_path_explain'] = '���� Imagick ������ͼת����ʽ��·����һ���� /usr/bin/convert (�� windows ��: c:/imagemagick/convert.exe)��';
$lang['Image_search_imagick'] = '��Ѱ Imagick';

$lang['Use_gd2'] = 'ʹ��GD2��չ';
$lang['Use_gd2_explain'] = 'PHP������ʹ��GD1��GD2��չ���ܶ�ͼƬ���в���. Ҫ��ȷ��������ͼ��������ʹ��imagemagick,����Mod�ṩ�����ֲ�ͬ�ķ�������������������ѡ��. �����ͼ�������ͼƬ���������Գ��Ըı�����.';
$lang['Attachment_version'] = '����Mod�汾�� %s'; // %s is the version number

// Extensions -> Forbidden Extensions
$lang['Manage_forbidden_extensions'] = '�����ֹ��չ��';
$lang['Manage_forbidden_extensions_explain'] = '����������Լ����ɾ����ֹ����չ��������չ�� php, php3 �� php4 ���ڶ�Ԥ���ֹ�Ļ��ڰ�ȫ���ɣ��㲻����ɾ�����ǡ�';
$lang['Forbidden_extension_exist'] = '��ֹ����չ�� %s �Ѿ�����'; // replace %s with the extension
$lang['Extension_exist_forbidden'] = '��չ�� %s ���Ѷ����������������չ�������������������֮ǰ����ɾ����';

// Extensions -> Extension Groups Control -> Group Permissions
$lang['Group_permissions_title'] = '��չ��Ⱥ��Ȩ�� -> \'%s\'';
$lang['Group_permissions_explain'] = '���������ܹ�������ѡ�����չ��Ⱥ���ȷ������̳(�������������̳�Ի���)��Ԥ��Ϊ������չ��Ⱥ���ȫ����̳��ʹ�����ǿ��Ը�����(һ�㷽ʽ���������Ǹ���ѧ��ʹ��)��ֻҪ������Щ��̳������ʹ�õ���չ��Ⱥ��(��չ�����������Ⱥ��ʹ��)��������׼��ʹ�ã�Ԥ��Ϊȫ����̳��������ֵ��������̳���嵥�С���������κ�ʱ�����¼���ȫ����̳������������̳�������������Ȩ�����趨��ȫ����̳�ǲ������κθı䡣����������б�������ƴ�ȡ��ĳЩ��̳�������ص����������������½�������̳����������ִ��������Զ��أ����������ǿ����ȥ�༭һ�����ļ�������һ�ѡ���ⷽ������Ŀǰ�����Ρ���������ģ���Щȫ�������̳�����ڴ��г���';
$lang['Note_admin_empty_group_permissions'] = 'ע��:<br />ʹ���������б����̳��ʹ����ͨ���Ǳ�������Ӹ����������Դ�û����չ��Ⱥ�������ﱻ����ȥ���ӵģ����ʹ�������޷������κ��ļ��ġ���������������Ը����ļ������ǽ�����յ�����ѶϢ����������Ҫ�趨Ȩ��\'�ɸ��ӵ��ļ�\' �������������̳�ĸ�����<br /><br />';
$lang['Add_forums'] = '������̳';
$lang['Add_selected'] = '������ѡ���';
$lang['Perm_all_forums'] = 'ȫ����̳';

// Attachments -> Quota Limits
$lang['Manage_quotas'] = '�������޶�';
$lang['Manage_quotas_explain'] = '�������������/ɾ��/�޸��޶����԰���Щ�޶�������Ա���Ŷӡ�Ҫ��һ���޶�����һ����Ա�������ͨ����Ա����->����ѡ�ѡ���û�����������濴�����ѡ�Ҫ��һ���޶�����һ���Ŷӣ������ͨ���Ŷӹ���->����ѡ�ѡ���ŶӺ���ῴ��������������鿴һ���޶���������Щ�û����Ŷӣ�����޶�������ߵ�\'���\'��';
$lang['Assigned_users'] = '��������û�';
$lang['Assigned_groups'] = '��������Ŷ�';
$lang['Quota_limit_exist'] = '�޿�%s�Ѿ����ڡ�'; // Replace %s with the Quota Description

// Attachments -> Control Panel
$lang['Control_panel_title'] = '�ļ����ӿ���̨';
$lang['Control_panel_explain'] = '����������Բ鿴�͹���ȫ���ĸ��������趨��ʹ���ߣ��������鿴����...';
$lang['File_comment_cp'] = '�ļ�ע��';

// Control Panel -> Search
$lang['Search_wildcard_explain'] = 'ʹ�� * ����ͨ�����Ϊ���ϵĲ���';
$lang['Size_smaller_than'] = '������СС��(�ֽ�)';
$lang['Size_greater_than'] = '������С����(�ֽ�)';
$lang['Count_smaller_than'] = '���ش�����С��';
$lang['Count_greater_than'] = '���ش����Ǵ���';
$lang['More_days_old'] = '����Щ�������ɵ�';
$lang['No_attach_search_match'] = 'û�и������������������';

// Control Panel -> Statistics
$lang['Number_of_attachments'] = '����������';
$lang['Total_filesize'] = '�ܼ��ļ���С';
$lang['Number_posts_attach'] = '�������º͸���������';
$lang['Number_topics_attach'] = '�����븽��������';
$lang['Number_users_attach'] = '�����ʹ�����ѷ���ĸ���';
$lang['Number_pms_attach'] = '�ܼƸ�����������վ�ڶ���';

// Control Panel -> Attachments
$lang['Statistics_for_user'] = '%s �ĸ���ͳ��'; // replace %s with username
$lang['Size_in_kb'] = '��С (KB)';
$lang['Downloads'] = '���ش���';
$lang['Post_time'] = '����ʱ��';
$lang['Posted_in_topic'] = '����������';
$lang['Submit_changes'] = '�ͳ����';

// Sort Types
$lang['Sort_Attachments'] = '����';
$lang['Sort_Size'] = '��С';
$lang['Sort_Filename'] = '����';
$lang['Sort_Comment'] = 'ע��';
$lang['Sort_Extension'] = '��չ��';
$lang['Sort_Downloads'] = '���ش���';
$lang['Sort_Posttime'] = '����ʱ��';
$lang['Sort_Posts'] = '����';

// View Types
$lang['View_Statistic'] = 'ͳ��';
$lang['View_Search'] = '��Ѱ';
$lang['View_Username'] = 'ʹ��������';
$lang['View_Attachments'] = '����';

// Successfully updated
$lang['Attach_config_updated'] = '�����趨�������';//Attachment Configuration updated successfully
$lang['Click_return_attach_config'] = '��� %s����%s �ص������趨';
$lang['Test_settings_successful'] = '�趨������ɣ��趨�������Ǻõġ�';

// Some basic definitions
$lang['Attachments'] = '����';
$lang['Attachment'] = '����';
$lang['Extensions'] = '��չ��';
$lang['Extension'] = '��չ��';

// Auth pages
$lang['Auth_attach'] = '�����ļ�';
$lang['Auth_download'] = '�����ļ�';

$lang['Sort_Descending'] = '�ݼ�'; 
$lang['Sort_Ascending'] = '����'; 
?>