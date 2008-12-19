<?php
require_once("config/config.inc.php");
require_once(PATH_Include."common_func.php");

//$smarty->debugging=true;
if(!empty($_GET['Mod']))
{
	$iModule = $_GET['Mod'];
	
	$iAuth = (session_is_registered("auth") && isset($_SESSION['auth'])) ? $_SESSION['auth'] : '';
	if($iAuth=='' && $iModule=="System") 
	{
		session_register("login_url");
		$url = "http://".$_SERVER['HTTP_HOST'];
		$url .= $_SERVER["REQUEST_URI"];
		$_SESSION['login_url']=$url;
		$iModule = "Auth";
		$iop="login";
	}
	$smarty->assign('Module',$iModule);
		
	$Mod_Path = PATH_Module . $iModule."/".$iModule.".php" ;
	if(file_exists($Mod_Path))
	{
		include_once($Mod_Path);
	}
	else
	{
		echo 'Sorry !  Module : "'.$iModule.'" doesn\'t exist !';
		exit;
	}
	$smarty->assign('Theme', $theme);
	$smarty->display("index.html");
}
else
{
	echo "Welcome ! DVM Manual Rsync Batch System. [ " . $_SERVER['HTTP_HOST'] . " ]";
}
$db->Close();
?>
