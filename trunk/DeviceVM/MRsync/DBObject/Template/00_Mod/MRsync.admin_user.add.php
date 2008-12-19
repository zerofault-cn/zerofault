<?php
/*
#          File :   "admin_user.add"
#          Type :   ""
#          Name :   "Admin_User Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "admin_user.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormAdmin_UserAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
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
    

    if($oAdmin_User->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Admin_User Add Success !');
        $smarty->display('message.htm');
    }else{
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
    

        $smarty->assign('message','Admin_User Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>