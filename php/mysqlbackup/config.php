<?php
	require("copyleft.env");
	echo "<html><head><title>".$ver.$copyleft."</title>";
	
	if(($dbhost!="") && ($dbusername!="") & ($dbpassword!=""))
	{
		$fp=fopen("connect.php","w");
		fwrite($fp,"<?php\n");
		if($dbport)
		{
			$dbhost=$dbhost.":".$dbport;
		}
		fwrite($fp,"\$dbhost=\"$dbhost\";\n");
		fwrite($fp,"\$dbusername=\"$dbusername\";\n");
		fwrite($fp,"\$dbpassword=\"$dbpassword\";\n");
		fwrite($fp,"\$con=mysql_pconnect(\$dbhost,\$dbusername,\$dbpassword) or die(\"Could not connect to MySQL Server!\");\n");
		fwrite($fp,"\$dbbackdir=\"$dbbackdir\";\n");
		fwrite($fp,"?>");
		fclose($fp);
		
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
		echo "<div align=center>�����ļ��Ѿ����ɣ��ȴ�3����Զ�ת����ҳ��</div>";
		echo "<meta http-equiv=REFRESH content=\"3;URL=index.php\">";
		echo "<br><div align=center>���ߵ��<a href=\"index.php\">����</a>����</div>";
	
		exit;
	}
?>
  <meta http-equiv="Content-Type" content="text/html; charset=GB18030">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body>
<p><p>
<h3 align="center">���������ӵ����ݿ�������Ϣ��</h3>
<center>
<form action="config.php" method="post">
	<table width="500">
		<tr>
			<td align="right" width="200">���ݿ���������</td>
			<td width="100"><input type="text" name="dbhost"></td>
			<td align="right" width="200">������д</td>
		</tr>
		<tr>
			<td align="right" width="200">���ݿ��û�����</td>
			<td width="100"><input type="text" name="dbusername"></td>
			<td align="right" width="200">������д</td></tr>
		<tr>
			<td align="right" width="200">�û������룺</td>
			<td width="100"><input type="password" name="dbpassword"></td>
			<td align="right" width="200">������д</td>
		</tr>
		<tr>
			<td align="right" width="200">�������ݿ�Ķ˿ڣ�</td>
			<td width="100"><input type="text" name="dbport"></td>
			<td align="right" width="200">ѡ����д</td>
		</tr>
		<tr>
			<td align="right" width="200">���ݿⱸ��Ŀ¼��</td>
			<td width="100"><input type="text" name="dbbackdir" value="./data"></td>
			<td align="right" width="200">ѡ����д</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr><td colspan="3" align="center"><input type="submit" value="�ύ"></td></tr>
	</table>
</form>
</body>
</html>
