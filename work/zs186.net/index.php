<?php
if (file_exists(dirname(__FILE__).'/LOCAL')) {
	define('ENV', 'LOCAL');
}
elseif (file_exists(dirname(__FILE__).'/TEST')) {
	define('ENV', 'TEST');
}
else {
	define('ENV', '');
}
define('THINK_PATH', dirname(__FILE__).'/Core');
define('APP_NAME', '');
define('APP_PATH', '.');
require(THINK_PATH."/ThinkPHP.php");
$App = new App();
$App->run();
?>