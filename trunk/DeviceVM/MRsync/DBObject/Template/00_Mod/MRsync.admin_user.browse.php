<?php
/*
#          File :   "admin_user.browse"
#          Type :   ""
#          Name :   "Admin_User Browse"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "admin_user.browse.html"
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

$oAdmin_User = new Admin_User;
$option = 'order by `ID` ASC ';

$amount =  $oAdmin_User->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $oAdmin_User->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

$smarty->assign('ID',$arr[ID]);
$smarty->assign('Type',$arr[Type]);
$smarty->assign('Role',$arr[Role]);
$smarty->assign('Username',$arr[Username]);
$smarty->assign('Password',$arr[Password]);
$smarty->assign('PassValidate',$arr[PassValidate]);
$smarty->assign('PassChangeTime',$arr[PassChangeTime]);
$smarty->assign('Name',$arr[Name]);
$smarty->assign('EMail',$arr[EMail]);
$smarty->assign('Memo',$arr[Memo]);
$smarty->assign('CreateTime',$arr[CreateTime]);
$smarty->assign('LastLoginTime',$arr[LastLoginTime]);
$smarty->assign('LastLoginIP',$arr[LastLoginIP]);


?>