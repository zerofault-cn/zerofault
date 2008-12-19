<?php
/*
#          File :   "<!!--{$tpl|lower}-->.edit"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Edit"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_GET[ID], $_POST[Action], $_POST[FromObject]"
#      Template :   "<!!--{$tpl|lower}-->.edit.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Edit, myForm<!!--{$tpl}-->Edit $_POST Variable in Edit Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$get<!!--{$tpl}-->ID = trim($_GET[ID]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Edit')
{
	//Global Lobal
<!!--{section name=show loop=$columns}-->
	$frm<!!--{$columns[show]}--> = trim($_POST[<!!--{$columns[show]}-->]);
<!!--{/section }-->


	$o<!!--{$tpl}--> = new <!!--{$tpl}-->;

<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0}-->
	$o<!!--{$tpl}-->->set<!!--{$columns[show]}-->($frm<!!--{$columns[show]}-->);
<!!--{/if}-->
<!!--{/section }-->        


	if($o<!!--{$tpl}-->->Update($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"<!!--{$tpl}--> $frmID Update Success !");
		$smarty->display('message.htm');
	}else{
<!!--{section name=show loop=$columns}-->
		$smarty->assign('<!!--{$columns[show]}-->',$frm<!!--{$columns[show]}-->);
<!!--{/section }-->

        $smarty->assign('message','<!!--{$tpl}--> $frmID Edit Fail !');
        $smarty->display('message.htm');
	}
	
}elseif($FormAction == 'Back'){
    $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
    $smarty->display('message.htm');

}else{
	if($get<!!--{$tpl}-->ID != '')
	{
		$o<!!--{$tpl}--> = new <!!--{$tpl}-->;
		$arr = $o<!!--{$tpl}-->->View($get<!!--{$tpl}-->ID);


<!!--{section name=show loop=$columns}-->
		$smarty->assign('<!!--{$columns[show]}-->',$arr[<!!--{$columns[show]}-->]);
<!!--{/section }-->		
		
	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>
