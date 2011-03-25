<?php
require_once '../lib/swift/swift_required.php';

include_once ("../lib/datetime.inc.php");	
include_once ("../config/config.inc.php");
include_once ("../pages/version.inc.php");
include_once ("../language_files/language.inc.php");

// Create the Transport
if ($MAIL_SEND_TYPE == 'SMTP') {
	$transport = Swift_SmtpTransport::newInstance($SMTP_SERVER, $SMTP_PORT)->setUsername($SMTP_USERID)->setPassword($SMTP_PWD);

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

$message = Swift_Message::newInstance()->setCharset($DEFAULT_CHARSET);

//--- the attachments
$strQuery = "SELECT * FROM cf_attachment WHERE nCirculationHistoryId=".$_REQUEST['historyid'];
$nResult = mysql_query($strQuery, $nConnection);
if (mysql_num_rows($nResult) > 0){
	while ($arrRow = mysql_fetch_array($nResult)) {
		$strFileName = basename($arrRow['strPath']);
		$mimetype = new mimetype();
		$filemime = $mimetype->getType($strFileName);
		$message->attach(Swift_Attachment::fromPath($arrRow["strPath"], $filemime)->setFilename($strFileName));
	}
}

//--- circulation history
$arrHistory = array();
$strQuery = "SELECT * FROM cf_circulationhistory WHERE nID=".$_REQUEST['historyid'];
$nResult = mysql_query($strQuery, $nConnection);
$arrHistory = mysql_fetch_array($nResult);

$arrForm = array();
$strQuery = "SELECT * FROM cf_circulationform WHERE nID=".$arrHistory['nCirculationFormId'];
$nResult = mysql_query($strQuery, $nConnection);
$arrForm = mysql_fetch_array($nResult);


$Circulation_Name	= $arrForm['strName'];
$Circulation_AdditionalText = str_replace("\n", "<br>", $arrHistory['strAdditionalText']);

$nCirculationId = $arrHistory['nCirculationFormId'];
$emailFormat = 'HTML';
$emailValues = 'VALUES';



//get users in process
$sql = "Select cf_circulationprocess.nSlotId,cf_user.strEMail,cf_user.strFirstName from cf_user,cf_circulationprocess where cf_user.nID=cf_circulationprocess.nUserId and cf_circulationprocess.nDecissionState=0 and cf_circulationprocess.nCirculationHistoryId=".$_REQUEST['historyid'];
$rs = mysql_query($sql);
$i = 0;
while ($row = mysql_fetch_assoc($rs)) {
	$nSlotId = $row['nSlotId'];
	if ($i==0) {
		$message->setTo(array($row["strEMail"]=>$row['strFirstName']));
	}
	else {
		$message->addTo($row["strEMail"], $row['strFirstName']);
	}
	$i++;
	
}
//print_r($message->getTo());
//exit;
require '../mail/mail_'.$emailFormat.$emailValues.'.inc.php';
switch ($emailFormat) {
	case PLAIN:
		$message->setBody($strMessage, 'text/plain');
		break;
	case HTML:
		$message->setBody($strMessage, 'text/html');
		break;
}
$message->setFrom(array($SYSTEM_REPLY_ADDRESS=>'AgigAFlow'));
if ($act == 'pause') {
	$subject = '[Flow Paused] Circulation: '.$arrForm["strName"];
}
elseif ('start' == $act) {
	$subject = '[Flow Started] Circulation: '.$arrForm["strName"];
}
$message->setSubject($subject);

//get maillist ID
$sql = "Select nMailingListId from cf_circulationform where nID=".$arrHistory['nCirculationFormId'];
$rs = mysql_query($sql);
$nMailingListId = mysql_result($rs, 0, 0);

//get user
$sql = "Select distinct cf_user.strEMail,cf_user.strFirstName from cf_user,cf_slottouser where cf_user.nID=cf_slottouser.nUserId and cf_slottouser.nMailingListId=".$nMailingListId;
$rs = mysql_query($sql);
$i = 0;
while ($row = mysql_fetch_assoc($rs)) {
	if ($i == 0) {
		$message->setCc($row["strEMail"], $row['strFirstName']);
	}
	else {
		$message->addCc($row["strEMail"], $row['strFirstName']);
	}
	$i++;
}

$result = $mailer->send($message);
if (!$result) {
	$fp = @fopen ("mailerror.log", "a");
	@fputs ($fp, date("Y/m/d H:i:s")." - sendToUser fail\r\n");
	fclose($fp);
}
else {
	echo 'success';
}
?>