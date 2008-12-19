<?php
$iop = (isset($_REQUEST['op']) || trim($_REQUEST['op'])!='') ? trim($_REQUEST['op']) : 'Rsync';

if($iop!='')
{
	$iOP_Mod=PATH_Module . $iModule . "/" . $iop . "/" . $iop . ".php";
}
else
{
	$iOP_Mod=PATH_Module . $iModule . "/" . $iModule . ".List.php";
}
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
