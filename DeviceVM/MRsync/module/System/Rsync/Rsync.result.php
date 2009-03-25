<?php
$ID=$_GET['id'];
$status =$_GET['status'];
$filename=$_GET['filename'];

if(strlen($status)>0)
{
	$oSync_XML->status=$status;
}
if($filename)
{
	$content =read_file(SYNC_RESULT_FOLDER.$filename);
	$oSync_XML->result=$content;
}

/****************Event Log**********************/
$LOG_ARR=array(
	"type"=>"1",
	"source"=>'Rsync Module',
	"user"=>'CURL Client @'.$_SERVER['REMOTE_ADDR'],
	"action"=>'Upload stauts and Sync Result',
	"info_xml"=>"id:".$ID."\nstatus change to ".$status."\nresult:$filename\n".$content,
	"description"=>'update success!'
);
include_once(PATH_Include."LogUL.php");
/****************Event Log**********************/

if(!empty($ID) && $oSync_XML->update($ID))
{
	echo '1';
}
else
{
	echo '0';
	$LOG_ARR["description"]='update DB error!';
}

/****************Event Log**********************/
$ret=LogUL($LOG_ARR);
/****************Event Log**********************/
exit;

?>