<?PHP
//include_once('../Include/smarty/MySmarty.class.php');
include_once('../Include/smarty/Smarty.class.php');

$smarty = new Smarty;

$smarty->compile_dir = 'Compile';
$smarty->template_dir = 'Template';
$smarty->left_delimiter = '<!!--{';
$smarty->right_delimiter = '}-->';

$tplarray = array('browse','add','view','edit','del','query','queryresult');
//$tplarray = array('Browse');

if($_POST['DBSubmit']=='Create') {
	echo "<a href='index.php'>Back</a>\n";

	include_once('config.inc.php');
	include('function.inc.php');
	/*
	$sql = 'show tables;';
	$rs = $db->Execute($sql);
	$arr = $rs->GetRows();
	
	$key = array_keys($arr[0]);
	for($i=0;$i<count($arr);$i++) {
		for($j=0;$j<count($key);$j++) {
			$newkey = $key[$j];
			$arr2[$newkey][]= $arr[$i][$newkey];
		}
	}
	*/
	//checkvar($_POST['table_list']);
	$arr2=$_POST['table_list'];
	//exit();

	$DBName = $_POST['DBName'];
	/*
	// Create Dir 
	if(is_dir("ObjectFiles/".$DBName)) {
		//echo "ObjectFiles/".$DBName.'Exist !<hr>';
	}
	else {
		if(mkdir("ObjectFiles/$DBName",0700)) { echo "ObjectFiles/".$DBName.'Create Success  !<hr>'; }
		else {
			echo "ObjectFiles/".$DBName.'Create Error !!!<hr>';
			//exit;
		}
	}
	*/

	$dbpath = "../Include/objects";

	for($i=0;$i<count($arr2);$i++) {
		$tpl = $arr2[$i];
		//$end = tabledb($tpl);
		//$fname = "ObjectFiles/$DBName/class.$DBName." . $tpl .'.php';
		
		$fname = $dbpath ."/class.$DBName." . $tpl .'.php';
		
		$fp = fopen($fname,"w");
		$flag = fwrite($fp,tabledb($tpl));
		if($flag) { echo "<hr><b>class.$DBName." . $tpl .'.php  Created !</b><br><br>' ; }
		else { echo '<hr><b>Something Wrong ! in ' .  $tpl . '</b><br><br>'; }
		
		fclose($fp);
		
		/*	
		if($_POST[Username]=='tommy') { $APpath = "ObjectFiles/".$DBName ; }
		else { $APpath = $dbpath .'/'. $DBName ; }
		*/
		
		$APpath = "./Template/00_Mod";
		
		echo $APpath .'<hr>';
		
		// Create Dir
		if(is_dir($APpath)) {
			//echo $APpath.'Exist !<hr>';
		}
		else {
			if(mkdir($APpath,0777)) { echo $APpath .'Create Success  !<hr>'; }
			else {
				echo $APpath .'Create Error !!!<hr>';
				//exit;
			}
		}
		
		// Create Module file !
		$fname = $DBName .'.'. strtolower( $tpl .'.php') ;
		$fp = fopen($APpath.'/'.$fname,"w");
		$flag = fwrite($fp,phpModule($DBName,$tpl));
		if($flag) { echo strtolower($tpl) .'.php' . ' Created !<br><br>' ; }
		else{ echo 'Something Wrong ! in ' .  $tpl.'<br><br>'; }
		
		for($j=0;$j<count($tplarray);$j++) {
			$fname = $DBName .'.'. strtolower($tpl) .'.'. $tplarray[$j] .'.php';
			
			$fp = fopen($APpath.'/'.$fname,"w");
			$flag = fwrite($fp,phptpl($DBName,$tpl,$tplarray[$j]));
			if($flag) { echo strtolower($tpl) .'.'. $tplarray[$j] .'.php' . ' Created !<br>' ; }
			else{ echo 'Something Wrong ! in ' . $tpl.'.'. $tplarray[$j] . '<br>'; }
			
		}
		
		//Tempalte
		$APpath = "./Template/00_Tpl";
		
		echo $APpath .'<hr>';
		// Create Dir
		if(is_dir($APpath)) {
			//echo $APpath.'Exist !<hr>';
		}
		else {
			if(mkdir($APpath,0777)) { echo $APpath .'Create Success  !<hr>'; }
			else {
				echo $APpath .'Create Error !!!<hr>';
				//exit;
			}
		}		
			
		// Create Module file !
		$fname = $DBName .'.'. strtolower( $tpl .'.php') ;
		$fp = fopen($APpath.'/'.$fname,"w");
		$flag = fwrite($fp,htmlModule($DBName,$tpl));
		if($flag) { echo strtolower($tpl) .'.html' . ' Created !<br><br>' ; }
		else { echo 'Something Wrong ! in ' . $tpl.'<br><br>'; }
		
		for($j=0;$j<count($tplarray);$j++) {
			$fname = $DBName .'-'. strtolower($tpl) .'-'. $tplarray[$j] .'.html';
			
			$fp = fopen($APpath.'/'.$fname,"w");
			$flag = fwrite($fp,htmltpl($DBName,$tpl,$tplarray[$j]));
			if($flag) { echo strtolower($tpl) .'-'. $tplarray[$j] .'-html' . ' Created !<br>' ; }
			else { echo 'Something Wrong ! in ' .  $tpl.'.'. $tplarray[$j] . '<br>'; }
		}
	}
	echo "<br><BR><hr><a href='index.php'>Back</a>";
}
else if ($_POST['DBSubmit']=='List') {

	include_once('config.inc.php');
	include('function.inc.php');
	
	$sql = 'show tables;';

	$rs = $db->Execute($sql);

	$arr = $rs->GetRows();
	
	$key = array_keys($arr[0]);
	for($i=0;$i<count($arr);$i++) {
		for($j=0;$j<count($key);$j++) {
			$newkey = $key[$j];
			$Out[$newkey][] = $arr[$i][$newkey];
		}
	}
	
	//checkvar($Out);
	
	$Show_Size = intval(count($arr)/5) <= 5 ? 5 : intval(count($arr)/5);
	
	$smarty->assign('DBServer', $ADODB_CONNECT);
	$smarty->assign('DBName', $ADODB_DB);
	$smarty->assign('Username', $ADODB_USER);
	$smarty->assign('Password', $ADODB_PWD);
	
	$smarty->assign('Show', $Show_Size);
	
	$smarty->assign('Out', $Out);
	
	$smarty->display('list_db.html');
}
else if($_POST['DBDownload']=='Download') {
	//echo "<a href='index.php'>Back</a>";
	//require_once('config.inc.php');

	require_once($_SERVER['DOCUMENT_ROOT'] . '/Include/class.MyDir.inc.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/Include/class.Archive.inc.php');

	$DBName = $_POST[DBName];
	$PATH_Module = $_SERVER['DOCUMENT_ROOT'] . '/DBOBject/00_Mod/';
	
	$DOWN_TEMPPath = $_SERVER['DOCUMENT_ROOT'] . '/Files/Temp/';
	$DOWN_TEMPPath2 = $_SERVER['DOCUMENT_ROOT'] . '/Files/Temp/00_Mod';
	
	$ZIP_FILEName = 'Mod_'.$DBName.'.zip';

	$DEL_FILE = $DOWN_TEMPPath2 . '/' . $ZIP_FILEName;
	
	if(!is_dir($DOWN_TEMPPath)) {
		mkdir($DOWN_TEMPPath);
		chmod($DOWN_TEMPPath, 0777);
	}

	if(!is_dir($DOWN_TEMPPath2)) {
		mkdir($DOWN_TEMPPath2);
		chmod($DOWN_TEMPPath2, 0777);
	}

	$oDir = new MyDir;

	$oDir->Read($PATH_Module , "", false, true, true, "", "", "");
	$arrDir = $oDir->aFiles;   

	$oZip = new zip_file($ZIP_FILEName);

	$oZip->set_options(array('inmemory'=>1, 'storepaths'=>0,'basedir'=>$DOWN_TEMPPath2));
	
	for($i=0; $i<count($arrDir); $i++) {
		$arr = explode('.',$arrDir[$i]['File']);

		if($arr[0] == $DBName) {		
			$ZipPath = $PATH_Module . '/' . $arrDir[$i]['Filename'];
			$oZip->add_files($ZipPath);
		}
	}

	$oZip->create_archive();
	$oZip->download_file();

	//rm 'temp' folder
	$comment = "rm -rf $DEL_FILE";
	exec($comment);
}
else { $smarty->display('index.html'); }
?>