<script language="javascript">
function check()
{
	if(window.document.board.username.value=="")
	{
		alert("����д�����ǳƣ�");
		document.board.username.focus();
		return false;
	}
	if(window.document.board.email.value!="" && !ismail(window.document.board.email.value))
	{
		alert("����E-Mail��ַ�Ƿ���");
		document.board.email.focus();
		return false;
	}

	if(window.document.board.content.value=="")
	{
		alert("������д��������");
		document.board.content.focus();
		return false;
	}
	return true;
}
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
</script>

<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>��������</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<div>��������</a>
<div> �� �� :<input type=text name="username" size=20><input type="checkbox" onclick="if(this.checked)document.board.username.value='����';else document.board.username.value='';">����</div>
<div>E-Mail:<input type="text" name="email" size=20>(������⹫��)</div>
<div> �� �� :<input type="text" name="title" size=20></div>
<div>�� �� :<textarea name="content" rows=6 cols=40></textarea></div>
<div style="padding-left:3em;"><input type="submit" value="�ύ">&nbsp;&nbsp;<input type="reset" value="��д">&nbsp;&nbsp;<button onclick="javascript:location='index.php'">����</button></div>
</form>
</body>
</html>