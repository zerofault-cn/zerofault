<?php
$arr=$oRsync_Host->Browse("order by ID");

for($i=0;$i<count($arr['ID']);$i++)
{
	$Rsync_Host[] = array(
		'ID'		=> $arr['ID'][$i],
		'Host'		=> $arr['Host'][$i],
		'Path'		=> $arr['Path'][$i],
		'Description'	=> $arr['Description'][$i]
	);
}
$smarty->assign('Rsync_Host', $Rsync_Host);
?>