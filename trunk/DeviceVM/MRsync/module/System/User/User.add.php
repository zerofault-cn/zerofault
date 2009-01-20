<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
if($action=='Doit') {
	$oAdmin_User->Type	= trim($_POST['Type']);
	$oAdmin_User->Role	= trim($_POST['Role']);
	$oAdmin_User->Username = trim($_POST['Username']);
	if(empty($oAdmin_User->Username))
	{
		echo '<script>parent.alert("No Username specified!");</script>';
		exit;
	}
	$oAdmin_User->Password = trim($_POST['Password']);
	if(empty($oAdmin_User->Password))
	{
		echo '<script>parent.alert("No Password specified!");</script>';
		exit;
	}
	if(strlen(trim($_POST['PassValidate']))>0)
	{
		$oAdmin_User->PassValidate = trim($_POST['PassValidate']);
	}
	else
	{
		$oAdmin_User->PassValidate = date("Y-m-d H:i:s",time()+3*30*24*60*60);//默认3个月有效期
	}
	$oAdmin_User->Name	= trim($_POST['Name']);
	$oAdmin_User->EMail	= trim($_POST['EMail']);
	$oAdmin_User->Memo	= trim($_POST['Memo']);
	$oAdmin_User->CreateTime=date("Y-m-d H:i:s");
	
	/****************Event Log************************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'User Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Add Admin_User',
		"info_xml"=>"Add user:".trim($_POST['Username']),
		"description"=>'add success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log************************/
	

	if($oAdmin_User->Add()!=false)
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

$smarty->assign('Title','Add User');
?>