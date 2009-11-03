<?php
if($_SERVER["SERVER_NAME"]=='localhost') {
	$config = array(
		'APP_DEBUG'			=> true,
		'APP_CONFIG_LIST'	=> array('menu'),

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'ERP',
		'DB_USER'			=> 'root',
		'DB_PWD'			=> '',
		'DB_PREFIX'			=> 'erp_',

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 0, //实时认证
		'USER_AUTH_MODEL' => 'Staff',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'RBAC_ROLE_TABLE'=>'erp_role',
		'RBAC_USER_TABLE'=>'erp_staff_role',
		'RBAC_ACCESS_TABLE'=>'erp_role_node',
		'RBAC_NODE_TABLE'=>'erp_node',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit')//在Iframe中进行的且需要认证的操作
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.zzl.org') {
	$config = array(
		'APP_CONFIG_LIST'	=> array('menu'),

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'zerofault_zzl_erp',
		'DB_USER'			=> '22366_root',
		'DB_PWD'			=> '123456',
		'DB_PREFIX'			=> 'erp_',

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 0, //实时认证
		'USER_AUTH_MODEL' => 'Staff',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'RBAC_ROLE_TABLE'=>'erp_role',
		'RBAC_USER_TABLE'=>'erp_staff_role',
		'RBAC_ACCESS_TABLE'=>'erp_role_node',
		'RBAC_NODE_TABLE'=>'erp_node',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit')//在Iframe中进行的且需要认证的操作
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.oxyhost.com') {
	$config = array(
		'APP_CONFIG_LIST'	=> array('menu'),

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'zerofault_yishu',
		'DB_USER'			=> 'zerofault_root',
		'DB_PWD'			=> '123456',
		'DB_PREFIX'			=> 'erp_',

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 0, //实时认证
		'USER_AUTH_MODEL' => 'Staff',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'RBAC_ROLE_TABLE'=>'erp_role',
		'RBAC_USER_TABLE'=>'erp_staff_role',
		'RBAC_ACCESS_TABLE'=>'erp_role_node',
		'RBAC_NODE_TABLE'=>'erp_node',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit')//在Iframe中进行的且需要认证的操作
	);
}
return $config;
?>