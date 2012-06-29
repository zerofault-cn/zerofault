<?php
$config = array(
	'APP_CONFIG_LIST'	=> 'menu',
	
	'DB_PREFIX'			=> 'zs_',


	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_ON'	=> true,
	'USER_AUTH_KEY' => 'administrator_ID',
	'IS_ADMINISTRATOR' => 'zs186_administrator',
	'NOT_AUTH_MODULE' => 'Base,Public,Attachment,Empty',
	'REQUIRE_AUTH_MODULE'=> '',
	'NOT_AUTH_ACTION' => '',
	'REQUIRE_AUTH_ACTION'=> '',
	'IFRAME_ACTION' => array('update','delete','edit','sub_category')
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['USER_AUTH_TYPE'] = 2;
	$config['DB_NAME'] = 'zs186_net';
}
elseif (ENV == 'TEST') {
	$config['DB_HOST'] = 'ruitengtest.gotoip2.com';
	$config['DB_NAME'] = 'ruitengtest';
	$config['DB_USER'] = 'ruitengtest';
	$config['DB_PWD'] = 'ruiteng@test';
}
else {
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'zshz666_com';
	$config['DB_USER'] = 'zshz666_com';
	$config['DB_PWD'] = 'yczshwhz';
}
return $config;
?>