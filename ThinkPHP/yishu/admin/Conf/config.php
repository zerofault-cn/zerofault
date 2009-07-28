<?php 

return array( 
	// 定义数据库连接信息
	'DB_TYPE'=> 'mysql',
	'DB_HOST'=> 'localhost',
	'DB_NAME'=>'yishu',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'yishu_', //数据表前缀（与数据库myapp中的表think_message对应）

//	'URL_MODEL' => 2,
	'DEBUG_MODE'=>true, //开启调试模式
	'SHOW_PAGE_TRACE' => TRUE,

	'APP_DOMAIN_DEPLOY' => false, //域名根目录下设为true

	'USER_AUTH_ON'=>true,
	'USER_AUTH_TYPE' => 1,
	'USER_AUTH_DECISION' => 'My',
	'USER_AUTH_KEY' => 'authId',
	'ADMIN_AUTH_KEY' => 'administrator',
	'USER_AUTH_PROVIDER' => 'DaoAuthentictionProvider',
	'USER_AUTH_GATEWAY' => '/Public/login',
	'NOT_AUTH_MODULE' => 'Public',
	'REQUIRE_AUTH_MODULE'=> '',
	'NOT_AUTH_ACTION' => 'login,logout,checkLogin',
	'REQUIRE_AUTH_ACTION'=> ''
	);

?>

