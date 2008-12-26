<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
if($action=='Doit') {
	$oRsync_Host->Name	= trim($_POST['Name']);
	$oRsync_Host->Host	= trim($_POST['Host']);
	$oRsync_Host->Path	= trim($_POST['Path']);
	$oRsync_Host->Description	= trim($_POST['Description']);
	if(empty($oRsync_Host->Name))
	{
		echo '<script>parent.alert("No Name specified!");</script>';
		exit;
	}
	if(empty($oRsync_Host->Host))
	{
		echo '<script>parent.alert("No Host address specified!");</script>';
		exit;
	}
	if(empty($oRsync_Host->Path))
	{
		echo '<script>parent.alert("No Path specified!");</script>';
		exit;
	}
	
	/****************Event Log************************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Host Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Add RsyncHost',
		"info_xml"=>"Host Info:\nName:".$oRsync_Host->Name."\nHost:".$oRsync_Host->Host."\nPath:".$oRsync_Host->Path."\nDescription:".$oRsync_Host->Description,
		"description"=>'add success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log************************/
	

	if($oRsync_Host->Add())
	{
		echo '<script>parent.alert("Add Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
	}
	else
	{
		echo '<script>parent.alert("Add Fail! Please check! ");</script>';

		$LOG_ARR["description"]='insert db error';
	}
	/****************Event Log************************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log************************/
	exit;
}
?>