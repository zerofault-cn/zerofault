<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';

if($action=='Doit') {
	$include_arr  = $_POST['include'];
	$exclude_arr  = $_POST['exclude'];
	
	
	$content = "<?php\n";
	//$content.= '$first_include=array( ';
	for($i=0;$i<sizeof($include_arr);$i++)
	{
		if($i==sizeof($include_arr)-1)
		{
			$j=0;
		}
		else
		{
			$j=$i+1;
		}
		$content.= '$filter["in"]['.$j.']=array( ';
		foreach(explode("\n",$include_arr[$i]) as $reg)
		{
			if(''!=trim($reg))
			{
				$content.= '"'.trim($reg).'",';
			}
		}
		$content = substr($content,0,-1);
		$content.= ");\n";
	
		$content.= '$filter["ex"]['.$j.']=array( ';
		foreach(explode("\n",$exclude_arr[$i]) as $reg)
		{
			if(''!=trim($reg))
			{
				$content.= '"'.trim($reg).'",';
			}
		}
		$content = substr($content,0,-1);
		$content.= ");\n";
	}
	

	$content.= "?>";

	$fp=fopen("config/path_filter.inc.php","w");
	
	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Rsync Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Edit PathFilter',
		"info_xml"=>"New PathFilter:\nInclude:\n".print_r($include_arr,true)."\nExclude:\n".print_r($exclude_arr,true),
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

foreach($filter as $key=>$val)
{
	foreach($val as $i=>$arr)
	{
		$smarty->assign('filter_'.$key.'_'.$i, $arr);
	}
}

$smarty->assign('Title','Path Filter Setting');
?>