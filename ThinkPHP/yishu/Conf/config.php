<?php 
if($_SERVER["SERVER_NAME"]=='localhost') {
	return array( 
		// �������ݿ�������Ϣ
		'DB_TYPE'=> 'mysql',
		'DB_HOST'=> 'localhost',
		'DB_NAME'=>'yishu321',
		'DB_USER'=>'root',
		'DB_PWD'=>'',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'yishu_', //���ݱ�ǰ׺�������ݿ�myapp�еı�think_message��Ӧ��

	//	'URL_MODEL' => 2,
	//	'DEBUG_MODE'=>true, //��������ģʽ
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => false, //������Ŀ¼����Ϊtrue

		'DATA_CACHE_TYPE'=>'file',	//���ݻ��淽ʽ���ļ�
		'DATA_CACHE_TIME'=>100,		//���ݻ�����Ч�� 10 ��

		'HTML_CACHE_ON'=>true,
		'HTML_FILE_SUFFIX'=>'.html',
		'HTML_CACHE_TIME'=>1000,
		'HTML_READ_TYPE'=>0,
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

		'APP_DOMAIN_DEPLOY' => true, //������Ŀ¼����Ϊtrue

		'DATA_CACHE_TYPE'=>'file',	//���ݻ��淽ʽ���ļ�
		'DATA_CACHE_TIME'=>86400,		//���ݻ�����Ч�� 10 ��

		'HTML_CACHE_ON'=>false,
		'HTML_FILE_SUFFIX'=>'.html',
		'HTML_CACHE_TIME'=>86400,
		'HTML_READ_TYPE'=>0,
	);
}
?>

