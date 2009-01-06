<?php
/*
#          File :   "event_log.php"
#          Type :   ""
#          Name :   "Event_Log"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   "objects_path . class.$DB.Event_Log.php"
#   Global Vars :   ""
#      Template :   "event_log.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//require op 下需要用到的 DB Object & 其他
require_once(objects_path . 'class.' . $DB . '.Event_Log.php');

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