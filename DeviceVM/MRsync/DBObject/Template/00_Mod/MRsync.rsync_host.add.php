<?php
/*
#          File :   "rsync_host.add"
#          Type :   ""
#          Name :   "Rsync_Host Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "rsync_host.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormRsync_HostAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
	$frmHost = trim($_POST[Host]);
	$frmPath = trim($_POST[Path]);
	$frmDescription = trim($_POST[Description]);


    $oRsync_Host = new Rsync_Host;
    
	$oRsync_Host->setHost($frmHost);
	$oRsync_Host->setPath($frmPath);
	$oRsync_Host->setDescription($frmDescription);
    

    if($oRsync_Host->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Rsync_Host Add Success !');
        $smarty->display('message.htm');
    }else{
		$smarty->assign('Host',$frmHost);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Description',$frmDescription);
    

        $smarty->assign('message','Rsync_Host Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>