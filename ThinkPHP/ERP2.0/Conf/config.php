<?php
$config = array(
	'APP_DEBUG'			=> true,
	'USER_AUTH_TYPE'	=> 2,

	'APP_CONFIG_LIST'	=> array('menu', 'absence', 'smtp', 'test'),
	'TAG_NESTED_LEVEL'	=> 6,

	'DB_TYPE'			=> 'mysql',
	'DB_HOST'			=> 'localhost', //数据库地址
	'DB_NAME'			=> 'ERP2', //数据库名
	'DB_USER'			=> 'root', //访问数据库的帐号
	'DB_PWD'			=> '', //访问数据库的密码
	'DB_PREFIX'			=> 'erp_',

	//显示标题，用于区分不同的ERP site
	'ERP_TITLE'			=> 'AGIGA Tech ERP System',

	//用户session，用于区分不同ERP site
	'STAFF_AUTH_NAME'   => 'staff',
	'MANAGER_AUTH_NAME' => 'location_manager',
	'ADMIN_AUTH_NAME'	=> 'administrator',
	
	'SUPER_ADMIN_ID'	=> array(1), //超级管理员的ID数组
	'ABSENCE_ADMIN_ID'	=> array(7), //Absence管理员(HR)的帐号ID，纯数字数组
	'NOTIFICATION_MAILTO' => array(), //资产申请时的重复通知邮件会额外发送给这些邮件帐号
	'USER_SYNC_TARGET'  => array('CuteFlow'=>'http://192.168.9.159/cuteflow/'), //AgigaFlow系统的根路径

	//权限认证所需参数，请不要更改
	'USER_AUTH_ON'		=> true,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'USER_AUTH_GATEWAY' => '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory,Absence',
	'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select','import','create')
	);

return $config;
?>