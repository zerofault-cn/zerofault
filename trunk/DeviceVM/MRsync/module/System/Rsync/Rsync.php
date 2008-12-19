<?php
$isub_op = (isset($_REQUEST['subop']) || trim($_REQUEST['subop'])!='') ? trim($_REQUEST['subop']) : 'browse';

$iSUB_OP_Mod=PATH_Module . $iModule . "/" . $iop . "/" . $iop . "." . $isub_op . ".php";
if (file_exists($iSUB_OP_Mod))
{
	include_once(objects_path . 'class.' . $DB . '.Sync_XML.php');
	include_once(objects_path . 'class.' . $DB . '.Sync_Info.php');
	include_once(objects_path . 'class.' . $DB . '.Host_Info.php');
	$oSync_XML = new Sync_XML();
	$oSync_Info= new Sync_Info();
	$oHost_Info= new Host_Info();

	include_once($iSUB_OP_Mod);
}
else
{
	echo $iModule.'-'.$iop.'-'.$isub_op.' error !';
}

$smarty->assign('subop', $isub_op);
?>
