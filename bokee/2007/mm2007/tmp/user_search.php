<?
include_once "session.php";
define('IN_MATCH', true);

$root_path = "../../";
$php_path="./../";
include_once($php_path."config.php");
include_once($php_path."includes/db.php");

include_once("left.php");//ื๓ฑ฿ฒหตฅ

$tpl = new Template($php_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_search.htm'));

$tpl->pparse('body');
$tpl->destroy();
?>