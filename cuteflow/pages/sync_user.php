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
		$sql = "select nID from cf_user where strUserId='".$_REQUEST['UserName']."'";
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)>0) {
			$nID = mysql_result($rs, 0, 'nID');
		}
			
		// build the index string
		$strIndex = $_REQUEST['strLastName'].' '.
					$_REQUEST['strFirstName'].' '.
					$_REQUEST['strEMail'].' '.
					$_REQUEST['UserName'].' '.
					$_REQUEST['IN_street'].' '.
					$_REQUEST['IN_country'].' '.
					$_REQUEST['IN_zipcode'].' '.
					$_REQUEST['IN_city'].' '.
					$_REQUEST['IN_phone_main1'].' '.
					$_REQUEST['IN_phone_main2'].' '.
					$_REQUEST['IN_phone_mobile'].' '.
					$_REQUEST['IN_fax'].' '.
					$_REQUEST['IN_organisation'].' '.
					$_REQUEST['IN_department'].' '.
					$_REQUEST['IN_cost_center'].' '.
					$_REQUEST['IN_userdefined1_value'].' '.
					$_REQUEST['IN_userdefined2_value'];
			
		if ($nID == 0) {
			// add new user
			$query = "INSERT INTO cf_user values (	null,
						'".$_REQUEST['strLastName']."',
						'".$_REQUEST['strFirstName']."',
						'".$_REQUEST['strEMail']."',
						'".$_REQUEST['UserAccessLevel']."',
						'".$_REQUEST['UserName']."',
						'".$_REQUEST['Password']."',
						'$mailFormat',
						'$mailValues',
						'".$_REQUEST['SubstitudeId']."',
						0,
						0,
						'".$_REQUEST['IN_street']."',
						'".$_REQUEST['IN_country']."',
						'".$_REQUEST['IN_zipcode']."',
						'".$_REQUEST['IN_city']."',
						'".$_REQUEST['IN_phone_main1']."',
						'".$_REQUEST['IN_phone_main2']."',
						'".$_REQUEST['IN_phone_mobile']."',
						'".$_REQUEST['IN_fax']."',
						'".$_REQUEST['IN_organisation']."',
						'".$_REQUEST['IN_department']."',
						'".$_REQUEST['IN_cost_center']."',
						'".$_REQUEST['IN_userdefined1_value']."',
						'".$_REQUEST['IN_userdefined2_value']."',
						'".$_REQUEST['strIN_Subtitute_Person_Value']."',
						'".$_REQUEST['strIN_Subtitute_Person_Unit']."',
						'".$_REQUEST['IN_bIndividualSubsTime']."',
						'".$_REQUEST['IN_bIndividualEmail']."'
						)";	
			$nResult = @mysql_query($query, $nConnection);
				
			$nUserId = mysql_insert_id();
				
			// write the index String
			$strQuery = "INSERT INTO cf_user_index values (	'$nUserId', '$strIndex')";
			$nResult = mysql_query($strQuery, $nConnection);
		}
		else {
			// update existing user
			$query = "UPDATE cf_user SET 	strLastName		= '".$_REQUEST['strLastName']."',
						strFirstName	= '".$_REQUEST['strFirstName']."',
						strEMail		= '".$_REQUEST['strEMail']."',
						nAccessLevel	= '".$nAccessLevel."',
						strUserId		= '".$_REQUEST['UserName']."',
						nSubstitudeId	= '".$_REQUEST['SubstitudeId']."',
						strEmail_Format	= '".$mailFormat."',
						strEmail_Values	= '".$mailValues."',
						strStreet		= '".$_REQUEST['IN_street']."',
						strCountry		= '".$_REQUEST['IN_country']."',
						strZipcode		= '".$_REQUEST['IN_zipcode']."',
						strCity			= '".$_REQUEST['IN_city']."',
						strPhone_Main1	= '".$_REQUEST['IN_phone_main1']."',
						strPhone_Main2	= '".$_REQUEST['IN_phone_main2']."',
						strPhone_Mobile	= '".$_REQUEST['IN_phone_mobile']."',
						strFax			= '".$_REQUEST['IN_fax']."',
						strOrganisation	= '".$_REQUEST['IN_organisation']."',
						strDepartment	= '".$_REQUEST['IN_department']."',
						strCostCenter	= '".$_REQUEST['IN_cost_center']."',
						UserDefined1_Value	= '".$_REQUEST['IN_userdefined1_value']."',
						UserDefined2_Value	= '".$_REQUEST['IN_userdefined2_value']."',
						nSubstituteTimeValue	= '".$_REQUEST['strIN_Subtitute_Person_Value']."',
						strSubstituteTimeUnit		= '".$_REQUEST['strIN_Subtitute_Person_Unit']."',
						bUseGeneralSubstituteConfig = '".$_REQUEST['IN_bIndividualSubsTime']."',
						bUseGeneralEmailConfig 		= '".$_REQUEST['IN_bIndividualEmail']."'
						";
			if (!empty($_REQUEST["Password"])) {
				$query .= ", strPassword	= '".$_REQUEST["Password"]."'";	
			}
				
			$query .= " WHERE nID = '".$nID."' LIMIT 1;";
			$nResult = mysql_query($query, $nConnection);
				
			// write the index String
			$strQuery = "UPDATE cf_user_index SET `index` = '$strIndex' WHERE user_id = '".$nID."' LIMIT 1";
			$nResult = mysql_query($strQuery, $nConnection) or die(mysql_error());
		}
			
	}	
?>
