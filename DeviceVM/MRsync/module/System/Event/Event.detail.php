<?php
require_once(objects_path . 'class.' . $DB . '.Event_Log.php');
$oEvent_Log = new Event_Log;

$ID=$_REQUEST['ID'];

$arr=$oEvent_Log->View($ID);
if($arr!=NULL) {
	$Out = array(
		'ID' => $ID,
		'Date' => substr($arr['Timestamp'],0,10),
		'Time' => substr($arr['Timestamp'],11),
		'Source' => $arr['Source'],
		'User' => $arr['User'],
		'Action' => $arr['Action'],
		'Info_XML'=>$arr['Info_XML'],
		'Description' => $arr['Description']
	);
}
if('download'==$arr['Action'])
{
	include_once(objects_path . 'class.' . $DB . '.DL_Log.php');
	$oDL_Log = new DL_Log;
	$dl_result=$oDL_Log->View($arr['ID']);
	if($dl_result!=null)
	{
		$DL_Info=array(
			"ID"=>$dl_result['ID'],
			"Remote_Host"=>$dl_result['Remote_Host'],
			"F_XML"=>$dl_result['F_XML'],
			"Type"=>$dl_result['Type'],
			"Size"=>$dl_result['Size'],
			"Start_Time"=>$dl_result['Start_Time'],
			"End_Time"=>$dl_result['End_Time']
		);
	}
	$smarty->assign('DL_Info',$DL_Info);
}
//$oEvent_Log->debug=true;
$pre_arr=$oEvent_Log->Browse("where ID<".$ID." and ETID=".$arr['ETID']." order by ID desc",1);
if(count($pre_arr['ID'])>0)
{
	$pre_id=$pre_arr['ID'][0];
}
else
{
	$pre_id=0;
}
$next_arr=$oEvent_Log->Browse("where ID>".$ID." and ETID=".$arr['ETID']." order by ID",1);
if(count($next_arr['ID'])>0)
{
	$next_id=$next_arr['ID'][0];
}
else
{
	$next_id=0;
}

$smarty->assign('PreID',$pre_id);
$smarty->assign('NextID',$next_id);
$smarty->assign('Title','Event detail');
$smarty->assign('Out', $Out);
?>