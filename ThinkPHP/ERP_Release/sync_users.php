<?php 
/**
* 命令行调用接口
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

define('THINK_PATH', dirname(__FILE__).'/Core');
require(THINK_PATH."/ThinkPHP.php");

//定义为命令行模式
define('CLI',true);

//定义默认Module和Action
define('MODULE_NAME','Public');
define('ACTION_NAME','sync_users');

//设置CuteFlow根目录地址
define('CuteFlow', 'http://172.23.57.10/cuteflow/');

$App = new App(); 
$App->run();

?>