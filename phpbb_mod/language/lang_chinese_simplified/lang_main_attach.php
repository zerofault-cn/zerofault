<?php
/** 
*
* attachment mod main [English]
*
* @package attachment_mod
* @version $Id: lang_main_attach.php,v 1.1 2005/11/05 10:25:02 acydburn Exp $
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
// Attachment Mod Main Language Variables
//

// Auth Related Entries
$lang['Rules_attach_can'] = '��<b>����</b>�������̳��Ӹ���';
$lang['Rules_attach_cannot'] = '��<b>����</b>�������̳��Ӹ���';
$lang['Rules_download_can'] = '��<b>����</b>�������̳�����ļ�';
$lang['Rules_download_cannot'] = '��<b>����</b>�������̳�����ļ�';
$lang['Sorry_auth_view_attach'] = '�Բ�����û�б���Ȩ�鿴�����������Ӹ�����';

// Viewtopic -> Display of Attachments
$lang['Description'] = '����'; // used in Administration Panel too...
$lang['Downloaded'] = '���ع���';
$lang['Download'] = '����'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['Filesize'] = '�ļ���С';
$lang['Viewed'] = '������';
$lang['Download_number'] = '�ļ������ػ�鿴 %d ��'; // replace %d with count
$lang['Extension_disabled_after_posting'] = '��չ�� \'%s\' �ѱ�ϵͳ����Աͣ�ã������������ǲ�����ʾ�ġ�'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display
$lang['Attach_posting_cp'] = '��������������';
$lang['Attach_posting_cp_explain'] = '�����������������������������Կ��������ĶԻ���<br />�ϴ��µİ汾�����������Ҫ���ش��������������ԭ�Ⱦɰ���ļ���<br />����ϴ��°汾�ļ����ȵ��������ĸ����嵥�����ٵ�����������������ٵ�[��������]�еġ��������<br />ѡ���°汾���ļ�֮���ٵ��[����ĸ����嵥]�еġ��ϴ��µİ汾����';

// Posting/PM -> Posting Attachments
$lang['Add_attachment'] = '��������';
$lang['Add_attachment_title'] = '��������';
$lang['Add_attachment_explain'] = '����������������������������У������ռ��ɡ�';
$lang['File_name'] = '�ļ���';
$lang['File_comment'] = '�ļ�ע��';

// Posting/PM -> Posted Attachments
$lang['Posted_attachments'] = '����ĸ����嵥';
$lang['Options'] = 'ѡ��';
$lang['Update_comment'] = '����ע��';
$lang['Delete_attachments'] = 'ɾ������';
$lang['Delete_attachment'] = 'ɾ������';
$lang['Delete_thumbnail'] = 'ɾ������ͼ';
$lang['Upload_new_version'] = '�ϴ��µİ汾';

// Errors -> Posting Attachments
$lang['Invalid_filename'] = '%s ��һ����Ч���ļ���'; // replace %s with given filename
$lang['Attachment_php_size_na'] = '����̫���ˡ�<br />�޷�ȡ���� PHP ����Ĵ�С���ơ�<br />ϵͳ�޷�ȷ�������� php.ini �е�����ϴ���С��';
$lang['Attachment_php_size_overrun'] = '�����ļ�̫���ˡ�<br />����ϴ���С: %d MB��<br />��ע���Ǹ���С�Ƕ����� php.ini������������� PHP ���趨����ϵͳ�޷��ı������ֵ��'; // replace %d with ini_get('upload_max_filesize')
$lang['Disallowed_extension'] = '��չ�� %s �ǲ��������'; // replace %s with extension (e.g. .php) 
$lang['Disallowed_extension_within_forum'] = '��δ�������ڴ���̳�����չ��Ϊ %s�ĸ���';
$lang['Attachment_too_big'] = '����̫���ˡ�<br />���Ĵ�С: %d %s'; // replace %d with maximum file size, %s with size var
$lang['Attach_quota_reached'] = '�Բ����Ѵﵽȫ�����������ļ���С���ơ����������������ϵϵͳ����Ա��';
$lang['Too_many_attachments'] = '�����޷�������������������ơ�%d ���ĸ����ļ��������������ɡ�'; // replace %d with maximum number of attachments
$lang['Error_imagesize'] = '����/ͼƬ����С�ڿ�� %d ���غ͸߶� %d ����'; 
$lang['General_upload_error'] = '�ϴ�����: �޷��ϴ������� %s ��'; // replace %s with local path

$lang['Error_empty_add_attachbox'] = '���������ڡ������������Ի��������������Ȼ������Ҫ���µ���Ŀ������ϴ��µİ汾����';
$lang['Error_missing_old_entry'] = '�޷����¸������޷��ҵ��ɵĸ�����Ŀ��';

// Errors -> PM Related
$lang['Attach_quota_sender_pm_reached'] = '�Բ��𣬵���������վ�ڶ����ռ����Ѵﵽȫ�������ļ�����ļ��Ĵ�С���ơ���ɾ��һЩ�������ռ���/����ϻ�ĸ����ļ���';
$lang['Attach_quota_receiver_pm_reached'] = '�Բ��𣬵�����վ�ڶ����ռ��е� \'%s\' �Ѵﵽȫ�������ļ�������ļ��Ĵ�С���ơ���������֪������ȴ�ֱ����/��ɾ��һЩ������/���ĸ����ļ���';

// Errors -> Download
$lang['No_attachment_selected'] = '��û��ѡ��һ�����������ػ�鿴��';
$lang['Error_no_attachment'] = 'ѡ��ĸ��������ڡ�';

// Delete Attachments
$lang['Confirm_delete_attachments'] = '��ȷ������Ҫɾ��ѡ��ĸ���?';
$lang['Deleted_attachments'] = 'ѡ��ĸ����ѱ�ɾ����';
$lang['Error_deleted_attachments'] = '�޷�ɾ��������';
$lang['Confirm_delete_pm_attachments'] = '��ȷ������Ҫɾ���ѷ��������վ�ڶ�����ȫ���ĸ�����?';

// General Error Messages
$lang['Attachment_feature_disabled'] = '���������ѱ�ͣ�á�';

$lang['Directory_does_not_exist'] = '�ļ��� \'%s\' �����ڻ��Ҳ�����'; // replace %s with directory
$lang['Directory_is_not_a_dir'] = '��� \'%s\' ��һ���ļ������ˡ�'; // replace %s with directory
$lang['Directory_not_writeable'] = '�ļ��� \'%s\' �ǲ���д��ġ�������Ҫ�����ϴ�·�����������Ϊ 777 (����ӵ����Ϊ�� httpd-��������ӵ����) Ҫ�ϴ��ļ���<br />�����ֻҪ��ȫ�� ftp-��ȡ ����ļ��е� \'����\' Ϊ rwxrwxrwx��'; // replace %s with directory

$lang['Ftp_error_connect'] = '�޷����ߵ� FTP ������: \'%s\'���������� FTP-�趨��';
$lang['Ftp_error_login'] = '�޷����뵽 FTP �����������û����� \'%s\' �������Ǵ���ġ��������� FTP-�趨��';
$lang['Ftp_error_path'] = '�޷���ȡ FTP �ļ���: \'%s\'���������� FTP �趨��';
$lang['Ftp_error_upload'] = '�޷��ϴ��ļ��� FTP �ļ���: \'%s\'���������� FTP �趨��';
$lang['Ftp_error_delete'] = '�޷�ɾ���� FTP �ļ��е��ļ�: \'%s\'���������� FTP �趨��<br />';
$lang['Ftp_error_pasv_mode'] = '�޷�����/�ر�FTP����ģʽ';

// Attach Rules Window
$lang['Rules_page'] = '��������';
$lang['Attach_rules_title'] = '��������չ��Ⱥ������ǵĴ�С';
$lang['Group_rule_header'] = '%s -> ����ϴ��Ĵ�С: %s';
$lang['Allowed_extensions_and_sizes'] = '�������չ���ʹ�С';
$lang['Note_user_empty_group_permissions'] = 'ע��:<br />������������̳��Ӹ�����<br />������Ϊû�и�����չ��Ⱥ�鱻������Ӽӣ�<br />���޷�����κ��ļ�����������Ÿ����ļ���<br />�㽫���յ�����ѶϢ��<br />';

// Quota Variables
$lang['Upload_quota'] = '�ϴ��޶�';
$lang['Pm_quota'] = '˽�˶����޶�';
$lang['User_upload_quota_reached'] = '�Բ������Ѿ��ﵽ���������ϴ��޶� %d %s'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel
$lang['User_acp_title'] = '���񸽼��������';
$lang['UACP'] = '�û������������';
$lang['User_uploaded_profile'] = '�ϴ���: %s';
$lang['User_quota_profile'] = '�޶�Ϊ: %s';
$lang['Upload_percent_profile'] = '�ܹ���%d%%';

// Common Variables
$lang['Bytes'] = '�ֽ�';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';
$lang['Attach_search_query'] = '��������';
$lang['Test_settings'] = '�����趨';
$lang['Not_assigned'] = 'δ��ָ��';
$lang['No_file_comment_available'] = '�޿��õ��ļ�ע��';
$lang['Attachbox_limit'] = '���ĸ�������ʹ��%d%%';
$lang['No_quota_limit'] = 'û�и����޶�';
$lang['Unlimited'] = 'û�����Ƶ�';

?>