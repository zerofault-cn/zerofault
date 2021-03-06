<?php

	require_once '../config/config.inc.php';
	require_once '../language_files/language.inc.php';
    require_once '../lib/datetime.inc.php';
    require_once '../lib/viewutils.inc.php';
	
	require_once '../pages/CCirculation.inc.php';
	
	if (!$ALLOW_UNENCRYPTED_REQUEST)
	{
		// clear $_REQUEST to ensure that only the encryptet "key" is used
		foreach ($_GET as $key => $value)
		{
			if($key != 'key')
			{
				$_REQUEST[$key]		= '';
			}
		}
	}
	
	$objMyCirculation 	= new CCirculation();
	
	//--- open database
	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
	if ($nConnection)
	{
		if (mysql_select_db($DATABASE_DB, $nConnection))
		{
			//-----------------------------------------------
			//--- get the user information from 
			//--- cf_circulationprocess
			//-----------------------------------------------
			$strQuery = "SELECT * FROM cf_circulationprocess WHERE nID=".$_REQUEST["cpid"];
			$nResult = mysql_query($strQuery, $nConnection);
			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrCirculationProcess = mysql_fetch_array($nResult);				
				}
			}
			if ($arrCirculationProcess['nIsSubstitiuteOf']>0) {
				$sql = "select nUserId from cf_circulationprocess WHERE nID=".$arrCirculationProcess['nIsSubstitiuteOf'];
				$rs = mysql_query($sql);
				$arrCirculationProcess['SubstitiuteOfUserId'] = mysql_result($rs, 0, 0);
			}
			//-----------------------------------------------
			//--- get the single circulation form
			//-----------------------------------------------
			$query = "select * from cf_circulationform WHERE nID=".$arrCirculationProcess["nCirculationFormId"];
			$nResult = mysql_query($query, $nConnection);
			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrCirculationForm = mysql_fetch_array($nResult);				
				}
			}
			
			//-----------------------------------------------
			//--- get the single circulation history
			//-----------------------------------------------
			$query = "select * from cf_circulationhistory WHERE nID=".$arrCirculationProcess["nCirculationHistoryId"];
			$nResult = mysql_query($query, $nConnection);
			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrCirculationHistory = mysql_fetch_array($nResult);
				}
			}
			
			//-----------------------------------------------
    		//--- get all users
         	//-----------------------------------------------
         	$arrUsers = array();
    		$strQuery = "SELECT * FROM cf_user WHERE bDeleted <> 1";
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrUsers[$arrRow["nID"]] = $arrRow;
    				}
    			}
    		}
			
			//-----------------------------------------------
			//--- get the template id
			//-----------------------------------------------
			$strQuery = "SELECT nTemplateId FROM cf_formslot WHERE nID=".$arrCirculationProcess["nSlotId"];
			$nResult = mysql_query($strQuery, $nConnection);
			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrRow = mysql_fetch_array($nResult);
					$templateid = $arrRow["nTemplateId"];
				}
			}
			
			//-----------------------------------------------
			//--- get the form slots
            //-----------------------------------------------	            
            $arrSlots = array();
            $strQuery = "SELECT * FROM cf_formslot WHERE nTemplateID=".$templateid." ORDER BY nSlotNumber ASC";
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrSlots[$arrRow["nID"]] = $arrRow;
    				}
    			}
    		}
			
			//-----------------------------------------------
            //--- get the field values
            //-----------------------------------------------	            
            $arrValues = array();
            $strQuery = "SELECT * FROM cf_fieldvalue WHERE nFormId=".$arrCirculationProcess["nCirculationFormId"]." AND nCirculationHistoryId=".$arrCirculationProcess["nCirculationHistoryId"];
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrValues[$arrRow["nInputFieldId"]."_".$arrRow["nSlotId"]."_".$arrRow["nFormId"]][$arrRow['nUserId']] = $arrRow;
    				}
    			}
    		}
			//echo '<pre>';print_r($arrValues);echo '</pre>';
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
	<title></title>
	<link rel="stylesheet" href="../pages/format.css" type="text/css">
	<script language="javascript">
		var strAllIDs = '';
		var strMyError	= "<?php echo $JS_PRESET_ERROR; ?>";
		function addID(strNewID)
		{
			strAllIDs = strAllIDs + strNewID + 'xxxx';
		}
				
		function validate_editfield()
		{	
			arrAllIDs = strAllIDs.split('xxxx');
			
			nMax = arrAllIDs.length;
			
			var Error 		= '';			
			
			for(nIndex = 0; nIndex < nMax; nIndex++)
			{
				arrCurID 		= arrAllIDs[nIndex];				
				arrCurIDDetails	= arrCurID.split('zz');
				
				strCurID	= arrCurIDDetails[0];
				strCurType	= arrCurIDDetails[1];
				
				
				//--- checking only text values in this slot!
				obj = document.getElementById(strCurID+"_"+strCurType);
				if (obj == null)
				{
					continue;
				}
				else
				{
					if (obj.disabled == true || obj.readOnly == true)
					{
						continue;
					}
				}
				
				
				switch (strCurType)
				{
					case '1':						
						strCurReg	= arrCurIDDetails[2];
						if ( (strCurReg != '') && (strCurReg != 'undefined') && (strCurReg != 'null') )
						{
							var valText		= eval(strCurReg);
							
							strCurID = strCurID + '_1';						
							var strValue 		= document.getElementById(strCurID).value;
							var bValstrValue	= valText.test(strValue);
													
							if (bValstrValue == false)
							{
								Error = strMyError + '. (Text)';
							}
						}
						else
						{
							var valText		= /[^A-z0-9\.\-\_\/\s\�\�\�\�\,\;\:\(\)\?\!]/i;
							strCurID = strCurID + '_1';						
							var strValue 		= document.getElementById(strCurID).value;
							var bValstrValue	= valText.test(strValue);
						}
						break;
					case '3_0':
						strCurID = strCurID + '_3_0';
						var strStandardValue = document.getElementById(strCurID).value;
			
						if (document.EditField.IN_regex[0].checked == true)
						{
							var valNumber = /[^0-9\-\,\.]/i;
						}
											
						var bValstrStandardValue = valNumber.test(strStandardValue);
						
						if (bValstrStandardValue == true)
						{
							Error = strMyError + '. (Number)';
						}
						break;						
					case '3_1':
						strCurID = strCurID + '_3_1';
						var strStandardValue = document.getElementById(strCurID).value;
						var valNumber = /[^0-9\-\,\.]/i;			
						if (strStandardValue < 0)
						{
							Error = strMyError + '. (Number)';
						}
						var bValstrStandardValue = valNumber.test(strStandardValue);
						
						if (bValstrStandardValue == true)
						{
							Error = strMyError + '. (Number)';
						}
						break;
					case '3_2':
						strCurID = strCurID + '_3_2';
						var strStandardValue = document.getElementById(strCurID).value;
						var valNumber = /[^0-9\-\,\.]/i;
						
						if (strStandardValue > 0)
						{
							Error = strMyError + '. (Number)';
						}
						var bValstrStandardValue = valNumber.test(strStandardValue);
						
						if (bValstrStandardValue == true)
						{
							Error = strMyError + '. (Number)';
						}
						break;	
					case '3_3':
						strCurReg	= arrCurIDDetails[2];
						if ( (strCurReg != '') && (strCurReg != 'undefined') && (strCurReg != 'null') )
						{
							var valText		= eval(strCurReg);
							strCurID = strCurID + '_3_3';
							var strStandardValue = document.getElementById(strCurID).value;
							var bValstrStandardValue	= valText.test(strStandardValue);

							if (bValstrStandardValue == true)
							{
								Error = strMyError + '. (Number)';
							}
						}
						break;					
					case '4_1':
						strCurID = strCurID + '_4_1';
						var strStandardValue = document.getElementById(strCurID).value;
						var valDate = /[0-3]{1}[0-9]{1}[\.\-]{1}[01]{1}[0-9]{1}[\.\-]{1}[0-9]{4}/;
						if (strStandardValue != '')
						{
							var strSplitter = strStandardValue.search(/\./);
							if (strSplitter != -1)
							{
								var arrDate = strStandardValue.split('.');
							}
							else
							{
								var arrDate = strStandardValue.split('-');
							}
							
							if (arrDate[0]>31)
							{
								Error = strMyError + '. (Date)';
							}
							if (arrDate[1]>12)
							{
								Error = strMyError + '. (Date)';
							}
							var bValstrDateFormat = valDate.test(strStandardValue);
			
							if (bValstrDateFormat == false)
							{
								Error = strMyError + '. (Date)';
							}
						}						
						else
						{
							Error = strMyError + '. (Date)';
						}
						break;
					case '4_2':
						strCurID = strCurID + '_4_2';
						var strStandardValue = document.getElementById(strCurID).value;
						var valDate = /[01]{1}[0-9]{1}[\.\-]{1}[0-3]{1}[0-9]{1}[\.\-]{1}[0-9]{4}/;
						if (strStandardValue != '')
						{
							var strSplitter = strStandardValue.search(/\./);
							if (strSplitter != -1)
							{
								var arrDate = strStandardValue.split('.');
							}
							else
							{
								var arrDate = strStandardValue.split('-');
							}
							
							if (arrDate[1]>31)
							{
								Error = strMyError + '. (Date)';
							}
							if (arrDate[0]>12)
							{
								Error = strMyError + '. (Date)';
							}
							var bValstrDateFormat = valDate.test(strStandardValue);
			
							if (bValstrDateFormat == false)
							{
								Error = strMyError + '. (Date)';
							}
						}						
						else
						{
							Error = strMyError + '. (Date)';
						}
						break;
					case '4_3':
						strCurID = strCurID + '_4_3';
						var strStandardValue = document.getElementById(strCurID).value;
						var valDate = /[0-9]{4}[\.\-]{1}[01]{1}[0-9]{1}[\.\-]{1}[0-3]{1}[0-9]{1}/;
						if (strStandardValue != '')
						{
							var strSplitter = strStandardValue.search(/\./);
							if (strSplitter != -1)
							{
								var arrDate = strStandardValue.split('.');
							}
							else
							{
								var arrDate = strStandardValue.split('-');
							}
							
							if (arrDate[2]>31)
							{
								Error = strMyError + '. (Date)';
							}
							if (arrDate[1]>12)
							{
								Error = strMyError + '. (Date)';
							}
							
							var bValstrDateFormat = valDate.test(strStandardValue);
			
							if (bValstrDateFormat == false)
							{
								Error = strMyError + '. (Date)';
							}
						}
						else
						{
							Error = strMyError + '. (Date)';
						}
						break;
					case '4_0':
						strCurReg	= arrCurIDDetails[2];
						if ( (strCurReg != '') && (strCurReg != 'undefined') && (strCurReg != 'null') )
						{
							var valText		= eval(strCurReg);
							strCurID = strCurID + '_4_0';
							var strStandardValue = document.getElementById(strCurID).value;
							var bValstrStandardValue	= valText.test(strStandardValue);
							if (bValstrStandardValue == false)
							{
								Error = strMyError + '. (Date)';
							}							
						}
						break;
					case '5':
						strCurID = strCurID + '_5';
						var strValue 		= document.getElementById(strCurID).value;
						
						break;
					case '9':
						strCurReg	= arrCurIDDetails[2];
						if ( (strCurReg != '') && (strCurReg != 'undefined') && (strCurReg != 'null') )
						{
							var valText		= eval(strCurReg);
							
							strCurID = strCurID + '_9';						
							var strValue 		= document.getElementById(strCurID).value;
							var bValstrValue	= valText.test(strValue);
													
							if (bValstrValue == false)
							{
								Error = strMyError + '. (File)';
							}
						}
						break;
				}
			}
			
			if (Error == '')
			{
				return true;
			}
			else
			{
				alert(Error);
				return false;	
			}
		}
		function empty_fieldvalue(id) {
			if (confirm('Are you sure to delete?')) {
				document.getElementById('_iframe').src="mail_content_write.php?action=empty_fieldvalue&id="+id;
			}
		}
	</script>
	<?php 
		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$DEFAULT_CHARSET."\" />";
	?>
</head>
<body style="margin-top:0px">
<table border="0" style="font-weight:bold;">
<tr>
	<td><img src="<?php echo $CUTEFLOW_SERVER;?>/images/singleuser.gif"></td>
	<td><?php echo ($CIRCDETAIL_SENDER);?></td>
	<td><?php echo htmlentities($arrUsers[$arrCirculationForm["nSenderId"]]["strLastName"].",".$arrUsers[$arrCirculationForm["nSenderId"]]["strFirstName"]."  (".$arrUsers[$arrCirculationForm["nSenderId"]]["strUserId"].")");?></td>
</tr>
<tr>
	<td><img src="<?php echo $CUTEFLOW_SERVER;?>/images/calendar.gif"></td>
	<td><?php echo ($CIRCDETAIL_SENDDATE);?></td>
	<td><?php echo convertDateFromDB($arrCirculationHistory["dateSending"]);?></td>
</tr>
</table>
<?php
$strSearchBrowserInfo = $_SERVER['HTTP_USER_AGENT'];
$bThunderbird 	= substr_count($strSearchBrowserInfo, 'Thunderbird');

//echo $strSearchBrowserInfo.' ff: '.$bFirefox.' ie: '.$bMSIE;

$bIsEmail = 0;
if($bThunderbird)
{
	$bIsEmail = 1;
}

if ($bIsEmail)
{
	?>
<form method="get" action="mail_content_write.php" id="MailContentForm" name="MailContentForm" onSubmit="return validate_editfield();">
	<?php
}
else
{
	?>
<form enctype="multipart/form-data" method="post" action="mail_content_write.php" id="MailContentForm" name="MailContentForm" onSubmit="return validate_editfield();">
	<?php
}
?>
	<table width="100%">
	<tr>
		<td valign="top" width="30"><img src="<?php echo $CUTEFLOW_SERVER;?>/images/question.png" height="32" width="32"></td>
		<td align="left">
			<table border="0" width="100%">
			<?php
			if ($arrCirculationHistory['isPaused']==1) {
				$ShowSendButton = false;
				?>
			<tr>
				<td align="left">
					<strong style="color:red;">&nbsp;&nbsp;Circulation paused!</strong>
				<?php
			}
			elseif ($arrCirculationProcess["nDecissionState"] == 0)
			{
				$ShowSendButton = true;
			?>
			<tr>
				<td align="left">
					<input type="radio" name="Answer" id="Answer" value="false"><?php echo $MAIL_CONTENT_RADIO_NACK;?><br>
				</td>
			</tr>
			<tr>
				<td align="left">
					<input type="radio" checked name="Answer" id="Answer" value="true"><?php echo $MAIL_CONTENT_RADIO_ACK;?><br>
			<?php
			}
			else
			{
				$ShowSendButton = false;
				if ($arrCirculationProcess["nDecissionState"] == 16)
				{
				?>
			<tr>
				<td align="left">
					<strong><?php echo ($MAIL_CONTENT_ATTETION); ?></strong> <?php echo $MAIL_CONTENT_STOPPED_TEXT; ?>					
					<?php		
				}
				else
				{
				?>
			<tr>
				<td align="left">
					<strong><?php echo ($MAIL_CONTENT_ATTETION); ?></strong> <?php echo $MAIL_CONTENT_ATTETION_TEXT; ?>
					<?php
				}
			}
			?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
<?php
if (sizeof($arrSlots) != 0) {
?>
	<center>
	<div style="width: 90%; max-height: 1200px;_height:1200px; overflow: auto; border:1px solid Gray;">
		<table border="0" width="100%" cellpadding="0" cellspacing="0" class="BorderSilver" style="background-color:White;">
		<tr>
			<td colspan="2">
				<table bgcolor="Silver" width="100%">
				<tr>
					<td width="20px"><img src="../images/values.png" height="16" width="16"></td>
					<td style="font-weight:bold;"><?php echo $MAIL_VALUES_HEADER;?></td>
				</tr>
				</table>
			</td>
		</tr>
		<?php
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection && mysql_select_db($DATABASE_DB, $nConnection))
		{
			$arrSlotsToShow = array();
			$index = 1;
			foreach ($arrSlots as $arrSlot) {
				if ($SLOT_VISIBILITY == 'SINGLE') {
					if ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) {
						$arrSlotsToShow[] = $arrSlot;
					}
				}
				else if ($SLOT_VISIBILITY == 'TOP') {
					if ($arrSlot["nID"] != $arrCirculationProcess["nSlotId"]) {
						$arrSlotsToShow[$index] = $arrSlot;
						$index++;
					}
					else {
						$arrSlotsToShow[0] = $arrSlot;
					}
				}
				else { // ALL
					$arrSlotsToShow[] = $arrSlot;
				}
			}
			for ($i = 0; $i < count($arrSlotsToShow); $i++)
			{
				$arrSlot = $arrSlotsToShow[$i];
				
				$time1 = $arrSlot['doneTime'];
				if ($time1%86400 == 0) {
					$unit1 = ' day';
					$number1 = $time1/86400;
				}
				elseif ($time1%3600 == 0) {
					$unit1 = ' hour';
					$number1 = $time1/3600;
				}
				if ($number1>1) {
					$unit1 .= 's';
				}

				$time2 = $arrSlot['remindTime'];
				if ($time2%86400 == 0) {
					$unit2 = ' day';
					$number2 = $time2/86400;
				}
				elseif ($time2%3600 == 0) {
					$unit2 = ' hour';
					$number2 = $time2/3600;
				}
				elseif ($time2%60 == 0) {
					$unit2 = ' minute';
					$number2 = $time2/60;
				}
				if ($number2>1) {
					$unit2 .= 's';
				}
				?>
		<tr>
			<td style="border-top: 1px solid Silver;">
				<?php 
				$background = ""; 
				if ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) {
					$background = "style='background-color: #ffe88e'";
				}
				?>
				<table width="100%" <?php echo $background;?>>
				<tr>
					<td style="font-weight: bold;background: #666666; color: #fff; padding:1px;" colspan="5" id="slot<?php echo $arrSlot['nID']; ?>"><?php echo $arrSlot['strName']; ?><a name="slot<?php echo $arrSlot['nID']; ?>"></a></td>
				</tr>
				<tr>
					<td style="background-color: #999999;padding:1px;" colspan="16">
						<table width="100%" border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border:1px solid #ffffff;color:#0000BB">
						<tr>
							<td style="color:#000000;" width="20%" nowrap="nowrap">Description:</td>
							<td colspan="5"><?php echo nl2br($arrSlot['strDescr']); ?></td>
						</tr>
						<tr>
							<td style="color:#000000;" width="20%" nowrap="nowrap">Due Date :</td>
							<td><?php echo $arrSlot['dueDate'];?></td>
							<td style="color:#000000;" width="20%" nowrap="nowrap">Expected completion days :</td>
							<td><?php echo $number1.$unit1;?></td>
							<td style="color:#000000;" width="20%" nowrap="nowrap">Press time interval :</td>
							<td><?php echo $number2.$unit2;?></td>
						</tr>
						<?php
						if ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"] && $ShowSendButton) {
						?>
						<tr bgcolor="#EAEAEA">
							<td colspan="6" align="center" height="30">
								<input type="submit" name="edit" value="Commit Modification" class="Button" style="font-size:14px"/>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" name="approve" value="<?php echo $BTN_SAVE;?>" class="Button" style="font-size:14px"/>
							</td>
						</tr>
						<?php
						}
						?>
						</table>
					</td>
				</tr>
				<tr>
				<?php
				$strQuery = "SELECT * FROM cf_inputfield INNER JOIN cf_slottofield ON cf_inputfield.nID = cf_slottofield.nFieldId WHERE cf_slottofield.nSlotId = ".$arrSlot["nID"]."  ORDER BY cf_slottofield.nPosition ASC";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult && mysql_num_rows($nResult) > 0) {
					$nRunningCounter = 1;
					while ($arrRow = mysql_fetch_array($nResult)) {
						echo "<td class=\"mandatory\" width=\"200px\" valign=\"top\">".($arrRow["strName"]).":</td>";
						echo "<td width=\"250px\" valign=\"top\" align=\"left\">";

						$bReadOnly = $arrRow['bReadOnly'];
						$bTextOnly = 0;
						$keyId = $arrRow["nFieldId"]."_".$arrSlot["nID"]."_".$arrCirculationProcess["nCirculationFormId"];
						//	echo '<pre>';print_r($arrCirculationProcess);echo '</pre>';
						foreach ($arrValues[$keyId] as $user_id=>$user_val) {
							if ($user_id!=$arrCirculationProcess['nUserId']) {
								if (!empty($arrCirculationProcess['SubstitiuteOfUserId']) && $user_id==$arrCirculationProcess['SubstitiuteOfUserId']) {
									$bTextOnly = 0;
								}
								else {
									$bTextOnly = 1;
								}
							}
							else{
								$bTextOnly = 0;
							}
							if ($arrCirculationHistory['isPaused']==1) {
								$bTextOnly = 1;
							}
							echo '<fieldset style="border-color:#666;border-width:1px;"><legend style="font-weight:bold"><img src="../images/singleuser.gif" height="16" width="16" align="absmiddle"/> '.$arrUsers[$user_id]["strFirstName"].'</legend>';
							if ($arrRow["nType"] == 1) {
								if ( ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) {
									//--- Slot is allowed to edit
									if ($user_val["strFieldValue"]!='') {
										$arrValue = split('rrrrr',$user_val["strFieldValue"]);
										$strFieldValue 	= $arrValue[0];
										$REG_Text		= $arrValue[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input style=\"width:220px; $bgStyle\" class=\"InputText\" type=\"text\" name=\"".$keyId.'_1'."\" id=\"".$keyId.'_1'."\" value=\"".$strFieldValue."\">";
										}
										?>
										<script language="javascript">
											addID('<?php echo $keyId."zz1zz".$REG_Text; ?>');
										</script>
										<?php
									}
									else {
										$arrValue = split('rrrrr',$arrRow['3']);
										$strFieldValue 	= $arrValue[0];
										$REG_Text		= $arrValue[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input style=\"width:220px; $bgStyle\" class=\"InputText\" type=\"text\" name=\"".$keyId.'_1'."\" id=\"".$keyId.'_1'."\" value=\"".$strFieldValue."\">";
										}
										?>
										<script language="javascript">
											addID('<?php echo $keyId."zz1zz".$REG_Text; ?>');
										</script>
										<?php
									}
								}
								else {
									if ($user_val["strFieldValue"]!='') {
										$arrValue = split('rrrrr',$user_val["strFieldValue"]);
										$strFieldValue 	= $arrValue[0];
										$REG_Text		= $arrValue[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input style=\"width:220px; $bgStyle\" class=\"InputText\" type=\"text\" name=\"".$keyId.'_1'."\" id=\"".$keyId.'_1'."\" value=\"".$strFieldValue."\" readonly>";
									}
									else {
										$arrValue = split('rrrrr',$arrRow['3']);
										$strFieldValue 	= $arrValue[0];
										$REG_Text		= $arrValue[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input style=\"width:220px; $bgStyle\" class=\"InputText\" type=\"text\" name=\"".$keyId.'_1'."\" id=\"".$keyId.'_1'."\" value=\"".$strFieldValue."\" readonly>";
									}
								}
								if ($REG_Text != '' && $bTextOnly==0) {
									?>
									<input type="hidden" name="<?php echo $keyId.'_REG'; ?>" value="<?php echo $REG_Text; ?>">
									<?php
								}
							}
							elseif ($arrRow["nType"] == 2) {
								$MyChecked = 0;
								if ($user_val["strFieldValue"]!='') {
									if ($user_val["strFieldValue"] == 'on') {
										$MyChecked = 1;
									}
								}
								else {
									if ($arrRow['3'] == 'on') {
										$MyChecked = 1;
									}
								}
								if ( ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"])  && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) {	//--- Slot is allowed to edit
									if($bTextOnly) {
										if ($MyChecked) {
											echo '<img src="../images/active.gif" height="16" width="16" align="absmiddle">';
										}
										else {
											echo '<img src="../images/inactive.gif" height="16" width="16" align="absmiddle">';
										}
									}
									else {
										if ($MyChecked) {
											echo "<input type=\"checkbox\" name=\"".$keyId.'_2'."\" value=\"on\" checked>";
										}
										else {
											echo "<input type=\"checkbox\" name=\"".$keyId.'_2'."\" value=\"on\">";
										}
									}
								}
								else {
									if ($MyChecked) {
										echo "<input type=\"checkbox\" name=\"".$keyId.'_2'."\" value=\"on\" disabled checked>";
										echo "<input type=\"hidden\" name=\"".$keyId.'_2_hidden'."\" value=\"on\">";
									}
									else {
										echo "<input type=\"checkbox\" name=\"".$keyId.'_2'."\" value=\"on\" disabled>";
									}
								}
								if ($bTextOnly==0) {
									echo "<input type=\"hidden\" name=\"".$keyId.'_2xx'."\" value=\"\">";
								}
							}
							elseif ($arrRow["nType"] == 3) {
								$REGEDIT = 0;
								if ( ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly)  ) {
									//--- Slot is allowed to edit
									if ($user_val["strFieldValue"]!='') {
										$arrMyValue = split('xx',$user_val["strFieldValue"]);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Number		= $arrValue3[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_3_'.$arrMyValue['1']."\" id=\"".$keyId.'_3_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\"><br>";
										}
									}
									else {
										$arrMyValue = split('xx',$arrRow['3']);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Number		= $arrValue3[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_3_'.$arrMyValue['1']."\" id=\"".$keyId.'_3_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\"><br>";
										}
									}
								}
								else {
									if ($user_val["strFieldValue"]!='') {
										$arrMyValue = split('xx',$user_val["strFieldValue"]);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Number		= $arrValue3[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_3_'.$arrMyValue['1']."\" id=\"".$keyId.'_3_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\" readonly><br>";
									}
									else {
										$arrMyValue = split('xx',$arrRow['3']);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Number		= $arrValue3[1];
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_3_'.$arrMyValue['1']."\" id=\"".$keyId.'_3_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\" readonly><br>";
									}
								}
								switch ($arrMyValue['1']) {
									case '0':
										echo "($FIELD_NUMTYPE_NOREGEX)";
										?>
										<script language="javascript">
											addID('<?php echo $keyId."zz3_0"; ?>');
										</script>
										<?php
										break;
									case '1':
										echo "($FIELD_NUMTYPE_POSITIVE)";
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz3_1"; ?>');
										</script>
										<?php
										break;
									case '2':
										echo "($FIELD_NUMTYPE_NEGATIVE)";
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz3_2"; ?>');
										</script>
										<?php
										break;
									case '3':
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz3_3zz".$REG_Number; ?>');
										</script>
										<?php
										break;
								}
								if ($REG_Number != '' && $bTextOnly==0)
								{
									?>
									<input type="hidden" name="<?php echo $keyId.'_REG'; ?>" value="<?php echo $REG_Number; ?>">
									<?php
								}
							}
							elseif ($arrRow["nType"] == 4) {
								if ( ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) {
									//--- Slot is allowed to edit
									if ($user_val["strFieldValue"]!='') {
										$arrMyValue = split('xx',$user_val["strFieldValue"]);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Date		= $arrValue3[1];
										
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_4_'.$arrMyValue['1']."\" id=\"".$keyId.'_4_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\"><br>";
										}
									}
									else {
										$arrMyValue = split('xx',$arrRow['3']);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Date		= $arrValue3[1];
										
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo $strFieldValue;
										}
										else {
											echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_4_'.$arrMyValue['1']."\" id=\"".$keyId.'_4_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\"><br>";
										}
									}
								}
								else {
									if ($user_val["strFieldValue"]!='') {
										$arrMyValue = split('xx',$user_val["strFieldValue"]);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Date		= $arrValue3[1];
										
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input class=\"InputText\" style='$bgStyle' type=\"text\" name=\"".$keyId.'_4_'.$arrMyValue['1']."\" id=\"".$keyId.'_4_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\" readonly><br>";
									}
									else {
										$arrMyValue = split('xx',$arrRow['3']);
										$strMyValue = $arrMyValue['2'];
										$arrValue3 = split('rrrrr',$strMyValue);
										$strFieldValue 	= $arrValue3[0];
										$REG_Date		= $arrValue3[1];
										
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										echo "<input class=\"InputText\" style='$bgColor' type=\"text\" name=\"".$keyId.'_4_'.$arrMyValue['1']."\" id=\"".$keyId.'_4_'.$arrMyValue['1']."\" value=\"".$strFieldValue."\" readonly><br>";
									}
								}
								switch ($arrMyValue['1']) {
									case '0':
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz4_0zz".$REG_Date; ?>');
										</script>
										<?php
										break;
									case '1':
										echo "(dd-mm-yyyy)";
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz4_1"; ?>');
										</script>
										<?php
										break;
									case '2':
										echo "(mm-dd-yyyy)";
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz4_2"; ?>');
										</script>
										<?php
										break;
									case '3':
										echo "(yyyy-mm-dd)";
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz4_3"; ?>');
										</script>
										<?php
										break;
								}
								if ($REG_Date != '' && $bTextOnly==0)
								{
									?>
									<input type="hidden" name="<?php echo $keyId.'_REG'; ?>" value="<?php echo $REG_Date; ?>">
									<?php
								}
							}
							elseif ($arrRow["nType"] == 5) {
								if ( ($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) {
									//--- Slot is allowed to edit
									if ($user_val["strFieldValue"]!='') {
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz5"; ?>');
										</script>
										<?php
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo nl2br($user_val["strFieldValue"]);
										}
										else {
											?>
										<textarea Name="<?php echo $keyId.'_5'; ?>" id="<?php echo $keyId.'_5'; ?>" class="InputText" style="<?php echo $bgStyle?>; width:250px; height: 100px;"><?php echo $user_val["strFieldValue"];?></textarea>
											<?php
										}
									}
									else {
										?>
										<script language="javascript">
										addID('<?php echo $keyId."zz5"; ?>');
										</script>
										<?php
										$bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : '';
										if($bTextOnly) {
											echo nl2br($arrRow['3']);
										}
										else {
											?>
										<textarea Name="<?php echo $keyId.'_5'; ?>" id="<?php echo $keyId.'_5'; ?>" class="InputText" style="<?php echo $bgStyle?>;width:250px; height: 100px;"><?php echo $arrRow['3'];?></textarea>
											<?php
										}
									}
								}
								else
								{
									if ($user_val["strFieldValue"]!='') {
										?>
										<?php $bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : ''; ?>
										<textarea readonly Name="<?php echo $keyId.'_5'; ?>" id="<?php echo $keyId.'_5'; ?>" class="InputText" style="<?php echo $bgStyle?>;width:250px; height: 100px;"><?php echo $user_val["strFieldValue"];?></textarea>
										<?php
									}
									else {
										?>
										<?php $bgStyle = $arrRow['strBgColor'] != "" ? 'background-color: #'.$arrRow['strBgColor'] : ''; ?>
										<textarea readonly Name="<?php echo $keyId.'_5'; ?>" id="<?php echo $keyId.'_5'; ?>" class="InputText" style="<?php echo $bgStyle?>;width:250px; height: 100px;"><?php echo $arrRow['3'];?></textarea>
										<?php
									}	
								}
							}
							elseif ($arrRow["nType"] == 6) {
								if ($user_val["strFieldValue"]!='') {
									// standard values
									$strValue = $user_val["strFieldValue"];
									$arrMySplit = split('---', $strValue);
									if ($arrMySplit[1] > 1) {
										// edited field values
										$strValue = '';
										$nMax = (sizeof($arrMySplit));
										for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
											$strValue .= $arrMySplit[$nIndex].'---';
										}
									}
								}
								$nInputfieldID 	= $arrRow["nFieldId"];
								$bIsEnabled 	= 1;
								if ( !(($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) ) {//--- Slot is not allowed to edit
									$bIsEnabled 	= 0;
								}
								$strEcho = $objMyCirculation->getRadioGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
								if($bTextOnly) {
									$arrSplit = split('---',$strValue);
									$arrInputFieldValues = $objMyCirculation->getInputFieldValue($nInputfieldID);
									foreach ($arrSplit as $key=>$val) {
										if ($val==1) {
											echo $arrInputFieldValues[$key].'<br />';
										}
									}
								}
								else {
									echo $strEcho;
								}
							}
							elseif ($arrRow["nType"] == 7) {
								if ($user_val["strFieldValue"]!='') {	// standard values
									$strValue = $user_val["strFieldValue"];
									$arrMySplit = split('---', $strValue);
	
									if ($arrMySplit[1] > 1) {	// edited field values
										$strValue = '';
										$nMax = (sizeof($arrMySplit));
										for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
											$strValue .= $arrMySplit[$nIndex].'---';
										}
									}
								}
								$nInputfieldID 	= $arrRow["nFieldId"];
								$bIsEnabled 	= 1;
								if ( !(($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) ) {
									//--- Slot is not allowed to edit
									$bIsEnabled 	= 0;
								}
								$strEcho = $objMyCirculation->getCheckBoxGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
								if($bTextOnly) {
									$arrSplit = split('---',$strValue);
									$arrInputFieldValues = $objMyCirculation->getInputFieldValue($nInputfieldID);
									foreach ($arrSplit as $key=>$val) {
										if ($val==1) {
											echo $arrInputFieldValues[$key].'<br />';
										}
									}
								}
								else {
									echo $strEcho;
								}
							}
							elseif($arrRow["nType"] == 8) {
								if ($user_val["strFieldValue"]!='') {	// standard values
									$strValue = $user_val["strFieldValue"];
									$arrMySplit = split('---', $strValue);
	
									if ($arrMySplit[1] > 1) {
										// edited field values
										$strValue = '';
										$nMax = (sizeof($arrMySplit));
										for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
											$strValue .= $arrMySplit[$nIndex].'---';
										}
									}
								}
								
								$nInputfieldID 	= $arrRow["nFieldId"];
								
								$bIsEnabled 	= 1;
								if ( !(($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) ) ) {
									//--- Slot is not allowed to edit
									$bIsEnabled 	= 0;
								}
								
								$strEcho = $objMyCirculation->getComboBoxGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
								if($bTextOnly) {
									$arrSplit = split('---',$strValue);
									$arrInputFieldValues = $objMyCirculation->getInputFieldValue($nInputfieldID);
									foreach ($arrSplit as $key=>$val) {
										if ($val==1) {
											echo $arrInputFieldValues[$key].'<br />';
										}
									}
								}
								else {
									echo $strEcho;
								}
							}
							elseif($arrRow["nType"] == 9) {
								if ($user_val["strFieldValue"]!='') {
									$arrValue = split('rrrrr',$user_val["strFieldValue"]);
									$REG_File		= $arrValue[1];
									$arrSplit = split('---',$arrValue[0]);
								}
								else {
									$arrValue = split('rrrrr',$arrRow['3']);
									$REG_File		= $arrValue[1];
									$arrSplit = split('---',$arrValue[0]);
								}
								
								$nNumberOfUploads 	= $arrSplit[1];
								$strDirectory		= $arrSplit[2].'_'.$nNumberOfUploads;
								$strFilename		= $arrSplit[3];
								$strUploadPath 		= $CUTEFLOW_SERVER.'/upload/';
								$strLink			= $strUploadPath.$strDirectory.'/'.$strFilename;
								echo "<a href=\"$strLink\" target=\"_blank\">$strFilename</a>";
								if ( !(!(($arrSlot["nID"] == $arrCirculationProcess["nSlotId"]) && ($arrCirculationProcess["nDecissionState"] == 0) && (!$bReadOnly) && $bTextOnly==0)) ) {//--- Slot is allowed to edit
									if (strlen($strFilename)>0) {
										echo ' <img align="absmiddle" style="cursor:pointer;" onclick=\'empty_fieldvalue("'.$user_val['nID'].'");\' src="../images/edit_remove.gif" alt="delete" title="Delete this attachment"/>';
									}
									if ($bIsEmail) {
										echo "<br>".$INFO_IFRAME_FILES;
									}
									else {
										echo "<br><br>$FIELD_EDIT_REPLACEFILE<br>";
										?>
										<input style="margin-top: 3px;" type="file" Name="<?php echo $keyId.'_9'; ?>" id="<?php echo $keyId.'_9'; ?>">
										<?php
									}
									?>
									<input type="hidden" name="FILEName_<?php echo $keyId; ?>_<?php echo $nNumberOfUploads; ?>" value="<?php echo $user_val["strFieldValue"]; ?>">
									<?php
									if ($REG_File != '') {
										?>
										<input type="hidden" name="<?php echo $keyId.'_REG'; ?>" id="<?php echo $keyId.'_REG'; ?>" value="<?php echo $REG_File; ?>">
										<?php
									}
									?>
									<script language="javascript">
									addID('<?php echo $keyId."zz9zz".$REG_File; ?>');
									</script>
									<?php	
								}
							}
							echo '</fieldset>';
						}
						echo "</td>";
						if ($nRunningCounter % 2 == 0) {
							echo "</tr>\n<tr><td height=\"10\"></td></tr><tr>\n";
						}
						else {
							echo "<td width=\"10px\">&nbsp;</td>";
						}
						$nRunningCounter++;
					}
					echo "</tr>\n<tr><td height=\"10\"></td></tr><tr>\n";
				}
				?>
				</tr>
				
				</table>
			</td>
		</tr>
		<?php
			}
		}
		?>
		</table>
	</div>
	</center>
<?php
}
?>
	<br>
	<table cellspacing="0" cellpadding="0" width="90%" align="center">
	<tr>
		<td align="left">
			<?php
			$strKey = 'circid='.$arrCirculationProcess['nCirculationFormId'].'&language='.$_REQUEST['language'].'>&sortby=&start=1';
			$strKey	= $objURL->encryptURL($strKey);
			?>
			<a href="<?php echo $CUTEFLOW_SERVER;?>/pages/print/print.php?key=<?php echo $strKey ?>" target="_blank"><img src="<?php echo $CUTEFLOW_SERVER;?>/images/printer_small.png" border="0" align="absmiddle"> <?php echo $MAIL_CONTENT_PRINTVIEW;?></a>
		</td>
		<td align="right">
			<?php
			if ($ShowSendButton) {
				?>
				<input type="submit" name="approve" value="<?php echo $BTN_SAVE;?>" class="Button" />
				<?php
			}
			?>
		</td>
	</tr>
	</table>
<?php if ($_REQUEST['bOwnCirculationView']): ?>
</div>
<?php endif ?>
	<input type="hidden" name="language" value="<?php echo $_REQUEST["language"];?>">
	<input type="hidden" name="chid" value="<?php echo $arrCirculationProcess["nCirculationHistoryId"]; ?>">
	<input type="hidden" name="cfid" value="<?php echo $arrCirculationProcess["nCirculationFormId"]; ?>">
	<input type="hidden" name="cpid" value="<?php echo $_REQUEST["cpid"];?>">
</form>
</body>
<iframe id="_iframe" name="_iframe" style="width:0;height:0;display:none;"></iframe>
</html>