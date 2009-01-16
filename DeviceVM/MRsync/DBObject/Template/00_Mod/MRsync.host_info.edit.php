<?php
/*
#          File :   "host_info.edit"
#          Type :   ""
#          Name :   "Host_Info Edit"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "host_info.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormHost_InfoEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getHost_InfoID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
	$frmHost = trim($_POST[Host]);
	$frmHost_Chroot = trim($_POST[Host_Chroot]);
	$frmLocal_Chroot = trim($_POST[Local_Chroot]);
	$frmTime = trim($_POST[Time]);
	$frmSync_ID = trim($_POST[Sync_ID]);
	$frmMail = trim($_POST[Mail]);


	$oHost_Info = new Host_Info;

	$oHost_Info->setHost($frmHost);
	$oHost_Info->setHost_Chroot($frmHost_Chroot);
	$oHost_Info->setLocal_Chroot($frmLocal_Chroot);
	$oHost_Info->setTime($frmTime);
	$oHost_Info->setSync_ID($frmSync_ID);
	$oHost_Info->setMail($frmMail);
        


	if($oHost_Info->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Host_Info $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('Host',$frmHost);
		$smarty->assign('Host_Chroot',$frmHost_Chroot);
		$smarty->assign('Local_Chroot',$frmLocal_Chroot);
		$smarty->assign('Time',$frmTime);
		$smarty->assign('Sync_ID',$frmSync_ID);
		$smarty->assign('Mail',$frmMail);

        $smarty->assign('message','Host_Info $frmID Edit Fail !');
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