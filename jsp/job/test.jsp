<%@ page contentType="text/html;charset=gb2312" import="java.sql.*"%>
<jsp:useBean id="test" scope="page" class="MySQL.dbconnect" />
<%
ResultSet rs = null;

/*
NinGoo.setServer("127.0.0.1"); //����<B style='color:black;background-color:#A0FFFF'>MySQL</B>�ķ�����������IP<BR>NinGoo.setPort("3306"); //����<B style='color:black;background-color:#A0FFFF'>MySQL</B>�ļ����˿�<BR>NinGoo.setDB("test"); //����<B style='color:black;background-color:#A0FFFF'>MySQL</B>�����ݿ���<BR>NinGoo.setUser("root"); //��������<B style='color:black;background-color:#A0FFFF'>MySQL</B>���û���<BR>NinGoo.setPass("password"); //��������<B style='color:black;background-color:#A0FFFF'>MySQL</B>������<BR>
*/

rs = test.executeQuery("select * from flash");
while(rs.next())
{
%>
Row:<%=rs.getString(2)%>
<%
}


rs.close();


%>
