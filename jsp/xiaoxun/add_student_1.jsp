<%@ page language="java" import="java.sql.*" %>
<script language="javascript">
function check()
{
	if(window.document.add.id.value=="")
	{
		alert("���������뿨��");
		document.add.id.focus();
		return false;
	}
	if(window.document.add.sname.value=="")
	{
		alert("����������ѧ������");
		document.add.sname.focus();
		return false;
	}
	if(window.document.add.grade.value=="")
	{
		alert("����������༶����");
		document.add.grade.focus();
		return false;
	}
	if(window.document.add.mobile.value=="")
	{
		alert("����������ѧ���ҳ��ֻ���");
		document.add.mobile.focus();
		return false;
	}	
	if(window.document.add.mobile.value.length!=11 && window.document.add.mobile.value.length!=8)
	{
		alert("��������ֻ���λ������");
		document.add.mobile.focus();
		return false;
	}
	return true;
}
</script>

<center>
  <table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
    <caption>���ѧ����¼</caption>
    <form action="add_student_2.jsp" method=post name=add onsubmit="return check()">
      <tr>
        <td align=right><span class=red>�༶����:</span></td>
        <td>
          <input name=grade value="<%=(String)session.getAttribute("grade")%>" size=12 readonly type="text">
        </td>
      </tr>
      <tr>
        <td align=right>ѧ������:</td>
        <td>
          <input type=text name=id>
        </td>
      </tr>
      <tr>
        <td align=right>ѧ��ѧ��:</td>
        <td>
          <input type=text name=ssn>
        </td>
      </tr>
      <tr>
        <td align=right>ѧ������:</td>
        <td>
          <input type=text name=sname>
        </td>
      </tr>
      <tr> 
        <td height="24">
          <div align="right">�ҳ��ֻ�:</div>
        </td>
        <td height="24">
          <input type="text" name="mobile">
        </td>
      </tr>
      <tr>
        <td height="14">
          <div align="right">�Ƿ���У�ò�:</div>
        </td>
        <td height="14"> 
          <input type="radio" name="haveLunch" value="1">��&nbsp;&nbsp;
		  <input type="radio" name="haveLunch" value="0" checked>��<br>
        </td>
      </tr>
      <tr>
        <td height="2"></td>
        <td height="2">
          <input type=submit value="����" name="submit">
        </td>
      </tr>
    </form>
  </table>

</center>
