<?php
$config = array(
	'DB_TYPE'			=> 'mysql',
	'DB_PREFIX'			=> 'lzwyc_',

	'USER_AUTH_GATEWAY' => '/Public/login',
	'ADMIN_ID' => 'administrator_ID',

);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'lzwyc_com';
	$config['DB_USER'] = 'root';
	$config['DB_PWD'] = '';
}
else {
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'lezhuang';
	$config['DB_USER'] = 'lezhuang';
	$config['DB_PWD'] = 'w2j7u5';
}
return $config;
?>