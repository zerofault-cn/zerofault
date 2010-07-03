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
	
	include_once ("../language_files/language.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
	<title></title>	
	<link rel="stylesheet" href="format.css" type="text/css">
	<script language="JavaScript">
	<!--
		function validate(objForm)
		{
			var objForm = document.forms["EditSlot"];
			objForm.strName.required = 1;
			objForm.strName.err = "<?php echo $FIELD_NEW_ERROR_NAME;?>";
			
			bResult = jsVal(objForm);
			
			return bResult;
		}
	//-->
	</script>
	<script src="jsval.js" type="text/javascript" language="JavaScript"></script>	
</head>
<?php
	$strName = "";
	$nSendType = 0;
	
	include_once ("../config/config.inc.php");

	if (-1 != $_REQUEST['$slotid'])
	{
    	//--- open database
    	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
    	
    	if ($nConnection)
    	{
    		//--- get maximum count of users
    		if (mysql_select_db($DATABASE_DB, $nConnection))
    		{
    			//--- read the values of the user
				$strQuery = "SELECT * FROM cf_formslot WHERE nID = ".$_REQUEST["slotid"];
				$nResult = mysql_query($strQuery, $nConnection);
        
        		if ($nResult)
        		{
        			if (mysql_num_rows($nResult) > 0)
        			{
        				$arrRow = mysql_fetch_array($nResult);
        				$strName = $arrRow["strName"];
        				$nSendType = $arrRow["nSendType"];

						$time1 = $arrRow['doneTime'];
						if ($time1%86400 == 0) {
							$unit1 = 'day';
							$number1 = $time1/86400;
						}
						elseif ($time1%3600 == 0) {
							$unit1 = 'hour';
							$number1 = $time1/3600;
						}

						$time2 = $arrRow['remindTime'];
						if ($time2%86400 == 0) {
							$unit2 = 'day';
							$number2 = $time2/86400;
						}
						elseif ($time2%3600 == 0) {
							$unit2 = 'hour';
							$number2 = $time2/3600;
						}
						elseif ($time2%60 == 0) {
							$unit2 = 'minute';
							$number2 = $time2/60;
						}
        			}
        		}
    		}
    	}
	}
	else {
		$number1 = 1;
		$number2 = 0;
		$unit2 = 'hour';
	}
?>
<body><br>
<span style="font-size: 14pt; color: #ffa000; font-family: Verdana; font-weight: bold;">
	<?php echo $MENU_TEMPLATE;?>
</span><br><br>

	<form action="writeslot.php" id="EditSlot" name="EditSlot" onsubmit="return validate(this);">
		<table width="620" style="border: 1px solid #c8c8c8;" cellspacing="0" cellpadding="3">
			<tr>
				<td class="table_header" colspan="2">
					<?php echo $SLOT_EDIT_HEADLINE;?>
				</td>
			</tr>
			<tr><td height="10"></td></tr>
            <tr>
				<td width="200"><?php echo $SLOT_EDIT_NAME;?></td>
				<td><input id="strName" Name="strName" type="text" class="InputText" style="width:250px;" value="<?php echo $strName;?>"></td>
			</tr>
			<!-- <tr>
				<td width="200" valign="top"><?php echo $SLOT_EDIT_SEND_TYPE;?></td>
				<td valign="top"><input disabled id="nSendType" Name="nSendType" type="checkbox" <?php echo $nSendType == 1 ? "checked" : ""; ?>></td>
			</tr> -->
			<tr>
				<td>Description: </td>
				<td><textarea name="description" cols="40" rows="3"><?php echo $arrRow['strDescr'];?></textarea></td>
			<tr>
				<td >Expected completion time: </td>
				<td><input type="text" name="number1" value="<?php echo $number1;?>" size="3" />
					<select name="unit1">
						<option value="day" <?php if($unit1 == 'day')echo 'selected="selected"';?> >Days</option>
						<option value="hour" <?php if($unit1 == 'hour')echo 'selected="selected"';?>>Hours</option>
					</select> (Integer number only)
				</td>
			</tr>
			<tr>
				<td >Reminder timespan: </td>
				<td><input type="text" name="number2" value="<?php echo $number2;?>" size="3" />
					<select name="unit2">
						<option value="day" <?php if($unit2 == 'day')echo 'selected="selected"';?> >Days</option>
						<option value="hour"  <?php if($unit2 == 'hour')echo 'selected="selected"';?> >Hours</option>
						<option value="minute" <?php if($unit2 == 'minute')echo 'selected="selected"';?> >Minutes</option>
					</select> (Integer number only, 0 : don't remind)
				</td>
			</tr>
			<tr><td height="10"></td></tr>
		</table>
		<table cellspacing="0" cellpadding="3" align="left" width="620">
		<tr>
			<td align="left">
				<input type="button" class="Button" value="<?php echo $BTN_CANCEL;?>" onclick="history.back()">
			</td>
			<td align="right">
				<input type="submit" value="<?php echo $USER_EDIT_ACTION;?>" class="Button">
			</td>
		</tr>
		</table>
	<input type="hidden" value="<?php echo $_REQUEST["templateid"];?>" id="templateid" name="templateid">
	<input type="hidden" value="<?php echo $_REQUEST["slotid"];?>" id="slotid" name="slotid">
	<input type="hidden" value="<?php echo $_REQUEST["language"];?>" id="language" name="language">
	<input type="hidden" value="<?php echo $_REQUEST["sort"];?>" id="sort" name="sort">
	<input type="hidden" value="<?php echo $_REQUEST["start"];?>" id="start" name="start">
	</form>
</body>
</html>

<?php
	function echoCheckedReadOnly($bReadOnly)
	{
		if ($bReadOnly == 1)
		{
			echo "CHECKED";	
		}	
	}
?>