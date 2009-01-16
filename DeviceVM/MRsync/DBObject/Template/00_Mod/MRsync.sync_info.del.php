<?php
/*
#          File :   "sync_info.del"
#          Type :   ""
#          Name :   "Sync_Info Delete"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "sync_info.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myFormSync_InfoDelete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$getSync_InfoID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$oSync_Info = new Sync_Info;

	if($oSync_Info->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Sync_Info $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Sync_Info $frmID Delete Fail !");
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