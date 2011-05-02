<?php
return $config = array(
	'ERP_TITLE'		=> 'AGIGA Tech ERP System', //设置系统标题，用于区分
	'DB_TYPE'		=> 'mysql',
	'DB_HOST'		=> 'localhost',  //设置MySQL服务器地址
	'DB_NAME'		=> 'ERP',        //设置ERP所用的Database
	'DB_USER'		=> 'root',       //设置连接MySQL的用户名
	'DB_PWD'		=> '',           //设置连接MySQL的密码
	'DB_PREFIX'		=> 'erp_',

	'APP_CONFIG_LIST'	=> array('menu'),

	'USER_AUTH_ON'		=> true,
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'STAFF_AUTH_NAME'	=> 'staff',         //保存登录用户的信息，为了与测试系统区分开，请修改为不同的值
	'MANAGER_AUTH_NAME'	=> 'manager',       //保存库管人员的信息，为了与测试系统区分开，请修改为不同的值
//	'ADMIN_AUTH_KEY'	=> 'administrator', //原ADMIN_AUTH_KEY改名为ADMIN_AUTH_NAME
	'ADMIN_AUTH_NAME'	=> 'administrator', //保存超级管理员的信息，为了与测试系统区分开，请修改为不同的值
	'SUPER_ADMIN_ID'	=> array(1),        //设定超级管理员，默认staff.ID为1，可以添加多个，用英文逗号分隔
	'USER_AUTH_GATEWAY'	=> '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
	'IFRAME_AUTH_ACTION'	=> array('update', 'delete', 'edit', 'submit', 'confirm', 'select','import')
	);
?>