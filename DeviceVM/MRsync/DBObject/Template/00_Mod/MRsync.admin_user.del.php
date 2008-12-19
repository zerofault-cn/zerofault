<?php
/*
#          File :   "admin_user.del"
#          Type :   ""
#          Name :   "Admin_User Delete"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "admin_user.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myFormAdmin_UserDelete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$getAdmin_UserID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$oAdmin_User = new Admin_User;

	if($oAdmin_User->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Admin_User $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Admin_User $frmID Delete Fail !");
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