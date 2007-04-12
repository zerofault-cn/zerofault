<?
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'index.htm'));

$sql1="select id,name,article_count from channel order by article_count desc limit 22";
assign_block_vars_by_sql("hotChannel", $sql1);

$sql2="select id,name from channel where sys_flag=1";
assign_block_vars_by_sql("sysChannel", $sql2);

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

?>