<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>��Ӽ�¼</title>
<link rel="stylesheet" href="../style.css" type="text/css">

<script language="javascript">
function check()
{
	if(window.document.soft.filepath.value=="")
	{
		alert("��������������");
		document.soft.filepath.focus();
		return false;
	}
	
	if(window.document.soft.name.value=="")
	{
		alert("������дname");
		document.soft.name.focus();
		return false;
	}
	if(window.document.soft.type.value=="")
	{
		alert("������ѡ������");
		document.soft.type.focus();
		return false;
	}
	return true;
}
</script>

</head>
<body>
<h2>������</h2>
<form method=post action="addsoft_2.php" name=soft onsubmit="return check();">
���·��:<input type=file name=filepath size=50><br>
&nbsp;&nbsp;�����:<input type=text name=name size=20>
����:
<select name="type">
<option>ѡ��</option>
	<option value=��������>��������</option>
	<option value=�������>�������</option>
	<option value=��������>��������</option>
	<option value=���Ӵʵ�>���Ӵʵ�</option>
	<option value=ý�岥��>ý�岥��</option>
	<option value=��Ļ����>��Ļ����</option>
	<option value=��������>��������</option>
	<option value=���뷨>���뷨</option>
	<option value=ͼ��ͼ��>ͼ��ͼ��</option>
	<option value=���繤��>���繤��</option>
	<option value=��ҳ����>��ҳ����</option>
	<option value=�ı��༭>�ı��༭</option>
	<option value=ϵͳ����>ϵͳ����</option>
	<option value=ϵͳ���>ϵͳ���</option>
	<option value=�������>�������</option>
	<option value=��Ϸ����>��Ϸ����</option>
	<option value=Դ����>Դ����</option></select>
<br>
���˵��:<textarea name=info rows=15 cols=56></textarea><br>
<input type="submit" value="�ύ">
</form>



</body>
</html>