<?php
$config = array(

	'DB_PREFIX'			=> 'zs_',

	'USER_AUTH_GATEWAY' => '/Public/login',
	'USER_AUTH_KEY' => 'administrator_ID',

);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['DB_NAME'] = 'zs186_net';
}
elseif (ENV == 'TEST') {
	$config['DB_HOST'] = 'ruitengtest.gotoip2.com';
	$config['DB_NAME'] = 'ruitengtest';
	$config['DB_USER'] = 'ruitengtest';
	$config['DB_PWD'] = 'ruiteng@test';
}
else {
	$config['DB_NAME'] = 'lezhuang';
	$config['DB_USER'] = 'lezhuang';
	$config['DB_PWD'] = 'w2j7u5';
}
return $config;
?>