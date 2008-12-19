<?php
/*
#          File :   "sync_info.add"
#          Type :   ""
#          Name :   "Sync_Info Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "sync_info.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getSync_InfoID = trim($_GET[ID]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");	
    $smarty->display('message.htm');
}else{
	if($getSync_InfoID != '')
	{
		$oSync_Info = new Sync_Info;
		$arr = $oSync_Info->View($getSync_InfoID);

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('UID',$arr[UID]);
		$smarty->assign('XID',$arr[XID]);
		$smarty->assign('Path',$arr[Path]);
		$smarty->assign('Filename',$arr[Filename]);
		$smarty->assign('status',$arr[status]);

	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>