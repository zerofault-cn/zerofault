<?php
if (file_exists(dirname(__FILE__).'/LOCAL')) {
	define('ENV', 'LOCAL');
	define('THINK_PATH', '/ThinkPHP2.2/ThinkPHP');
}
elseif (file_exists(dirname(__FILE__).'/TEST')) {
	define('ENV', 'TEST');
	define('THINK_PATH', dirname(__FILE__).'/Core');
}
else {
	define('ENV', '');
	define('THINK_PATH', dirname(__FILE__).'/Core');
}
define('THINK_PATH', dirname(__FILE__).'/Core');
define('APP_NAME', '');
define('APP_PATH', '.');
require(THINK_PATH."/ThinkPHP.php");
$App = new App();
$App->run();
?>