<?PHP
//define('PATH_ROOT',$_SERVER[DOCUMENT_ROOT].'/../');
define('PATH_ROOT',$_SERVER[DOCUMENT_ROOT]);

define('PATH_Include',PATH_ROOT . 'Include/');
define('PATH_Config',PATH_ROOT . 'Config/');
define('PATH_File',PATH_ROOT . 'Files/');

define('PATH_Compile',PATH_ROOT . 'DBObject/Compile/');
define('PATH_Template',PATH_ROOT . 'DBObject/Template/');
define('PATH_Module',PATH_Template);



define('objects_path',PATH_Include . 'objects/');
define('adodb_path', PATH_Include . 'adodb/');
define('smarty_path', PATH_Include . 'smarty/');



include_once(PATH_Config . 'config_db.inc.php');


if(isset($_SESSION[Pref][Language])&$_SESSION[Pref][Language])
{
	$lang = $_SESSION[Pref][Language];
}else{
	$lang = 'en';
}

if(isset($_SESSION[Pref][Theme])&$_SESSION[Pref][Theme]!='')
{
	$theme = $_SESSION[Pref][Theme];
}else{
	$theme = 'default';
}


include_once(PATH_Config . 'config_tpl.inc.php');



/*
function checkvar($input)
{
	echo '<pre><br>';
	print_r($input);
    echo '</pre><hr>';
}
*/
//include_once(PATH_Include . 'class.MyTimer.inc.php');

?>