<?php 
define('THINK_PATH', '../ThinkPHP/ThinkPHP');
define('APP_NAME', 'admin');
define('APP_PATH', './admin');
require(THINK_PATH."/ThinkPHP.php");

$App = new App(); 
$App->run();
?>