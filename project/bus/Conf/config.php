<?php
if(defined('CLI') || $_SERVER["SERVER_NAME"]=='localhost') {
	$config = array(
		'APP_DEBUG'			=> false,

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'bus',
		'DB_USER'			=> 'root',
		'DB_PWD'			=> '',
		'DB_PREFIX'			=> 'bus_hz_',
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.oxyhost.com') {
	$config = array(
		'APP_DEBUG'			=> false,

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'zerofault_bus',
		'DB_USER'			=> 'zerofault_root',
		'DB_PWD'			=> '123456',
		'DB_PREFIX'			=> 'bus_hz_',
	);
}
elseif($_SERVER["SERVER_NAME"]=='zerofault.zzl.org') {
	$config = array(
		'APP_DEBUG'			=> false,

		'DB_TYPE'			=> 'mysql',
		'DB_HOST'			=> 'localhost',
		'DB_NAME'			=> 'zerofault_zzl_bus',
		'DB_USER'			=> '22366_root',
		'DB_PWD'			=> '123456',
		'DB_PREFIX'			=> 'bus_hz_',
	);
}
return $config;
?>