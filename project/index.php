<?php 
/**
* 项目总入口
* 定义框架所在目录、项目名、项目路径
*
* @author zerofault <zerofault@gmail.com>
* @since  2009/9/2
*/

define('THINK_PATH', 'Core');
require(THINK_PATH."/ThinkPHP.php");

$App = new App(); 
$App->run();

?>