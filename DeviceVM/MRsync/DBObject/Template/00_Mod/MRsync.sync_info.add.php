<?php
/*
#          File :   "sync_info.add"
#          Type :   ""
#          Name :   "Sync_Info Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "sync_info.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormSync_InfoAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
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
    

    if($oSync_Info->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Sync_Info Add Success !');
        $smarty->display('message.htm');
    }else{
		$smarty->assign('UID',$frmUID);
		$smarty->assign('XID',$frmXID);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Filename',$frmFilename);
		$smarty->assign('status',$frmstatus);
    

        $smarty->assign('message','Sync_Info Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>