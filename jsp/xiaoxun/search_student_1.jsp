<%@ page language="java" import="java.sql.*" %>

<script language="javascript">
function check()
{
	if(window.document.search.keyword.value=="")
	{
		alert("�����������ѯ�ؼ���");
		document.search.keyword.focus();
		return false;
	}
	return true;
}
</script>

<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>��ѯѧ������</caption>
<form action="index.jsp?content=search_student_2" method=post name=search onsubmit="return check()">
<tr><td align=right>��ѯ��ʽ:</td><td><input type=radio name=search_type value=id>����<input type=radio name=search_type value=sname checked>ѧ������</td></tr>
<tr><td align=right>����ؼ���:</td><td><input type=text name=keyword></td></tr>
<tr><td></td><td><input type=submit value="��ѯ"></td></tr>
</form>
</table>

</center>
