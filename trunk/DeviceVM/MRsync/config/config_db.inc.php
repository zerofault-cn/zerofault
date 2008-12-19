<?PHP
include_once(adodb_path .'adodb.inc.php');

$ADODB_DRIVER='mysql';
$ADODB_CONNECT='192.168.9.177';
$ADODB_USER ='dvm';
$ADODB_PWD ='dvmpwd';
$ADODB_DB ='MRsync';

$DB=$ADODB_DB;

$db = &ADONewConnection($ADODB_DRIVER);

$db->Connect($ADODB_CONNECT,$ADODB_USER,$ADODB_PWD) or die('DB connect Fail');
$db->SelectDB($DB);
//$db->lifetime(300);
$db->SetFetchMode(ADODB_FETCH_ASSOC);

?>
