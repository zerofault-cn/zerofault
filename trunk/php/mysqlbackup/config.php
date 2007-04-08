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
		echo "<div align=center>配置文件已经生成，等待3秒后将自动转自首页。</div>";
		echo "<meta http-equiv=REFRESH content=\"3;URL=index.php\">";
		echo "<br><div align=center>或者点击<a href=\"index.php\">这里</a>返回</div>";
	
		exit;
	}
?>
  <meta http-equiv="Content-Type" content="text/html; charset=GB18030">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body>
<p><p>
<h3 align="center">请输入连接到数据库的相关信息：</h3>
<center>
<form action="config.php" method="post">
	<table width="500">
		<tr>
			<td align="right" width="200">数据库主机名：</td>
			<td width="100"><input type="text" name="dbhost"></td>
			<td align="right" width="200">必须填写</td>
		</tr>
		<tr>
			<td align="right" width="200">数据库用户名：</td>
			<td width="100"><input type="text" name="dbusername"></td>
			<td align="right" width="200">必须填写</td></tr>
		<tr>
			<td align="right" width="200">用户的密码：</td>
			<td width="100"><input type="password" name="dbpassword"></td>
			<td align="right" width="200">必须填写</td>
		</tr>
		<tr>
			<td align="right" width="200">连接数据库的端口：</td>
			<td width="100"><input type="text" name="dbport"></td>
			<td align="right" width="200">选择填写</td>
		</tr>
		<tr>
			<td align="right" width="200">数据库备份目录：</td>
			<td width="100"><input type="text" name="dbbackdir" value="./data"></td>
			<td align="right" width="200">选择填写</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr><td colspan="3" align="center"><input type="submit" value="提交"></td></tr>
	</table>
</form>
</body>
</html>
