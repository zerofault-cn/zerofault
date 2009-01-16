<?php
/*
#          File :   "event_log.edit"
#          Type :   ""
#          Name :   "Event_Log Edit"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "event_log.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormEvent_LogEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getEvent_LogID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
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
        


	if($oEvent_Log->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Event_Log $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('ETID',$frmETID);
		$smarty->assign('Timestamp',$frmTimestamp);
		$smarty->assign('Source',$frmSource);
		$smarty->assign('User',$frmUser);
		$smarty->assign('Action',$frmAction);
		$smarty->assign('Info_XML',$frmInfo_XML);
		$smarty->assign('Description',$frmDescription);

        $smarty->assign('message','Event_Log $frmID Edit Fail !');
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