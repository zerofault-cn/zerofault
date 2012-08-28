<?php
$config = array(
	'APP_CONFIG_LIST'	=> 'menu',
	
	'DB_PREFIX'			=> 'hg_',


	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_ON'	=> false,
	'USER_AUTH_KEY' => 'hg_admin_id',
	'IS_ADMINISTRATOR' => 'hg_administrator',
	'NOT_AUTH_MODULE' => 'Base,Index,Public,Attachment,Empty',
	'REQUIRE_AUTH_MODULE'=> '',
	'NOT_AUTH_ACTION' => '',
	'REQUIRE_AUTH_ACTION'=> '',
	'IFRAME_ACTION' => array('submit', 'update', 'delete', 'edit')
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['USER_AUTH_TYPE'] = 2;
	$config['DB_NAME'] = 'hg08_com';
}
elseif (ENV == 'TEST') {
}
else {
	$config['DB_HOST'] = '60.191.221.120';
	$config['DB_NAME'] = 'hg08com';
	$config['DB_USER'] = 'hg08com';
	$config['DB_PWD'] = 'hg08com';
}
return $config;
?>