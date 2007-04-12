<?
session_start();
define('IN_MATCH', true);

$root_path = "./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'index.htm'));

if($_POST["Submit"])
{
	$name=$_POST["html_name"];
	$pass=$_POST["html_pass"];
	if("star"==$name && "ent_20060224"==$pass)
	{
		session_register("admin");
		echo "<script>location='user_list.php';</script>";
		exit;
	}
}

$tpl->pparse('body');
$tpl->destroy();
?>