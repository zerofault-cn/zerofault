<?php
$config = array(

	'DB_PREFIX'			=> 'zs_',

	'DATA_CACHE_TYPE'	=> 'file',	//数据缓存方式：文件
	'DATA_CACHE_TIME'	=> 86400,	//数据缓存有效期,秒

	'HTML_CACHE_ON'		=> false,
	'HTML_FILE_SUFFIX'	=> '.html',
	'HTML_CACHE_TIME'	=> 86400,
	'HTML_READ_TYPE'	=> 0,
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['DB_NAME'] = 'zs186_net';
}
else {
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'lezhuang';
	$config['DB_USER'] = 'lezhuang';
	$config['DB_PWD'] = 'w2j7u5';
	$config['APP_DOMAIN_DEPLOY'] = true;
}
return $config;
?>