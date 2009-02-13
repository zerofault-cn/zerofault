<?php
$ID=$_GET['id'];
$arr_Sync_XML = $oSync_XML->view($ID);
$arr_Host_Info= $oHost_Info->view($ID);
$arr_Sync_Info= $oSync_Info->Browse("where Sync_ID=".$ID." order by ID");
/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'Rsync Module',
	"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Re-Do a sync job',
	"description"=>'copy success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

$time = date("Y-m-d H:i:s");
$xml_filename=$_SESSION['auth']['ID'].'_'.date("YmdHis").'.xml';

//先写Sync_XML表
$oSync_XML->User_ID=$arr_Sync_XML['User_ID'];
$oSync_XML->Host_ID=$arr_Sync_XML['Host_ID'];
$oSync_XML->Filename=$xml_filename;
$oSync_XML->Content=$arr_Sync_XML['Content'];
$oSync_XML->Create_Time=$oSync_XML->Modify_Time=$time;
$oSync_XML->status=0;
if(!$Sync_ID=$oSync_XML->Add())
{
	echo '<script>parent.alert("insert DB error!");</script>';
	$LOG_ARR["description"]='Insert DB error!';
}
else
{
	//再写Host_Info表
	$oHost_Info->Host =	$arr_Host_Info['Host'];
	$oHost_Info->Host_Chroot = $arr_Host_Info['Host_Chroot'];
	$oHost_Info->Local_Chroot= $arr_Host_Info['Local_Chroot'];
	$oHost_Info->Time =	$time;
	$oHost_Info->Sync_ID =$Sync_ID;
	$oHost_Info->Mail = $arr_Host_Info['Mail'];
	$Host_Info_ID=$oHost_Info->Add();
	//生成xml文件
	
	$fp=fopen('rsync_xml/'.$xml_filename,'w');
	
	if(fwrite($fp,$arr_Sync_XML['Content']))//xml文件生成成功后,继续写入Sync_Info表
	{
		
		$oSync_Info->Sync_ID=$Sync_ID;
		for($i=0;$i<count($arr_Sync_Info['ID']);$i++)
		{
			$oSync_Info->Path = $arr_Sync_Info['Path'][$i];
			$oSync_Info->Filename = $arr_Sync_Info['Filename'][$i];
			$oSync_Info->Add();
		}
		echo '<script>parent.alert("Copy Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
		
		$LOG_ARR["info_xml"]="rsync_xml:".$xml_filename."\n".$arr_Sync_XML['Content'];
	}
	else
	{
		$oSync_XML->Del($Sync_ID);
		$oHost_Info->Del($Host_Info_ID);
		echo '<script>parent.alert("write file error!");</script>';
		$LOG_ARR["description"]='Write File error!';
	}
}
/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/
exit;

?>