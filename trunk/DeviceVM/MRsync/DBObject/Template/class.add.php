<?php
/*
#          File :   "<!!--{$tpl|lower}-->.add"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Add"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "<!!--{$tpl|lower}-->.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);
//if $FormAction == Add, myForm<!!--{$tpl}-->Add $_POST Variable in Add Block to setting

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$Now = date("Y-m-d H:i:s",time());

if($FormAction == 'Add')
{
	//Global Lobal
<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0}-->
	$frm<!!--{$columns[show]}--> = trim($_POST[<!!--{$columns[show]}-->]);
<!!--{/if}-->
<!!--{/section }-->


    $o<!!--{$tpl}--> = new <!!--{$tpl}-->;
    
<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0}-->
	$o<!!--{$tpl}-->->set<!!--{$columns[show]}-->($frm<!!--{$columns[show]}-->);
<!!--{/if}-->
<!!--{/section }-->    

    if($o<!!--{$tpl}-->->Add())
    {
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
        $smarty->assign('message','<!!--{$tpl}--> Add Success !');
        $smarty->display('message.htm');
    }else{
<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0}-->
		$smarty->assign('<!!--{$columns[show]}-->',$frm<!!--{$columns[show]}-->);
<!!--{/if}-->
<!!--{/section }-->    

        $smarty->assign('message','<!!--{$tpl}--> Add Fail !');
        $smarty->display('message.htm');
    }
}elseif($FormAction == 'Back'){
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
	$smarty->display('message.htm');

}else{    
   //other procedure
}

?>
