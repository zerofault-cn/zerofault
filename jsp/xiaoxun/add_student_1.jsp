<%@ page language="java" import="java.sql.*" %>
<script language="javascript">
function check()
{
	if(window.document.add.id.value=="")
	{
		alert("您忘了输入卡号");
		document.add.id.focus();
		return false;
	}
	if(window.document.add.sname.value=="")
	{
		alert("您忘了输入学生姓名");
		document.add.sname.focus();
		return false;
	}
	if(window.document.add.grade.value=="")
	{
		alert("您忘了输入班级代号");
		document.add.grade.focus();
		return false;
	}
	if(window.document.add.mobile.value=="")
	{
		alert("您忘了输入学生家长手机号");
		document.add.mobile.focus();
		return false;
	}	
	if(window.document.add.mobile.value.length!=11 && window.document.add.mobile.value.length!=8)
	{
		alert("您输入的手机号位数不对");
		document.add.mobile.focus();
		return false;
	}
	return true;
}
</script>

<center>
  <table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
    <caption>添加学生记录</caption>
    <form action="add_student_2.jsp" method=post name=add onsubmit="return check()">
      <tr>
        <td align=right><span class=red>班级代号:</span></td>
        <td>
          <input name=grade value="<%=(String)session.getAttribute("grade")%>" size=12 readonly type="text">
        </td>
      </tr>
      <tr>
        <td align=right>学生卡号:</td>
        <td>
          <input type=text name=id>
        </td>
      </tr>
      <tr>
        <td align=right>学生学号:</td>
        <td>
          <input type=text name=ssn>
        </td>
      </tr>
      <tr>
        <td align=right>学生姓名:</td>
        <td>
          <input type=text name=sname>
        </td>
      </tr>
      <tr> 
        <td height="24">
          <div align="right">家长手机:</div>
        </td>
        <td height="24">
          <input type="text" name="mobile">
        </td>
      </tr>
      <tr>
        <td height="14">
          <div align="right">是否在校用餐:</div>
        </td>
        <td height="14"> 
          <input type="radio" name="haveLunch" value="1">是&nbsp;&nbsp;
		  <input type="radio" name="haveLunch" value="0" checked>否<br>
        </td>
      </tr>
      <tr>
        <td height="2"></td>
        <td height="2">
          <input type=submit value="加入" name="submit">
        </td>
      </tr>
    </form>
  </table>

</center>
