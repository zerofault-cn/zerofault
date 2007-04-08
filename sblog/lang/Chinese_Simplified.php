<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL

		Language	Chinese Simplified
		Author	inso <http://www.sblog.cn>
		Edited	2005-04-08

	 **************************************************/

	// set locale
	setlocale(LC_ALL, 'zh_CN', 'chs');
	
	$lang =	array(
					// Messages
					'Administrator\'s password has been updated.' => '����Ա�����Ѿ�����',
					'Administrator\'s username has been updated.' => '����Ա�û����Ѿ�����',
					'Change the administrator\'s username and password.' => '���Ĺ���Ա�û���������.',
					'Could NOT update administrator\'s password!' => '�޷����¹���Ա����',
					'Could not update administrator\'s username!' => '�޷����Ź���Ա�û���',
					'ERROR: Invalid username!' => '����:��Ч�û���',
					'Invalid username' => '��Ч�û���',
					'Passwords doesn\'t match!' => '���벻ƥ��!',
					'The post has been deleted!' => 'Blog��ɾ!',
					'Wrong password!' => '�������',
					
					// Blocks
					'Archive' => '�浵',
					'Calendar' => '����',
					'Comments' => '����',
					'Latest posts' => '����Blog',
					'Links' => '����',
					'RSS Feeds' => 'RSS�ۺϲ鿴',
					'Search' => '����',
					'Style' => '���',
					
					// Manage blocks
					'Block content' => 'ģ������',
					'Block positions' => 'ģ��λ��',
					'Block settings' => 'ģ������',
					'Block topic' => 'ģ������',
					'Built in blocks' => '����ģ��',
					'Create block' => '����ģ��',
					'Delete block?' => 'ɾ��ģ��?',
					'Make the block visible for visitors' => 'ʹģ��ɼ�',
					'Position' => 'λ��',
					'Show block topic' => '��ʾģ������',
					'This field is not parsed as regular posts and may thus contain HTML tags.' => '����λ���ܽ����﷨,���ܰ���HTML���',
					'Use block style' => 'ʹ��ģ����',
					'blocks' => 'ģ��',

					// Buttons
					'Cancel' => 'ȡ��',
					'Go back' => '����',
					'Help' => '����',
					'OK' => '',
					'Preview' => 'Ԥ��',
					'Publish' => '����',
					'Search posts' => '����Blog',
					'Upload image' => '�ϴ�ͼƬ',
					
					// Options
					'Backup archive' => '���ݴ浵',
					'Backup' => '����',
					'E-mail' => '',
					'Language' => '����',
					'Max. image width (in pixels). This requires GD to work.' => '�����(��λ:px),��ҪGD��֧��.',
					'Open links in a new window.' => '���´����д�����',
					'Page description' => 'Blog����',
					'Page title' => 'Blog����',					
					'Personal' => '������Ϣ',
					'Posts in "Comments"' => '��ʾ������',
					'Posts in "Latest posts"' => '��ʾ����Blog��',
					'Posts per page' => '��/ҳ',
					'Send me e-mails when new comments are posted.' => '�����������Ƿ���Email����',
					
					// Menu
					'add post' => '����Blog',
					'categories' => '����',
					'censoring' => '����',
					'links' => '����',
					'login' => '��¼',
					'Login' => '��¼',
					'logout' => 'ע��',
					'Logout' => 'ע��',
					'settings' => '����',
					
					// Links
					'Existing links' => '��������',
					'Link URL' => '���ӵ�ַ',
					'Link title' => '���ӱ���',
					
					// Censor
					'Add word' => '�������',
					'Existing words' => '��������',
					
					// Upgrade
					'Could not fetch information from server!' => '�޷��ӷ�������ȡ��Ϣ',
					'Download' => '����',
					'Error' => '����',
					'New version of sBLOG available!' => '�°汾sBlog����!',
					'No new version available.' => 'û���°汾����.',
					'Please try again later.' => '���Ժ�����.',
					'You are using the latest version of sBLOG.' => '������ʹ�õ�sBlog�����°汾��.',
					
					// Miscellaneous
					'Add new category' => '����·���',
					'Administrator' => '����Ա',
					'Are you sure you want to delete this post?' => '��ȷ��ɾ����Blog?',
					'Attention!' => 'ע��!',
					'Blocks' => 'ģ��',
					'Categories' => '����',
					'Category' => '����',
					'Check for upgrade' => '������',
					'Colors' => '��ɫ',
					'Comment' => '����',
					'Could not create category!' => '�޷���������',
					'Could not delete the category!' => '�޷�ɾ������',
					'Current password' => '��ǰ����',
					'Date and time' => '����/ʱ��',
					'Default' => 'Ĭ��',
					'Delete' => 'ɾ��',
					'Dimensions' => '�ֱ���',
					'Document root' => '�ĵ���·��',
					'Download language files' => '�������԰�',
					'Download new styles' => '�����·��',
					'ERROR' => '����',
					'Edited' => '�༭',
					'Enable user comments' => '�û����Է�������',
					'Error(s)' => '����',
					'Example' => '����',
					'Existing categories' => '���з���',
					'Filename' => '�ļ���',
					'First' => '��һ',
					'Homepage' => '��ҳ',
					'Image database' => 'ͼƬ���ݿ�',
					'Images' => 'ͼƬ',
					'Last' => '���',
					'Limits' => '����',
					'Max number of characters in blocks.' => 'ģ���������',
					'Message(s)' => '��Ϣ',
					'Messages' => '��Ϣ',
					'Miscellaneous' => '����',
					'Name' => '����',
					'New password' => '������',
					'Next' => '��һҳ',
					'No posts were posted on this date.' => '����û�з���Blog.',
					'Not assigned to any post(s).' => 'δָ���κ�Blog',
					'Open link in new window' => '���´����д�',
					'Options' => 'ѡ��',
					'Page' => '',
					'Password' => '����',
					'Post comment' => '��������',
					'Posted' => '������',
					'Previous' => 'ǰһҳ',
					'Remember me for a week.' => '��סһ�����',
					'Replace with' => '�滻Ϊ',
					'Server' => '������',
					'Show/Hide' => '��ʾ/����',
					'Silent edit' => '�޼�����',
					'Smilies' => '΢Ц����',
					'Text formatting' => '�ı���ʽ',
					'Text' => '�ı�',
					'The category has been created.' => '����ɹ�����!',
					'The category was successfully deleted.' => '����ɹ�ɾ��!',
					'The search string is too short!' => '�ؼ���̫��!',
					'There are no posts assigned to this category.' => 'ָ��������û��Blog.',
					'Topic' => '����',
					'Uncategorized' => 'δ����',
					'Uploaded' => '�ϴ�ʱ��',
					'Used in the following post(s)' => '������Blogʹ��',
					'Username' => '�û���',
					'Verify new password' => '��֤������',
					'Version' => '�汾',
					'Web root' => '��վ��Ŀ¼',
					'Word' => '����',
					'You can now access it from the image list.' => '�����Դ�ͼƬ�б����.',
					'Your image was successfully uploaded.' => '���Ѿ��ɹ��ϴ�ͼƬ.',
					'add comment' => '��������',
					'comments' => '����',
					'delete' => 'ɾ��',
					'edit' => '�༭',
					'images' => 'ͼƬ',
					'no topic' => '������',
					'of' => '',
					'permalink' => '�Ķ�ȫ��',
					'post(s)' => '����',
					'rename' => '����',
					'the %#d %B %Y %H:%M' => '%Y %B %#d  %H:%M',
					'The sBLOG is empty' => 'BlogΪ��',
					'Download new styles' => '�����·��'
				);

?>