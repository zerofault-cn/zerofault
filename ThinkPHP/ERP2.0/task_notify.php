<?php 
/**
* 命令行调用接口
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

if (file_exists(dirname(__FILE__).'/LOCAL')) {
	define('ENV', 'LOCAL');
	define('THINK_PATH', dirname(__FILE__).'/../ThinkPHP/ThinkPHP');
	define('APP_ROOT', 'http://localhost/ERP2.0/index.php');
}
elseif (file_exists(dirname(__FILE__).'/TEST')) {
	define('ENV', 'TEST');
	define('THINK_PATH', dirname(__FILE__).'/Core');
	define('APP_ROOT', 'http://172.23.57.20/ERP2.0/index.php');
}
else {
	define('ENV', '');
	define('THINK_PATH', dirname(__FILE__).'/Core');
	define('APP_ROOT', 'http://172.23.57.10/ERP/index.php');
}
require(THINK_PATH."/ThinkPHP.php");

//定义为命令行模式
define('CLI',true);

//定义默认Module和Action
define('MODULE_NAME','Public');
define('ACTION_NAME','task_notify');

$App = new App(); 
$App->run();

?>