<?
define('IN_MATCH', true);
session_start();
$lifeTime = 24 * 3600; 
setcookie(session_name(), session_id(), time() + $lifeTime);//用cookie保存登录session,期限为一天
$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'index.htm'));

if($_POST["Submit"])
{
	$name=$_POST["html_name"];
	$pass=$_POST["html_pass"];

	if("admin"==$name && '#dAk7(Ns{#1a'==$pass)
	{
		session_register("admin");
		header("location:user_list.php");
		exit;
	}
	elseif('user'==$name && 'B*g5%dFD(@{A'==$pass)
	{
		session_register("user");
		header("location:user_list.php");
		exit;
	}
}

$tpl->pparse('body');
$tpl->destroy();
?>