<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="gb2312">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="../style/Blue.css" />
<title>sBLOG��װ��: ���� 1 / 4</title>
</head>
<body>
<?php

	$doc_root			= substr(dirname($_SERVER['SCRIPT_FILENAME']), 0, -7);
	$web_root			= 'http://' . $_SERVER['HTTP_HOST'] . str_replace('install', '', dirname($_SERVER['SCRIPT_NAME']));

?>

<div id="sblog_root">
	<div id="sblog_head">
		<div id="sblog_page_title">
			<h1 id="sblog_page_title_text">sBLOG��װ��</h1>
		</div>
		<div id="sblog_page_description">
			<h2 id="sblog_page_description_text">����: 1 / 4</h2>
		</div>
	</div>
	<div id="sblog_body">
		<div id="sblog_block_body">
			<div><img src="sblogo.png" alt="sBLOGo" /></div>
		</div>
		<div id="sblog_main">
			<form id="install" method="post" action="install_mysql.php">
			<fieldset>
				<legend>MySQL��ϸ����</legend>
				<div class="sblog_var">MySQL������</div>
				<div class="sblog_val"><input type="text" name="mysql_hostname" id="mysql_hostname" size="40" value="localhost" class="sblog_input" /></div>

				<div class="sblog_var">MySQL�û���</div>
				<div class="sblog_val"><input type="text" name="mysql_username" id="mysql_username" size="40" value="" class="sblog_input" /></div>

				<div class="sblog_var">MySQL����</div>
				<div class="sblog_val"><input type="text" name="mysql_password" id="mysql_password" size="40" value="" class="sblog_input" /></div>

				<div class="sblog_var">MySQL���ݿ���</div>
				<div class="sblog_val"><input type="text" name="mysql_database" id="mysql_database" size="40" value="" class="sblog_input" /></div>

				<div class="sblog_var">MySQLǰ׺</div>
				<div class="sblog_val"><input type="text" name="mysql_prefix" id="mysql_prefix" size="40" value="sblog_" class="sblog_input" /></div>
			</fieldset>
			<fieldset>
				<legend>����Աϸ��</legend>
				<div class="sblog_var">�û���</div>
				<div class="sblog_val"><input type="text" name="admin_username" id="admin_username" size="40" value="" class="sblog_input" /></div>
				<div class="sblog_var">����</div>
				<div class="sblog_val"><input type="text" name="admin_password" id="admin_password" size="40" value="" class="sblog_input" /></div>
				<div class="sblog_var">E-mail</div>
				<div class="sblog_val"><input type="text" name="admin_email" id="admin_email" size="40" value="" class="sblog_input" /></div><br />
				<div class="sblog_quote">�����Ҫ��������,Email����.</div>
			</fieldset>
			<fieldset>
				<legend>����������</legend>
				<div class="sblog_quote">ϵͳ�Զ�̽�⵽�ķ���������,ͨ������ȷ��,<br/>������Щ�ط�������Ҫ���ֶ�����.</div><br />
				<div class="sblog_var">�ĵ���Ŀ¼(����·��)</div>
				<div class="sblog_val"><input type="text" name="doc_root" id="doc_root" size="40" value="<?php echo $doc_root; ?>" class="sblog_input" /></div>
				<div class="sblog_var">��վ��ַ(���·��)</div>
				<div class="sblog_val"><input type="text" name="web_root" id="web_root" size="40" value="<?php echo $web_root; ?>" class="sblog_input" /></div>
			</fieldset>
			<fieldset>
				<legend>ѡ��</legend>
				<input type="submit" value="��һ��" class="sblog_button" />
			</fieldset>
			</form>
		</div>
	</div>
	<div id="sblog_copy"></div>
	<div id="sblog_foot"></div>
</div>

</body>
</html>