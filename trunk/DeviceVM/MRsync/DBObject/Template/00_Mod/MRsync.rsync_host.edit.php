<?php
/*
#          File :   "rsync_host.edit"
#          Type :   ""
#          Name :   "Rsync_Host Edit"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "rsync_host.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormRsync_HostEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getRsync_HostID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
	$frmName = trim($_POST[Name]);
	$frmHost = trim($_POST[Host]);
	$frmPath = trim($_POST[Path]);
	$frmDescription = trim($_POST[Description]);


	$oRsync_Host = new Rsync_Host;

	$oRsync_Host->setName($frmName);
	$oRsync_Host->setHost($frmHost);
	$oRsync_Host->setPath($frmPath);
	$oRsync_Host->setDescription($frmDescription);
        


	if($oRsync_Host->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Rsync_Host $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('Name',$frmName);
		$smarty->assign('Host',$frmHost);
		$smarty->assign('Path',$frmPath);
		$smarty->assign('Description',$frmDescription);

        $smarty->assign('message','Rsync_Host $frmID Edit Fail !');
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