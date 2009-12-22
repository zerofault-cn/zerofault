<?php
/**
 * 获得系统的信息
 *
 * @access  public
 * @return  array     系统各项信息组成的数组
 */
function get_system_info()
{
    $system_info = array();

    /* 检查系统基本参数 */
    $system_info[] = array('PHP_OS', PHP_OS);
    $system_info[] = array('PHP_Version', PHP_VERSION);

    /* 检查MYSQL支持情况 */
    $system_info[] = array('support MySQL', function_exists('mysql_connect') ? 'yes' : 'no');

    /* 检查JSON支持情况 */
    $system_info[] = array('support JSON', function_exists('json_encode') ? 'yes' : 'no');

    /* 服务器是否安全模式开启 */
    $system_info[] = array('safe_mode', ini_get('safe_mode') == '1' ? 'ON' : 'OFF');

    return $system_info;
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


//print_r($config);
/*
   @$connection=mysql_pconnect($_POST["dbserver"],$_POST["dbuser"],$_POST["dbpass"]);
   if (!$connection) exit('Something wrong with Database settings, please press BACK button and enter Database settings again.<br />'.mysql_errno().': '.mysql_error());
   @$success=mysql_select_db($_POST["dbname"]);
   if (!$success) exit('Something went wrong while trying to choose Database, please press BACK button and enter Database settings again.<br />'.mysql_errno().': '.mysql_error());
   @$sql=join('',file('system.sql'));
   $sql=explode(";",$sql);
   foreach ($sql as $value)
           {
           $value=trim($value);
           if ($value) @$success=mysql_query($value);
           if (!$success) exit('Something went wrong while creating tables. Please, delete all tables in database.<br />'.mysql_errno().': '.mysql_error());
           }
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>ERP Install</title>
<body>
<form method="post" target="_iframe">
<table align="center" cellpadding="5">
<caption>ERP Install</option>
<tr>
	<td colspan="2" bgcolor="#DDDDDD">System Enviroment Infomation</td>
</tr>
<tr>
	<td>Operation System:</td>
	<td><?=PHP_OS?></td>
</tr>
<tr>
	<td>PHP Version:</td>
	<td><?=PHP_VERSION?></td>
</tr>
<tr>
	<td>Support MySQL:</td>
	<td></td>
</tr>
<tr>
	<td>Support JSON:</td>
	<td></td>
</tr>
<tr>
	<td>Attach Writable</td>
	<td></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#DDDDDD">System Enviroment Infomation</td>
</tr>
<tr>
	<td>Database server address:</td>
	<td><input type="text" name="DB_HOST" id="DB_HOST" size="20" value="<?=$config['DB_HOST']?>" /></td>
</tr>
<tr>
	<td>Database username:</td>
	<td><input type="text" name="DB_USER" id="DB_USER" size="20" value="<?=$config['DB_USER']?>" /></td>
</tr>
<tr>
	<td>Database password:</td>
	<td><input type="text" name="DB_PWD" id="DB_PWD" size="20" value="<?=$config['DB_PWD']?>" /></td>
</tr>
<tr>
	<td>Database name:</td>
	<td><input type="text" name="DB_NAME" id="DB_NAME" size="20" value="<?=$config['DB_NAME']?>" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="Install" name="submit" /></td>
</tr>
</table>
</form>
</body>
</html>