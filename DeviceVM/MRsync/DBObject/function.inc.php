<?PHP

function check_type($var) {
	$type=2;
	if(strpos($var, "int")!==false || strpos($var, "float")!==false || strpos($var, "double")!==false) { $type=0; }
	if(strpos($var, "date")!==false || strpos($var, "time")!==false || strpos($var, "year")!==false) { $type=1; }
	return $type;
}

function tabledb($tpl) {
	global $db,$smarty;

	$sql = "SHOW COLUMNS FROM `$tpl`;";
	$rs = $db->Execute($sql);
	$arr = $rs->GetRows();
		
	$key = array_keys($arr[0]);
	for($i=0;$i<count($arr);$i++) {
		for($j=0;$j<count($key);$j++) {
			$newkey = $key[$j];
			if(is_int($newkey)) { continue; }
			
			switch ($newkey) {
				case "Type":
					$arr2[$newkey][]=check_type($arr[$i][$newkey]);
					break;
				case "Null":
					if($arr[$i][$newkey]=='NO') { $arr2[$newkey][]=0; }
					if($arr[$i][$newkey]=='YES') { $arr2[$newkey][]=1; }
					break;
				case "Key":
					if($arr[$i][$newkey]=='PRI') { $arr2[$newkey][]=1; }
					else { $arr2[$newkey][]=0; }
					break;
				case "Default":
					if($arr[$i]['Null']) {
						if(strlen($arr[$i][$newkey])) {	$arr2[$newkey][]="'".$arr[$i][$newkey]."'"; }
						else { $arr2[$newkey][]='null'; }
					}
					else { $arr2[$newkey][]='null'; }
					break;
				default:
					$arr2[$newkey][] = $arr[$i][$newkey];
					break;
			}
		}
	}
	//checkvar($arr);
	//checkvar($arr2);
	
	ob_start();
	$smarty->assign('tpl',$tpl);
	$smarty->assign('columns',$arr2['Field']);
	$smarty->assign('Out',$arr2);

	//$smarty->display('class.Template.php');
	$smarty->display('class.DBObject.inc.php');
	$end = ob_get_contents();
	ob_end_clean();
	//ob_end_flush();
	return $end;
}

function phptpl($DB,$tpl,$type) {
	global $db,$smarty;

	$sql = "SHOW COLUMNS FROM `$tpl`;";
	$rs = $db->Execute($sql);
	$arr = $rs->GetRows();
		
	$key = array_keys($arr[0]);
	for($i=0;$i<count($arr);$i++) {
		for($j=0;$j<count($key);$j++) {
			$newkey = $key[$j];
			$arr2[$newkey][] = $arr[$i][$newkey];
		}
	}

	ob_start();
	$smarty->assign('DB',$DB);
	$smarty->assign('tpl',$tpl);
	$smarty->assign('columns',$arr2['Field']);
	$smarty->assign('type',$type);

	$smarty->display("class.$type.php");
	$end = ob_get_contents();
	ob_end_clean();
	//ob_end_flush();
	return $end ;
}

function phpModule($DB,$tpl) {
	global $db,$smarty;

	ob_start();
	$smarty->assign('DB',$DB);
	$smarty->assign('tpl',$tpl);

	$smarty->display("class.Module.php");
	$end = ob_get_contents();
	ob_end_clean();
	//ob_end_flush();
	return $end ;			
}

function htmltpl($DB,$tpl,$type) {
	global $db,$smarty;

	$sql = "SHOW COLUMNS FROM `$tpl`;";
	$rs = $db->Execute($sql);
	$arr = $rs->GetRows();
		
	$key = array_keys($arr[0]);
	for($i=0;$i<count($arr);$i++) {
		for($j=0;$j<count($key);$j++) {
			$newkey = $key[$j];
			$arr2[$newkey][]= $arr[$i][$newkey];
		}
	}

	ob_start();
	$smarty->assign('DB',$DB);
	$smarty->assign('tpl',$tpl);
	$smarty->assign('columns',$arr2['Field']);
	$smarty->assign('type',$type);

	$smarty->display("class-$type.html");
	$end = ob_get_contents();
	ob_end_clean();
	//ob_end_flush();
	return $end ;
}

function htmlModule($DB,$tpl) {
	global $db,$smarty;

	ob_start();
	$smarty->assign('DB',$DB);
	$smarty->assign('tpl',$tpl);

	$smarty->display("class-Template.html");
	$end = ob_get_contents();
	ob_end_clean();
	//ob_end_flush();
	return $end ;
}
?>