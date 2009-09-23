<?php
if($_SERVER["SERVER_NAME"]=='localhost') {
	$config = array(
		'APP_DEBUG'			=> false,
		'APP_DOMAIN_DEPLOY'	=> false,
		'APP_FILE_CASE'		=> true,
		'APP_CONFIG_LIST'	=> array('menu'),

		'COOKIE_EXPIRE'		=> 86400,    // Coodie有效期
		'COOKIE_DOMAIN'		=> '',      // Cookie有效域名
		'COOKIE_PATH'		=> '/',     // Cookie路径
		'COOKIE_PREFIX'		=> 'erp_',      // Cookie前缀 避免冲突

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
		'IFRAME_AUTH_ACTION' => array('update','delete','edit')//在Iframe中进行的且需要认证的操作
	);
}
else{
	$config = array(
		'APP_DEBUG'			=> false,
		'APP_DOMAIN_DEPLOY'	=> false,
		'APP_FILE_CASE'		=> true,
		'APP_CONFIG_LIST'	=> array('menu'),

		'COOKIE_EXPIRE'		=> 86400,    // Coodie有效期
		'COOKIE_DOMAIN'		=> '',      // Cookie有效域名
		'COOKIE_PATH'		=> '/',     // Cookie路径
		'COOKIE_PREFIX'		=> 'erp_',      // Cookie前缀 避免冲突

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
		'IFRAME_AUTH_ACTION' => array('update','delete','edit')//在Iframe中进行的且需要认证的操作
	);
}
return $config;
?>