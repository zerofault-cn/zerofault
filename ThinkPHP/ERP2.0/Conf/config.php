<?php
	$config = array(
		'APP_DEBUG'			=> true,
		'DB_NAME'			=> 'ERP2',
		'DB_USER'			=> 'root',
		'DB_PWD'			=> '',
		'USER_AUTH_TYPE'	=> 2, //1:登录时一次验证，2:实时验证，默认为1
	);
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
		'SUPER_ADMIN_ID'	=> array(1), //超级管理员的ID数组
		'NOTIFICATION_MAILTO' => array('bin.li@agigatech.com'), //重复通知邮件会额外发送给这些邮件帐号
		'USER_AUTH_GATEWAY' => '/Public/login',
		'RBAC_ROLE_TABLE'	=> 'erp_role',
		'RBAC_USER_TABLE'	=> 'erp_staff_role',
		'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
		'RBAC_NODE_TABLE'	=> 'erp_node',
		'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select','import')//在Iframe中进行的且需要认证的操作
		));
return $config;
?>