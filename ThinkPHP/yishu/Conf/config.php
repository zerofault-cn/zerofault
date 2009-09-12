<?php 
if($_SERVER["SERVER_NAME"]=='localhost') {
	return array( 
		// 定义数据库连接信息
		'DB_TYPE'=> 'mysql',
		'DB_HOST'=> 'localhost',
		'DB_NAME'=>'yishu321',
		'DB_USER'=>'root',
		'DB_PWD'=>'',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'yishu_', //数据表前缀（与数据库myapp中的表think_message对应）

	//	'URL_MODEL' => 2,
	//	'DEBUG_MODE'=>true, //开启调试模式
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => false, //域名根目录下设为true

		'DATA_CACHE_TYPE'=>'file',	//数据缓存方式：文件
		'DATA_CACHE_TIME'=>100,		//数据缓存有效期 10 秒

		'HTML_CACHE_ON'=>true,
		'HTML_FILE_SUFFIX'=>'.html',
		'HTML_CACHE_TIME'=>1000,
		'HTML_READ_TYPE'=>0,
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

	//	'URL_MODEL' => 2,
	//	'DEBUG_MODE'=>true, //开启调试模式
	//	'SHOW_PAGE_TRACE' => TRUE,

		'APP_DOMAIN_DEPLOY' => true, //域名根目录下设为true

		'DATA_CACHE_TYPE'=>'file',	//数据缓存方式：文件
		'DATA_CACHE_TIME'=>86400,		//数据缓存有效期 10 秒

		'HTML_CACHE_ON'=>false,
		'HTML_FILE_SUFFIX'=>'.html',
		'HTML_CACHE_TIME'=>86400,
		'HTML_READ_TYPE'=>0,
	);
}
?>

