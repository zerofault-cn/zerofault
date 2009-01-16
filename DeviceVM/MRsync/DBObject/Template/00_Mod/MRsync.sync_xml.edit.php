<?php
/*
#          File :   "sync_xml.edit"
#          Type :   ""
#          Name :   "Sync_XML Edit"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "sync_xml.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myFormSync_XMLEdit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$getSync_XMLID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
	$frmID = trim($_POST[ID]);
	$frmUser_ID = trim($_POST[User_ID]);
	$frmHost_ID = trim($_POST[Host_ID]);
	$frmFilename = trim($_POST[Filename]);
	$frmContent = trim($_POST[Content]);
	$frmCreate_Time = trim($_POST[Create_Time]);
	$frmModify_Time = trim($_POST[Modify_Time]);
	$frmstatus = trim($_POST[status]);


	$oSync_XML = new Sync_XML;

	$oSync_XML->setUser_ID($frmUser_ID);
	$oSync_XML->setHost_ID($frmHost_ID);
	$oSync_XML->setFilename($frmFilename);
	$oSync_XML->setContent($frmContent);
	$oSync_XML->setCreate_Time($frmCreate_Time);
	$oSync_XML->setModify_Time($frmModify_Time);
	$oSync_XML->setstatus($frmstatus);
        


	if($oSync_XML->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"Sync_XML $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('ID',$frmID);
		$smarty->assign('User_ID',$frmUser_ID);
		$smarty->assign('Host_ID',$frmHost_ID);
		$smarty->assign('Filename',$frmFilename);
		$smarty->assign('Content',$frmContent);
		$smarty->assign('Create_Time',$frmCreate_Time);
		$smarty->assign('Modify_Time',$frmModify_Time);
		$smarty->assign('status',$frmstatus);

        $smarty->assign('message','Sync_XML $frmID Edit Fail !');
        $smarty->display('message.htm');
	}
	
}elseif($FormAction == 'Back'){
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