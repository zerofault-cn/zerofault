<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="gb2312">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="../style/Blue.css" />
<title>sBLOG安装向导: 步骤 3 / 4</title>
</head>
<body>

<?php

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

	// server
	$doc_root = $_POST['doc_root'];
	$web_root = $_POST['web_root'];

	$dir	=	array(
					'upload/',
					'upload/tn/'
				);

	while(list(, $val) = each($dir)) {
		if($fp = @fopen('../' . $val . 'test', 'w')) {
			fclose($fp);
			unlink('../' . $val . 'test');
		}
		else {
			$error[] = '<strong>出错:</strong>/' . $val.'目录没有写权限,请更改属性(CHMOD)为777';
		}
	}

?>

<div id="sblog_root">
	<div id="sblog_head">
		<div id="sblog_page_title">
			<h1 id="sblog_page_title_text">sBLOG安装向导</h1>
		</div>
		<div id="sblog_page_description">
			<h2 id="sblog_page_description_text">步骤: 3 / 4</h2>
		</div>
	</div>
	<div id="sblog_body">
		<div id="sblog_block_body">
			<div><img src="sblogo.png" alt="sBLOGo" /></div>
		</div>
		<div id="sblog_main">
			<form name="install" id="install" method="post" action="install_finish.php">
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
				<fieldset>
					<legend>信息</legend>
<?php

	if(isset($error)) {
		echo "\t\t\t\t\t" . '<ul>' . "\n";
		
		while(list(, $val) = each($error)) {
			echo "\t\t\t\t\t\t" . '<li>' . $val . '</li>' . "\n";
		}
		
		echo "\t\t\t\t\t" . '</ul>' . "\n";
		
		$next = 'disabled';
	}
	else {
		echo "\t\t\t\t\t" . '<ul>' . "\n";
		echo "\t\t\t\t\t\t" . '<li>属性正确.</li>' . "\n";
		echo "\t\t\t\t\t\t" . '<li>点击"下一步" 继续安装.</li>' . "\n";
		echo "\t\t\t\t\t" . '</ul>' . "\n";
		
		$next = null;
	}

?>
				</fieldset>
				<fieldset>
					<legend>选项</legend>
					<input type="reset" value="返回" onClick="javascript:history.go(-1);return false" class="sblog_button" />
					<input type="reset" value="重试" onClick="javascript:document.getElementById('install').action='install_chmod.php';submit();" class="sblog_button" />
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