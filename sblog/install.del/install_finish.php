<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="gb2312">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="../style/Blue.css" />
<title>sBLOG��װ��: ���� 4 / 4</title>
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

?>

<div id="sblog_root">
	<div id="sblog_head">
		<div id="sblog_page_title">
			<h1 id="sblog_page_title_text">sBLOG��װ��</h1>
		</div>
		<div id="sblog_page_description">
			<h2 id="sblog_page_description_text">����: 4 / 4</h2>
		</div>
	</div>
	<div id="sblog_body">
		<div id="sblog_block_body">
			<div><img src="sblogo.png" alt="sBLOGo" /></div>
		</div>
		<div id="sblog_main">
			<form>
				<fieldset>
					<legend>��Ϣ</legend>
					<ul>
						<li>sBLOG�Ѿ��ɹ���װ!</li>
						<li><strong>! ע�� !</strong></li>
						<li>�븴������Ĵ���,Ȼ�󱣴�Ϊһ��<strong>config.php</strong>�ļ�,�ϴ������Blog�ĸ�Ŀ¼:</li>
					</ul><br />
	
					<pre class="sblog_code">&lt;?php

$conf_mysql_hostname = <strong>'<?php echo $mysql_hostname; ?>'</strong>;
$conf_mysql_username = <strong>'<?php echo $mysql_username; ?>'</strong>;
$conf_mysql_password = <strong>'<?php echo $mysql_password; ?>'</strong>;
$conf_mysql_database = <strong>'<?php echo $mysql_database; ?>';</strong>
$conf_mysql_prefix   = <strong>'<?php echo $mysql_prefix; ?>'</strong>;

$conf_doc_root       = <strong>'<?php echo $doc_root; ?>'</strong>;
$conf_web_root       = <strong>'<?php echo $web_root; ?>'</strong>;

?&gt;</pre><br />
			
				<strong>! ע�� !</strong><br />
				Ȼ��ɾ��<strong>/install</strong> ���������е��ļ�.
				</fieldset>
				<fieldset>
					<legend>ѡ��</legend>
					������ʹ���û���'<strong><?php echo $admin_username; ?></strong>', ����'<strong><?php echo $admin_password; ?></strong>'.<br /><br />
					<div class="sblog_quote">
						<strong>����blog,������:</strong><br /><br />
						<a href="<?php echo $web_root; ?>admin"><?php echo $web_root; ?>admin</a>
					</div>
					<!-- <input type="reset" value="Login to sBLOG" onClick="javascript:location.href='../login.php';return false" class="sblog_button" /> -->
				</fieldset>
			</form>
		</div>
	</div>
	<div id="sblog_copy"></div>
	<div id="sblog_foot"></div>
</div>

</body>
</html>