<?php 
/**
* 项目总入口
* 定义框架所在目录、项目名、项目路径
*
* @author zerofault <zerofault@gmail.com>
* @since  2014/6/13
*/

define('APP_NAME', '');

define('APP_PATH', dirname(__FILE__).'/');

if (file_exists(APP_PATH.'LOCAL')) {
	define('ENV', 'LOCAL');
	define('THINK_PATH', APP_PATH.'../ThinkPHP/');
	define('APP_DEBUG',true);
}
else {
	define('ENV', '');
	define('THINK_PATH', APP_PATH.'ThinkPHP/');
}
define('ENGINE_NAME','Sae');
require(THINK_PATH."ThinkPHP.php");
//define('ENGINE_PATH', THINK_PATH.'Extend/Engine/');
//require THINK_PATH.'Extend/Engine/Sae.php';

?>