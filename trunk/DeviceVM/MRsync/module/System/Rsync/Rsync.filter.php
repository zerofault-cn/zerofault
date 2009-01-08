<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';

if($action=='Doit') {
	$path_include	= trim($_POST['path_include']);
	$path_exclude	= trim($_POST['path_exclude']);
	if(strlen($path_include)>0)
	{
		$pi_arr=explode("\n",$path_include);
	}
	else
	{
		$pi_arr=array();
	}
	if(strlen($path_exclude)>0)
	{
		$pe_arr=explode("\n",$path_exclude);
	}
	else
	{
		$pe_arr=array();
	}
	$content = "<?php\n";
	$content.= '$path_include=array( ';
	foreach($pi_arr as $pi)
	{
		$content.= '"'.$pi.'",';
	}
	$content = substr($content,0,-1);
	$content.= ");\n";

	$content.= '$path_exclude=array( ';
	foreach($pe_arr as $pe)
	{
		$content.= '"'.$pe.'",';
	}
	$content = substr($content,0,-1);
	$content.= ");\n";
	$content.= "?>";

	$fp=fopen("config/path_filter.inc.php","w");
	
	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Rsync Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Edit PathFilter',
		"info_xml"=>"New PathFilter:\nInclude:\n".$path_include."\nExclude:\n".$path_exclude,
		"description"=>'update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/
	
	if(fwrite($fp,$content)) {
		echo '<script>parent.alert("Update Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=filter");</script>';
	}
	else { 
		echo '<script>parent.alert("File Write Fail! ");</script>';

		$LOG_ARR["description"]='File Write Fail';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/
	exit;
}

include_once("config/path_filter.inc.php");


$smarty->assign('Path_Include', $path_include);
$smarty->assign('Path_Exclude', $path_exclude);

$smarty->assign('Title','Path Filter Setting');
?>