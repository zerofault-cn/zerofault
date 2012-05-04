<?php
$config = array(
	'DB_TYPE'			=> 'mysql',
	'DB_PREFIX'			=> 'lzwyc_',

	'USER_AUTH_GATEWAY' => '/Public/login',
	'ADMIN_ID' => 'administrator_ID',
	'ADMIN_INFO' => 'administrator_INFO',

);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['USER_AUTH_TYPE'] = 2;
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'lzwyc_com';
	$config['DB_USER'] = 'root';
	$config['DB_PWD'] = '';
}
else {
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'lzwyc_com';
	$config['DB_USER'] = 'root';
	$config['DB_PWD'] = '';
	$config['APP_DOMAIN_DEPLOY'] = true;
}
return $config;
?>