<?php
/*
#          File :   "rsync_host.add"
#          Type :   ""
#          Name :   "Rsync_Host Add"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "rsync_host.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getRsync_HostID = trim($_GET[ID]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");	
    $smarty->display('message.htm');
}else{
	if($getRsync_HostID != '')
	{
		$oRsync_Host = new Rsync_Host;
		$arr = $oRsync_Host->View($getRsync_HostID);

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Name',$arr[Name]);
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