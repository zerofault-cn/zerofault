<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

session_start();
?>


<?php
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//����ͶƱʱ��Σ����ݲ�ͬʱ��Σ������ݱ��浽��ͬ�ı�



$db->sql_close();
?>
