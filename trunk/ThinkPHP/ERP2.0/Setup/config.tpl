<?php
return $config = array(
	'DB_TYPE'			=> 'mysql',
	'DB_HOST'			=> '~DB_HOST~',
	'DB_NAME'			=> '~DB_NAME~',
	'DB_USER'			=> '~DB_USER~',
	'DB_PWD'			=> '~DB_PWD',
	'DB_PREFIX'			=> '~DB_PREFIX~',

	'APP_CONFIG_LIST'	=> array('menu'),

	'USER_AUTH_ON'		=> true,
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'ADMIN_AUTH_KEY'	=> 'administrator',
	'USER_AUTH_GATEWAY' => '/Public/login',
	'RBAC_ROLE_TABLE'	=> '~DB_PREFIX~role',
	'RBAC_USER_TABLE'	=> '~DB_PREFIX~staff_role',
	'RBAC_ACCESS_TABLE'	=> '~DB_PREFIX~role_node',
	'RBAC_NODE_TABLE'	=> '~DB_PREFIX~node',
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
	'REQUIRE_AUTH_MODULE'=> '',
	'NOT_AUTH_ACTION'	=> '',
	'REQUIRE_AUTH_ACTION'=> '',
	'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select')
	);
?>