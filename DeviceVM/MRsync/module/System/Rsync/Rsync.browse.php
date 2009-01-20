<?php
require_once(PATH_Include .'paginator_html.php');
include_once(objects_path . 'class.' . $DB . '.Rsync_Host.php');
$oRsync_Host=new Rsync_Host();

$WHERE = "where User_ID=".$_SESSION['auth']['ID']." order by ID desc";
$arr=$oSync_XML->Browse($WHERE);

$count = count($arr['ID']);

$Page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$nav =& new Paginator_html($Page, $count);
if(isset($_POST['perCount'])) { $perPage = trim($_POST['perCount'])>0 ? trim($_POST['perCount']) : 20; }
else { $perPage = isset($_COOKIE["perCount"]) ? $_COOKIE["perCount"] : 20; }
setcookie("perCount", $perPage, 0);
$nav->set_Limit($perPage);
$nav->set_Links(3);
$start = $nav->getRange1();
$offset = $nav->getRange2();

$arr=$oSync_XML->Browse($WHERE, $offset, $start);
$maxrecord = count($arr['ID']);
for($i=0;$i<$maxrecord;$i++) {
	$host_info=$oRsync_Host->View($arr['Host_ID'][$i]);
	
	$OUT[]=array(
		"ID"	=> $arr['ID'][$i],
		"Host_Name"	=> $host_info['Name'],
		"Host_Host"	=> $host_info['Host'],
		"Filename"=>$arr['Filename'][$i],
		"Modify_Time"=>$arr['Modify_Time'][$i],
		"status"=>$arr['status'][$i]
		);
}
$smarty->assign('OUT',$OUT);

$smarty->assign('navagation', $nav->gamingtypes());
$smarty->assign('NavTotalPages', $nav->getTotalPages());
$smarty->assign('NavTotalCount', $count);
$smarty->assign('NavCount', $offset);
$smarty->assign('NavperPage', $perPage);

$smarty->assign('Title','Rsync Schedule List');
?>