<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_GET['id'];

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

	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Host Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Edit RsyncHost',
		"info_xml"=>"New Host Info:\nName:".$oRsync_Host->Name."\nHost:".$oRsync_Host->Host."\nPath:".$oRsync_Host->Path."\nDescription:".$oRsync_Host->Description,
		"description"=>'update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/
	
	if($oRsync_Host->Update($ID)) {
		echo '<script>parent.alert("Update Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
	}
	else { 
		echo '<script>parent.alert("Update Fail! Please check! ");</script>';

		$LOG_ARR["description"]='update fail';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/
	exit;
}

$arr=$oRsync_Host->view($ID);
if(!empty($arr))
{
	$Rsync_Host = array(
		'ID'		=> $ID,
		'Name'		=> $arr['Name'],
		'Host'		=> $arr['Host'],
		'Path'		=> $arr['Path'],
		'Description'	=> $arr['Description']
	);
}

$smarty->assign('Rsync_Host', $Rsync_Host);

$smarty->assign('Title','Edit Rsync Host');
?>