<?php

$xml_arr=$oSync_XML->Browse("where UID=".$_SESSION['auth']['ID']." order by ID desc");

$count = count($xml_arr['ID']);
for($i=0;$i<$count;$i++)
{
	$oHost_Info->key='Sync_ID';
	$host_arr=$oHost_Info->View($xml_arr['ID'][$i]);

	$OUT[]=array(
		"ID"	=> $xml_arr['ID'][$i],
		"Host"	=> $host_arr['Host'],
		"Path"	=> $host_arr['Path'],
		"Filename"=>$xml_arr['Filename'][$i],
		"Modify_Time"=>$xml_arr['Modify_Time'][$i],
		"status"=>$xml_arr['status'][$i]
		);
}
$smarty->assign('OUT',$OUT);

?>