<?php
/*
#          File :   "sync_xml.add"
#          Type :   ""
#          Name :   "Sync_XML Add"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "sync_xml.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myFormSync_XMLAdd $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
	$frmUID = trim($_POST[UID]);
	$frmFilename = trim($_POST[Filename]);
	$frmCreate_Time = trim($_POST[Create_Time]);
	$frmModify_Time = trim($_POST[Modify_Time]);
	$frmstatus = trim($_POST[status]);


    $oSync_XML = new Sync_XML;
    
	$oSync_XML->setUID($frmUID);
	$oSync_XML->setFilename($frmFilename);
	$oSync_XML->setCreate_Time($frmCreate_Time);
	$oSync_XML->setModify_Time($frmModify_Time);
	$oSync_XML->setstatus($frmstatus);
    

    if($oSync_XML->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','Sync_XML Add Success !');
        $smarty->display('message.htm');
    }else{
		$smarty->assign('UID',$frmUID);
		$smarty->assign('Filename',$frmFilename);
		$smarty->assign('Create_Time',$frmCreate_Time);
		$smarty->assign('Modify_Time',$frmModify_Time);
		$smarty->assign('status',$frmstatus);
    

        $smarty->assign('message','Sync_XML Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>