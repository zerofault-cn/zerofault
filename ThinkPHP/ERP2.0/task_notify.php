<?php 
/**
* 命令行调用接口
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

define('THINK_PATH', dirname(__FILE__).'/Core');
//define('THINK_PATH', dirname(__FILE__).'/../ThinkPHP/ThinkPHP');
require(THINK_PATH."/ThinkPHP.php");

//定义为命令行模式
define('CLI',true);

//定义默认Module和Action
define('MODULE_NAME','Public');
define('ACTION_NAME','task_notify');

//设置web服务器的IP及路径
define('APP_ROOT', 'http://172.23.57.10/ERP/index.php');

$App = new App(); 
$App->run();

?>