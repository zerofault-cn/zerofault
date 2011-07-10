<?php 
/**
* 项目总入口
* 定义框架所在目录、项目名、项目路径
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

if (file_exists(dirname(__FILE__).'/LOCAL')) {
	define('ENV', 'LOCAL');
	define('THINK_PATH', dirname(__FILE__).'/../ThinkPHP/ThinkPHP');
}
elseif (file_exists(dirname(__FILE__).'/TEST')) {
	define('ENV', 'TEST');
	define('THINK_PATH', dirname(__FILE__).'/Core');
}
else {
	define('ENV', '');
	define('THINK_PATH', dirname(__FILE__).'/Core');
}
require(THINK_PATH."/ThinkPHP.php");

$App = new App(); 
$App->run();

?>