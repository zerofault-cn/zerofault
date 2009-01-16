<?php
/*
#          File :   "sync_xml.add"
#          Type :   ""
#          Name :   "Sync_XML Add"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "sync_xml.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getSync_XMLID = trim($_GET[ID]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");	
    $smarty->display('message.htm');
}else{
	if($getSync_XMLID != '')
	{
		$oSync_XML = new Sync_XML;
		$arr = $oSync_XML->View($getSync_XMLID);

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('User_ID',$arr[User_ID]);
		$smarty->assign('Host_ID',$arr[Host_ID]);
		$smarty->assign('Filename',$arr[Filename]);
		$smarty->assign('Content',$arr[Content]);
		$smarty->assign('Create_Time',$arr[Create_Time]);
		$smarty->assign('Modify_Time',$arr[Modify_Time]);
		$smarty->assign('status',$arr[status]);

	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>