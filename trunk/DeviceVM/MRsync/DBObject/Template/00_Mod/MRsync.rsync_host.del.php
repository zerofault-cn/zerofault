<?php
/*
#          File :   "rsync_host.del"
#          Type :   ""
#          Name :   "Rsync_Host Delete"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "rsync_host.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myFormRsync_HostDelete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$getRsync_HostID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$oRsync_Host = new Rsync_Host;

	if($oRsync_Host->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Rsync_Host $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Rsync_Host $frmID Delete Fail !");
		$smarty->display('message.htm');
	}

}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{
	if($getRsync_HostID != '')
	{
		$oRsync_Host = new Rsync_Host;
		$arr = $oRsync_Host->View($getRsync_HostID);


		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Host',$arr[Host]);
		$smarty->assign('Path',$arr[Path]);
		$smarty->assign('Description',$arr[Description]);
	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>