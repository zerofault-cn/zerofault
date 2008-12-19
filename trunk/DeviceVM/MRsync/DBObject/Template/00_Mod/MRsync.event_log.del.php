<?php
/*
#          File :   "event_log.del"
#          Type :   ""
#          Name :   "Event_Log Delete"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "event_log.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myFormEvent_LogDelete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$getEvent_LogID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$oEvent_Log = new Event_Log;

	if($oEvent_Log->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Event_Log $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Event_Log $frmID Delete Fail !");
		$smarty->display('message.htm');
	}

}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{
	if($getEvent_LogID != '')
	{
		$oEvent_Log = new Event_Log;
		$arr = $oEvent_Log->View($getEvent_LogID);


		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('ETID',$arr[ETID]);
		$smarty->assign('Timestamp',$arr[Timestamp]);
		$smarty->assign('Source',$arr[Source]);
		$smarty->assign('User',$arr[User]);
		$smarty->assign('Action',$arr[Action]);
		$smarty->assign('Info_XML',$arr[Info_XML]);
		$smarty->assign('Description',$arr[Description]);
	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>