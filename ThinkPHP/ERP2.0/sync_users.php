<?php 
/**
* 命令行调用接口
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

//define('THINK_PATH', dirname(__FILE__).'/Core');
define('THINK_PATH', dirname(__FILE__).'/../ThinkPHP/ThinkPHP');
require(THINK_PATH."/ThinkPHP.php");

//定义为命令行模式
define('CLI',true);

//定义默认Module和Action
define('MODULE_NAME','Public');
define('ACTION_NAME','sync_users');

//设置CuteFlow根目录地址
//define('CF_ROOT', 'http://172.23.57.10/cuteflow/');
define('CF_ROOT', 'http://192.168.8.134/cuteflow/');

$App = new App(); 
$App->run();

?>