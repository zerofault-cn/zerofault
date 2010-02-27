<?php
if($_SERVER["SERVER_NAME"]=='localhost' || substr($_SERVER["SERVER_NAME"],0,3)=='192') {
	$config = array(
		'APP_DEBUG'			=> true,
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'yishu321',
		'DB_USER'			=> 'root',
		'DB_PWD'			=> '',
	);
}
else {
	$config = array(
		'DB_HOST'			=> '222.76.214.65',
		'DB_NAME'			=> 'yishu321',
		'DB_USER'			=> 'yishu321',
		'DB_PWD'			=> 'yishu321',
	);
}
$config = array_merge($config,array(

		'DB_TYPE'			=> 'mysql',
		'DB_PREFIX'			=> 'yishu_',


		'DATA_CACHE_TYPE'=>'file',	//数据缓存方式：文件
		'DATA_CACHE_TIME'=>86400,		//数据缓存有效期 10 秒

		'HTML_CACHE_ON'=>false,
		'HTML_FILE_SUFFIX'=>'.html',
		'HTML_CACHE_TIME'=>86400,
		'HTML_READ_TYPE'=>0,


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
	));
return $config;
?>