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
	
	require_once '../lib/swift/swift_required.php';
	
	include_once ("../config/config.inc.php");
	include ("../pages/version.inc.php");
	include_once ("../language_files/language.inc.php");
	
	
	function getNextUserInList($nCurUserId, $nMailingListId, $nSlotId)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB;
		
		$arrUserInfo = array();
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		$nConnection2 = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		
		if ( ($nConnection) && ($nConnection2) ) 
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{
				mysql_select_db($DATABASE_DB, $nConnection2);
				
				$query = "SELECT * FROM cf_formslot WHERE nID={$nSlotId}";
				$result = mysql_query($query, $nConnection);
				if ($result) {
					$arrSlotInfo = mysql_fetch_array($result);
				}
				
				$strQuery = "SELECT * FROM cf_slottouser INNER JOIN cf_formslot ON cf_slottouser.nSlotId  = cf_formslot.nID WHERE cf_slottouser.nMailingListId=$nMailingListId ORDER BY cf_formslot.nSlotNumber ASC, cf_slottouser.nPosition ASC";
				$nResult = mysql_query($strQuery, $nConnection);
				
        		if ($nResult)
        		{
        			if (mysql_num_rows($nResult) > 0)
        			{
						$bFoundOne == false;
        				while (	$arrRow = mysql_fetch_array($nResult))
        				{
        					if ($nCurUserId == -1)
							{
								//--- lets take the first user
								$arrUserInfo[0] = $arrRow["nUserId"];
								$arrUserInfo[1] = $arrRow["nSlotId"];
								
								return $arrUserInfo;
							}
							else if ($bFoundOne == true)
							{
								$arrUserInfo[0] = $arrRow["nUserId"];
								$arrUserInfo[1] = $arrRow["nSlotId"];
								
								// Slot has changed
								$arrUserInfo[2] = $nSlotId != $arrRow['nSlotId'] ? $arrRow['nSlotId'] : false; 
								
								return $arrUserInfo;
							}
							else
							{
								if ( ($arrRow["nUserId"] == $nCurUserId) && 
										($arrRow["nSlotId"] == $nSlotId))
								{
									$bFoundOne = true; //--- next loop returns user	
								}
							}
						}
					}
				}
			}
		}
		
		return $arrUserInfo;
	}
	function getNextUsersInList($nCurUserId, $nMailingListId, $nSlotId, $nCirculationFormId, $nCirculationHistoryId=0)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB;
		
		$arrUserInfo = array();
		$arrUsersInfo = array();
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD) or die('DB Connection fail');
		
		if (mysql_select_db($DATABASE_DB, $nConnection))
		{
			$arrUserDone = array();
			$sql = "select * from cf_circulationprocess where nCirculationFormId=$nCirculationFormId and nCirculationHistoryId=$nCirculationHistoryId and nDecissionState!=0";
			$rs = mysql_query($sql, $nConnection);
			if ($rs && mysql_num_rows($rs)) {
				while ($r = mysql_fetch_array($rs)) {
					$arrUserDone[] = array($r['nSlotId'], $r['nUserId']);
				}
			}
		//	echo '<pre>arrUserDone';print_r($arrUserDone);echo '</pre>';
			$strQuery = "SELECT * FROM cf_slottouser INNER JOIN cf_formslot ON cf_slottouser.nSlotId  = cf_formslot.nID WHERE cf_slottouser.nMailingListId=$nMailingListId ORDER BY cf_formslot.nSlotNumber ASC, cf_slottouser.nPosition ASC";
			$nResult = mysql_query($strQuery, $nConnection);
			
        	if ($nResult)
        	{
        		if (mysql_num_rows($nResult) > 0)
        		{
					while (	$arrRow = mysql_fetch_array($nResult))
        			{
        				if (in_array(array($arrRow['nSlotId'], $arrRow['nUserId']), $arrUserDone)) {
        					continue;
        				}
        				$arrUsersInfo[$arrRow['nSlotId']][] = array($arrRow["nUserId"], $arrRow["nSlotId"], false);
					}
				}
			}
		//	echo '<pre>';print_r($arrUsersInfo);echo '</pre>';
		}
		if (count($arrUsersInfo)) {
			$arrUserInfo = array_shift($arrUsersInfo);
			if (!array_key_exists($nSlotId, $arrUsersInfo)) {
				foreach ($arrUserInfo as $i=>$item) {
					$arrUserInfo[$i][2] = $item[1];
				}
			}
		}
		else {
			$arrUserInfo = array(array(''));
		}
		return $arrUserInfo;
	}
	function getSkipUsers($nCurUserId, $nMailingListId, $nSlotId, $nCirculationFormId, $nCirculationHistoryId=0)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB;
		
		$arrUserInfo = array();
		$arrUsersInfo = array();
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD) or die('DB Connection fail');
		
		if (mysql_select_db($DATABASE_DB, $nConnection))
		{
			$arrUserDone = array();
			$sql = "select * from cf_circulationprocess where nCirculationFormId=$nCirculationFormId and nCirculationHistoryId=$nCirculationHistoryId and ((nSlotId=$nSlotId and nUserId=$nCurUserId) or (nDecissionState!=0 and nDecissionState!=8))";
			$rs = mysql_query($sql, $nConnection);
			if ($rs && mysql_num_rows($rs)) {
				while ($r = mysql_fetch_array($rs)) {
					if ($r['nIsSubstitiuteOf']!=0) {
						$strQuery = "select * FROM cf_circulationprocess WHERE nID = ".$r['nIsSubstitiuteOf'];
						$nResult 	= mysql_query($strQuery);
						$r = mysql_fetch_array($nResult, MYSQL_ASSOC);
					}
					$arrUserDone[] = array($r['nSlotId'], $r['nUserId']);
				}
			}
		//	echo '<pre>arrUserDone<br />';print_r($arrUserDone);echo '</pre>';
			$strQuery = "SELECT * FROM cf_slottouser INNER JOIN cf_formslot ON cf_slottouser.nSlotId  = cf_formslot.nID WHERE cf_slottouser.nMailingListId=$nMailingListId ORDER BY cf_formslot.nSlotNumber ASC, cf_slottouser.nPosition ASC";
			$nResult = mysql_query($strQuery, $nConnection);
			
        	if ($nResult)
        	{
        		if (mysql_num_rows($nResult) > 0)
        		{
					while (	$arrRow = mysql_fetch_array($nResult))
        			{
        				if (in_array(array($arrRow['nSlotId'], $arrRow['nUserId']), $arrUserDone)) {
        					continue;
        				}
        				$arrUsersInfo[$arrRow['nSlotId']][] = array($arrRow["nUserId"], $arrRow["nSlotId"], false);
					}
				}
			}
		//	echo '<pre>arrUsersInfo<br />';print_r($arrUsersInfo);echo '</pre>';
		}
		if (count($arrUsersInfo)) {
			$arrUserInfo = array_shift($arrUsersInfo);
			if (!array_key_exists($nSlotId, $arrUsersInfo)) {
				foreach ($arrUserInfo as $i=>$item) {
					$arrUserInfo[$i][2] = $item[1];
				}
			}
		}
		else {
			$arrUserInfo = array(array(''));
		}
		return $arrUserInfo;
	}
	function sendToUser($nUserId, $nCirculationId, $nSlotId, $nCirculationProcessId, $nCirculationHistoryId, $tsDateInProcessSince = '', $force_send_mail=false)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH;
		global $SYSTEM_REPLY_ADDRESS, $CUTEFLOW_VERSION, $TStoday, $objURL, $EMAIL_FORMAT, $EMAIL_VALUES, $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS;
		
		global $DEFAULT_CHARSET, $SEND_WORKFLOW_MAIL;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{	
				// Create the Transport
				if ($MAIL_SEND_TYPE == 'SMTP') {
					$transport = Swift_SmtpTransport::newInstance($SMTP_SERVER, $SMTP_PORT)
			  					->setUsername($SMTP_USERID)
			  					->setPassword($SMTP_PWD);
			  					
			  		if ($SMPT_ENCRYPTION != 'NONE') {
			  			$transport = $transport->setEncryption(strtolower($SMPT_ENCRYPTION));
			  		}
				}
				else if ($MAIL_SEND_TYPE == 'PHP') {
					$transport = Swift_MailTransport::newInstance();
				}
				else if ($MAIL_SEND_TYPE == 'MTA') {
					$transport = Swift_SendmailTransport::newInstance($MTA_PATH);
				}
				
				// Create the Mailer using the created Transport
				$mailer = Swift_Mailer::newInstance($transport);
				
				$message = Swift_Message::newInstance()
									->setCharset($DEFAULT_CHARSET);
	
				//------------------------------------------------------
				//--- get the needed informations
				//------------------------------------------------------
				
				//--- circulation form
				$arrForm = array();
				$strQuery = "SELECT * FROM cf_circulationform WHERE nID=$nCirculationId";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrForm = mysql_fetch_array($nResult);
					}
				}
				
				//--- circulation history
				$arrHistory = array();
				$strQuery = "SELECT * FROM cf_circulationhistory WHERE nID=$nCirculationHistoryId";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrHistory = mysql_fetch_array($nResult);
					}
				}
				
				//--- the attachments
				$strQuery = "SELECT * FROM cf_attachment WHERE nCirculationHistoryId=$nCirculationHistoryId";
				$nResult = mysql_query($strQuery, $nConnection);
	    		if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				while (	$arrRow = mysql_fetch_array($nResult))
	    				{
							$strFileName = basename($arrRow['strPath']);
							$mimetype = new mimetype();
					      	$filemime = $mimetype->getType($strFileName);
							$message->attach(Swift_Attachment::fromPath(
													$arrRow["strPath"],
													$filemime)->setFilename($strFileName));
						}
					}
				}
				
				//------------------------------------------------------
				//--- update status in circulationprocess table
				//------------------------------------------------------				
				$sql = "select * from cf_circulationprocess where nCirculationFormId=$nCirculationId and nSlotId=$nSlotId and nUserId=$nUserId and nCirculationHistoryId=$nCirculationHistoryId";
				$rs = mysql_query($sql);
				if ($rs && mysql_num_rows($rs)==0) {
					if ($tsDateInProcessSince == '')
					{
						$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $TStoday, 0, 0, $nCirculationProcessId, $nCirculationHistoryId, 0, 0)";
						mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
					}
					else
					{
						//( `nID` , `nCirculationFormId` , `nSlotId`, `nUserId` , `dateInProcessSince` , `nDecissionState`, `dateDecission` , `nIsSubstitiuteOf` , `nCirculationHistoryId`)
						$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $tsDateInProcessSince, 0, 0, 0, $nCirculationHistoryId, 0, 0)";
						mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
					}
					$send_mail = true;
				}
				
				//------------------------------------------------------
				//--- generate email message
				//------------------------------------------------------	
				if ($force_send_mail || ($SEND_WORKFLOW_MAIL == true && $send_mail)) 
				{		
					$strQuery = "SELECT nID FROM cf_circulationprocess WHERE nSlotId=$nSlotId AND nUserId=$nUserId AND nCirculationFormId=$nCirculationId AND nCirculationHistoryId=$nCirculationHistoryId";
					$nResult = mysql_query($strQuery, $nConnection);
		    		if ($nResult)
		    		{
		    			if (mysql_num_rows($nResult) > 0)
		    			{
		    				$arrLastRow = array();
		    				
		    				while ($arrRow = mysql_fetch_array($nResult))
		    				{
		    					$arrLastRow = $arrRow;
		    				}
							$Circulation_cpid = $arrLastRow[0];
						}
					}				
					
					//switching Email Format
					if ($nUserId != -2)
					{	
						$strQuery = "SELECT * FROM `cf_user` WHERE nID = $nUserId;";
					}
					else
					{	// in this case the next user is the sender of this circulation
						$strQuery = "SELECT * FROM `cf_user` WHERE nID = ".$arrForm['nSenderId'].";";
					}
					$nResult = mysql_query($strQuery, $nConnection);
					if ($nResult)
		    		{
			    		$user						= mysql_fetch_array($nResult, MYSQL_ASSOC);
			    		
			    		$useGeneralEmailConfig		= $user['bUseGeneralEmailConfig'];
			    		
			    		if (!$useGeneralEmailConfig)
			    		{
				    		$emailFormat	= $user['strEmail_Format'];
				    		$emailValues	= $user['strEmail_Values'];
			    		}
			    		else
			    		{
				    		$emailFormat	= $EMAIL_FORMAT;
				    		$emailValues	= $EMAIL_VALUES;
			    		}
			    		
			    		$Circulation_Name			= $arrForm['strName'];
						$Circulation_AdditionalText = str_replace("\n", "<br>", $arrHistory['strAdditionalText']);
	    				
	    				//--- create mail
						require '../mail/mail_'.$emailFormat.$emailValues.'.inc.php';
	
						switch ($emailFormat)
						{
							case PLAIN:
								$message->setBody($strMessage, 'text/plain');
								break;
							case HTML:
								$message->setBody($strMessage, 'text/html');
								break;
		    			}		    		
		    		}				
					
					//------------------------------------------------------
					//--- send email to user
					//------------------------------------------------------
					if ($nUserId != -2)
					{
						$strQuery = "SELECT * FROM cf_user WHERE nID = $nUserId";
					}
					else
					{	// in this case the next user is the sender of this circulation
						$strQuery = "SELECT * FROM cf_user WHERE nID = ".$arrForm['nSenderId']."";
					}
					$nResult = mysql_query($strQuery, $nConnection);
	        		if ($nResult)
	        		{
	        			if (mysql_num_rows($nResult) > 0)
	        			{
							$arrRow = mysql_fetch_array($nResult);
							$SYSTEM_REPLY_ADDRESS = str_replace (' ', '_', $SYSTEM_REPLY_ADDRESS);
							
							$message->setFrom(array($SYSTEM_REPLY_ADDRESS=>'AgigAFlow'));
							$message->setSubject($MAIL_HEADER_PRE.$arrForm["strName"]);
							
							$message->setTo(array($arrRow["strEMail"]));
							
							$result = $mailer->send($message);
							if (!$result)
							{
								$fp = @fopen ("mailerror.log", "a");
								if ($fp)
								{
									@fputs ($fp, date("d.m.Y", time())." - sendToUser\n");
									fclose($fp);
								}
							}
							else
							{
								return true;
							}
						}
					}
				}
			}
		}
		
		return false;
	}
	function sendToUserDelay($nUserId, $nCirculationId, $nSlotId, $nCirculationProcessId, $nCirculationHistoryId, $tsDateInProcessSince = '', $force_send_mail=false)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH;
		global $SYSTEM_REPLY_ADDRESS, $CUTEFLOW_VERSION, $TStoday, $objURL, $EMAIL_FORMAT, $EMAIL_VALUES, $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS;
		
		global $DEFAULT_CHARSET, $SEND_WORKFLOW_MAIL;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{	
				//------------------------------------------------------
				//--- get the needed informations
				//------------------------------------------------------
				
				//--- circulation form
				$arrForm = array();
				$strQuery = "SELECT * FROM cf_circulationform WHERE nID=$nCirculationId";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrForm = mysql_fetch_array($nResult);
					}
				}
				
				//------------------------------------------------------
				//--- update status in circulationprocess table
				//------------------------------------------------------				
				$sql = "select * from cf_circulationprocess where nCirculationFormId=$nCirculationId and nSlotId=$nSlotId and nUserId=$nUserId and nCirculationHistoryId=$nCirculationHistoryId";
				$rs = mysql_query($sql);
				if (mysql_num_rows($rs)==0) {
					if ($tsDateInProcessSince == '')
					{
						$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $TStoday, 0, 0, $nCirculationProcessId, $nCirculationHistoryId, 0, 0)";
						mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
					}
					else
					{
						//( `nID` , `nCirculationFormId` , `nSlotId`, `nUserId` , `dateInProcessSince` , `nDecissionState`, `dateDecission` , `nIsSubstitiuteOf` , `nCirculationHistoryId`)
						$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $tsDateInProcessSince, 0, 0, 0, $nCirculationHistoryId, 0, 0)";
						mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
					}
					$send_mail = true;
				}
				elseif ($force_send_mail || ($SEND_WORKFLOW_MAIL == true && $send_mail)) {
					$nID = mysql_result($rs, 0, 0);
					$sql = "update cf_circulationprocess set lastRemindTime = 0 WHERE nID=".$nID;
					mysql_query($sql, $nConnection) or die ($strQuery.mysql_error());
				//	$strQuery = "Insert into cf_mailentry values (null, $nUserId, $nCirculationId, $nSlotId, $nCirculationProcessId, $nCirculationHistoryId, $TStoday, 0, 0)";
				//	mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
				}
				return true;
			}
		}
		return false;
	}
	function remindUser()
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH;
		global $SYSTEM_REPLY_ADDRESS, $CUTEFLOW_VERSION, $TStoday, $objURL, $EMAIL_FORMAT, $EMAIL_VALUES, $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS;
		
		global $DEFAULT_CHARSET, $SEND_WORKFLOW_MAIL;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{	
				// Create the Transport
				if ($MAIL_SEND_TYPE == 'SMTP') {
					$transport = Swift_SmtpTransport::newInstance($SMTP_SERVER, $SMTP_PORT)
								->setUsername($SMTP_USERID)
								->setPassword($SMTP_PWD);
								
					if ($SMPT_ENCRYPTION != 'NONE') {
						$transport = $transport->setEncryption(strtolower($SMPT_ENCRYPTION));
					}
				}
				else if ($MAIL_SEND_TYPE == 'PHP') {
					$transport = Swift_MailTransport::newInstance();
				}
				else if ($MAIL_SEND_TYPE == 'MTA') {
					$transport = Swift_SendmailTransport::newInstance($MTA_PATH);
				}
				
				// Create the Mailer using the created Transport
				$mailer = Swift_Mailer::newInstance($transport);
				
				//------------------------------------------------------
				//--- get the needed informations
				//------------------------------------------------------
				$mail_entry = array(
					'normal' => array(),
					'remind' => array(),
					'press' => array(),
					'notify' => array()
					);
				$strQuery = "Select * from cf_circulationprocess where nDecissionState=0";
				$nResult = mysql_query($strQuery, $nConnection);
				if (mysql_num_rows($nResult) > 0)
				{
					while ($arrRow = mysql_fetch_array($nResult)) {
						$nSlotId = $arrRow['nSlotId'];
						$startTime = $arrRow['dateInProcessSince'];
						$lastRemindTime = $arrRow['lastRemindTime'];
						//get Slot remind setting
						$sql = "Select dueDate,doneTime,remindTime from cf_formslot where nID=".$nSlotId;
						$rs = mysql_query($sql);
						if (empty($rs) || mysql_num_rows($rs)==0) {
							continue;
						}
						$dueDate = mysql_result($rs, 0, 0);
						$doneTime = mysql_result($rs, 0, 1);
						if (false === strtotime($dueDate) || strcmp($dueDate, date('Y-m-d', $startTime))<0) {//绝对完成日期无效，或者早于开始日期
							$endTime = $startTime+$doneTime;//完成时间
						}
						elseif(0==$doneTime) {//预计完成时间无效
							$endTime = strtotime($dueDate)+86400;
						}
						else {
							$endTime = min(strtotime($dueDate)+86400, $startTime+$doneTime);
						}
						$remindTime = mysql_result($rs, 0, 2);
						if ($lastRemindTime==0) {
							//首次邮件通知
							//判断通知类型
							$sql = "Select * from cf_slottofield slotfield, cf_inputfield field where slotfield.nSlotId=".$nSlotId." and slotfield.nFieldId=field.nID and field.bReadOnly=0";
							$rs = mysql_query($sql);
							if (mysql_num_rows($rs)>0) {
								//有可编辑Field，需发送普通通知
								$mail_entry['normal'][] = $arrRow;
							}
							else {
								$mail_entry['notify'][] = $arrRow;
							}
						}
						else {
							$tmp = $lastRemindTime+round(($endTime-$lastRemindTime)*0.618);
							if (time()>=$tmp && time()<$endTime && time()-$lastRemindTime>86300) {//预提醒
								$time = $endTime-time();
								$mail_entry['remind'][] = array($time, $arrRow);
							}
							elseif ($remindTime>0 && time()>=$endTime && time()-$lastRemindTime+100>=$remindTime) && (date('G')>=9 && date('G')<18 && date('N')<=5)) {//后提醒
								//remindTime大于0，已超过完成时间，且距上次提醒时间已超过提醒间隔
								//100秒用于补足程序执行所耗时间
								$time = time() - $endTime;
								$mail_entry['press'][] = array($time, $arrRow);
							}
						}/*
						elseif (date('G')>=9 && date('G')<18 && date('N')<=5) {//非工作日不提醒
							//计算预提醒时间
							$tmp = $lastRemindTime+round(($endTime-$lastRemindTime)*0.618);
							if (time()>=$tmp && time()<$endTime) {//预提醒
								$mail_entry[] = $arrRow;
							}
							elseif ($remindTime>0 && time()>=$endTime && time()-$lastRemindTime+100>=$remindTime) {//后提醒
								//remindTime大于0，已超过完成时间，且距上次提醒时间已超过提醒间隔
								//100秒用于补足程序执行所耗时间
								$mail_entry[] = $arrRow;
							}
						}
						else {
							//nothing
						}*/
					}
				}
				if (empty($mail_entry)) {
					echo "No process to be reminded.\n";
				}
				foreach ($mail_entry as $type=>$entry_arr) {
					echo "Process ".$type." mail:\n";
					foreach ($entry_arr as $val) {
						if ('remind' == $type || 'press' == $type) {
							$time = $val[0];
							if ($time>=86400) {
								$unit = ' Day';
								$number = round($time/86400);
							}
							elseif ($time>=3600) {
								$unit = ' Hour';
								$number = round($time/3600);
							}
							elseif ($time>=60) {
								$unit = ' Minute';
								$number = round($time/60);
							}
							if ($number>1) {
								$unit .= 's';
							}
							$entry = $val[1];
						}
						else {
							$entry = $val;
						}
						echo "\tID: ".$entry['nID']."\t";
						$message = Swift_Message::newInstance()->setCharset($DEFAULT_CHARSET);
						$Circulation_cpid = $entry['nID'];
						$nUserId = $entry['nUserId'];
						$nCirculationId = $entry['nCirculationFormId'];
						$nSlotId = $entry['nSlotId'];
						$nCirculationHistoryId = $entry['nCirculationHistoryId'];
						
						//--- circulation form
						$arrForm = array();
						$strQuery = "SELECT * FROM cf_circulationform WHERE nID=".$nCirculationId;
						$nResult = mysql_query($strQuery, $nConnection);
						if ($nResult && mysql_num_rows($nResult) > 0) {
							$arrForm = mysql_fetch_array($nResult);
						}
						
						//--- circulation history
						$arrHistory = array();
						$strQuery = "SELECT * FROM cf_circulationhistory WHERE nID=".$nCirculationHistoryId;
						$nResult = mysql_query($strQuery, $nConnection);
						if ($nResult && mysql_num_rows($nResult) > 0) {
							$arrHistory = mysql_fetch_array($nResult);
						}
					
						//--- the attachments
						$strQuery = "SELECT * FROM cf_attachment WHERE nCirculationHistoryId=".$nCirculationHistoryId;
						$nResult = mysql_query($strQuery, $nConnection);
						if ($nResult && mysql_num_rows($nResult) > 0) {
							while ($arrRow = mysql_fetch_array($nResult))
							{
								$strFileName = basename($arrRow['strPath']);
								$mimetype = new mimetype();
								$filemime = $mimetype->getType($strFileName);
								$message->attach(Swift_Attachment::fromPath($arrRow["strPath"], $filemime)
										->setFilename($strFileName));
							}
						}
						//switching Email Format
						if ($nUserId != -2) {
							$strQuery = "SELECT * FROM `cf_user` WHERE nID = ".$nUserId;
						}
						else { // in this case the next user is the sender of this circulation
							$strQuery = "SELECT * FROM `cf_user` WHERE nID = ".$arrForm['nSenderId'];
						}
						$nResult = mysql_query($strQuery, $nConnection);
						if ($nResult) {
							$user = mysql_fetch_array($nResult, MYSQL_ASSOC);
							if (empty($user)) {
								continue;
							}
							$useGeneralEmailConfig = $user['bUseGeneralEmailConfig'];
							if (!$useGeneralEmailConfig) {
								$emailFormat	= $user['strEmail_Format'];
								$emailValues	= $user['strEmail_Values'];
							}
							else {
								$emailFormat	= $EMAIL_FORMAT;
								$emailValues	= $EMAIL_VALUES;
							}
							
							$Circulation_Name			= $arrForm['strName'];
							$Circulation_AdditionalText = nl2br($arrHistory['strAdditionalText']);
							
							//--- create mail
							require '../mail/mail_'.$emailFormat.$emailValues.'.inc.php';
							switch ($emailFormat) {
								case 'PLAIN':
									$message->setBody($strMessage, 'text/plain');
									break;
								case 'HTML':
									$message->setBody($strMessage, 'text/html');
									break;
							}
						}
						$strQuery = "Select strName from `cf_formslot` where nID=".$nSlotId;
						$nResult = mysql_query($strQuery, $nConnection);
						$slotName = mysql_result($nResult, 0, 0);
						
						$SYSTEM_REPLY_ADDRESS = str_replace (' ', '_', $SYSTEM_REPLY_ADDRESS);
						
						$message->setFrom(array($SYSTEM_REPLY_ADDRESS=>'AgigAFlow'));

						$prefix = '';
						switch ($type) {
							case 'normal':
								break;
							case 'remind':
								$prefix = '['.$number.$unit.' Left] ';
								break;
							case 'press':
								$prefix = '[Exceed Time Limit '.$number.$unit.'] ';
								break;
							case 'notify':
								$prefix = '[Notification] ';
								break;
							default :
								//
						}
						$message->setSubject($prefix.$MAIL_HEADER_PRE.'['.$arrForm["strName"].'] ['.$slotName.']');
						
						$message->setTo(array($user["strEMail"]));
						
						$result = $mailer->send($message);
						if ($result) {
							echo "Mail Sent\t";
							if ('notify' == $type) {
								$strQuery = "update cf_circulationprocess set nDecissionState=1, dateDecission='".$TStoday."', lastRemindTime=".time()." where nID=".$entry['nID'];
								if (mysql_query($strQuery, $nConnection)) {
									turnToNext($entry);
									echo "1<br />\n";
								}
							}
							else {
								$strQuery = "update cf_circulationprocess set lastRemindTime=".time()." where nID=".$entry['nID'];
								if (mysql_query($strQuery, $nConnection)) {
									echo "1<br />\n";
								}
							}
						}
						else {
							$fp = @fopen ("mail_delay.log", "a");
							if ($fp)
							{
								@fputs ($fp, date("d.m.Y", time())." - cf_circulationprocess.nID:".$entry['nID']."\n");
								fclose($fp);
							}
						}
					}
				}
			}
		}
		return true;
	}
	function turnToNext($arrProcessInfo) {
		global $nConnection;
		//-----------------------------------------------
		//--- send mail to next user in list
		//-----------------------------------------------
		$strQuery = "SELECT * FROM cf_mailinglist INNER JOIN cf_circulationform ON cf_mailinglist.nID = cf_circulationform.nMailingListId WHERE cf_circulationform.nID=".$arrProcessInfo["nCirculationFormId"];
		$nResult = mysql_query($strQuery, $nConnection);
		if ($nResult && mysql_num_rows($nResult) > 0) {
			$arrRow = mysql_fetch_array($nResult);
			$nListId = $arrRow[0];
		}

		$arrCirculationProcess 	= $arrProcessInfo;
		$nCirculationProcessId 	= $arrCirculationProcess['nID'];
		$nCirculationFormId 	= $arrCirculationProcess['nCirculationFormId'];
		$nSlotId			 	= $arrCirculationProcess['nSlotId'];
		$nUserId 				= $arrCirculationProcess['nUserId'];
		$nIsSubtituteOf	 		= $arrCirculationProcess['nIsSubstitiuteOf'];
		$nCirculationHistoryId 	= $arrCirculationProcess['nCirculationHistoryId'];
		$dateInProcessSince		= $arrCirculationProcess['dateInProcessSince'];
		
		// get the Position in current Slot
		$query 		= "SELECT nMailingListId FROM cf_circulationform WHERE nID = ".$nCirculationFormId." LIMIT 1;";
		$result 	= mysql_query($query, $nConnection);
		$arrResult 	= mysql_fetch_array($result, MYSQL_ASSOC);
		$nMailingListId = $arrResult['nMailingListId'];
		
		if ($nIsSubtituteOf == 0)  {	// the current user is no substitute
			$query 		= "SELECT * FROM cf_slottouser WHERE nSlotId = ".$nSlotId." AND nMailingListId = ".$nMailingListId." AND nUserId = ".$nUserId." LIMIT 1;";
			$result 	= mysql_query($query, $nConnection);
			$arrResult 	= mysql_fetch_array($result, MYSQL_ASSOC);
			if ($arrResult['nID'] == '') {
				// it's the sender of the circulation!!!
				$arrNextUsers = getNextUsersInList(-2, $nListId, $nSlotId, $nCirculationFormId, $nCirculationHistoryId);
			}
			else {
				//$arrNextUser = getNextUserInList($nUserId, $nListId, $nSlotId);
				$arrNextUsers = getNextUsersInList($nUserId, $nListId, $nSlotId, $nCirculationFormId, $nCirculationHistoryId);
			}
		}
		else {
			// user is a substitute
			// let's see who this substitute belongs to
			// it's NOT saved in "nIsSubstituteOf" -.-
			$strQuery 	= "SELECT nUserId FROM cf_circulationprocess WHERE nID = $nIsSubtituteOf";
			$result 	= mysql_query($strQuery, $nConnection);
			$arrResult 	= mysql_fetch_array($result, MYSQL_ASSOC);
			
			$nSubsUserId = $arrResult['nUserId'];
			
			$arrNextUsers = getNextUsersInList($nSubsUserId, $nListId, $nSlotId, $nCirculationFormId, $nCirculationHistoryId);
		}
	//	echo '<pre>$arrNextUsers<br />';var_dump($arrNextUsers);echo '</pre>';
		$sendMessageToSender = false;
		foreach ($arrNextUsers as $arrNextUser) {
			if ($arrNextUser[0] != "") {
				if ($arrNextUser[0] == -2) {
					// let's get the Sender User ID
					$objCirculation	= new CCirculation();
					$arrSender 		= $objCirculation->getSenderDetails($nCirculationFormId);
					$arrNextUser[0] = $arrSender['nID'];
				}
				
				sendToUserDelay($arrNextUser[0], $arrProcessInfo["nCirculationFormId"], $arrNextUser[1], 0, $arrProcessInfo["nCirculationHistoryId"]);
				
				if ($arrNextUser[2] !== false && $arrNextUser[2] != $nSlotId) {
					// Slot has changed
					// Send a notification if this is wished
					$strQuery = "SELECT * FROM cf_circulationform WHERE nID=".$arrProcessInfo["nCirculationFormId"];
					$nResult = mysql_query($strQuery, $nConnection);
					if ($nResult && mysql_num_rows($nResult) > 0)
					{
						$arrRow = mysql_fetch_array($nResult);

						$nSenderId		= $arrRow["nSenderId"];
						$strCircName	= $arrRow["strName"];
						$nEndAction		= $arrRow["nEndAction"];
					}
					
					$strQuery = "SELECT * FROM cf_formslot WHERE nID=".$nSlotId;
					$nResult = mysql_query($strQuery, $nConnection);
					if ($nResult && mysql_num_rows($nResult) > 0) {
						$arrRow = mysql_fetch_array($nResult);
						$slotname = $arrRow['strName'];
					}
					
					if ( ($nEndAction & 8) == 8 && !$sendMessageToSender) {
					//	echo 'sendMessageToSender1<br />';
						sendMessageToSenderDelay($nSenderId, $arrProcessInfo["nUserId"], "done", $strCircName, "ENDSLOT", $nCirculationProcessId, $slotname);
						$sendMessageToSender = true;
					}
				}
			}
			else {
				//--- send done email to sender if wanted
				$strQuery = "SELECT * FROM cf_circulationform WHERE nID=".$arrProcessInfo["nCirculationFormId"];
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult && mysql_num_rows($nResult) > 0)
				{
					$arrRow = mysql_fetch_array($nResult);

					$nEndAction		= $arrRow["nEndAction"];
					$nSenderId		= $arrRow["nSenderId"];
					$strCircName	= $arrRow["strName"];
						
					// check the hook CF_ENDACTION
					$circulation 	= new CCirculation();
					$endActions		= $circulation->getExtensionsByHookId('CF_ENDACTION');

					if ($endActions) {
						foreach ($endActions as $endAction) {
							$params		= $circulation->getEndActionParams($endAction);
							$hookValue	= (int) $params['hookValue'];
							if (($nEndAction & $hookValue) == $hookValue) {
								require $params['filename'];
							}
						}
					}
						
					$nShouldArchived 	= $nEndAction & 2;
					$nShouldMailed 		= $nEndAction & 1;
					$nShouldDeleted 	= 4;
						
					if ($nShouldMailed == 1) {
						//	echo 'sendMessageToSender2<br />';
						sendMessageToSenderDelay($nSenderId, $arrProcessInfo["nUserId"], "done", $strCircName, "SUCCESS", $nCirculationProcessId);
						$sendMessageToSender = true;
					}
						
					if ($nShouldArchived == 2) {
						// archive the circulation
						$strQuery = "UPDATE cf_circulationform SET bIsArchived=1 WHERE nID=".$arrProcessInfo["nCirculationFormId"];
						mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
					}
					elseif ($nShouldDeleted & $nEndAction) {
						// delete circulation
						$query = "UPDATE cf_circulationform SET bDeleted = 1 WHERE nID = ".$arrProcessInfo['nCirculationFormId'];
						mysql_query($query, $nConnection) or die ($query.mysql_error());
					}
				}
			}
		}
	}

	function sendMessageToSender($nSenderId, $nLastStationId, $strMessageFile, $strCirculationName, $strEndState, $Circulation_cpid, $slotname="")
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH, $MAIL_ENDACTION_DONE_REJECT, $MAIL_ENDACTION_DONE_SUCCESS;
		global $SYSTEM_REPLY_ADDRESS, $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CUTEFLOW_VERSION, $EMAIL_FORMAT;
		global $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION, $CIRCULATION_SLOTEND_MESSSAGE_SUCCESS, $MAIL_ENDACTION_DONE_ENDSLOT;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS, $objURL;
		
		global $DEFAULT_CHARSET;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{
				// Create the Transport
				if ($MAIL_SEND_TYPE == 'SMTP') {
					$transport = Swift_SmtpTransport::newInstance($SMTP_SERVER, $SMTP_PORT)
			  					->setUsername($SMTP_USERID)
			  					->setPassword($SMTP_PWD);
			  					
					if ($SMPT_ENCRYPTION != 'NONE') {
			  			$transport = $transport->setEncryption(strtolower($SMPT_ENCRYPTION));
			  		}
				}
				else if ($MAIL_SEND_TYPE == 'PHP') {
					$transport = Swift_MailTransport::newInstance();
				}
				else if ($MAIL_SEND_TYPE == 'MTA') {
					$transport = Swift_SendmailTransport::newInstance($MTA_PATH);
				}
			  					
			  	// Create the Mailer using the created Transport
				$mailer = Swift_Mailer::newInstance($transport);
				
				$mail_message = Swift_Message::newInstance()
									->setCharset($DEFAULT_CHARSET);
				
				//switching Email Format
				$strQuery	= "SELECT * FROM `cf_user` WHERE nID = $nSenderId;";
				$nResult	= mysql_query($strQuery, $nConnection) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $strQuery . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());

	    		$user					= mysql_fetch_array($nResult, MYSQL_ASSOC);
	    		
	    		$useGeneralEmailConfig	= $user['bUseGeneralEmailConfig'];
	    		
	    		if (!$useGeneralEmailConfig)
	    		{
		    		$emailFormat	= $user['strEmail_Format'];
	    		}
	    		else
	    		{
		    		$emailFormat	= $EMAIL_FORMAT;
	    		}
		    		   	
    			require_once '../mail/mail_'.$emailFormat.'_done.inc.php';					
	    					
				switch ($emailFormat)
				{
					case PLAIN:
						$mail_message->setBody($strMessage, 'text/plain');
						break;
					case HTML:
						$mail_message->setBody($strMessage, 'text/html');
						break;
    			}	
	    		
				$mail_message->setFrom(array($SYSTEM_REPLY_ADDRESS=>'AgigAFlow'));
				eval ("\$strEndSubject = \"\$MAIL_ENDACTION_DONE_$strEndState\";");
				
				$mail_message->setSubject($MAIL_HEADER_PRE.'['.$strCirculationName.'] ['.$slotname.'] '.$strEndSubject);
				
				$mail_message->setTo(array($user["strEMail"]));
				$result = $mailer->send($mail_message);
				if (!$result)
				{
					$fp = @fopen ("mailerror.log", "a");
					if ($fp)
					{
						@fputs ($fp, date("d.m.Y", time())." - sendToUser\n");
						fclose($fp);
					}
				}
				else
				{
					return true;
				}
			}
		}
	}
	function sendMessageToSenderDelay($nSenderId, $nLastStationId, $strMessageFile, $strCirculationName, $strEndState, $Circulation_cpid, $slotname="")
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH, $MAIL_ENDACTION_DONE_REJECT, $MAIL_ENDACTION_DONE_SUCCESS;
		global $SYSTEM_REPLY_ADDRESS, $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CUTEFLOW_VERSION, $EMAIL_FORMAT;
		global $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION, $CIRCULATION_SLOTEND_MESSSAGE_SUCCESS, $MAIL_ENDACTION_DONE_ENDSLOT;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS, $objURL;
		
		global $DEFAULT_CHARSET;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{
				$strQuery = "Insert into cf_mailToSender values (null, ".$nSenderId.", '".addslashes($strCirculationName)."', '".$strEndState."', ".$Circulation_cpid.", '".addslashes($slotname)."', ".time().", 0, 0)";
				mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
			}
		}
	}
	function MailToSenderDelay()
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH, $MAIL_ENDACTION_DONE_REJECT, $MAIL_ENDACTION_DONE_SUCCESS;
		global $SYSTEM_REPLY_ADDRESS, $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CUTEFLOW_VERSION, $EMAIL_FORMAT;
		global $MAIL_SEND_TYPE, $MTA_PATH, $SMPT_ENCRYPTION, $CIRCULATION_SLOTEND_MESSSAGE_SUCCESS, $MAIL_ENDACTION_DONE_ENDSLOT;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS, $objURL;
		
		global $DEFAULT_CHARSET;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{
				// Create the Transport
				if ($MAIL_SEND_TYPE == 'SMTP') {
					$transport = Swift_SmtpTransport::newInstance($SMTP_SERVER, $SMTP_PORT)
			  					->setUsername($SMTP_USERID)
			  					->setPassword($SMTP_PWD);
			  					
					if ($SMPT_ENCRYPTION != 'NONE') {
			  			$transport = $transport->setEncryption(strtolower($SMPT_ENCRYPTION));
			  		}
				}
				else if ($MAIL_SEND_TYPE == 'PHP') {
					$transport = Swift_MailTransport::newInstance();
				}
				else if ($MAIL_SEND_TYPE == 'MTA') {
					$transport = Swift_SendmailTransport::newInstance($MTA_PATH);
				}
			  					
			  	// Create the Mailer using the created Transport
				$mailer = Swift_Mailer::newInstance($transport);
				
				$mail_entry = array();
				$strQuery = "select * from cf_mailToSender where bStatus=0";
				$nResult = mysql_query($strQuery, $nConnection);
				if (mysql_num_rows($nResult) > 0)
				{
					while ($arrRow = mysql_fetch_array($nResult)) {
						$nID = $arrRow['nID'];
						echo "Process ID: ".$nID."\t";
						$nSenderId = $arrRow['nSenderId'];
						$strCirculationName = $arrRow['strCirculationName'];
						$strEndState = $arrRow['strEndState'];
						$Circulation_cpid = $arrRow['nCPId'];
						$strSlotName = $arrRow['strSlotName'];
						$mail_message = Swift_Message::newInstance()->setCharset($DEFAULT_CHARSET);
						//switching Email Format
						$strQuery	= "SELECT * FROM `cf_user` WHERE nID =".$nSenderId;
						$nResult	= mysql_query($strQuery, $nConnection) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $strQuery . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
						$user = mysql_fetch_array($nResult, MYSQL_ASSOC);
	    				$useGeneralEmailConfig	= $user['bUseGeneralEmailConfig'];
	    				if (!$useGeneralEmailConfig)
	    				{
		    				$emailFormat	= $user['strEmail_Format'];
	    				}
	    				else
	    				{
		    				$emailFormat	= $EMAIL_FORMAT;
	    				}
		    			require '../mail/mail_'.$emailFormat.'_done.inc.php';
	    				switch ($emailFormat)
						{
							case PLAIN:
								$mail_message->setBody($strMessage, 'text/plain');
								break;
							case HTML:
								$mail_message->setBody($strMessage, 'text/html');
								break;
    					}
	    				$mail_message->setFrom(array($SYSTEM_REPLY_ADDRESS=>'AgigAFlow'));
						eval ("\$strEndSubject = \"\$MAIL_ENDACTION_DONE_$strEndState\";");
						$strSubject = $MAIL_HEADER_PRE.'['.$strCirculationName.'] ';
						if (!empty($strSlotName)) {
							$strSubject .= '['.$strSlotName.'] ';
						}
						$strSubject .= $strEndSubject;
						$mail_message->setSubject($strSubject);
				
						$mail_message->setTo(array($user["strEMail"]));
						$result = $mailer->send($mail_message);
						if ($result)
						{
							echo "Mail Sent\t";
							$strQuery = "update cf_mailToSender set timeSend=".time().",bStatus=1 where nID=".$nID;
							if (mysql_query($strQuery, $nConnection)) {
								echo "1<br />\n";
							}
						}
						else {
							$fp = @fopen ("mailToSender.log", "a");
							if ($fp)
							{
								@fputs ($fp, date("d.m.Y", time())." - mailToSender.nID:".$nID."\n");
								fclose($fp);
							}
						}
					}
				}
				else {
					echo "No mail to send\n";
				}
			}
		}
	}
?>