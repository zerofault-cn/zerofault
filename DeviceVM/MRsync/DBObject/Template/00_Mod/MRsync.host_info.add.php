<?php
/*
#          File :   "host_info.add"
#          Type :   ""
#          Name :   "Host_Info Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "host_info.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormHost_InfoAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
	$frmHost = trim($_POST[Host]);
	$frmPath = trim($_POST[Path]);
	$frmSync_ID = trim($_POST[Sync_ID]);


    $oHost_Info = new Host_Info;
    
	$oHost_Info->setHost($frmHost);
	$oHost_Info->setPath($frmPath);
	$oHost_Info->setSync_ID($frmSync_ID);
    

    if($oHost_Info->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Host_Info Add Success !');
        $smarty->display('message.htm');
    }else{
		$smarty->assign('Host',$frmHost);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Sync_ID',$frmSync_ID);
    

        $smarty->assign('message','Host_Info Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>