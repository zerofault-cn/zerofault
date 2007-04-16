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
$pass_arr=array("","dF^*23][Ms!#","#dAk7(Ns{#1a","B*g5%dFD(@{A");

if($_POST["Submit"])
{
	$name=$_POST["html_name"];
	$pass=$_POST["html_pass"];
	$area=$_POST["area"];

	if("0"==$area)
	{
		if("admin_mm"==$name && "k:]gml}M<9J>"==$pass)
		{
			session_register("admin");
			echo "<script>location='user_list.php';</script>";
			exit;
		}
		elseif("mm"==$name && "z]k)ONvi5]9i"==$pass)
		{
			session_register("user");
			echo "<script>location='user_list.php';</script>";
			exit;
		}
	}
	else
	{
		if("admin_mm"==$name && $pass==$pass_arr[$area])
		{
			session_register("admin");
			session_register("admin_area");
			$_SESSION['admin_area']=$area;
			echo "<script>location='user_list.php';</script>";
			exit;
		}
	}
}

$tpl->pparse('body');
$tpl->destroy();
?>