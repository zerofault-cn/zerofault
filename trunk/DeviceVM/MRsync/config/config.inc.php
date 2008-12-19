<?PHP
define('PATH_ROOT',$_SERVER['DOCUMENT_ROOT'] . '/MRsync/');

define('PATH_Config', PATH_ROOT . 'config/');
define('PATH_Include',PATH_ROOT . 'Include/');
define('PATH_Module', PATH_ROOT . 'module/');

define('objects_path',PATH_Include . 'objects/');
define('adodb_path',  PATH_Include . 'adodb/');
define('smarty_path', PATH_Include . 'smarty/');

define('PATH_Template',PATH_ROOT . 'Template/');
define('PATH_Compile', PATH_ROOT . 'Compile/');

define('PATH_Lib',PATH_ROOT . 'lib/');

define('XML_FILE_FOLDER',PATH_ROOT . 'rsync_xml/');
define('SYNC_FILE_FOLDER','/home');//no slash('/') at the end

session_start();

include_once('config_db.inc.php');


if(isset($_SESSION['Pref']['Theme']) && $_SESSION['Pref']['Theme']!='') { $theme = $_SESSION['Pref']['Theme']; }
else { $theme = 'default'; }

include_once('config_tpl.inc.php');
?>