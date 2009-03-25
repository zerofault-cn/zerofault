<?php
require_once(PATH_Include .'paginator_html.php');
require_once(objects_path . 'class.' . $DB . '.Event_Log.php');

$Page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$ETID = isset($_GET['ETID']) ? trim($_GET['ETID']) : '1';
$smarty->assign('ETID', $ETID);

$db->debug=0;

$WHERE = "WHERE ETID=".$ETID;
$WHERE .= ' ORDER BY ID desc';

$oEvent_Log = new Event_Log;
$event_log_arr=$oEvent_Log->Browse($WHERE);

$event_log_count=count($event_log_arr['ID']);
$nav =& new Paginator_html($Page, $event_log_count);
if(isset($_POST['perCount'])) { $perPage = trim($_POST['perCount'])>0 ? trim($_POST['perCount']) : 20; }
else { $perPage = isset($_COOKIE["perCount"]) ? $_COOKIE["perCount"] : 25; }
//$perPage=100;
setcookie("perCount", $perPage, 0);
$nav->set_Limit($perPage);
$nav->set_Links(3);
$start = $nav->getRange1();
$offset = $nav->getRange2();

$arr=$oEvent_Log->Browse($WHERE, $offset, $start);
$maxrecord = count($arr['ID']);
for($i=0;$i<$maxrecord;$i++) {
	$Out[] = array(
		'ID' => $arr['ID'][$i],
		'Date' => substr($arr['Timestamp'][$i],0,10),
		'Time' => substr($arr['Timestamp'][$i],11),
		'Source' => $arr['Source'][$i],
		'User' => $arr['User'][$i],
		'Action' => $arr['Action'][$i],
		'Info_XML' => $arr['Info_XML'][$i],
		'Description' => $arr['Description'][$i]
	);
}
//checkvar($Out);
//$smarty->debugging=true;
$smarty->assign('Out', $Out);

$smarty->assign('navagation', $nav->gamingtypes());
$smarty->assign('NavTotalPages', $nav->getTotalPages());
$smarty->assign('NavTotalCount', $event_log_count);
$smarty->assign('NavCount', $offset);
$smarty->assign('NavperPage', $perPage);

$smarty->assign('Title','Event Viewer');
?>