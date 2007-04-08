<%@ page language="java" import="java.sql.*" %>

<script language="javascript">
function check()
{
	if(window.document.search.keyword.value=="")
	{
		alert("您忘了输入查询关键字");
		document.search.keyword.focus();
		return false;
	}
	return true;
}
</script>

<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>查询学生资料</caption>
<form action="index.jsp?content=search_student_2" method=post name=search onsubmit="return check()">
<tr><td align=right>查询方式:</td><td><input type=radio name=search_type value=id>卡号<input type=radio name=search_type value=sname checked>学生姓名</td></tr>
<tr><td align=right>输入关键字:</td><td><input type=text name=keyword></td></tr>
<tr><td></td><td><input type=submit value="查询"></td></tr>
</form>
</table>

</center>
