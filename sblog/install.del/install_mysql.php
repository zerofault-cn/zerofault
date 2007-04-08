<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="gb2312">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="../style/Blue.css" />
<title>sBLOG安装向导: 步骤 2 / 4</title>
</head>
<body>

<?php

	// fetch version info
	if(file_exists('../inc/version.inso')) {
		$v = parse_ini_file('../inc/version.inso', false);
	}
	else {
		$v['conf_current_version'] = null;
		$v['conf_current_buidl'] = null;
	}
	
	// define variables
	$msg = null;
	$error = null;

	// mysql
	$mysql_hostname = $_POST['mysql_hostname'];
	$mysql_username = $_POST['mysql_username'];
	$mysql_password = $_POST['mysql_password'];
	$mysql_database = $_POST['mysql_database'];
	$mysql_prefix = $_POST['mysql_prefix'];
	
	// administrator
	$admin_username = $_POST['admin_username'];
	$admin_password = $_POST['admin_password'];
	$admin_email = $_POST['admin_email'];
	
	// version variables
	$conf_current_version = $v['conf_current_version'];
	$conf_current_build = $v['conf_current_build'];
	
	// server
	$doc_root = $_POST['doc_root'];
	$web_root = $_POST['web_root'];
	
	if(strlen($admin_username) == 0) {
		$error[] = '<strong>管理员细节:</strong>无效用户名!';
	}
	
	if(strlen($admin_password) < 4) {
		$error[] = '<strong>管理员细节:</strong>密码不能少于5位!';
	}
	
	if(strlen($admin_email) == 0) {
		$error[] = '<strong>管理员细节:</strong>Email地址不能为空!';
	}
	
	if(strlen($doc_root) == 0) {
		$error[] = '绝对路径: 您必须指定一个文档根目录!';
	}

	if(strlen($web_root) == 0) {
		$error[] = '相对地址: 您必须指定一个网站地址!!';
	}
	else if(substr($web_root, 0, 7) != 'http://' || substr($web_root, -1, 1) != '/') {
		$error[] = '相对地址: 网站地址必须以"http://"开头,"/"结尾!';
	}
	
	// connect to host
	if(@mysql_connect($mysql_hostname, $mysql_username, $mysql_password)) {
		$msg[] = '<strong>MySQL:</strong>连接到主机.';

		// select database
		if(@mysql_select_db($mysql_database)) {
			$msg[] = '<strong>MySQL:</strong>选择数据库"' . $mysql_database . '".';
			
			// create sblog_blocks
			$queryBlocks = 'CREATE TABLE ' . $mysql_prefix . 'blocks (id int(11) unsigned NOT NULL auto_increment, block_topic varchar(64) default NULL, block_content text, block_vis set(\'0\',\'1\') NOT NULL default \'0\', block_pos int(11) unsigned default \'0\', block_style set(\'0\',\'1\') NOT NULL default \'1\', block_top set(\'0\',\'1\') NOT NULL default \'1\', PRIMARY KEY (id));';

			if(mysql_query($queryBlocks)) {
				$msg[] = '<strong>MySQL:</strong> 表 ' . $mysql_prefix . 'blocks已创建.';
				
				// default values
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (1,\'{CALENDAR}\',NULL,\'1\',10,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (2,\'{ARCHIVE}\',NULL,\'1\',20,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (3,\'{CATEGORIES}\',NULL,\'1\',30,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (4,\'{LATEST}\',NULL,\'1\',40,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (5,\'{COMMENTS}\',NULL,\'1\',50,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (6,\'{SEARCH}\',NULL,\'1\',60,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (7,\'{LINKS}\',NULL,\'1\',70,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (8,\'{STYLE}\',NULL,\'1\',80,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (9,\'{RSS}\',NULL,\'1\',90,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (10,\'{ADMIN}\',NULL,\'1\',999,\'1\',\'1\');');

				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'blocks已经以默认值创建.';
			}
			else if(mysql_errno() == 1050) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'blocks已经存在,将用保留安装.';

				// default values
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (1,\'{CALENDAR}\',NULL,\'1\',10,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (2,\'{ARCHIVE}\',NULL,\'1\',20,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (3,\'{CATEGORIES}\',NULL,\'1\',30,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (4,\'{LATEST}\',NULL,\'1\',40,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (5,\'{COMMENTS}\',NULL,\'1\',50,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (6,\'{SEARCH}\',NULL,\'1\',60,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (7,\'{LINKS}\',NULL,\'1\',70,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (8,\'{STYLE}\',NULL,\'1\',80,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (9,\'{RSS}\',NULL,\'1\',90,\'1\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'blocks (id, block_topic, block_content, block_vis, block_pos, block_style, block_top) VALUES (10,\'{ADMIN}\',NULL,\'1\',999,\'1\',\'1\');');

				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'blocks已经以默认值创建.';
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'blocks!<br />' . mysql_errno() . ' ' . mysql_error();
			}

			// create sblog_categories
			$queryCategories = 'CREATE TABLE ' . $mysql_prefix . 'categories (id int(11) unsigned NOT NULL auto_increment, date_created datetime default NULL, date_modified timestamp NOT NULL, category varchar(32) NOT NULL default \'\', PRIMARY KEY (id));';

			if(mysql_query($queryCategories)) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'categories已创建.';
				// default values
				mysql_query('INSERT INTO ' . $mysql_prefix . 'categories (id, date_created, category) VALUES (1, \'' . date('Y-m-d H:i:s') . '\', \'Uncategorized\');');
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'categories已经以默认值创建.';
			}
			else if(mysql_errno() == 1050) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'categories已经存在,将用保留安装.';
				// default values
				mysql_query('INSERT INTO ' . $mysql_prefix . 'categories (id, date_created, category) VALUES (1, \'' . date('Y-m-d H:i:s') . '\', \'Uncategorized\');');
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'categories已经以默认值创建.';
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'categories!<br />' . mysql_errno() . ' ' . mysql_error();
			}

			// create sblog_censoring
			$queryCensoring = 'CREATE TABLE ' . $mysql_prefix . 'censoring (id int(11) unsigned NOT NULL auto_increment, word_orig text NOT NULL, word_repl text, PRIMARY KEY (id));';

			if(mysql_query($queryCensoring)) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'censoring已创建.';
			}
			else if(mysql_errno() == 1050) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'censoring已经存在,将用保留安装.';
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'censoring!<br />' . mysql_errno() . ' ' . mysql_error();
			}
			
			// create sblog_comments
			$queryComments = 'CREATE TABLE ' . $mysql_prefix . 'comments (id int(11) unsigned NOT NULL auto_increment, blog_id int(11) unsigned NOT NULL default \'0\', date_created datetime NOT NULL default \'0000-00-00 00:00:00\', username varchar(32) NOT NULL default \'n/a\', email varchar(255) default NULL, homepage text, comment text NOT NULL, PRIMARY KEY (id));';
			
			if(mysql_query($queryComments)) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'comments已创建.';
			}
			else if(mysql_errno() == 1050) {
				$queryCommentsAlter = 'ALTER TABLE ' . $mysql_database . '.' . $mysql_prefix . 'comments CHANGE COLUMN homepage homepage text NULL;';
				if(mysql_query($queryCommentsAlter)) {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'comments already已经存在,将更新结构.';
				}
				else {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'comments已经存在,将用保留安装.';
				}
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'comments!<br />' . mysql_errno() . ' ' . mysql_error();
			}
			
			// create sblog_config
			$queryConfig = 'CREATE TABLE ' . $mysql_prefix . 'config (conf_name varchar(32) NOT NULL default \'\', conf_value text, PRIMARY KEY (conf_name));';
			
			if(mysql_query($queryConfig) || mysql_errno() == 1050) {
				if(mysql_errno() == 1050) {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'config已经存在,将更新数据.';
				}
				else {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'config已创建.';
				}

				// default values
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_admin_email\',\'' . $admin_email . '\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_admin_password\',\'' . md5($admin_password) . '\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_admin_username\',\'' . $admin_username . '\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_bar_comments_disp\',\'5\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_bar_latest_disp\',\'5\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_block_chars\',\'16\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_comments_act\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_comments_email\',\'1\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_current_build\',\'' . $conf_current_build . '\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_current_version\',\'' . $conf_current_version . '\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_date\',\'%Y-%m-%d %H:%M\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_img_width\',\'320\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_lang_default\',\'Chinese_Simplified\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_link_new\',\'0\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_page_description\',\'Blog描述\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_page_disp\',\'4\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_page_title\',\'我的blog\');');
				mysql_query('INSERT INTO ' . $mysql_prefix . 'config (conf_name, conf_value) VALUES (\'conf_style_default\',\'Blue\');');
				
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'%Y-%m-%d %H:%M\' WHERE conf_name=\'conf_date\';');
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'' . $admin_email . '\' WHERE conf_name=\'conf_admin_email\';');
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'Blue\' WHERE conf_name=\'conf_style_default\';');

				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'' . $conf_current_version . '\' WHERE conf_name=\'conf_current_version\';');
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'' . $conf_current_build . '\' WHERE conf_name=\'conf_current_build\';');
				
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'' . $admin_username . '\' WHERE conf_name=\'conf_admin_username\';');
				mysql_query('UPDATE ' . $mysql_prefix . 'config SET conf_value=\'' . md5($admin_password) . '\' WHERE conf_name=\'conf_admin_password\';');

				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'config已经以默认值创建.';
			}
			else if(mysql_errno() == 1050) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'config已经存在,将用保留安装.';
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'config!<br />' . mysql_errno() . ' ' . mysql_error();
			}
			
			// create sblog_data
			$queryData = 'CREATE TABLE ' . $mysql_prefix . 'data (id int(11) unsigned NOT NULL auto_increment, category_id int(11) NOT NULL default \'1\', date_created datetime NOT NULL default \'0000-00-00 00:00:00\', date_modified timestamp NOT NULL, topic varchar(64) NOT NULL default \'n/a\', text text, PRIMARY KEY (id));';

			if(mysql_query($queryData)) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'data已创建.';
				mysql_query('INSERT INTO ' . $mysql_prefix . 'data SET date_created=\'' . date('YmdHis') . '\', date_modified=\'' . date('YmdHis') . '\', topic=\'欢迎使用sBLOG\', text=\'[b]欢迎使用sBLOG[/b] :D\';');
			}
			else if(mysql_errno() == 1050) {
				$queryDataAlter = 'ALTER TABLE ' . $mysql_database . '.' . $mysql_prefix . 'data ADD COLUMN category_id int(11) NOT NULL DEFAULT \'1\' AFTER id, CHANGE COLUMN text text text NULL, CHANGE COLUMN date_created date_created datetime;';
				if(mysql_query($queryDataAlter)) {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'data already已经存在,将更新结构.';
				}
				else {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'data已经存在,将用保留安装.';
				}
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'data!<br />' . mysql_errno() . ' ' . mysql_error();
			}
			
			// create sblog_links
			$queryLinks = 'CREATE TABLE ' . $mysql_prefix . 'links (id int(11) unsigned NOT NULL auto_increment, date_created datetime default NULL, date_modified timestamp NOT NULL, link_title varchar(32) NOT NULL default \'n/a\', link_url text, PRIMARY KEY (id));';
			
			if(mysql_query($queryLinks)) {
				$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'links已创建.';
			}
			else if(mysql_errno() == 1050) {
				$queryLinksAlter = 'ALTER TABLE ' . $mysql_database . '.' . $mysql_prefix . 'links CHANGE COLUMN link_url link_url text NULL, CHANGE COLUMN date_created date_created datetime;';
				if(mysql_query($queryLinksAlter)) {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'links已经存在,将更新结构.';
				}
				else {
					$msg[] = '<strong>MySQL:</strong>表' . $mysql_prefix . 'links已经存在,将用保留安装.';
				}
			}
			else {
				$error[] = '<strong>MySQL:</strong>无法创建' . $mysql_prefix . 'links!<br />' . mysql_errno() . ' ' . mysql_error();
			}
			
		}
		else {
			$error[] = '<strong>MySQL:</strong>数据库"' . $mysql_database . '"不存在!<br />' . mysql_errno() . ' ' . mysql_error();
		}
		mysql_close();
	}
	else {
		$error[] = '<strong>MySQL:</strong>无法连接到"' . $mysql_hostname . '"!<br />' . mysql_errno() . ' ' . mysql_error();
		$error[] = '<strong>MySQL:</strong>请确认数据库服务器,数据库名,数据库用户和密码是正确的.<br />' . mysql_errno() . ' ' . mysql_error();
	}

?>

<div id="sblog_root">
	<div id="sblog_head">
		<div id="sblog_page_title">
			<h1 id="sblog_page_title_text">sBLOG安装向导</h1>
		</div>
		<div id="sblog_page_description">
			<h2 id="sblog_page_description_text">步骤: 2 / 4</h2>
		</div>
	</div>
	<div id="sblog_body">
		<div id="sblog_block_body">
			<div><img src="sblogo.png" alt="sBLOGo" /></div>
		</div>
		<div id="sblog_main">
			<form id="install" method="post" action="install_chmod.php">
				<input type="hidden" name="mysql_hostname" id="mysql_hostname" value="<?php echo $mysql_hostname; ?>" />
				<input type="hidden" name="mysql_username" id="mysql_username" value="<?php echo $mysql_username; ?>" />
				<input type="hidden" name="mysql_password" id="mysql_password" value="<?php echo $mysql_password; ?>" />
				<input type="hidden" name="mysql_database" id="mysql_database" value="<?php echo $mysql_database; ?>" />
				<input type="hidden" name="mysql_prefix" id="mysql_prefix" value="<?php echo $mysql_prefix; ?>" />
				<input type="hidden" name="admin_username" id="admin_username" value="<?php echo $admin_username; ?>" />
				<input type="hidden" name="admin_password" id="admin_password" value="<?php echo $admin_password; ?>" />
				<input type="hidden" name="admin_email" id="admin_email" value="<?php echo $admin_email; ?>" />
				<input type="hidden" name="doc_root" id="doc_root" value="<?php echo $doc_root; ?>" />
				<input type="hidden" name="web_root" id="web_root" value="<?php echo $web_root; ?>" />
<?php

	if(isset($error)) {
		echo "\t\t\t" . '<fieldset>' . "\n";
		echo "\t\t\t\t" . '<legend>出错</legend>' . "\n";
		echo "\t\t\t\t" . '<ul>' . "\n";
		while(list(, $val) = each($error)) {
			echo "\t\t\t\t\t" . '<li>' . $val . "</li>\n";
		}
		echo "\t\t\t\t" . '</ul>' . "\n";
		echo "\t\t\t" . '</fieldset>' . "\n";
		$next = ' disabled="disabled"';
	}
	else {
		$next = null;
	}

	if(isset($msg)) {
		echo "\t\t\t" . '<fieldset>' . "\n";
		echo "\t\t\t\t" . '<legend>信息</legend>' . "\n";
		echo "\t\t\t\t" . '<ul>' . "\n";
		while(list(, $val) = each($msg)) {
			echo "\t\t\t\t\t" . '<li>' . $val . "</li>\n";
		}
		echo "\t\t\t\t" . '</ul>' . "\n";
		echo "\t\t\t" . '</fieldset>' . "\n";
	}

?>
				<fieldset>
					<legend>选项</legend>
					<input type="reset" value="Go back" onclick="javascript:history.go(-1);return false" class="sblog_button" />
					<input type="submit" value="下一步"<?php echo $next; ?> class="sblog_button" />
				</fieldset>
				</form>
			</div>
	</div>
	<div id="sblog_copy"></div>
	<div id="sblog_foot"></div>
</div>

</body>
</html>