<?php
$ID=$_GET['id'];

$arr=$oAdmin_User->View($ID);
/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'User Module',
	"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Delete user',
	"info_xml"=>"Delete user:".$arr['Username'],
	"description"=>'delete success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

if($oAdmin_User->Del($ID)) {
//	$Update=1;
	echo '<script>parent.alert("Delete Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
}
else { 
//	$Update=0;
	echo '<script>parent.alert("Delete Fail! Please check! ");</script>';

	$LOG_ARR["description"]='delete error';
}
/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/

exit;
?>