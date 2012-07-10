<?php
$config = array(

	'DB_PREFIX'			=> 'hg_',

	'DATA_CACHE_TYPE'	=> 'file',	//数据缓存方式：文件
	'DATA_CACHE_TIME'	=> 86400,	//数据缓存有效期,秒

	'HTML_CACHE_ON'		=> false,
	'HTML_FILE_SUFFIX'	=> '.html',
	'HTML_CACHE_TIME'	=> 86400,
	'HTML_READ_TYPE'	=> 0,
);
if (ENV == 'LOCAL') {
	$config['APP_DEBUG'] = true;
	$config['DB_NAME'] = 'hg08_com';
}
elseif (ENV == 'TEST') {
	$config['DB_HOST'] = 'ruitengtest.gotoip2.com';
	$config['DB_NAME'] = 'ruitengtest';
	$config['DB_USER'] = 'ruitengtest';
	$config['DB_PWD'] = 'ruiteng@test';
}
else {
	$config['APP_SUB_DOMAIN_DEPLOY'] = true;
	$config['DB_HOST'] = 'localhost';
	$config['DB_NAME'] = 'zshz666_com';
	$config['DB_USER'] = 'zshz666_com';
	$config['DB_PWD'] = 'yczshwhz';
}
return $config;
?>