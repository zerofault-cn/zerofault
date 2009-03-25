<?php
$iop = (isset($_REQUEST['op']) || trim($_REQUEST['op'])!='') ? trim($_REQUEST['op']) : 'Rsync';

$iOP_Mod=PATH_Module . $iModule . "/" . $iop . "/" . $iop . ".php";
if (file_exists($iOP_Mod))
{
	include_once($iOP_Mod);
}
else
{
	echo $iModule.'-'.$iop." error !"; 
}
$smarty->assign('QRSTR',$_SERVER["QUERY_STRING"]);
$smarty->assign('op', $iop);
?>
