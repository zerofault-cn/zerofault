<?php
	require_once '../config/config.inc.php';
	require_once '../language_files/language.inc.php';

	
	$mailFormat = "HTML";
	$mailValues = "IFRAME";
	$_REQUEST['IN_bIndividualSubsTime'] = 1;
	$_REQUEST['IN_bIndividualEmail'] = 1;
	
	//--- open database
	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
	if ($nConnection && mysql_select_db($DATABASE_DB, $nConnection)) {
		$nID = 0;
		$sql = "select nID from cf_user where nStaffId=".intval($_REQUEST['StaffId']);
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)==0) {
			$sql = "select nID from cf_user where strUserId='".$_REQUEST['UserName']."'";
			$rs = mysql_query($sql);
			if (mysql_num_rows($rs)>0) {
				$nID = mysql_result($rs, 0, 0);
			}
		}
		else {
			$nID = mysql_result($rs, 0, 0);
		}
			
		// build the index string
		$strIndex = $_REQUEST['strFirstName'].' '.
					$_REQUEST['strEMail'].' '.
					$_REQUEST['UserName'];
			
		if ($nID == 0) {
			// add new user
			$query = "INSERT INTO cf_user values (null, '".$_REQUEST['strLastName']."', '".$_REQUEST['strFirstName']."', '".$_REQUEST['strEMail']."', ".$_REQUEST['UserAccessLevel'].", '".$_REQUEST['UserName']."', '".$_REQUEST['Password']."', '".$mailFormat."', '".$mailValues."', 0, 0, ".intval($_REQUEST['Deleted']).", '', '', '', '', '', '', '', '', '', '','', '', '', '0', '', 1, 1, ".intval($_REQUEST['StaffId']).")";
			if (mysql_query($query, $nConnection)) {
				echo 'Success';
				$nUserId = mysql_insert_id();
				// write the index String
				$strQuery = "INSERT INTO cf_user_index values (".$nUserId.", '".$strIndex."')";
				$nResult = mysql_query($strQuery, $nConnection);
			}
			else {
				echo "SQL Error:".$query."<br />\n";
			}
		}
		else {
			// update existing user
			$query = "UPDATE cf_user SET ".
					"strLastName ='".$_REQUEST['strLastName']."',".
					"strFirstName ='".$_REQUEST['strFirstName']."',".
					"strEMail ='".$_REQUEST['strEMail']."',".
					"strUserId ='".$_REQUEST['UserName']."',".
					"bDeleted =".intval($_REQUEST['Deleted']).",".
					"nStaffId = ".intval($_REQUEST['StaffId']);
			if (!empty($_REQUEST["Password"])) {
				$query .= ", strPassword	= '".$_REQUEST["Password"]."'";	
			}
			$query .= " WHERE nID = '".$nID."'";
			if (mysql_query($query, $nConnection)) {
				echo 'Success';
			}
			else {
				echo "SQL Error:".$query."<br />\n";
			}
			// write the index String
			$strQuery = "UPDATE cf_user_index SET `index` = '$strIndex' WHERE user_id = '".$nID."' LIMIT 1";
			$nResult = mysql_query($strQuery, $nConnection);
		}
			
	}	
?>
