<?PHP
include_once('../Include/adodb/adodb.inc.php');

//$ADODB_SESS_DEBUG = true;

$ADODB_DRIVER = 'mysql';
$ADODB_CONNECT = $_POST['DBServer'];
$ADODB_DB = $_POST['DBName'];
$ADODB_USER = $_POST['Username'];
$ADODB_PWD = $_POST['Password'];

$db = &ADONewConnection($ADODB_DRIVER);  
$db->Connect($ADODB_CONNECT,$ADODB_USER,$ADODB_PWD,$ADODB_DB) or die('DB connect Fail');

function checkvar($input)
{
	echo "<pre>\n";
	print_r($input);
	echo "\n</pre>\n<hr>\n";
}

?>  