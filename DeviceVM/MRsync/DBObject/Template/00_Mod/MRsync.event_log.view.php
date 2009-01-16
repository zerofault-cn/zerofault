<?php
/*
#          File :   "event_log.add"
#          Type :   ""
#          Name :   "Event_Log Add"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "event_log.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getEvent_LogID = trim($_GET[ID]);

if($FormAction == 'Back')
{
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