<?php

$gpc=get_magic_quotes_gpc();

require_once(PATH_Include.'common_func.php');

require_once(objects_path . 'class.' . $DB . '.Event_Log.php');

$oEvent_Log = new Event_Log;

if($debug) {
	checkvar($_POST);
}

$type	=$_POST['type'];
$source	=$_POST['source'];
$user	=$_POST['user'];
$action	=$_POST['action'];
$info_xml=$_POST['info_xml'];
$dl_info=$_POST['dl_info'];
$description=$_POST['description'];
if($gpc)
{
	$info_xml=stripslashes($info_xml);
	$description=stripslashes($description);
}

$oEvent_Log->ETID=$type;
$oEvent_Log->Timestamp=date('Y-m-d H:i:s');
$oEvent_Log->Source=$source;
$oEvent_Log->User=$user;
$oEvent_Log->Action=$action;
$oEvent_Log->Info_XML=$info_xml;
$oEvent_Log->Description=$description;

$event_log_id=$oEvent_Log->Add();


?>
