
<html>
<head>
<title>Flash upload</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<center>
<form name="form1" enctype="multipart/form-data" action="upload_do.jsp" method="post">
<table width="720" cellpadding="0" cellspacing="0" border="1" bordercolor="#d0dce0">
<caption>FLASH�ϴ�</caption>
<tr>
	<td>ѡ���ļ�</td>
	<td><input type="file" name="flash_file"></td>
</tr>
<tr>
	<td>����</td>
	<td><input type="text" name="title"></td>
</tr>
<tr>
	<td>�ϴ���</td>
	<td><input type="text" name="user"></td>
</tr>
<tr>
	<td>����</td>
	<td><textarea name="descr" cols="40" rows="5"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="�ύ">&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="javascript:history.go(-1)">����</button></td>
</tr>
</table>
</form>

</center>
</body>
</html>
