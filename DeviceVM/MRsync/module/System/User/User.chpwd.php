<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_SESSION['auth']['ID'];

if($action=='Doit') {
	if( md5(trim($_POST['OldPassword'])) != $_SESSION['auth']['Password'])
	{
		echo '<script>parent.alert("Old Password not matching!");</script>';
		exit;
	}
	if(strlen(trim($_POST['Password']))>0)//如果新填写了密码，则更新密码
	{
		$oAdmin_User->Password=trim($_POST['Password']);
		$oAdmin_User->PassChangeTime=date("Y-m-d H:i:s");
	}
	else
	{
		echo '<script>parent.alert("Empty password not allowed!");</script>';
		exit;
	}

	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'User Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Change Password',
		"info_xml"=>$_SESSION['auth']['Username']." change his password",
		"description"=>'update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/
	
	if($oAdmin_User->Update($ID))
	{
		echo '<script>parent.alert("Update Successfully!");</script>';
	}
	else
	{
		echo '<script>parent.alert("Update Fail! Please check! ");</script>';

		$LOG_ARR["description"]='update db fail';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/

	exit;
}


?>