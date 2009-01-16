<?php
/*
#          File :   "sync_xml.php"
#          Type :   ""
#          Name :   "Sync_XML"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "objects_path . class.$DB.Sync_XML.php"
#   Global Vars :   ""
#      Template :   "sync_xml.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//require op 下需要用到的 DB Object & 其他
require_once(objects_path . 'class.' . $DB . '.Sync_XML.php');

//取得 $_GET[job], 否則給預設值
if(isset($_GET[job]))
{
    $ijob = $_GET[job];
}else{
    $ijob = 'browse';
}

//include 下一層 [$iModule.$iop.$ijob.php]
if (file_exists(PATH_Module . $iModule . "/" . $iModule . "." . $iop . "." . $ijob . ".php"))
{
    include_once(PATH_Module . $iModule . "/" . $iModule . "." . $iop . "." . $ijob . ".php");
}else{
    echo $iModule.'-'.$iop.'-'.$ijob." error !";
}

$smarty->assign('job',$ijob);


?>