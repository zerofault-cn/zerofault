<?php
return $config = array(
	'DB_TYPE'		=> 'mysql',
	'DB_HOST'		=> '~DB_HOST~',
	'DB_NAME'		=> '~DB_NAME~',
	'DB_USER'		=> '~DB_USER~',
	'DB_PWD'		=> '~DB_PWD~',
	'DB_PREFIX'		=> 'erp_',

	'APP_CONFIG_LIST'	=> array('menu'),

	'USER_AUTH_ON'		=> true,
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'ADMIN_AUTH_KEY'	=> 'administrator',
	'SUPER_ADMIN_ID'	=> array(1),
	'USER_AUTH_GATEWAY'	=> '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
	'IFRAME_AUTH_ACTION'	=> array('update', 'delete', 'edit', 'submit', 'confirm', 'select')
	);
?>