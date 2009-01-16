<?php
/*
#          File :   "sync_xml.browse"
#          Type :   ""
#          Name :   "Sync_XML Browse"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "sync_xml.browse.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
// Load Config / Class / Function
require_once(PATH_Include .'pagelist_html.php'); 

$sessPage = trim($_SESSION[MyWork][Page]);
$Page = trim($_GET[page]);


if($Page != '')
{
    $_SESSION[MyWork][Page] = $Page;
}else{
    $Page = $sessPage;
}


// Navagation count Pages
$perPage = 10;

$oSync_XML = new Sync_XML;
$option = 'order by `ID` ASC ';

$amount =  $oSync_XML->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $oSync_XML->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

$smarty->assign('ID',$arr[ID]);
$smarty->assign('User_ID',$arr[User_ID]);
$smarty->assign('Host_ID',$arr[Host_ID]);
$smarty->assign('Filename',$arr[Filename]);
$smarty->assign('Content',$arr[Content]);
$smarty->assign('Create_Time',$arr[Create_Time]);
$smarty->assign('Modify_Time',$arr[Modify_Time]);
$smarty->assign('status',$arr[status]);


?>