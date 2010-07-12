<?php
	include_once ("../config/config.inc.php");
	include_once ("../language_files/language.inc.php");
	include_once ("../pages/version.inc.php");
	$CurLang = $_REQUEST["language"];
	
	
$strParams					= 'cpid='.$Circulation_cpid.'&language='.$CurLang;
$strEncyrptedParams			= $objURL->encryptURL($strParams);
$strEncryptedBrowserview	= $CUTEFLOW_SERVER.'/pages/editworkflow_standalone.php?key='.$strEncyrptedParams;

$strMessage_TOP = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
	<title></title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$DEFAULT_CHARSET\">
	<style>
		body, table, td, tr
		{
			font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
			font-size: 9pt;
		}
		a
		{
			font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
			font-size: 9pt;
			text-decoration: none;
		}
		a:hover
		{ text-decoration: underline; }
		.BorderRed
		{ border: 1px solid Red; }
		.BorderGray
		{ border: 1px solid Gray; }
		.FormInput
		{
			font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
			font-size: 8pt;
			border: 1px solid #B8B8B8;
		}
		.Button
		{
			font-size: 8pt;
			border: 1px solid #C10000;
			color: Black;
			padding: 2px 2px 2px 2px;
		}
		.note
		{
			padding-left : 2px;
			padding-top  : 2px;
			border-width : 1px;
			border-color : #B0B0AF;
			border-style : solid;
			background-color: #FCFBE9;
			font-size: 8pt;
		}
		.table_header
		{
			background-color: #8e8f90; 
			color: #fff; 
			font-size: 12px; 
			font-weight: bold;
		}
		.mandatory
		{ font-weight: bold; }
	</style>
</head>
<body bgcolor=\"#ffffff\">
	<br>
	<br>
	<div align=\"center\">
		
		<table width=\"620\" style=\"border: 1px solid #c8c8c8; background: #efefef;\" cellspacing=\"0\" cellpadding=\"3\">
			<tr>
				<td colspan=\"2\" align=\"left\" class=\"table_header\">
					$MAIL_HEADER_PRE $strCirculationName
				</td>
			</tr>
			<tr>
				<td colspan=\"2\">
					<br><br>
				</td>
			</tr>
			<tr>
				<td colspan=\"2\" style=\"border-top:1px solid Gray;\" height=\"10px\">&nbsp;</td>
			</tr>
			<tr>";
			
			
switch ($strEndState)
{
	case '0':
		$strMessage_BOTTOM = "<td><img src=\"$CUTEFLOW_SERVER/images/state_stop.png\" border=\"0\" /></td>
					<td align=\"left\">
						$CIRCULATION_DONE_MESSSAGE_REJECT
					</td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
				<td  colspan=\"2\" class=\"note\" style=\"background-color:white;\">
				<a href=\"$strEncryptedBrowserview\">$EMAIL_BROWSERVIEW</a>
				</td>
				</tr>
				</table>
	
			<br><br>
			<img src=\"$CUTEFLOW_SERVER/images/agiga.jpg\" border=\"0\" /><br>
			<strong style=\"font-size:8pt;font-weight:normal\">Version $CUTEFLOW_VERSION</strong><br>
				
		</div>
		</body>
		</html>";
		break;
	case 'REJECT':
		$strMessage_BOTTOM = "<td><img src=\"$CUTEFLOW_SERVER/images/state_stop.png\" border=\"0\" /></td>
					<td align=\"left\">
						$CIRCULATION_DONE_MESSSAGE_REJECT
					</td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
				<td  colspan=\"2\" class=\"note\" style=\"background-color:white;\">
				<a href=\"$strEncryptedBrowserview\">$EMAIL_BROWSERVIEW</a>
				</td>
				</tr>
				</table>
	
			<br><br>
			<img src=\"$CUTEFLOW_SERVER/images/agiga.jpg\" border=\"0\" /><br>
			<strong style=\"font-size:8pt;font-weight:normal\">Version $CUTEFLOW_VERSION</strong><br>
				
		</div>
		</body>
		</html>";
		break;
	case 'SUCCESS':
		$strMessage_BOTTOM = "<td><img src=\"$CUTEFLOW_SERVER/images/state_ok.png\" border=\"0\" /></td>
				<td align=\"left\">
					$CIRCULATION_DONE_MESSSAGE_SUCCESS
				</td>
			</tr>
			<tr><td><br></td></tr>
			<tr>
				<td  colspan=\"2\" class=\"note\" style=\"background-color:white;\">
				<a href=\"$strEncryptedBrowserview\">$EMAIL_BROWSERVIEW</a>
				</td>
			</tr>
			</table>

			<br><br>
			<img src=\"$CUTEFLOW_SERVER/images/agiga.jpg\" border=\"0\" /><br>
			<strong style=\"font-size:8pt;font-weight:normal\">Version $CUTEFLOW_VERSION</strong><br>
				
		</div>
		</body>
		</html>";
		break;
	case 'ENDSLOT':
		$strMessage_BOTTOM = "<td><img src=\"$CUTEFLOW_SERVER/images/state_ok.png\" border=\"0\" /></td>
				<td align=\"left\">
					$CIRCULATION_SLOTEND_MESSSAGE_SUCCESS: $slotname
				</td>
			</tr>
			<tr><td><br></td></tr>
			<tr>
				<td  colspan=\"2\" class=\"note\" style=\"background-color:white;\">
				<a href=\"$strEncryptedBrowserview\">$EMAIL_BROWSERVIEW</a>
				</td>
			</tr>
			</table>

			<br><br>
			<img src=\"$CUTEFLOW_SERVER/images/agiga.jpg\" border=\"0\" /><br>
			<strong style=\"font-size:8pt;font-weight:normal\">Version $CUTEFLOW_VERSION</strong><br>
				
		</div>
		</body>
		</html>";
		break;
}
$strMessage = $strMessage_TOP.$strMessage_BOTTOM;
?>