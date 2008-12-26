<?php
include_once(objects_path . 'class.' . $DB . '.Rsync_Host.php');
$oRsync_Host=new Rsync_Host();

$xml_arr=$oSync_XML->Browse("where User_ID=".$_SESSION['auth']['ID']." order by ID desc");

$count = count($xml_arr['ID']);
for($i=0;$i<$count;$i++)
{
	$host_info=$oRsync_Host->View($xml_arr['Host_ID'][$i]);
	
	$OUT[]=array(
		"ID"	=> $xml_arr['ID'][$i],
		"Host_Name"	=> $host_info['Name'],
		"Host_Host"	=> $host_info['Host'],
		"Filename"=>$xml_arr['Filename'][$i],
		"Modify_Time"=>$xml_arr['Modify_Time'][$i],
		"status"=>$xml_arr['status'][$i]
		);
}
$smarty->assign('OUT',$OUT);

?>