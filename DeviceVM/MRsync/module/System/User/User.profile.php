<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_SESSION['auth']['ID'];

if($action=='Doit') {
	$oAdmin_User->Username=trim($_POST['Username']);
	$oAdmin_User->Name=trim($_POST['Name']);
	$oAdmin_User->EMail=trim($_POST['EMail']);
	$oAdmin_User->Memo=trim($_POST['Memo']);

	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'User Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Change profile',
		"info_xml"=>$_SESSION['auth']['Username']." change his profile",
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

		$LOG_ARR["description"]='update fail';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/

	exit;
}

$arr=$oAdmin_User->view($ID);
if(!empty($arr))
{
	$User_Info = array(
		'ID'=>$ID,
		'Username'=>$arr['Username'],
		'PassValidate'=>empty($arr['PassValidate'])?date("Y-m-d H:i:s",time()+3*30*24*60*60):$arr['PassValidate'],
		'Name'=>$arr['Name'],
		'EMail'=>$arr['EMail'],
		'Memo'=>$arr['Memo'],
		'LastLoginTime'=>$arr['LastLoginTime'],
		'LastLoginIP'=>$arr['LastLoginIP']
	);
}

$smarty->assign('User_Info', $User_Info);

$smarty->assign('Title','Change Profile');
?>