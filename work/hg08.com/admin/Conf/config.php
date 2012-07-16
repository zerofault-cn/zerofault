<?php
$config = array(
	'APP_CONFIG_LIST'	=> 'menu',
	
	'DB_PREFIX'			=> 'hg_',


	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_ON'	=> true,
	'USER_AUTH_KEY' => 'hg_admin_id',
	'IS_ADMINISTRATOR' => 'hg_administrator',
	'NOT_AUTH_MODULE' => 'Base,Index,Public,Attachment,Empty',
	'REQUIRE_AUTH_MODULE'=> '',
	'NOT_AUTH_ACTION' => '',
	'REQUIRE_AUTH_ACTION'=> '',
	'IFRAME_ACTION' => array('update','delete','edit')
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['USER_AUTH_TYPE'] = 2;
	$config['DB_NAME'] = 'hg08_com';
}
elseif (ENV == 'TEST') {
	$config['DB_NAME'] = 'ruitcms';
	$config['DB_USER'] = 'root';
	$config['DB_PWD'] = 'ruiteng';
}
else {
	$config['DB_NAME'] = 'ruitcms';
	$config['DB_USER'] = 'root';
	$config['DB_PWD'] = 'ruiteng';
}
return $config;
?>