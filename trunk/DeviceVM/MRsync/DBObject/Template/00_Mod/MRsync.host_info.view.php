<?php
/*
#          File :   "host_info.add"
#          Type :   ""
#          Name :   "Host_Info Add"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "host_info.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getHost_InfoID = trim($_GET[ID]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");	
    $smarty->display('message.htm');
}else{
	if($getHost_InfoID != '')
	{
		$oHost_Info = new Host_Info;
		$arr = $oHost_Info->View($getHost_InfoID);

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Host',$arr[Host]);
		$smarty->assign('Host_Chroot',$arr[Host_Chroot]);
		$smarty->assign('Local_Chroot',$arr[Local_Chroot]);
		$smarty->assign('Time',$arr[Time]);
		$smarty->assign('Sync_ID',$arr[Sync_ID]);
		$smarty->assign('Mail',$arr[Mail]);

	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>