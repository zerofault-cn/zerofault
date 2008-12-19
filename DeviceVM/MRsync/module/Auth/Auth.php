<?php
empty($iop) && $iop = (isset($_REQUEST['op']) || trim($_REQUEST['op'])!='') ? trim($_REQUEST['op']) : 'login';

$iOP_Mod=PATH_Module.$iModule."/".$iModule.".".$iop.".php"; 

if (file_exists($iOP_Mod))
{
	include_once($iOP_Mod);
}
else
{
	echo $iModule.'-'.$iop." error !"; 
}

$smarty->assign('op', $iop);
?>
