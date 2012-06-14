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
else {
	$config['DB_NAME'] = 'lezhuang';
	$config['DB_USER'] = 'lezhuang';
	$config['DB_PWD'] = 'w2j7u5';
}
return $config;
?>