<?php
/*
#          File :   "event_log.add"
#          Type :   ""
#          Name :   "Event_Log Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "event_log.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormEvent_LogAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
	$frmETID = trim($_POST[ETID]);
	$frmTimestamp = trim($_POST[Timestamp]);
	$frmSource = trim($_POST[Source]);
	$frmUser = trim($_POST[User]);
	$frmAction = trim($_POST[Action]);
	$frmInfo_XML = trim($_POST[Info_XML]);
	$frmDescription = trim($_POST[Description]);


    $oEvent_Log = new Event_Log;
    
	$oEvent_Log->setETID($frmETID);
	$oEvent_Log->setTimestamp($frmTimestamp);
	$oEvent_Log->setSource($frmSource);
	$oEvent_Log->setUser($frmUser);
	$oEvent_Log->setAction($frmAction);
	$oEvent_Log->setInfo_XML($frmInfo_XML);
	$oEvent_Log->setDescription($frmDescription);
    

    if($oEvent_Log->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Event_Log Add Success !');
        $smarty->display('message.htm');
    }else{
		$smarty->assign('ETID',$frmETID);
		$smarty->assign('Timestamp',$frmTimestamp);
		$smarty->assign('Source',$frmSource);
		$smarty->assign('User',$frmUser);
		$smarty->assign('Action',$frmAction);
		$smarty->assign('Info_XML',$frmInfo_XML);
		$smarty->assign('Description',$frmDescription);
    

        $smarty->assign('message','Event_Log Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>