<?php
	/** Copyright (c) Timo Haberkern. All rights reserved.
	*
	* Redistribution and use in source and binary forms, with or without 
	* modification, are permitted provided that the following conditions are met:
	* 
	*  o Redistributions of source code must retain the above copyright notice, 
	*    this list of conditions and the following disclaimer. 
	*     
	*  o Redistributions in binary form must reproduce the above copyright notice, 
	*    this list of conditions and the following disclaimer in the documentation 
	*    and/or other materials provided with the distribution. 
	*     
	*  o Neither the name of Timo Haberkern nor the names of 
	*    its contributors may be used to endorse or promote products derived 
	*    from this software without specific prior written permission. 
	*     
	* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
	* AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, 
	* THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
	* PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR 
	* CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, 
	* EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
	* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
	* OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
	* WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR 
	* OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, 
	* EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	*/
	session_start();

	require_once '../config/config.inc.php';
	require_once '../language_files/language.inc.php';
    require_once '../lib/datetime.inc.php';
    require_once '../lib/viewutils.inc.php';
    require_once 'CCirculation.inc.php';
    require_once 'send_circulation.php';

	function replaceLinks($value) {
		$linktext = preg_replace('/(([a-zA-Z]+:\/\/)([a-zA-Z0-9?&%.;:\/=+_-]*))/i', "<a href=\"$1\" target=\"_blank\">$1</a>", $value);
		return $linktext;
	}

	if ('set_slot' == $_REQUEST['action']) {
		$nID = intval(trim($_REQUEST['nID']));
		$field = trim($_REQUEST['field']);
		$value = trim($_REQUEST['value']);
		$unit = str_replace('s', '', trim($_REQUEST['unit']));
		switch ($field) {
			case 'strName':
			case 'strDescr':
				$value = addslashes($value);
				break;
			
			case 'dueDate':
				if (false === strtotime($value)) {
					die('-1');
				}
				break;
			
			case 'doneTime':
				if ('day'==$unit) {
					$value = intval(86400*floatval($value));
				}
				elseif ('hour' == $unit) {
					$value = intval(3600*intval($value));
				}
				$value -= $value%3600;
				break;
			
			case 'remindTime':
				if ('day'==$unit) {
					$value = intval(86400*floatval($value));
				}
				elseif ('hour' == $unit) {
					$value = intval(3600*floatval($value));
				}
				elseif ('minute' == $unit) {
					$value = intval(60*intval($value));
				}
				$value -= $value%60;
				break;
			
			default:
				//nothing
		}
		$sql = "Update cf_formslot set ".$field."='".$value."' where nID=".$nID;
		if (mysql_query($sql)) {
			echo '1';
		}
		else {
			echo '0';
		}
		exit;
	}
	elseif ('set_name'==$_REQUEST['action']) {
		$nID = intval(trim($_REQUEST['nID']));
		$strName = addslashes(trim($_REQUEST['strName']));
		$sql = "Update cf_circulationform set strName='".$strName."' where nID=".$nID;
		if (mysql_query($sql)) {
			echo '1';
		}
		else {
			echo $sql;
		}
		exit;
	}
	elseif ('add_user' == $_REQUEST['action']) {
		$sql = "Insert into cf_slottouser set nSlotId=".$_REQUEST['SlotId'].", nMailingListId=".$_REQUEST['MailingListId'].", nUserId=".$_REQUEST['UserId'].", nPosition=".$_REQUEST['Position'];
		if (mysql_query($sql)) {
			$sql = "Select field.* from cf_slottofield slot,cf_inputfield field where slot.nSlotId=".$_REQUEST['SlotId']." and slot.nFieldId=field.nID order by slot.nPosition";
			$rs = mysql_query($sql);
			while ($r=mysql_fetch_array($rs)) {
				$strNewStdValue = $r['strStandardValue'];
				if ($r['nType'] == 6 || $r['nType'] == 7 || $r['nType'] == 8) {
					$arrSplit = explode('---', $r['strStandardValue']);
					for ($nNewIndex = 3; $nNewIndex < sizeof($arrSplit); $nNewIndex = ($nNewIndex + 2))
					{
						if ($arrSplit[$nNewIndex] == '')
						{
							$strNewStdValue = $strNewStdValue.'0---';
						}
						else
						{
							$strNewStdValue = $strNewStdValue.$arrSplit[$nNewIndex].'---';
						}
					}
				}
				$sql = "INSERT INTO cf_fieldvalue set nInputFieldId=".$r['nID'].", nUserId=".$_REQUEST['UserId'].", strFieldValue='".addslashes($strNewStdValue)."', nSlotId=".$_REQUEST['SlotId'].", nFormId=".$_REQUEST['FormId'].", nCirculationHistoryId=".$_REQUEST['HistoryId'];
				if (mysql_query($sql)) {
					continue;
				}
				else {
					exit;
				}
			}
			if ($_REQUEST['InProcess']=='1' && sendToUserDelay($_REQUEST['UserId'], $_REQUEST['FormId'], $_REQUEST['SlotId'], 0, $_REQUEST['HistoryId'])) {
				echo '1';
			}
			elseif ($_REQUEST['InProcess']=='0') {
				echo '1';
			}
			exit;
		}
		exit;
	}
	elseif ('add_slot' == $_REQUEST['action']) {
		$strName = trim($_REQUEST['strName']);
		if (''==$strName) {
			exit('<script>parent.alert("Slot name must be set");</script>');
		}
		$nSendType = $_REQUEST['nSendType'] == "on" ? 1 : 0;
		$dueDate = $_REQUEST['dueDate'];
		$number1 = intval($_REQUEST['number1']);
		switch ($_REQUEST['unit1']) {
			case 'day':
				$time1 = $number1 * 86400;
				break;
			case 'hour':
				$time1 = $number1 * 3600;
				break;
			default:
				$time1 = $number1;
		}
		$number2 = intval($_REQUEST['number2']);
		switch ($_REQUEST['unit2']) {
			case 'day':
				$time2 = $number2 * 86400;
				break;
			case 'hour':
				$time2 = $number2 * 3600;
				break;
			case 'minute':
				$time2 = $number2 * 60;
				break;
			default:
				$time2 = $number2;
		}
		//--- update the SlotNumber of next all slot
		$sql = "update cf_formslot set nSlotNumber=nSlotNumber+1 where nTemplateId=".$_REQUEST["TemplateId"]." and nSlotNumber>".$_REQUEST['SlotNumber'];
		if (mysql_query($sql)) {
			//add slot
			$sql = "INSERT INTO cf_formslot set strName='".addslashes($strName)."', strDescr='".addslashes($_REQUEST['description'])."', nTemplateId=".$_REQUEST["TemplateId"].", nSlotNumber=".($_REQUEST["SlotNumber"]+1).", nSendType=".$nSendType.", dueDate='".$dueDate."', doneTime=".$time1.", remindTime=".$time2;
			if (mysql_query($sql)) {
				$slot_id = mysql_insert_id();
				//add slot fields
				while(list($key, $value) = each($_REQUEST)) {
					$arrKeyValue = explode ("_", $value);
					if (sizeof($arrKeyValue) == 3) {
						// Position => FieldId
						$sql = "INSERT INTO cf_slottofield set nSlotId=".$slot_id.", nFieldId=".$arrKeyValue[1].", nPosition=".$arrKeyValue[2];
						if (mysql_query($sql)) {
							continue;
						}
						else {
							exit('<script>parent.alert("SQL error:'.$sql.'");</script>');
						}
					}
				}
				exit('<script>parent.location.href=parent.location.href;</script>');
			}
			else {
				exit('<script>parent.alert("SQL error:'.$sql.'");</script>');
			}
		}
		else {
			exit('<script>parent.alert("SQL error:'.$sql.'");</script>');
		}
		exit('<script>parent.alert("Unknown error!");</script>');
	}

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
    
    $objMyCirculation = new CCirculation();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
	<title></title>
   	<link rel="stylesheet" href="format.css" type="text/css">
<style>
td.edit{
	padding:2px;
}
td.focus{
	border:1px solid #92D050;
}
</style>
	<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="tooltip.js"></SCRIPT>
	<script src="../lib/RPL/Encryption/aamcrypt.js" type="text/javascript" language="JavaScript"></script>
	<script src="../lib/RPL/Encryption/boxes.js?<?php echo time();?>" type="text/javascript" language="JavaScript"></script>
	<script type="text/javascript">
    	maketip('skip_station','<?php echo escapeSingle($CIRCDETAIL_TIP_SKIP);?>');
    	maketip('retry_station','<?php echo escapeSingle($CIRCDETAIL_TIP_RETRY);?>');
    	maketip('change_station','<?php echo escapeSingle($CIRCDETAIL_TIP_CHANGE_STATION);?>');
    	maketip('change_substitute','<?php echo escapeSingle($CIRCDETAIL_TIP_CHANGE_SUBSTITUTE);?>');
		maketip('redo','<?php echo escapeSingle($CIRCDETAIL_TIP_REDO);?>');
    	
    	var nCURCirculationFormID;
    	var strCURLanguage;
    	var nCURCirculationProcessID;
    	var nCURMailinglistID;
    	
    	function Go(nId) 
		{
			document.forms["RevisionForm"].submit();
		}
		
		var WindowObjectReference;
		
		function BrowseUserlist( nCirculationFormID, strLanguage, nCirculationProcessID, nMailinglistID)
		{
			nCURCirculationFormID		= nCirculationFormID;
	    	strCURLanguage				= strLanguage;
	    	nCURCirculationProcessID	= nCirculationProcessID;
	    	nCURMailinglistID			= nMailinglistID;
			
			var strParams	= 'nCirculationFormID=' + nCirculationFormID + '&strLanguage=' + strLanguage + '&nCirculationProcessID=' + nCirculationProcessID + '&nMailinglistID=' + nMailinglistID;
			inpdata	= strParams;
			encodeblowfish();
			
			WindowObjectReference = window.open(
				"selectskipuser.php?key=" + outdata,
				'BrowseMailinglist',
				'width=310,height=250,resizable=no,scrollbars=no,status=1'
				);
		}
		
		function BrowseUserlist_Subs( nCirculationFormID, strLanguage, nCirculationProcessID, nMailinglistID)
		{
			nCURCirculationFormID		= nCirculationFormID;
	    	strCURLanguage				= strLanguage;
	    	nCURCirculationProcessID	= nCirculationProcessID;
	    	nCURMailinglistID			= nMailinglistID;
			
			var strParams	= 'nCirculationFormID=' + nCirculationFormID + '&strLanguage=' + strLanguage + '&nCirculationProcessID=' + nCirculationProcessID + '&nMailinglistID=' + nMailinglistID;
			inpdata	= strParams;
			encodeblowfish();
			
			WindowObjectReference = window.open(
				'selectskipuser_subs.php?key=' + outdata,
				'BrowseMailinglist',
				'width=310,height=250,resizable=no,scrollbars=no,status=1'
				);		
		}
		
		function changeCurrentStation_Subs(nUserID)
		{
			strParams = '?nUserID=' + nUserID + '&nCURCirculationFormID=' + nCURCirculationFormID + '&nCURCirculationProcessID=' + nCURCirculationProcessID + '&nCURMailinglistID=' + nCURMailinglistID + '&language=<?php echo $_REQUEST['language']; ?>';
			location='circulation_detail_changestation_subs.php' + strParams;
		}
		
		function changeCurrentStation(nMyIndex, nSlotID, nUserID, nPosition)
		{
			strParams = '?nSlotID=' + nSlotID + '&nMyIndex=' + nMyIndex + '&nUserID=' + nUserID + '&nPosition=' + nPosition + '&nCURCirculationFormID=' + nCURCirculationFormID + '&nCURCirculationProcessID=' + nCURCirculationProcessID + '&nCURMailinglistID=' + nCURMailinglistID + '&language=<?php echo $_REQUEST['language']; ?>';
			location='circulation_detail_changestation.php' + strParams;
		}
	</script>
</head>
<?php
    //--- open database
	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
	if ($nConnection)
	{
		if (mysql_select_db($DATABASE_DB, $nConnection))
		{
            //--- get the single circulation form
			$query = "select * from cf_circulationform WHERE nID=".$_REQUEST["circid"];
			$nResult = mysql_query($query, $nConnection);

			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrCirculationForm = mysql_fetch_array($nResult);
				}
			}
			$nSenderUserId = $arrCirculationForm['nSenderId'];
			if ($_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 4 || $_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 1) {
				$nMailingListId = $arrCirculationForm['nMailingListId'];
				$sql = "select * from cf_slottouser where nMailingListId=".$nMailingListId." and nUserId=".$_SESSION['SESSION_CUTEFLOW_USERID'];
				$rs = mysql_query($sql, $nConnection);
				if (mysql_num_rows($rs) == 0) {
					echo '<h2>You are not in this circulation.</h2>';
					exit;
				}
			}
			//-----------------------------------------------
			//--- get history (all revisions)
			//-----------------------------------------------
			$arrHistoryData = array();
			$nMaxRevisionId = 0;
			$strQuery = "SELECT * FROM cf_circulationhistory WHERE nCirculationFormId=".$_REQUEST["circid"]." ORDER BY nRevisionNumber DESC";
			$nResult = mysql_query($strQuery, $nConnection);
			if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					if ($nMaxRevisionId == 0)
    					{
    						$nMaxRevisionId = $arrRow["nID"];	
    					}
    					$arrHistoryData[$arrRow["nID"]] = $arrRow;
    				}
    			}
    		}
    		
    		if ($_REQUEST['nRevisionId'] == '')
    		{
    			$_REQUEST['nRevisionId'] = $nMaxRevisionId;
    		}
    		
    		//-----------------------------------------------
    		//--- get all users
            //-----------------------------------------------
            $arrUsers = array();
    		$strQuery = "SELECT * FROM cf_user  WHERE bDeleted <> 1";
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
			//--- get the mailing list
			//-----------------------------------------------
			$query = "select * from cf_mailinglist WHERE nID=".$arrCirculationForm["nMailingListId"];
			$nResult = mysql_query($query, $nConnection);
			if ($nResult)
			{
				if (mysql_num_rows($nResult) > 0)
				{
					$arrMailingList = mysql_fetch_array($nResult);
				}
			}
			$nMailingListID = $arrMailingList['nID'];
			
            //-----------------------------------------------
            //--- get the template
            //-----------------------------------------------	            
            $strQuery = "SELECT * FROM cf_formtemplate WHERE nID=".$arrMailingList["nTemplateId"];
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				$arrTemplate = mysql_fetch_array($nResult);
   					$strTemplateName = $arrTemplate["strName"];
    			}
    		}
            
            //-----------------------------------------------
            //--- get the form slots
            //-----------------------------------------------	            
            $arrSlots = array();
            $strQuery = "SELECT * FROM cf_formslot WHERE nTemplateID=".$arrMailingList["nTemplateId"]."  ORDER BY nSlotNumber ASC";
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrSlots[] = $arrRow;
    				}
    			}
    		}
			//-----------------------------------------------
			//--- get all fields
			//-----------------------------------------------
			$arrFields	= array();
			$strQuery	= "SELECT * FROM cf_inputfield ORDER BY strName ASC";
			$nResult	= mysql_query($strQuery, $nConnection);
			if ($nResult && mysql_num_rows($nResult) > 0) {
				while ($arrRow = mysql_fetch_array($nResult)) {
					$arrFields[$arrRow["nID"]] = $arrRow;
				}
			}

			//-----------------------------------------------
            //--- get the field values
            //-----------------------------------------------	
			            
            $arrValues = array();
            $strQuery = "SELECT * FROM cf_fieldvalue WHERE nFormId=".$_REQUEST["circid"]." AND nCirculationHistoryId=".$_REQUEST["nRevisionId"];
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrValues[$arrRow["nInputFieldId"]."_".$arrRow["nSlotId"]][$arrRow['nUserId']] = $arrRow;
    				}
    			}
    		}
			//echo '<pre>';print_r($arrValues);echo '</pre>';
			//-----------------------------------------------
            //--- get the form process detail
            //-----------------------------------------------	            
            $arrProcessInformation = array();
			$arrProcessInformationSubstitute = array();
			
            $strQuery = "SELECT process.* FROM cf_circulationprocess process, cf_formslot slot WHERE process.nSlotId=slot.nID and process.nCirculationFormId=".$_REQUEST["circid"]." AND process.nCirculationHistoryId=".$_REQUEST["nRevisionId"]." order by slot.nSlotNumber,process.nID";
    		$nResult = mysql_query($strQuery, $nConnection) or die ($strQuery."<br>".mysql_error());
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				$nPosInSlot = -1;
    				$nLastSlotId = -1;
					$LastCurrSlot = 0;
					$current_Slot = array();
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					if ($arrRow['nDecissionState'] ==0) {
							$current_Slot[$arrRow['nSlotId']] = '';
							$LastCurrSlot = $arrRow['nSlotId'];
						}
						if ($arrRow["nIsSubstitiuteOf"] != 0)
						{
							if ($arrRow["nSlotId"] != $nLastSlotId)
	    					{
	    						$nLastSlotId = $arrRow["nSlotId"];	
	    						$nPosInSlot = -1;
	    					}
	    					//$nPosInSlot++;
							$arrProcessInformationSubstitute[$arrRow["nIsSubstitiuteOf"]] = $arrRow;
						}
						else
						{
    						if ($arrRow["nSlotId"] != $nLastSlotId)
	    					{
	    						$nLastSlotId = $arrRow["nSlotId"];	
	    						$nPosInSlot = -1;
	    					}
	    					$nPosInSlot++;
    						$arrProcessInformation[$arrRow["nUserId"]."_".$arrRow["nSlotId"]."_".$nPosInSlot] = $arrRow;
    					}
    				}
    			}
    		}
			//echo '<pre>';print_r($arrProcessInformation);echo '</pre>';
		}
    }

	function printUser($arrRow, $bIsSubstitute, $nUserId, $bLastUser)
	{
		global $arrUsers, $_REQUEST, $arrHistoryData;
		global $CIRCDETAIL_RECEIVE, $CIRCDETAIL_STATE_WAITING, $CIRCDETAIL_STATE_OK, $CIRCDETAIL_STATE_STOP;
		global $CIRCDETAIL_STATE_SKIPPED, $CIRCDETAIL_STATE_SUBSTITUTE, $CIRCDETAIL_PROCESS_DURATION;
		global $CIRCDETAIL_DAYS, $CIRCDETAIL_STATE_DENIED, $nMailingListID, $SELF_DELEGATE_USER;
		
		echo "<tr style=\"height:22px;\">\n";
		
		if ($bIsSubstitute == false)
		{
        	if ($nUserId != -2)
        	{
				echo "<td width=\"20px\"><img src=\"../images/singleuser.gif\" height=\"16\" width=\"16\"></td>\n";
	       		echo "<td width=\"140px\">".$arrUsers[$nUserId]["strFirstName"]."</td>\n";
        	}
        	else
        	{
        		echo "<td width=\"20px\"><img src=\"../images/user_green.gif\" height=\"16\" width=\"16\"></td>\n";
	       		echo "<td width=\"140px\">".$SELF_DELEGATE_USER."</td>\n";
        	}
		}
		else
		{
			?>
			<td width="20" align="right"><img src="../images/right.png" height="16" width="16"></td>
       		<td width="140"><img src="../images/singleuser2.gif" height="16" width="16" align="absmiddle" style="margin-right: 6px;"><?php echo $arrUsers[$arrRow['nUserId']]['strFirstName'] ?></td>
       		<?php
		}
	
		//--- The receiving date
		$dateReceive = convertDateFromDB($arrRow["dateInProcessSince"]);
		if (0 == $arrRow["dateInProcessSince"])
		{
			$dateReceive = "-";
			echo "<td width=\"150px\">&nbsp;</td>\n";
		}
		else
		{
			echo "<td width=\"150px\" nowrap>".$dateReceive."</td>\n";
		}

		//--- The process state
		if (!$arrRow)
		{
			echo "<td width=\"16px\">&nbsp;</td>\n";
	        echo "<td width=\"110px\">&nbsp;</td>\n";
		}
		else
		{
			switch ($arrRow["nDecissionState"])
			{
				case 0: $strImage = "state_wait.gif";
						$strText = $CIRCDETAIL_STATE_WAITING;
						break;
				case 1: $strImage = "state_ok.png";
						$strText = $CIRCDETAIL_STATE_OK;
						break;
				case 2: $strImage = "state_stop.png";
						$strText = "<strong style=\"color:Red;\">$CIRCDETAIL_STATE_DENIED</strong>";
						break;
				case 4: $strImage = "state_skip.png";
						$strText = $CIRCDETAIL_STATE_SKIPPED;
						break;
				case 8: $strImage = "state_skip.png";
						$strText = $CIRCDETAIL_STATE_SUBSTITUTE;
						break;
				case 16: $strImage = "stop.gif";
						$strText = "<strong style=\"color:Red;\">$CIRCDETAIL_STATE_STOP</strong>";
						break;
						
			}
			echo "<td width=\"16px\">";
			echo "<img src=\"../images/$strImage\" height=\"16\" width=\"16\">";
			echo "</td>\n";
	       	echo "<td width=\"200px\" nowrap>$strText</td>\n";
		}
		
		//--- the working duration
		if ($dateReceive != "-")
		{
			if ($arrRow["nDecissionState"] == 0)
			{
				$time = time();
				if ($arrRow['dateInProcessSince']<$arrHistoryData[$_REQUEST["nRevisionId"]]['pausedTime']) {
					//这个process是在暂停之前开始的
					if ($arrHistoryData[$_REQUEST["nRevisionId"]]['isPaused']==0) {
						//已从暂停中恢复
						$time -= $arrHistoryData[$_REQUEST["nRevisionId"]]['pausedInterval'];
					}
					else {
						//正在暂停中
						$time = $arrHistoryData[$_REQUEST["nRevisionId"]]['pausedTime'];
					}
				}
				$diff = abs($time - $arrRow["dateInProcessSince"]);
				$nDays = floor($diff / (60 * 60 * 24) );
			}
			else
			{
				if ($arrRow["nDecissionState"] != 16)
				{					
					$time = $arrRow["dateDecission"];
					if ($arrRow['dateInProcessSince']<$arrHistoryData[$_REQUEST["nRevisionId"]]['pausedTime'] && $arrHistoryData[$_REQUEST["nRevisionId"]]['pausedTime']<$arrRow["dateDecission"]) {
						if ($arrHistoryData[$_REQUEST["nRevisionId"]]['isPaused']==0) {
							//已从暂停中恢复
							$time -= $arrHistoryData[$_REQUEST["nRevisionId"]]['pausedInterval'];
						}
						else {
							//正在暂停中
							$time = $arrHistoryData[$_REQUEST["nRevisionId"]]['pausedTime'];
						}
					}
					$diff = abs($time - $arrRow["dateInProcessSince"]);
					$nDays = floor($diff / (60 * 60 * 24) );
				}
				else
				{
					$nDays = "-";
				}
			}
			
            echo "<td nowrap><strong style=\"color:".getDelayColor($nDays).";\">$nDays</strong> $CIRCDETAIL_DAYS</td>\n";
		}
		else
		{
            echo "<td>&nbsp;</td>\n";
		}
		//--- the actions
		global $objURL;
		echo "<td nowrap>";
		if ($arrHistoryData[$_REQUEST["nRevisionId"]]['isPaused']==0 && ($_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"]==2 || $_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"]==8))
		{
			if ($dateReceive != "-")
			{
				$nState = $arrRow["nDecissionState"];
				
				if ( ($nState == 0) || ($nState == 2) )
				{
					$strParams				= 'circid='.$_REQUEST['circid'].'&language='.$_REQUEST['language'].'&cpid='.$arrRow['nID'].'&start='.$_REQUEST['start'].'&sortby='.$_REQUEST['sortby'].'&archivemode='.$_REQUEST['archivemode'];
					$strEncyrptedParams		= $objURL->encryptURL($strParams);
					?>					
					<a onMouseOver="tip('retry_station')" onMouseOut="untip()" href="retryuser.php?key=<?php echo $strEncyrptedParams ?>">
					<img src="../images/retry.png" border="0" height="16" width="16" style="margin-right: 4px;">
					</a>
					
					<a onMouseOver="tip('skip_station')" onMouseOut="untip()" href="skipuser.php?key=<?php echo $strEncyrptedParams ?>">
					<img src="../images/stepover_co.png" border="0" height="16" width="16">
					</a>
					
					<?php if ($bIsSubstitute == false): ?>					
						<a onMouseOver="tip('change_substitute')" onMouseOut="untip()" href="javascript:BrowseUserlist_Subs('<?php echo $_REQUEST['circid'] ?>', '<?php echo $_REQUEST['language'] ?>', '<?php echo $arrRow['nID'] ?>', '<?php echo $nMailingListID ?>')">
						<img src="../images/cs_subs.jpg" border="0" height="16" width="16" style="margin-left: 4px;">
						</a>
					<?php endif; ?>
					
					<a onMouseOver="tip('change_station')" onMouseOut="untip()" href="javascript:BrowseUserlist('<?php echo $_REQUEST['circid'] ?>', '<?php echo $_REQUEST['language'] ?>', '<?php echo $arrRow['nID'] ?>', '<?php echo $nMailingListID ?>')"><img src="../images/cs.jpg" border="0" height="16" width="16" style="margin-left: 4px;"></a>
					<?php
				}
				elseif ($nState==1 || $nState==4) {
					$strParams				= 'circid='.$_REQUEST['circid'].'&language='.$_REQUEST['language'].'&cpid='.$arrRow['nID'].'&start='.$_REQUEST['start'].'&sortby='.$_REQUEST['sortby'].'&archivemode='.$_REQUEST['archivemode'];
					$strEncyrptedParams		= $objURL->encryptURL($strParams);
					?>
					<a onMouseOver="tip('redo')" onMouseOut="untip()" href="redo.php?key=<?php echo $strEncyrptedParams ?>"><img src="../images/128.png" border="0" height="16" width="16"></a>
					<?php
				}
				elseif (false && ($bLastUser == true) && ($bIsSubstitute == false) && ($nState != 16) && ($nState != 8))
				{
					$strParams				= 'circid='.$_REQUEST['circid'].'&language='.$_REQUEST['language'].'&cpid='.$arrRow['nID'].'&start='.$_REQUEST['start'].'&sortby='.$_REQUEST['sortby'].'&archivemode='.$_REQUEST['archivemode'];
					$strEncyrptedParams		= $objURL->encryptURL($strParams);
					?>
					<a onMouseOver="tip('retry_station')" onMouseOut="untip()" href="retryuser.php?key=<?php echo $strEncyrptedParams ?>">
					<img src="../images/retry.png" border="0" height="16" width="16">
					</a>
					<?php
				}
			}
		}
		elseif ($arrHistoryData[$_REQUEST["nRevisionId"]]['isPaused']==1 && $dateReceive != "-") {
			echo 'Paused';
		}
		echo "&nbsp;</td>";
        echo "</tr>\n";
	}

?>
<body bgcolor="White">
<center><br>
<?php
	//var strParams	= 'nCirculationFormID=' + nCirculationFormID + '&strLanguage=' + strLanguage + '&nCirculationProcessID=' + nCirculationProcessID + '&nMailinglistID=' + nMailinglistID;
	$strParams				= 'language='.$_REQUEST['language'].'&circid='.$arrCirculationForm['nID'];
	$strEncyrptedParams		= $objURL->encryptURL($strParams);
	$strEncryptedLinkURL	= 'circulation_detail.php?key='.$strEncyrptedParams;
?>
<form method="POST" id="RevisionForm" action="<?php echo $strEncryptedLinkURL ?>">
	<table border="0" width="95%" cellpadding="0" cellspacing="0" class="BorderSilver">
	    <tr>
	        <td colspan="3">
	            <table bgcolor="Silver" width="100%">
	                <tr>
	                    <td width="20px" align="left"><img src="../images/circulate.png" height="16" width="16"></td>
	                    <td style="font-weight:bold;" align="left">
						<?php
						if ($arrCirculationForm["nSenderId"] != $_SESSION['SESSION_CUTEFLOW_USERID']) {
							echo $arrCirculationForm["strName"];
						}
						else {
							echo '<input type="text" size="40" id="'.$arrCirculationForm["nID"].'" value="'.$arrCirculationForm["strName"].'" /><input type="button" value="Update Name" onclick="update_name(this);" />';
						}
						?></td>
	                </tr>
	            </table>
	        </td>
	    </tr>
	    <tr style="height:22px;">
	        <td width="20px" align="left"><img src="../images/template_type.gif" height="16" width="16"></td>
	        <td width="150px" align="left"><?php echo $CIRCDETAIL_TEMPLATE_TYPE;?></td>
	        <td align="left"><?php echo $strTemplateName;?></td>
	    </tr>
	    <tr style="height:22px;">
	        <td width="20px" align="left"><img src="../images/singleuser2.gif" height="16" width="16"></td>
	        <td width="150px" align="left"><?php echo $CIRCDETAIL_SENDER;?></td>
	        <td align="left">
	        <?php
	            echo $arrUsers[$arrCirculationForm["nSenderId"]]["strLastName"].", ".$arrUsers[$arrCirculationForm["nSenderId"]]["strFirstName"]." (".$arrUsers[$arrCirculationForm["nSenderId"]]["strUserId"].")";
	        ?>
	        </td>
	    </tr>
	    <?php 
	    if ($view != "print")
		{
	    ?>
	    <tr style="height:22px;">
	        <td width="20px" align="left"><img src="../images/calendar.gif" height="16" width="16" ></td>
	        <td width="150px" align="left"><?php echo $CIRCDETAIL_SENDREV;?></td>
	        <td align="left">
	        	<select name="nRevisionId" id="nRevisionId" class="FormInput" onChange="Go(this.form.nRevisionId.options[this.form.nRevisionId.options.selectedIndex].value)">
				<?php 
	        		foreach ($arrHistoryData as $arrCurHistory)
	        		{
						$check = "";
						if($_REQUEST["nRevisionId"] == $arrCurHistory["nID"])
							$check = "selected";
						
						echo "<option value=\"".$arrCurHistory["nID"]."\" ".$check.">#".$arrCurHistory["nRevisionNumber"]." - ".convertDateFromDB($arrCurHistory["dateSending"])."</option>";
					}
				?>
				</select>
				
	        </td>
	    </tr>
	    <?php
		}
	    ?>
		 <tr style="height:22px; padding-top: 4px;">
		 	<td align="left" style="padding-top: 4px;" width="20px" valign="top"><img src="../images/description.gif" height="16" width="16" ></td>
	        <td align="left" style="padding-top: 4px;" width="150px" valign="top"><?php echo $CIRCDETAIL_DESCRIPTION;?></td>
	        <td align="left" style="padding-top: 4px;" valign="top"><?php echo str_replace("\n", "<br>", $arrHistoryData[$_REQUEST["nRevisionId"]]["strAdditionalText"]);?></td>
		 </tr>
	</table>
</form><br>

<?php
if ($view != 'print')
{
	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
	if ($nConnection)
	{
		if (mysql_select_db($DATABASE_DB, $nConnection))
		{
            //-----------------------------------------------
    		//--- get all attachments
            //-----------------------------------------------
            $strQuery = "SELECT * FROM cf_attachment WHERE  nCirculationHistoryId=".$arrHistoryData[$_REQUEST["nRevisionId"]]["nID"];
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
					?>
					<table border="0" width="95%" cellpadding="0" cellspacing="0" class="BorderSilver">
					    <tr>
					        <td colspan="5" align="left">
					            <table bgcolor="Silver" width="100%">
					                <tr>
					                    <td width="20px" align="left"><img src="../images/attach.png" height="16" width="16"></td>
					                    <td style="font-weight:bold;" align="left"><?php echo $CIRCDETAIL_ATTACHMENT;?></td>
					                </tr>
					            </table>
					        </td>
					    </tr>
					    <?php					    
		                    $nRunningNumber = 1;
		                    echo "<tr>\n";
							while (	$arrRow = mysql_fetch_array($nResult))
		    				{
		                        echo "<td align=\"left\">\n";
								echo "<table>\n<tr>\n";
		    					echo "<td align=\"left\" style=\"height:22px;\" width=\"20px\"><img src=\"../images/document.png\" height=\"16\" width=\"16\"></td>\n";
		                        echo "<td align=\"left\" style=\"height:22px;\"><a target=\"_blank\" href=\"".$arrRow["strPath"]."\">".getFileNameFromPath($arrRow["strPath"])."</td>\n";
		                    	echo "</tr>\n</table\n";
								echo "</td>\n";
								
		                        if ($nRunningNumber % 2 == 0)
		                        {
		                            echo "</tr>\n<tr>";
		                        }
		                        else
		                        {
		                            echo "<td style=\"height:22px;\" width=\"10px\">&nbsp;</td>\n";
		                        }
		                        
		                        $nRunningNumber++;
		        			}
							echo "</tr>\n";
					    ?>
					</table><br>
					<?php
    			}
    		}
		}
	}
?>
<table border="0" width="95%" cellpadding="0" cellspacing="0" class="BorderSilver">
<tr>
	<td colspan="2" align="left">
		<table bgcolor="Silver" width="100%">
		<tr>
			<td width="20px" align="left"><img src="../images/history.gif" height="16" width="16"></td>
			<td style="font-weight:bold;" align="left"><?php echo $CIRCDETAIL_HISTORY;?></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" align="left">
		<table width="100%">
		<tr style="background-color:#EEEEEE;">
			<td>&nbsp;</td>
			<td align="left"><?php echo $CIRCDETAIL_STATION;?></td>
			<td align="left"><?php echo $CIRCDETAIL_RECEIVE;?></td>
			<td colspan="2" align="left"><?php echo $CIRCDETAIL_STATE;?></td>
			<td align="left"><?php echo $CIRCDETAIL_PROCESS_DURATION;?></td>
			<td align="left"><?php echo $CIRCDETAIL_COMMANDS;?></td>
		</tr>
	<?php
	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
	mysql_select_db($DATABASE_DB, $nConnection);
	$nPICount = 0;
	for ($nIndex = 0; $nIndex < sizeof($arrSlots); $nIndex++) {
		$nPosInSlot = 0;
		$arrSlot = $arrSlots[$nIndex];
		$userId_arr = array();
		?>
		<tr>
			<td colspan="8" style="border-bottom: 1px solid Silver; padding-top:8px;" align="left"><strong><?php echo $MAILLIST_EDIT_FORM_SLOT.": ".$arrSlot['strName'];?></strong></td>
		</tr>
		<?php
		$strQuery = "SELECT * FROM cf_slottouser WHERE nMailingListId=".$arrCirculationForm["nMailingListId"]." AND nSlotId=".$arrSlot["nID"]." ORDER BY nPosition ASC";
		$nResult = mysql_query($strQuery, $nConnection) or die ($strQuery."<br>".mysql_error());
		$arrCurPi = array();
		$InProcess = false;
		if (mysql_num_rows($nResult) > 0) {
			while ($arrRow = mysql_fetch_array($nResult)) {
				if ($arrRow['nUserId'] != -2) {
					$arrCurPi = $arrProcessInformation[$arrRow['nUserId'].'_'.$arrSlot['nID'].'_'.$nPosInSlot];
					$userId_arr[] = $arrRow['nUserId'];
				}
				else {
					$arrCurPi = $arrProcessInformation[$nSenderUserId.'_'.$arrSlot['nID'].'_'.$nPosInSlot];
					if (sizeof($arrCurPi) < 1) {
						$arrCurPi = $arrProcessInformation['-2'.'_'.$arrSlot['nID'].'_'.$nPosInSlot];
					}
				}
				if ($arrCurPi['nDecissionState']==0) {
					$InProcess = true;
				}
				$nPICount++;
				$bLastUser = ($nPICount == sizeof($arrProcessInformation)) ? true : false;
				printUser($arrCurPi, false, $arrRow["nUserId"], $bLastUser);
				$printed_users = $printed_users+1;
				$nCurPiId 		= $arrCurPi["nID"];
				$arrSubstitute 	= $arrProcessInformationSubstitute[$nCurPiId];

				if ($arrSubstitute)
				{
					$nUserId 				= $arrRow['nUserId'];
					$nCirculationFormId 	= $arrSubstitute['nCirculationFormId'];
					$nCirculationHistoryId 	= $arrSubstitute['nCirculationHistoryId'];
					//?
					$nSubstituteId 			= $arrSubstitute['nUserId'];
					//$arrSubstitutes = $objMyCirculation->getSubstitutes($nUserId);
					
					
					$strQuery 	= "SELECT * FROM cf_circulationprocess WHERE nIsSubstitiuteOf = '".$nCurPiId."' ORDER BY nID ASC";
					$result		= mysql_query($strQuery, $nConnection);
					$arrCPResult = NULL;
					while ($arrRow2 = mysql_fetch_array($result))
					{
						$arrCPResult = $arrRow2;
					}
					printUser($arrCPResult, true, $nSubstituteId, $bLastUser);
					if ($arrCPResult['nDecissionState']==0) {
						$InProcess = true;
					}
				}
				$nPosInSlot++;
			}
		}
		if ($arrCirculationForm["nSenderId"] == $_SESSION['SESSION_CUTEFLOW_USERID'] && (empty($arrCurPi) || $InProcess)) {
			?>
		<tr>
			<td><img src="../images/adduser.gif" height="16" width="16" align="absmiddle"></td>
			<td colspan="7">
				<select>
			<?php
			$sql_ext = '';
			if (!empty($userId_arr)) {
				$sql_ext = " and nID not in (".implode(',', $userId_arr).")";
			}
			$sql = "SELECT * FROM cf_user WHERE bDeleted <> 1 ".$sql_ext." ORDER BY strFirstName ASC";
			$rs = mysql_query($sql, $nConnection);
			if ($rs && mysql_num_rows($rs) > 0) {
				while ($r = mysql_fetch_array($rs)) {
					echo "<option value=\"".$r["nID"]."\">".$r["strUserId"]." (".$r["strLastName"].", ".$r["strFirstName"].")</option>";
				}
			}
			?>
				</select>
				<input type="button" value="Add the selected user" onclick="adduser(this,<?php echo $arrSlot['nID'];?>,<?php echo $arrCirculationForm["nMailingListId"];?>,<?php echo ($nPosInSlot+1);?>,<?php echo $arrCirculationForm['nID'];?>,<?php echo $_REQUEST['nRevisionId'];?>,<?php echo intval(!empty($arrCurPi))?>);" />
			</td>
		</tr>
			<?php
		}
	}
	?>
		</table>
	</td>
</tr>
</table>
<br>
<?php
}	//--- end if ($view != "print")
?>
<?php if ($_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 2 || $_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 8): ?>
<span style="color:blue;">Tips: the following slot's <u>Name</u>/<u>Description</u>/<u>Due Date</u>/<u>Expected completion days</u>/<u>Press time interval</u> can be edited by clicking, Enter to submit, ESC to cancel.</span>
<?php endif;?>
<table border="0" width="95%" cellpadding="0" cellspacing="0" class="BorderSilver">
<tr>
	<td colspan="2" align="left">
		<table bgcolor="Silver" border="0" width="100%">
		<tr>
			<td align="left" width="20px"><img src="../images/values.png" height="16" width="16"></td>
			<td align="left" style="font-weight:bold;"><?php echo $CIRCDETAIL_VALUES;?></td>
		</tr>
		</table>
	</td>
</tr>
<?php
$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
mysql_select_db($DATABASE_DB, $nConnection);
$add_slot = 0;//是否开始添加Slot
foreach ($arrSlots as $slotIndex=>$arrSlot) {
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
	$bg = '';
	if (array_key_exists($arrSlot['nID'], $current_Slot)) {
		$bg = 'background-color: #ffe88e;';
	}
	if ($arrSlot['nID'] == $LastCurrSlot) {
		$add_slot = 1;
	}
	?>
<tr>
	<td style="border-top: 1px solid Silver;" align="left">
		<table width="100%" border="1" cellpadding="4" style="border-collapse:collapse;border:1px solid #999999;<?php echo $bg;?>">
		<tr>
			<td style="font-weight: bold;background: #666666; color: #fff; padding:1px;" colspan="16" class="edit" title="Click to Edit, Enter to submit"><span><?php echo $arrSlot['strName']; ?></span><input type="text" name="strName" id="<?php echo $arrSlot['nID'];?>" value="<?php echo $arrSlot['strName']; ?>" style="display:none;width:0;"/></td>
		</tr>
		<tr>
			<td style="background-color: #999999;padding:1px;" colspan="16">
				<table width="100%" border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border:1px solid #ffffff;color:#0000BB">
				<tr>
					<td style="color:#000000;" width="20%" nowrap="nowrap">Description :</td>
					<td colspan="5" class="edit" title="Click to Edit, Ctrl+Enter to submit"><span class="textarea"><?php echo nl2br($arrSlot['strDescr']); ?></span><textarea name="strDescr" id="<?php echo $arrSlot['nID'];?>" style="display:none;width:0;height:0;"><?php echo $arrSlot['strDescr']; ?></textarea></td>
				</tr>
				<tr>
					<td style="color:#000000;" width="20%" nowrap="nowrap">Due Date :</td>
					<td class="edit" title="Click to Edit, Enter to submit"><span><?php echo $arrSlot['dueDate'];?></span><input type="text" name="dueDate" id="<?php echo $arrSlot['nID'];?>" value="<?php echo $arrSlot['dueDate']; ?>" style="display:none;width:0;"/></td>
					<td style="color:#000000;" width="20%" nowrap="nowrap">Expected completion days :</td>
					<td class="edit" title="Click to Edi, Enter to submitt"><span><?php echo $number1;?></span><input type="text" name="doneTime" id="<?php echo $arrSlot['nID'];?>" value="<?php echo $number1; ?>" style="display:none;width:0;" title="<?php echo $unit1;?>"/><?php echo $unit1;?></td>
					<td style="color:#000000;" width="20%" nowrap="nowrap">Press time interval :</td>
					<td class="edit" title="Click to Edi, Enter to submitt"><span><?php echo $number2;?></span><input type="text" name="remindTime" id="<?php echo $arrSlot['nID'];?>" value="<?php echo $number2; ?>" style="display:none;width:0;" title="<?php echo $unit2;?>"/><?php echo $unit2;?></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
	<?php
	$strQuery = "SELECT * FROM cf_inputfield INNER JOIN cf_slottofield ON cf_inputfield.nID = cf_slottofield.nFieldId WHERE cf_slottofield.nSlotId = ".$arrSlot["nID"]."  ORDER BY cf_slottofield.nPosition ASC";
	$nResult = mysql_query($strQuery, $nConnection) or die ($strQuery."<br>".mysql_error());
	if ($nResult && mysql_num_rows($nResult) > 0) {
		$nRunningCounter = 1;
		while ($arrRow = mysql_fetch_array($nResult)) {
			?>
			<td class="mandatory" width="20%"><?php echo $arrRow["strName"];?> :</td>
			<td width="300px" valign="top">
			<?php
			foreach ($arrValues[$arrRow["nFieldId"]."_".$arrSlot["nID"]] as $user_id=>$user_val) {
				?>
				<fieldset style="border-color:#666;border-width:1px;">
					<legend style="font-weight:bold"><img src="../images/singleuser.gif" height="16" width="16" align="absmiddle"/> <?php echo $arrUsers[$user_id]["strFirstName"];?></legend>
				<?php
				if ($arrRow["nType"] == 1) {
					if ($user_val["strFieldValue"]!='') {
						$arrValue = explode('rrrrr',$user_val["strFieldValue"]);
						$output = replaceLinks($arrValue[0]); 
						if ($arrRow['strBgColor'] != "") {
							$output = '<span style="background-color: #'.$arrRow['strBgColor'].'">'.$output.'<span>';
						}
						echo $output; 
					}
					else {
						$arrValue = explode('rrrrr',$arrRow['strStandardValue']);
						$output = replaceLinks($arrValue[0]); 
						if ($arrRow['strBgColor'] != "") {
							$output = '<span style="background-color: #'.$arrRow['strBgColor'].'">'.$output.'<span>';
						}
						echo $output;
					}
				}
				elseif ($arrRow["nType"] == 2) {
					if ($user_val["strFieldValue"] != "on") {
						$state = "inactive";
					}
					else {
						$state = "active";
					}
					echo "<img src=\"../images/$state.gif\" height=\"16\" width=\"16\">";
				}
				elseif ($arrRow["nType"] == 3) {
					if ($user_val["strFieldValue"]!='') {
						$arrValue = explode('xx',$user_val["strFieldValue"]);
						$nNumGroup 	= $arrValue[1];
						$arrValue1 = explode('rrrrr',$arrValue[2]);
						$strMyValue	= $arrValue1[0];
					}
					else {
						$arrValue = explode('xx',$arrRow['strStandardValue']);
						$nNumGroup 	= $arrValue[1];
						$arrValue1 = explode('rrrrr',$arrValue[2]);
						$strMyValue	= $arrValue1[0];
					}
					$output = replaceLinks($strMyValue); 
					if ($arrRow['strBgColor'] != "") {
						$output = '<span style="background-color: #'.$arrRow['strBgColor'].'">'.$output.'<span>';
					}
					echo $output;
				}
				elseif ($arrRow["nType"] == 4) {
					if ($user_val["strFieldValue"]!='') {
						$arrValue = explode('xx',$user_val["strFieldValue"]);
						$nDateGroup 	= $arrValue[1];
						$arrValue2 = explode('rrrrr',$arrValue[2]);
						$strMyValue 	= $arrValue2[0];
					}
					else {
						$arrValue 		= explode('xx',$arrRow['strStandardValue']);
						$nDateGroup 	= $arrValue[1];
						$arrValue2 		= explode('rrrrr',$arrValue[2]);
						$strMyValue 	= $arrValue2[0];
					}
					$output = replaceLinks($strMyValue); 
					if ($arrRow['strBgColor'] != "") {
						$output = '<span style="background-color: #'.$arrRow['strBgColor'].'">'.$output.'<span>';
					}
					echo $output;
				}
				elseif ($arrRow["nType"] == 5){
					if ($user_val["strFieldValue"]!='') {
						echo replaceLinks(nl2br($user_val["strFieldValue"]));
					}
					else {
						echo replaceLinks(nl2br($arrRow['strStandardValue']));
					}
				}
				elseif ($arrRow["nType"] == 6) {
					if ($user_val["strFieldValue"]!='') {
						$strValue = $user_val["strFieldValue"];
						$arrMySplit = explode('---', $strValue);
						if ($arrMySplit[1] > 1) {	// edited field values
							$strValue = '';
							$nMax = (sizeof($arrMySplit));
							for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
								$strValue .= $arrMySplit[$nIndex].'---';
							}
							$keyId = rand(1, 150);
						}
						else {	// we have to use the standard value
							$strValue = $user_val["strFieldValue"];
							$keyId = rand(1, 150);
						}
					}
					else {
						$strValue = $arrRow['strStandardValue'];
					}
					$nInputfieldID 	= $arrRow["nFieldId"];
					$bIsEnabled 	= 0;
					$strEcho = $objMyCirculation->getRadioGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
					echo $strEcho;
				}
				elseif ($arrRow["nType"] == 7) {
					if ($user_val["strFieldValue"]!='') {
						$strValue = $user_val["strFieldValue"];
						$arrMySplit = explode('---', $strValue);
						if ($arrMySplit[1] > 1) {	// edited field values
							$strValue = '';
							$nMax = (sizeof($arrMySplit));
							for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
								$strValue .= $arrMySplit[$nIndex].'---';
							}
							$keyId = rand(1, 150);
						}
						else {	// we have to use the standard value
							$strValue = $user_val["strFieldValue"];
							$keyId = rand(1, 150);
						}
					}
					else {
						$strValue = $arrRow['strStandardValue'];
					}
					$nInputfieldID 	= $arrRow["nFieldId"];
					$bIsEnabled 	= 0;
					$strEcho = $objMyCirculation->getCheckboxGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
					echo $strEcho;
				}
				elseif($arrRow["nType"] == 8) {
					if ($user_val["strFieldValue"]!='') {
						$strValue = $user_val["strFieldValue"];
						$arrMySplit = explode('---', $strValue);
						if ($arrMySplit[1] > 1) {	// edited field values
							$strValue = '';
							$nMax = (sizeof($arrMySplit));
							for ($nIndex = 3; $nIndex < $nMax; $nIndex = $nIndex + 2) {
								$strValue .= $arrMySplit[$nIndex].'---';
							}
							$keyId = rand(1, 150);
						}
						else {	// we have to use the standard value
							$strValue = $user_val["strFieldValue"];
							$keyId = rand(1, 150);
						}
					}
					else {
						$strValue = $arrRow['strStandardValue'];
					}
					$nInputfieldID 	= $arrRow["nFieldId"];
					$bIsEnabled 	= 0;
					$strEcho = $objMyCirculation->getComboBoxGroup($nInputfieldID, $strValue, $bIsEnabled, $keyId, $nRunningCounter);
					echo $strEcho;
				}
				elseif($arrRow["nType"] == 9) {
					if ($user_val["strFieldValue"]!='') {
						$arrSplit = explode('---',$user_val["strFieldValue"]);
					}
					else {
						$arrSplit = explode('---',$arrRow['strStandardValue']);
					}
					$nNumberOfUploads 	= $arrSplit[1];
					$strDirectory		= $arrSplit[2].'_'.$nNumberOfUploads;
					$arrValue22 = explode('rrrrr',$arrSplit[3]);
					$strFilename		= $arrValue22[0];
					$strUploadPath 		= $CUTEFLOW_SERVER.'/upload/';
					$strLink			= $strUploadPath.$strDirectory.'/'.$strFilename;
					echo "<a href=\"$strLink\" target=\"_blank\">$strFilename</a>";
				}
				echo '</fieldset>';
			}
			echo "</td>";
			if ($nRunningCounter % 2 == 0) {
				echo "</tr>\n<tr>\n";
			}
			$nRunningCounter++;
		}
		echo "<td>&nbsp;</td>";
	}
	?>
		</tr>
		</table>
	</td>
</tr>
	<?php
	if ($add_slot && $arrCirculationForm["nSenderId"] == $_SESSION['SESSION_CUTEFLOW_USERID']) {
		?>
<tr bgcolor="#FFFFFF">
	<td style="padding:3px;">
		<!-- <img src="../images/addtemplate.png" width="16" height="16" align="absmiddle" /> --><input type="button" onclick="$(this).next().show();" value="Insert a slot here" />
		<form style="display:none;margin:0;" action="?action=add_slot" method="post" target="_iframe" onsubmit="return confirm('Do you confirm to submit?')&&confirm('Notice: once saved, it cant\'t be deleted!\nContinue?');">
		<table width="100%" cellspacing="1" cellpadding="3" bgcolor="#c8c8c8">
		<tr bgcolor="#FFFFFF">
			<td valign="top">
				<table>
				<tr>
					<td class="table_header" colspan="2" height="25">Slot details</td>
				</tr>
				<tr>
					<td>Slot name:</td>
					<td><input id="strName" Name="strName" type="text" class="InputText" style="width:200px;" value=""></td>
				</tr>
				<tr>
					<td>Description: </td>
					<td><textarea name="description" style="width:200px;height:80px;"></textarea></td>
				</tr>
				<tr>
					<td >Due Date: </td>
					<td><input type="text" id="dueDate" name="dueDate" value="0000-00-00" size="10" />
					</td>
				</tr>
				<tr>
					<td>Expected completion days: </td>
					<td><input type="text" name="number1" value="0" size="3" />
						<select name="unit1">
							<option value="day" selected="selected" >Days</option>
							<option value="hour" >Hours</option>
							</select>
							<br />
							(Integer number only)
					</td>
				</tr>
				<tr>
					<td >Press time interval: </td>
					<td><input type="text" name="number2" value="0" size="3" />
						<select name="unit2">
							<option value="day"  >Days</option>
							<option value="hour"  selected="selected" >Hours</option>
							<option value="minute"  >Minutes</option>
						</select>
						<br />
						(Integer number only, '0' means no press mail)
					</td>
				</tr>
				</table>
			</td>
			<td valign="top">
				<table>
				<tr>
					<td style="background: gray; color: white;" colspan="2" height="25">Slot fields</td>
				</tr>
				<tr>
					<td align="left" valign="top" style="padding-bottom:5px;">
						<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
						<tr style="background-color: silver;">
							<td width="47">Pos.</td>
							<td>Name</td>
						</tr>
						</table>
						<div style="height: 220px; width: 230px; overflow: auto;">
							<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
								<tbody id="AttachedFields_<?php echo $slotIndex;?>">
									
								</tbody>
							</table>
						</div>
					</td>
					<td valign="top" align="left" style="padding:5px;">
						<input type="button" class="Button" value="Add" onclick="addFields('<?php echo $slotIndex;?>')"/>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top">
				<table>
				<tr style="background-color: gray;">
					<td align="left" height="25" style="color: #fff;">Available fields: </td>
				</tr>
				<tr>
					<td>
						<div style="height: 240px; width: 220px; overflow: auto;">
						<table cellpadding="2" cellspacing="0" style="background-color:white;" width="100%">
						<tbody id="AvailableFields_<?php echo $slotIndex;?>">
							<?php
							foreach ($arrFields as $arrField)
							{
								$sid = $arrField['nID'];
								?>
								<tr>
									<td width="16px" style="border-top:1px solid Silver;" valign="middle"><input type="checkbox" id="<?php echo $sid ?>" name="<?php echo $sid ?>" value="<?php echo $sid ?>"></td>
									<td width="20px" style="border-top:1px solid Silver;" valign="middle"><img src="../images/textfield_rename.gif" height="16" width="16"></td>
									<td style="border-top:1px solid Silver;" valign="middle"><?php echo $arrField['strName'] ?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
						</table>
						</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td>
				&nbsp;<input type="button" class="Button" value="Cancel" onclick="$(this).parent().parent().parent().parent().parent().hide();">
			</td>
			<td align="right" colspan="2">
				<input type="submit" value="Save" class="Button">&nbsp;
			</td>
		</tr>
		</table>
		<input type="hidden" value="<?php echo $arrSlot["nTemplateId"];?>" name="TemplateId">
		<input type="hidden" value="<?php echo $arrSlot["nSlotNumber"];?>" name="SlotNumber">
		<input type="hidden" value="en" id="language" name="language">
		</form>
	</td>
</tr>
		<?php
	}
}
?>
</table>
<br>
</center>
<iframe id="_iframe" name="_iframe" style="width:0;height:0;display:none;"></iframe>
</body>
<script language="javascript" type="text/javascript" src="../src/jquery-1.2.6.pack.js"></script>
<script language="JavaScript" type="text/javascript">
<?php if ($_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 2 || $_SESSION["SESSION_CUTEFLOW_ACCESSLEVEL"] == 8): ?>
$(document).ready(function(){
	$("td.edit").each(function(i) { //设置数字可编辑
		setEditable(this, i);
	});
});
<?php endif;?>
var last_element = '';
function setEditable(obj, n) {
	$(obj).css('cursor', 'pointer').mouseover(function(){
		$(this).addClass("focus");
	}).mouseout(function(){
		$(this).removeClass("focus");
	}).click(function(){
		var element = $(this).children('span').attr('class');
		if (''==element) {
			element = 'input';
		}
		if ($(this).children(element).css('display') != 'none') {
			return;
		}
		if (''!=last_element) {
			$("td.editing").children(last_element).hide();
			$("td.editing").children('span').show();
			$("td.editing").removeClass('editing');
		}
		var width = $(this).width();
		var height = $(this).height();
		$(this).children('span').hide();
		var element_obj = $(this).children(element);
		element_obj.css('width', width);
		if ('textarea' == element) {
			element_obj.css('height', height*2).css('overflow-y','scroll');
		}
		element_obj.show().select().keydown(function(e){
			var keyCode=e.keyCode || window.event.keyCode;
			if (keyCode==13) {
				if ('textarea' == element && !e.ctrlKey && !window.event.ctrlKey) {
					return;
				}
				submit_edit(this);
			}
			else if (keyCode==27) {
				cancel_edit(this);
			}
		});
		$(this).addClass('editing');
		last_element = element;
	});
}
function submit_edit(obj){
	$.post('?action=set_slot', {
		'nID' : $(obj).attr('id'),
		'field' : $(obj).attr('name'),
		'value' : $(obj).val(),
		'unit'  : $(obj).attr('title')
	}, function(str) {
			if ('1'==str) {
				$(obj).hide().prev().html($(obj).val().replace(/[\r\n]/g, '<br />')).show();
				alert('Update Success!');
			}
			else if ('-1'==str) {
				alert('Invalid input!');
			}
			else {
				alert('Oops, failure!');
			}
		});
}
function cancel_edit(obj){
	$(obj).hide().prev().show();
}
function update_name(obj) {
	$.post('?action=set_name', {
		'nID' : $(obj).prev().attr('id'),
		'strName' : $(obj).prev().val()
	}, function(str) {
			if ('1'==str) {
				alert('Update Success!');
			}
			else {
				alert('Oops, failure!');
			}
		});
}
function adduser(obj, SlotId, MailingListId, Position, FormId, HistoryId, InProcess) {
	if (confirm("Do you confirm to add him to this slot?")) {
		//add user to slot
		$.post('?action=add_user', {
			'UserId' : $(obj).prev().val(),
			'SlotId' : SlotId,
			'MailingListId' : MailingListId,
			'Position' : Position,
			'FormId' : FormId,
			'HistoryId' : HistoryId,
			'InProcess' : InProcess
		}, function(str) {
				if ('1'==str) {
					window.location.href = window.location.href;
				}
				else {
					alert('Oops, failure!');
			}
		});
	}
	return false;
}
</script>
	<script language="JavaScript">
	<!--
		function up(SlotId, nPosition)
		{
			if (nPosition > 1)
			{
				swapPosition (SlotId, nPosition, nPosition-1);
			}
		}
		
		function down(SlotId, nPosition)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objDestinationTable = document.getElementById(strDestinationId);		
			nLastPos = getLastPosition(objDestinationTable);
			
			if (nPosition < nLastPos)
			{
				swapPosition (SlotId, nPosition+1, nPosition);
			}
		}
		
		//--- swapping nPos2 in front of nPos1
		function swapPosition (SlotId, nPos1, nPos2)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objTable = document.getElementById(strDestinationId);
			
			//--- copy the pos2 in front of pos1
			objRow1 = findRow(objTable, nPos1);
			objRow2 = findRow(objTable, nPos2);
			
			if (objRow1)
			{
				objRow1.swapNode(objRow2);
			
				changePosition(objRow1, nPos2, SlotId);
				changePosition(objRow2, nPos1, SlotId);
			}
		}
		
		function changePosition(objRow, nPosNumber, SlotId)
		{
			nPosTd = getPosOfType(objRow.childNodes, "TD", 1);
			nHrefTd = getPosOfType(objRow.childNodes, "TD", 4);
			
			objRow.childNodes[nPosTd].innerHTML = nPosNumber;

			//--- change "up"-href
			nHref1Pos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "A", 1);
			objHref1 = objRow.childNodes[nHrefTd].childNodes[nHref1Pos];
			strUrl = "javascript:up("+SlotId+","+nPosNumber+")";
			objHref1.setAttribute("href", strUrl);
			
			//--- change "down"-href
			nHref2Pos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "A", 2);
			objHref2 = objRow.childNodes[nHrefTd].childNodes[nHref2Pos];
			strUrl = "javascript:down("+SlotId+","+nPosNumber+")";
			objHref2.setAttribute("href", strUrl);
			
			//--- change "remove"-href
			nHref3Pos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "A", 3);
			objHref3 = objRow.childNodes[nHrefTd].childNodes[nHref3Pos];
			strUrl = "javascript:remove("+SlotId+","+nPosNumber+")";
			objHref3.setAttribute("href", strUrl);
			
			//--- change the hidden input field
			nInputPos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "INPUT", 1);
			objInput = objRow.childNodes[nHrefTd].childNodes[nInputPos];
			
			strCurValue = objInput.getAttribute("value");
			
			Ids = strCurValue.split("_");
			strNewId = SlotId+"_"+Ids[1]+"_"+nPosNumber;
			objInput.setAttribute("id", strNewId);
			objInput.setAttribute("name", strNewId);
			objInput.setAttribute("value", strNewId);					
		}
		
		function remove(SlotId, nPosition)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objTable = document.getElementById(strDestinationId);
			
			//--- remove row
			objRowDelete = findRow(objTable, nPosition);
			
			objTable.removeChild(objRowDelete);
			
			//--- renumber all following rows
			nLastPos = getLastPosition(objTable);
			for (nCurPos = nPosition+1; nCurPos <= nLastPos; nCurPos++)
			{
				objCurRow = findRow(objTable, nCurPos);
				changePosition(objCurRow, nCurPos-1, SlotId);
			}
		}
	
		function addFields(SlotId)
		{
			strDestinationId = 'AttachedFields_'+SlotId;
			strSourceId = 'AvailableFields_'+SlotId;
			
			objSourceTable = document.getElementById(strSourceId);
			objDestinationTable = document.getElementById(strDestinationId);
			
			//--- get last position in destination table
			nLastPos = getLastPosition(objDestinationTable);
			for (i=0; i <objSourceTable.childNodes.length; i++)
			{
				nCheckboxPos = getPosOfType(objSourceTable.childNodes[i].childNodes, "TD", 1);
				if (-1 != nCheckboxPos)
				{
					if (objSourceTable.childNodes[i].childNodes[nCheckboxPos])
					{
						if (objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.checked)
						{
							nID = objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.getAttribute("id");
							nNamePos = getLastOfType(objSourceTable.childNodes[i].childNodes, "TD");
							strUserName = objSourceTable.childNodes[i].childNodes[nNamePos].innerHTML;
							
							//--- add element to table (as last item)
							nLastPos++;
							new_row=document.createElement("TR");
								first_cell=document.createElement("TD");
									first_cell.setAttribute("style", "border-top:1px solid Silver;");
									first_cell.setAttribute("width", "20px");
									first_cell.appendChild(document.createTextNode(nLastPos));
								new_row.appendChild(first_cell);
								
								second_cell=document.createElement("TD");
									second_cell.appendChild(createImage("../images/textfield_rename.gif", 16, 19));
									second_cell.setAttribute("style", "border-top:1px solid Silver;");
									second_cell.setAttribute("width", "22px");
								new_row.appendChild(second_cell);
								
								third_cell=document.createElement("TD");
									third_cell.appendChild(document.createTextNode(strUserName));							
									third_cell.setAttribute("style", "border-top:1px solid Silver;");
								new_row.appendChild(third_cell);
								
								forth_cell=document.createElement("TD");
									forth_cell.setAttribute("style", "border-top:1px solid Silver; padding-right: px;");
									forth_cell.setAttribute("align", "right");
									forth_cell.setAttribute("width", "80px");								
									
									strUrl = "javascript:up("+SlotId+","+nLastPos+")";
									href = createHref(strUrl, "", "");
									href.appendChild(createImage("../images/up.gif", 16, 16));
									forth_cell.appendChild(href);
									
									strUrl = "javascript:down("+SlotId+","+nLastPos+")";
									href = createHref(strUrl, "", "");
									href.appendChild(createImage("../images/down.gif", 16, 16));
									forth_cell.appendChild(href);
									
									strUrl = "javascript:remove("+SlotId+","+nLastPos+")";
									href = createHref(strUrl, "", "");
									href.appendChild(createImage("../images/edit_remove.gif", 16, 16));
									forth_cell.appendChild(href);
									
									strNewId = SlotId+"_"+nID+"_"+nLastPos;
									hidden_field = document.createElement("INPUT");
										hidden_field.setAttribute("type", "hidden");
										hidden_field.setAttribute("id", strNewId);
										hidden_field.setAttribute("name", strNewId);
										hidden_field.setAttribute("value", strNewId);
									forth_cell.appendChild(hidden_field);
								new_row.appendChild(forth_cell);
								
							objDestinationTable.appendChild(new_row);
							
							//new: deselects the checkbox after adding it to the field
							objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.checked = false;
						}
					}
				}
			}				
		}
		
		function createHref(strUrl, strTarget, strAlt)
		{
			href = document.createElement("A");
			href.setAttribute("href", strUrl);
			href.setAttribute("target", strTarget);
			href.setAttribute("alt", strAlt);
			
			return href;
		}
		
		function createImage(strPath, nWidth, nHeight)
		{
			img = document.createElement("IMG");
			img.setAttribute("src", strPath);
			img.setAttribute("height", nHeight);
			img.setAttribute("width", nWidth);		
			img.setAttribute("border", 0);
				
			return img;
		}
		
		function getLastPosition(objTable)
		{	
			nLastPos = 0;		
			nTrPos = getLastOfType(objTable.childNodes, "TR");
			
			if (-1 != nTrPos)
			{
				nTdPos = getPosOfType(objTable.childNodes[nTrPos].childNodes, "TD", 1); 
				
				if (-1 != nTdPos)
				{
					nLastPos = parseInt(objTable.childNodes[nTrPos].childNodes[nTdPos].innerHTML);
				}
			}
			
			return nLastPos;
		}
		
		function findRow (objTable, nPosition)
		{
			for (x = 0; x < objTable.childNodes.length; x++)
			{
				if (objTable.childNodes[x].nodeName == "TR")
				{
					nPos = getPosOfType(objTable.childNodes[x].childNodes, "TD", 1);
					objTd = objTable.childNodes[x].childNodes[nPos];
					
					nCurPosition = Math.abs(objTd.innerHTML);
					
					if (nCurPosition == nPosition)
					{
						return objTable.childNodes[x];
					}
				}
			}
		}
		
		function getPosOfType(objCollection, strTag, Pos)
		{
			nTempPos = 0;
			for (iPos = 0; iPos < objCollection.length; iPos++)
			{
				if (objCollection[iPos].nodeName == strTag)
				{
					nTempPos++;
					
					if (nTempPos == Pos)
					{		
						return iPos;
					}
				}		
			}
			
			return -1;
		}
		
		function getLastOfType(objCollection, strTag)
		{
			for (ilPos = objCollection.length-1; ilPos >= 0; ilPos--)
			{
				if (objCollection[ilPos].nodeName == strTag)
				{
					return ilPos;
				}
			}
			
			return -1;
		}

		if(!document.all){
			Node.prototype.swapNode = function (node) 
			{
	  			var nextSibling = this.nextSibling;
	  		  	var parentNode = this.parentNode;
				node.parentNode.replaceChild(this, node);
				parentNode.insertBefore(node, nextSibling);  
	
				return this;
			}
		}
	//-->
	</script>
</html>
