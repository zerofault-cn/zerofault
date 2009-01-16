<?php
/*
#          File :   "sync_info.edit"
#          Type :   ""
#          Name :   "Sync_Info Edit"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
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
	$frmSync_ID = trim($_POST[Sync_ID]);
	$frmPath = trim($_POST[Path]);
	$frmFilename = trim($_POST[Filename]);


	$oSync_Info = new Sync_Info;

	$oSync_Info->setSync_ID($frmSync_ID);
	$oSync_Info->setPath($frmPath);
	$oSync_Info->setFilename($frmFilename);
        


	if($oSync_Info->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Sync_Info $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('Sync_ID',$frmSync_ID);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Filename',$frmFilename);

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
		$smarty->assign('Sync_ID',$arr[Sync_ID]);
		$smarty->assign('Path',$arr[Path]);
		$smarty->assign('Filename',$arr[Filename]);
		
		
	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>