<?php

function error($msg) {
	echo '<script>parent.alert("'.addslashes($msg).'");</script>';
	exit;
}

//get exists config
$config_file = '../Conf/config.php';
if(file_exists($config_file)) {
	$config = include($config_file);
}
else {
	$config = array();
}

//get config templete
$config_tpl = file_get_contents('config.tpl');

if(!empty($_POST['submit'])) {
	if(PHP_VERSION<'5.0') {
		error('PHP Version must be 5.0 or above!');
	}
	if(!function_exists('mysql_connect')) {
		error('MySQL support required!');
	}
	if(!function_exists('json_encode')) {
		error('JSON support required!');
	}
	$conn = mysql_connect(trim($_POST['DB_HOST']), trim($_POST['DB_USER']), trim($_POST['DB_PWD']));
	if(!$conn) {
		error('Your MySQL Setting is not correct!');
	}
	if(!mysql_select_db(trim($_POST['DB_NAME']))) {
		if(!mysql_query("create database ".$_POST['DB_NAME'])) {
			error('Can\'t create DB: '.$_POST['DB_NAME']);
		}
		mysql_select_db(trim($_POST['DB_NAME']));
	}
	$sql_file=file_get_contents('init.sql');
	if(empty($sql_file)) {
		error('Schema file not exists!');
	}
	foreach (explode(';', $sql_file) as $sql) {
		$sql = trim($sql);
		$sql = str_replace('~admin_name~', trim($_POST['admin_name']), $sql);
		$sql = str_replace('~admin_pass~', md5(trim($_POST['admin_pass'])), $sql);
		if ($sql) {
			if(!mysql_query($sql)) {
				error('SQL error:'.$sql.'<br />'.mysql_errno().': '.mysql_error());
			}
		}
	}
	$arr = array(
		'~DB_HOST~' => trim($_POST['DB_HOST']),
		'~DB_NAME~' => trim($_POST['DB_NAME']),
		'~DB_USER~' => trim($_POST['DB_USER']),
		'~DB_PWD~'  => trim($_POST['DB_PWD']),
		);
	$content = str_replace(array_keys($arr), array_values($arr), $config_tpl);
	if(!file_put_contents($config_file, $content)) {
		error('Write config file fail!');
	}
	rename(__FILE__, __FILE__.'.old');
	echo '<script>parent.alert("Install complete!");parent.location.href="../index.php";</script>';
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>ERP Install</title>
<style>
strong{
	color:red;
}
b{
	color:blue;
}
</style>
</head>
<body>
<form method="post" target="_iframe">
<table align="center" cellpadding="5">
<caption>ERP Install</caption>
<tr>
	<td colspan="2" bgcolor="#DDDDDD">System Enviroment Infomation</td>
</tr>
<tr>
	<td>Operation System:</td>
	<td><?php echo PHP_OS;?></td>
</tr>
<tr>
	<td>PHP Version:</td>
	<td><?php echo PHP_VERSION;if(PHP_VERSION<'5.0'){echo '<strong>5.0 or above required</strong>';}?></td>
</tr>
<tr>
	<td>MySQL Support:</td>
	<td><?php echo function_exists('mysql_connect') ? '<b>Yes</b>' : '<strong>No</strong>';?></td>
</tr>
<tr>
	<td>JSON Support:</td>
	<td><?php echo function_exists('json_encode') ? '<b>Yes</b>' : '<strong>No</strong>';?></td>
</tr>
<tr>
	<td>Attach Folder Writable</td>
	<td><?php echo is_writable('../Attach/Product') ? '<b>Yes</b>' : '<strong>No</strong>';?></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#DDDDDD">Database Setting</td>
</tr>
<tr>
	<td>Database server address:</td>
	<td><input type="text" name="DB_HOST" id="DB_HOST" size="20" value="<?php echo $config['DB_HOST'];?>" /></td>
</tr>
<tr>
	<td>Database username:</td>
	<td><input type="text" name="DB_USER" id="DB_USER" size="20" value="<?php echo $config['DB_USER'];?>" /></td>
</tr>
<tr>
	<td>Database password:</td>
	<td><input type="text" name="DB_PWD" id="DB_PWD" size="20" value="<?php echo $config['DB_PWD'];?>" /></td>
</tr>
<tr>
	<td>Database name:</td>
	<td><input type="text" name="DB_NAME" id="DB_NAME" size="20" value="<?php echo $config['DB_NAME'];?>" /></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#DDDDDD">Admin Account Setting</td>
</tr>
<tr>
	<td>SuperAdmin account:</td>
	<td><input type="text" name="admin_name" size="20" value="administrator" /></td>
</tr>
<tr>
	<td>SuperAdmin password:</td>
	<td><input type="password" name="admin_pass" size="20" /></td>
</tr>
<tr>
	<td colspan="2">When you login, you can change your account and password!</td>
</tr>
<tr>
	<td colspan="2" bgcolor="#DDDDDD" height="10"></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="Install" name="submit" /></td>
</tr>
</table>
</form>
<iframe name="_iframe" id="_iframe" style="width:500px;height:200px;display:none;"></iframe>
</body>
</html>