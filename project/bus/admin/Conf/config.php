<?php 
if($_SERVER["SERVER_NAME"]=='localhost') {
	return array( 
		// �������ݿ�������Ϣ
		'DB_TYPE'=> 'mysql',
		'DB_HOST'=> 'localhost',
		'DB_NAME'=>'bus',
		'DB_USER'=>'root',
		'DB_PWD'=>'',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'bus_hz_', //���ݱ�ǰ׺�������ݿ�myapp�еı�think_message��Ӧ��
		'DB_CHARSET'=>'latin1',

		'DEBUG_MODE'=>true, //��������ģʽ
	//	'SHOW_PAGE_TRACE' => TRUE,
	);
}
else{
	return array( 
		// �������ݿ�������Ϣ
		'DB_TYPE'=> 'mysql',
		'DB_HOST'=> '61.160.213.132',
		'DB_NAME'=>'yishu321',
		'DB_USER'=>'yishu321',
		'DB_PWD'=>'yishu321',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'yishu_', //���ݱ�ǰ׺�������ݿ�myapp�еı�think_message��Ӧ��


	//	'URL_MODEL' => 2,
	//	'DEBUG_MODE'=>true, //��������ģʽ
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => false, //������Ŀ¼����Ϊtrue

		'USER_AUTH_ON'=>true,
		'USER_AUTH_TYPE' => 2, //ʵʱ��֤������������ʹ��
		'USER_AUTH_DECISION' => 'My',
		'USER_AUTH_KEY' => 'authId',
		'ADMIN_AUTH_KEY' => 'administrator',
		'USER_AUTH_PROVIDER' => 'DaoAuthentictionProvider',
		'USER_AUTH_GATEWAY' => '/Public/login',
		'NOT_AUTH_MODULE' => 'Public,Script',
		'REQUIRE_AUTH_MODULE'=> '',
		'NOT_AUTH_ACTION' => '',
		'REQUIRE_AUTH_ACTION'=> '',
		'IFRAME_AUTH_ACTION' => array('update','delete','edit')//��Iframe�н��е�����Ҫ��֤�Ĳ���
	);
}
?>

