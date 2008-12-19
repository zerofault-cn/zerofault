<?php
/*
#          File :   "sync_info.edit"
#          Type :   ""
#          Name :   "Sync_Info Edit"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "sync_info.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormSync_InfoEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getSync_InfoID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
	$frmUID = trim($_POST[UID]);
	$frmXID = trim($_POST[XID]);
	$frmPath = trim($_POST[Path]);
	$frmFilename = trim($_POST[Filename]);
	$frmstatus = trim($_POST[status]);


	$oSync_Info = new Sync_Info;

	$oSync_Info->setUID($frmUID);
	$oSync_Info->setXID($frmXID);
	$oSync_Info->setPath($frmPath);
	$oSync_Info->setFilename($frmFilename);
	$oSync_Info->setstatus($frmstatus);
        


	if($oSync_Info->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Sync_Info $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('UID',$frmUID);
		$smarty->assign('XID',$frmXID);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Filename',$frmFilename);
		$smarty->assign('status',$frmstatus);

        $smarty->assign('message','Sync_Info $frmID Edit Fail !');
        $smarty->display('message.htm');
	}
	
}elseif($FormAction == 'Back'){
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