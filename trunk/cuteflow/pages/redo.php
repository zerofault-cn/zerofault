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
	
	require_once '../config/config.inc.php';
	require_once '../language_files/language.inc.php';
	require_once '../config/db_connect.inc.php';
	require_once '../lib/datetime.inc.php';
	require_once 'send_circulation.php';
	
	$nCirculationFormId 	= strip_tags($_REQUEST['circid']);
	$nCirculationProcessId 	= strip_tags($_REQUEST['cpid']);
	
	// get all entries from the current circulation process
	$strQuery 	= "SELECT * FROM cf_circulationprocess WHERE nID = '$nCirculationProcessId'";
	$nResult 	= mysql_query($strQuery);
	
	if ($nResult)
	{
		$arrCPResult = mysql_fetch_array($nResult, MYSQL_ASSOC);
	}
	

	$nCirculationHistoryId 	= $arrCPResult['nCirculationHistoryId'];
	$nCirculationFormId		= $arrCPResult['nCirculationFormId'];
	$nSlotId 				= $arrCPResult['nSlotId'];
	$nUserId				= $arrCPResult['nUserId'];
	
	// set current user state to "in process"
	$strQuery = "	UPDATE cf_circulationprocess SET dateInProcessSince=".time().", dateDecission=0, nDecissionState = 0, lastRemindTime=0 WHERE nID = ".$nCirculationProcessId;
	mysql_query($strQuery, $nConnection);

?>
<html>
<head>
	<?php 
		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$DEFAULT_CHARSET."\" />";
		$saved=true;
	?>
	<script src="../lib/RPL/Encryption/aamcrypt.js" type="text/javascript" language="JavaScript"></script>
	<script src="../lib/RPL/Encryption/boxes.js?<?php echo time();?>" type="text/javascript" language="JavaScript"></script>
	<script language="JavaScript">
	<!--
		function siteLoaded()
		{
			var strParams	= "circid=<?php echo $_REQUEST["circid"];?>&language=<?php echo $_REQUEST["language"];?>&sortby=<?php echo $_REQUEST["sortby"];?>&start=<?php echo $_REQUEST["start"];?>";
			inpdata	= strParams;
			encodeblowfish();
			location.href = "circulation_detail.php?key=" + outdata;
		}
	//-->
	</script>
</head>
<body onLoad="siteLoaded()">
</body>
</html>