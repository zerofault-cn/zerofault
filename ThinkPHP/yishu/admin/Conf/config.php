<?php 

return array( 
	// �������ݿ�������Ϣ
	'DB_TYPE'=> 'mysql',
	'DB_HOST'=> 'localhost',
	'DB_NAME'=>'yishu',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'yishu_', //���ݱ�ǰ׺�������ݿ�myapp�еı�think_message��Ӧ��

//	'URL_MODEL' => 2,
	'DEBUG_MODE'=>true, //��������ģʽ
	'SHOW_PAGE_TRACE' => TRUE,

	'APP_DOMAIN_DEPLOY' => false, //������Ŀ¼����Ϊtrue

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

