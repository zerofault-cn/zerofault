<?php
$ID=$_GET['id'];

$arr=$oRsync_Host->View($ID);
/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'Host Module',
	"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Delete RsyncHost',
	"info_xml"=>"Deleted Host:".$arr['Host'],
	"description"=>'delete success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

if($oRsync_Host->Del($ID)) {
//	$Update=1;
	echo '<script>parent.alert("Delete Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
}
else { 
//	$Update=0;
	echo '<script>parent.alert("Delete Fail! Please check! ");</script>';

	$LOG_ARR["description"]='delete fail';
}
/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/

exit;
?>