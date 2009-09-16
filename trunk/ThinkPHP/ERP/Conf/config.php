<?php 
if($_SERVER["SERVER_NAME"]=='localhost') {
	return array(

		'DEFAULT_LANGUAGE'=> 'en-US',
		'DB_TYPE'=> 'mysql',	// 定义数据库连接信息
		'DB_HOST'=> 'localhost',
		'DB_NAME'=>'ERP',
		'DB_USER'=>'root',
		'DB_PWD'=>'',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'erp_',

		'EXTEND_CONFIG_LIST'=>array('menu'),
		'DEBUG_MODE'=>true, //开启调试模式
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => false, //项目在域名根时设为true

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 2, //实时认证，开发过程中使用
		'USER_AUTH_DECISION' => 'My',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_PROVIDER' => 'DaoAuthentictionProvider',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit')//在Iframe中进行的且需要认证的操作
	);
}
else{
	return array( 
		// 定义数据库连接信息
		'DB_TYPE'=> 'mysql',
		'DB_HOST'=> '61.160.213.132',
		'DB_NAME'=>'yishu321',
		'DB_USER'=>'yishu321',
		'DB_PWD'=>'yishu321',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'yishu_', //数据表前缀（与数据库myapp中的表think_message对应）


	//	'URL_MODEL' => 0,
	//	'DEBUG_MODE'=>true, //开启调试模式
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => false, //域名根目录下设为true

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 2, //实时认证，开发过程中使用
		'USER_AUTH_DECISION' => 'My',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_PROVIDER' => 'DaoAuthentictionProvider',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit')//在Iframe中进行的且需要认证的操作
	);
}
?>

