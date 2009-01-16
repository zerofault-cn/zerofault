<?php
/*
#          File :   "host_info.del"
#          Type :   ""
#          Name :   "Host_Info Delete"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "host_info.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myFormHost_InfoDelete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$getHost_InfoID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$oHost_Info = new Host_Info;

	if($oHost_Info->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Host_Info $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Host_Info $frmID Delete Fail !");
		$smarty->display('message.htm');
	}

}elseif($FormAction == 'Back'){
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