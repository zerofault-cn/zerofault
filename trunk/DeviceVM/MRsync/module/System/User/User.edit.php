<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_GET['id'];

if($action=='Doit') {
	$oAdmin_User->Type=trim($_POST['Type']);
	$oAdmin_User->Role=trim($_POST['Role']);
	$oAdmin_User->Username=trim($_POST['Username']);
	$oAdmin_User->PassValidate=trim($_POST['PassValidate']);
	if(strlen(trim($_POST['Password']))>0)//如果新填写了密码，则更新密码
	{
		$oAdmin_User->Password=trim($_POST['Password']);
		$oAdmin_User->PassValidate=date("Y-m-d H:i:s",time()+3*30*24*60*60);
		$oAdmin_User->PassChangeTime=date("Y-m-d H:i:s");
	}
	$oAdmin_User->Name=trim($_POST['Name']);
	$oAdmin_User->EMail=trim($_POST['EMail']);
	$oAdmin_User->Memo=trim($_POST['Memo']);

	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'User Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Edit user',
		"info_xml"=>"edit user:".$oAdmin_User->Username,
		"description"=>'update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/
	
	if($oAdmin_User->Update($ID)) {
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


$arr=$oAdmin_User->view($ID);
if(!empty($arr))
{
	$User_Info = array(
		'ID'=>$ID,
		'Type'=>$arr['Type'],
		'Role'=>$arr['Role'],
		'Username'=>$arr['Username'],
		'PassValidate'=>empty($arr['PassValidate'])?date("Y-m-d H:i:s",time()+3*30*24*60*60):$arr['PassValidate'],
		'PassChangeTime'=>$arr['PassChangeTime'],
		'Name'=>$arr['Name'],
		'EMail'=>$arr['EMail'],
		'Memo'=>$arr['Memo'],
		'CreateTime'=>$arr['CreateTime'],
		'LastLoginTime'=>$arr['LastLoginTime'],
		'LastLoginIP'=>$arr['LastLoginIP']
	);
}

$smarty->assign('User_Info', $User_Info);

$smarty->assign('Title','Edit User Detail');
?>