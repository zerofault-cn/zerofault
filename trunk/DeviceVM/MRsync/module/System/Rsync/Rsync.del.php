<?php
$ID=$_GET['id'];

$arr=$oSync_XML->View($ID);
/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'Rsync Module',
	"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Delete rsync_xml',
	"info_xml"=>"rsync_xml:".$arr['Filename'],
	"description"=>'Delete success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

if($oSync_XML->Del($ID) && $oSync_Info->DelOpt("Sync_ID=".$ID) && $oHost_Info->DelOpt("Sync_ID=".$ID) && unlink('rsync_xml/'.$arr['Filename']))
{
	echo '<script>parent.alert("Delete Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
}
else
{
	echo '<script>parent.alert("Delete Fail! Please check! ");</script>';

	$LOG_ARR["description"]='Delete fail';
}
/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/
exit;
?>