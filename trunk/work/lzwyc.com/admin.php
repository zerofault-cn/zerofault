<?php
if (file_exists(dirname(__FILE__).'/LOCAL')) {
	define('ENV', 'LOCAL');
}
else {
	define('ENV', '');
}
define('THINK_PATH', dirname(__FILE__).'/Core');
define('APP_NAME', 'admin');
define('APP_PATH', './admin');
require(THINK_PATH."/ThinkPHP.php");
$App = new App();
$App->run();
?>