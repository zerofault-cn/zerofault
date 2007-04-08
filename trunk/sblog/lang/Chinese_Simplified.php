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
					'Administrator\'s password has been updated.' => '管理员密码已经更新',
					'Administrator\'s username has been updated.' => '管理员用户名已经更新',
					'Change the administrator\'s username and password.' => '更改管理员用户名和密码.',
					'Could NOT update administrator\'s password!' => '无法更新管理员密码',
					'Could not update administrator\'s username!' => '无法封信管理员用户名',
					'ERROR: Invalid username!' => '出错:无效用户名',
					'Invalid username' => '无效用户名',
					'Passwords doesn\'t match!' => '密码不匹配!',
					'The post has been deleted!' => 'Blog已删!',
					'Wrong password!' => '密码错误',
					
					// Blocks
					'Archive' => '存档',
					'Calendar' => '日历',
					'Comments' => '评论',
					'Latest posts' => '最新Blog',
					'Links' => '链接',
					'RSS Feeds' => 'RSS聚合查看',
					'Search' => '搜索',
					'Style' => '风格',
					
					// Manage blocks
					'Block content' => '模块内容',
					'Block positions' => '模块位置',
					'Block settings' => '模块设置',
					'Block topic' => '模块主题',
					'Built in blocks' => '内置模块',
					'Create block' => '创建模块',
					'Delete block?' => '删除模块?',
					'Make the block visible for visitors' => '使模块可见',
					'Position' => '位置',
					'Show block topic' => '显示模块主题',
					'This field is not parsed as regular posts and may thus contain HTML tags.' => '该栏位不能解释语法,可能包含HTML标记',
					'Use block style' => '使用模块风格',
					'blocks' => '模块',

					// Buttons
					'Cancel' => '取消',
					'Go back' => '返回',
					'Help' => '帮助',
					'OK' => '',
					'Preview' => '预览',
					'Publish' => '发布',
					'Search posts' => '搜索Blog',
					'Upload image' => '上传图片',
					
					// Options
					'Backup archive' => '备份存档',
					'Backup' => '备份',
					'E-mail' => '',
					'Language' => '语言',
					'Max. image width (in pixels). This requires GD to work.' => '最大宽度(单位:px),需要GD库支持.',
					'Open links in a new window.' => '在新窗口中打开链接',
					'Page description' => 'Blog描述',
					'Page title' => 'Blog标题',					
					'Personal' => '个人信息',
					'Posts in "Comments"' => '显示评论数',
					'Posts in "Latest posts"' => '显示最新Blog数',
					'Posts per page' => '帖/页',
					'Send me e-mails when new comments are posted.' => '当有新评论是发送Email给我',
					
					// Menu
					'add post' => '发表Blog',
					'categories' => '分类',
					'censoring' => '过滤',
					'links' => '链接',
					'login' => '登录',
					'Login' => '登录',
					'logout' => '注销',
					'Logout' => '注销',
					'settings' => '设置',
					
					// Links
					'Existing links' => '已有链接',
					'Link URL' => '链接地址',
					'Link title' => '链接标题',
					
					// Censor
					'Add word' => '添加脏字',
					'Existing words' => '已有脏字',
					
					// Upgrade
					'Could not fetch information from server!' => '无法从服务器获取信息',
					'Download' => '下载',
					'Error' => '出错',
					'New version of sBLOG available!' => '新版本sBlog可用!',
					'No new version available.' => '没有新版本可用.',
					'Please try again later.' => '请稍候再试.',
					'You are using the latest version of sBLOG.' => '您现在使用的sBlog是最新版本的.',
					
					// Miscellaneous
					'Add new category' => '添加新分类',
					'Administrator' => '管理员',
					'Are you sure you want to delete this post?' => '你确认删除该Blog?',
					'Attention!' => '注意!',
					'Blocks' => '模块',
					'Categories' => '分类',
					'Category' => '分类',
					'Check for upgrade' => '检查更新',
					'Colors' => '颜色',
					'Comment' => '评论',
					'Could not create category!' => '无法创建分类',
					'Could not delete the category!' => '无法删除分类',
					'Current password' => '当前密码',
					'Date and time' => '日期/时间',
					'Default' => '默认',
					'Delete' => '删除',
					'Dimensions' => '分辨率',
					'Document root' => '文档根路径',
					'Download language files' => '下载语言包',
					'Download new styles' => '下载新风格',
					'ERROR' => '出错',
					'Edited' => '编辑',
					'Enable user comments' => '用户可以发表评论',
					'Error(s)' => '出错',
					'Example' => '例子',
					'Existing categories' => '已有分类',
					'Filename' => '文件名',
					'First' => '第一',
					'Homepage' => '主页',
					'Image database' => '图片数据库',
					'Images' => '图片',
					'Last' => '最后',
					'Limits' => '限制',
					'Max number of characters in blocks.' => '模块最多字数',
					'Message(s)' => '信息',
					'Messages' => '信息',
					'Miscellaneous' => '其他',
					'Name' => '名字',
					'New password' => '新密码',
					'Next' => '下一页',
					'No posts were posted on this date.' => '该日没有发表Blog.',
					'Not assigned to any post(s).' => '未指定任何Blog',
					'Open link in new window' => '在新窗口中打开',
					'Options' => '选项',
					'Page' => '',
					'Password' => '密码',
					'Post comment' => '发表评论',
					'Posted' => '发表于',
					'Previous' => '前一页',
					'Remember me for a week.' => '记住一个礼拜',
					'Replace with' => '替换为',
					'Server' => '服务器',
					'Show/Hide' => '显示/隐藏',
					'Silent edit' => '无迹更新',
					'Smilies' => '微笑符号',
					'Text formatting' => '文本格式',
					'Text' => '文本',
					'The category has been created.' => '分类成功创建!',
					'The category was successfully deleted.' => '分类成功删除!',
					'The search string is too short!' => '关键词太短!',
					'There are no posts assigned to this category.' => '指定分类中没有Blog.',
					'Topic' => '主题',
					'Uncategorized' => '未归类',
					'Uploaded' => '上传时间',
					'Used in the following post(s)' => '被以下Blog使用',
					'Username' => '用户名',
					'Verify new password' => '验证新密码',
					'Version' => '版本',
					'Web root' => '网站根目录',
					'Word' => '脏字',
					'You can now access it from the image list.' => '您可以从图片列表进入.',
					'Your image was successfully uploaded.' => '您已经成功上传图片.',
					'add comment' => '发表评论',
					'comments' => '评论',
					'delete' => '删除',
					'edit' => '编辑',
					'images' => '图片',
					'no topic' => '无主题',
					'of' => '',
					'permalink' => '阅读全文',
					'post(s)' => '帖子',
					'rename' => '更名',
					'the %#d %B %Y %H:%M' => '%Y %B %#d  %H:%M',
					'The sBLOG is empty' => 'Blog为空',
					'Download new styles' => '下载新风格'
				);

?>