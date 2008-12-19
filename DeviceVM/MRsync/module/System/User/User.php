<?php
$isub_op = (isset($_REQUEST['subop']) || trim($_REQUEST['subop'])!='') ? trim($_REQUEST['subop']) : 'browse';

$iSUB_OP_Mod=PATH_Module . $iModule . "/" . $iop . "/" . $iop . "." . $isub_op . ".php";
if (file_exists($iSUB_OP_Mod))
{
	include_once(objects_path . 'class.' . $DB . '.Admin_User.php');
	$oAdmin_User=new Admin_User();
	include_once($iSUB_OP_Mod);
}
else
{
	echo $iModule.'-'.$iop.'-'.$isub_op.' error !';
}
$smarty->assign('subop', $isub_op);
?>
