<?php
$ID=$_GET['id'];
$field=$_GET['field'];
$value=$_GET['value'];

/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'Rsync Module',
	"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Change '.$field,
	"info_xml"=>"change ".$field." to ".$value,
	"description"=>'update success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

$oSync_XML->{$field}=$value;

if($oSync_XML->update($ID))
{
	echo '<script>parent.alert("Update Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
}
else
{
	echo '<script>parent.alert("Update DB error!");</script>';
	$LOG_ARR["description"]='update DB error!';
}

/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/
exit;

?>