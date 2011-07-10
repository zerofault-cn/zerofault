<?php
$config = array(
	//调试模式，默认false
	'APP_DEBUG'			=> false,
	//扩展配置文件
	'APP_CONFIG_LIST'	=> array('menu', 'absence', 'smtp', 'test'),
	//标签嵌套级别，默认为3
	'TAG_NESTED_LEVEL'	=> 6,
	//数据库参数
	'DB_TYPE'			=> 'mysql',
	'DB_HOST'			=> 'localhost',
	'DB_NAME'			=> 'ERP',
	'DB_USER'			=> 'root',
	'DB_PWD'			=> '',
	'DB_PREFIX'			=> 'erp_',
	//显示标题，用于区分不同的ERP site
	'ERP_TITLE'			=> 'AGIGA Tech ERP System',
	//用户session变量名，用于在同一站点上区分不同目录下的ERP系统
	'STAFF_AUTH_NAME'   => 'staff',
	'MANAGER_AUTH_NAME' => 'location_manager',
	'ADMIN_AUTH_NAME'	=> 'administrator',
	//超级管理员的ID数组，用英文逗号分隔
	'SUPER_ADMIN_ID'	=> array(1),
	//Absence管理员(HR)的ID数组
	'ABSENCE_ADMIN_ID'	=> array(1),
	//Task管理员的ID数组
	'TASK_ADMIN_ID'		=> array(1),
	//资产申请时的提醒通知邮件会额外发送给这些邮件帐号，用英文单引号包含，英文逗号分隔
	'NOTIFICATION_MAILTO' => array(),
	//权限认证所需参数，请不要随意更改
	'USER_AUTH_ON'		=> true,
	//权限认证模式，默认为1：登录时认证一次；2：实时认证
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'USER_AUTH_GATEWAY' => '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',
	//以下模块不需要权限认证，即默认情况下所有Staff帐号都可以访问
	'NOT_AUTH_MODULE'	=> array('Index', 'Public', 'Script', 'Asset', 'Inventory', 'Absence', 'Task', 'Attachment'),
	//在iframe中处理请求，并以弹出消息方式提示处理结果的Action名
	'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select','import','create')
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['USER_AUTH_TYPE'] = 2;
//	$config['USER_AUTH_METHOD'] = 'LDAP'; //可选LDAP或DB，如果无此参数，或者设为其他值，均使用DB方式
//	$config['APP_CONFIG_LIST'][] = 'ldap';

	$config['ERP_TITLE'] = 'Local ERP';

	$config['APP_CONFIG_LIST'][] = 'share';
	$config['NOT_AUTH_MODULE'][] = 'Share';
}
elseif (ENV == 'TEST') {
	$config['ERP_TITLE'] = 'ERP Test';
	$config['DB_PWD'] = 'erp4ctu';

	$config['APP_CONFIG_LIST'][] = 'share';
	$config['NOT_AUTH_MODULE'][] = 'Share';

	$config['ABSENCE_ADMIN_ID'] = array(1,9);
	$config['TASK_ADMIN_ID'] = array(3,9);
}
return $config;
?>