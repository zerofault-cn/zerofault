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
	define('CF_ROOT', 'http://localhost/cuteflow/');
}
elseif (file_exists(dirname(__FILE__).'/TEST')) {
	define('ENV', 'TEST');
	define('THINK_PATH', dirname(__FILE__).'/Core');
	define('CF_ROOT', 'http://172.23.57.20/cuteflow/');
}
else {
	define('ENV', '');
	define('THINK_PATH', dirname(__FILE__).'/Core');
	define('CF_ROOT', 'http://172.23.57.10/cuteflow/');
}
require(THINK_PATH."/ThinkPHP.php");

//定义为命令行模式
define('CLI',true);

//定义默认Module和Action
define('MODULE_NAME','Public');
define('ACTION_NAME','sync_users');

$App = new App(); 
$App->run();

?>