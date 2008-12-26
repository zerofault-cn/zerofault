<?php
require_once(objects_path . 'class.' . $DB . '.Admin_User.php');

//$db->debug = true;
$id = isset($_REQUEST['ID']) ? trim($_REQUEST['ID']) : '';
$pw = isset($_REQUEST['pw']) ? trim($_REQUEST['pw']) : '';

$smarty->assign('TITLE', "System Admin Login");
$smarty->assign('id', $id);

if($id!='' && $pw!='') {
	$oAdminUser=new Admin_User;
	$option = 'where Username=\''.$id.'\' and Password=\''.$pw.'\'';
	
	/****************Event Log************************/
	$LOG_ARR=array(
		"type"=>"3",
		"source"=>'Auth Module',
		"user"=>$id,
		"action"=>'login',
		"info_xml"=>'User:'.$id.' login from '.$_SERVER['REMOTE_ADDR'],
		"description"=>'login success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log************************/
		
	if($oAdminUser->RecordCount($option)>0)
	{
		$arr = $oAdminUser->Browse($option, 1);
		$auth=array('ID'=>$arr['ID'][0],'Username'=>$arr['Username'][0], 'Password'=>md5($arr['Password'][0]), 'Name'=>$arr['Name'][0], 'Type'=>$arr['Type'][0], 'Role'=>$arr['Role'][0], 'Mail'=>$arr['Mail'][0]);
		$_SESSION['auth']=$auth;
		$oAdminUser->ChangeOne($arr['ID'][0], 'LastLoginTime', date("Y-m-d H:i:s"));
		$oAdminUser->ChangeOne($arr['ID'][0], 'LastLoginIP', trim($_SERVER['REMOTE_ADDR']));
		
		header('Location: '.$_SESSION['login_url']);
	}
	else
	{
		$smarty->assign('msg', "login error!!");

		$LOG_ARR["info_xml"]='Username not exist or Password is wrong';
		$LOG_ARR["description"]='login fail';
	}
	/****************Event Log************************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log************************/
}
?>