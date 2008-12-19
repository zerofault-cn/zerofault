<?php
/*
#          File :   "admin_user.edit"
#          Type :   ""
#          Name :   "Admin_User Edit"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "admin_user.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormAdmin_UserEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getAdmin_UserID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
	$frmType = trim($_POST[Type]);
	$frmRole = trim($_POST[Role]);
	$frmUsername = trim($_POST[Username]);
	$frmPassword = trim($_POST[Password]);
	$frmPassValidate = trim($_POST[PassValidate]);
	$frmPassChangeTime = trim($_POST[PassChangeTime]);
	$frmName = trim($_POST[Name]);
	$frmEMail = trim($_POST[EMail]);
	$frmMemo = trim($_POST[Memo]);
	$frmCreateTime = trim($_POST[CreateTime]);
	$frmLastLoginTime = trim($_POST[LastLoginTime]);
	$frmLastLoginIP = trim($_POST[LastLoginIP]);


	$oAdmin_User = new Admin_User;

	$oAdmin_User->setType($frmType);
	$oAdmin_User->setRole($frmRole);
	$oAdmin_User->setUsername($frmUsername);
	$oAdmin_User->setPassword($frmPassword);
	$oAdmin_User->setPassValidate($frmPassValidate);
	$oAdmin_User->setPassChangeTime($frmPassChangeTime);
	$oAdmin_User->setName($frmName);
	$oAdmin_User->setEMail($frmEMail);
	$oAdmin_User->setMemo($frmMemo);
	$oAdmin_User->setCreateTime($frmCreateTime);
	$oAdmin_User->setLastLoginTime($frmLastLoginTime);
	$oAdmin_User->setLastLoginIP($frmLastLoginIP);
        


	if($oAdmin_User->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Admin_User $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('Type',$frmType);
		$smarty->assign('Role',$frmRole);
		$smarty->assign('Username',$frmUsername);
		$smarty->assign('Password',$frmPassword);
		$smarty->assign('PassValidate',$frmPassValidate);
		$smarty->assign('PassChangeTime',$frmPassChangeTime);
		$smarty->assign('Name',$frmName);
		$smarty->assign('EMail',$frmEMail);
		$smarty->assign('Memo',$frmMemo);
		$smarty->assign('CreateTime',$frmCreateTime);
		$smarty->assign('LastLoginTime',$frmLastLoginTime);
		$smarty->assign('LastLoginIP',$frmLastLoginIP);

        $smarty->assign('message','Admin_User $frmID Edit Fail !');
        $smarty->display('message.htm');
	}
	
}elseif($FormAction == 'Back'){
    $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
    $smarty->display('message.htm');

}else{
	if($getAdmin_UserID != '')
	{
		$oAdmin_User = new Admin_User;
		$arr = $oAdmin_User->View($getAdmin_UserID);


		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Type',$arr[Type]);
		$smarty->assign('Role',$arr[Role]);
		$smarty->assign('Username',$arr[Username]);
		$smarty->assign('Password',$arr[Password]);
		$smarty->assign('PassValidate',$arr[PassValidate]);
		$smarty->assign('PassChangeTime',$arr[PassChangeTime]);
		$smarty->assign('Name',$arr[Name]);
		$smarty->assign('EMail',$arr[EMail]);
		$smarty->assign('Memo',$arr[Memo]);
		$smarty->assign('CreateTime',$arr[CreateTime]);
		$smarty->assign('LastLoginTime',$arr[LastLoginTime]);
		$smarty->assign('LastLoginIP',$arr[LastLoginIP]);
		
		
	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>