<?php
if($_SERVER["SERVER_NAME"]=='localhost' || substr($_SERVER["SERVER_NAME"],0,3)=='192') {
	$config = array(
		'APP_DEBUG'			=> true,
		'DB_NAME'			=> 'ERP2',
		'DB_USER'			=> 'root',
		'DB_PWD'			=> '',
		'USER_AUTH_TYPE'	=> 2, //1:登录时一次验证，2:实时验证，默认为1
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.zzl.org') {
	$config = array(
		'DB_NAME'			=> 'zerofault_zzl_erp',
		'DB_USER'			=> '22366_root',
		'DB_PWD'			=> '123456',
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.oxyhost.com') {
	$config = array(
		'DB_NAME'			=> 'zerofault_yishu',
		'DB_USER'			=> 'zerofault_root',
		'DB_PWD'			=> '123456',
	);
}
$config = array_merge($config,array(
		'APP_CONFIG_LIST'	=> array('menu'),

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_PREFIX'			=> 'erp_',

		'ERP_TITLE'			=> 'AGIGA Tech ERP System',
		'USER_AUTH_ON'		=>true,
		'USER_AUTH_MODEL'	=> 'Staff',
		'USER_AUTH_KEY'		=> 'authId',
		'STAFF_AUTH_NAME'   => 'staff',
		'MANAGER_AUTH_NAME' => 'manager',
		'ADMIN_AUTH_NAME'	=> 'administrator',
		'SUPER_ADMIN_ID'	=> array(1),//超级管理员的ID数组
		'USER_AUTH_GATEWAY' => '/Public/login',
		'RBAC_ROLE_TABLE'	=> 'erp_role',
		'RBAC_USER_TABLE'	=> 'erp_staff_role',
		'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
		'RBAC_NODE_TABLE'	=> 'erp_node',
		'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select')//在Iframe中进行的且需要认证的操作
		));
return $config;
?>