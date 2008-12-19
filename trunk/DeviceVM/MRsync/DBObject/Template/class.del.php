<?php
/*
#          File :   "<!!--{$tpl|lower}-->.del"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Delete"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   ""
#   Global Vars :   "$_POST[Action], $_POST[ID], $_GET[ID]"
#      Template :   "<!!--{$tpl|lower}-->.del.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Delete, myForm<!!--{$tpl}-->Delete $_POST Variable in Delete Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

$get<!!--{$tpl}-->ID = trim($_GET[ID]);

if($FormAction == 'Delete')
{
	$frmID = trim($_POST[ID]);


	$o<!!--{$tpl}--> = new <!!--{$tpl}-->;

	if($o<!!--{$tpl}-->->Del($frmID))
	{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"<!!--{$tpl}--> $frmID Delete Success !");
		$smarty->display('message.htm');
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"<!!--{$tpl}--> $frmID Delete Fail !");
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
