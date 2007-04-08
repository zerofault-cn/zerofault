<%@ page contentType="text/html;charset=gb2312" import="java.sql.*"%>
<jsp:useBean id="test" scope="page" class="MySQL.dbconnect" />
<%
ResultSet rs = null;

/*
NinGoo.setServer("127.0.0.1"); //设置<B style='color:black;background-color:#A0FFFF'>MySQL</B>的服务器名或者IP<BR>NinGoo.setPort("3306"); //设置<B style='color:black;background-color:#A0FFFF'>MySQL</B>的监听端口<BR>NinGoo.setDB("test"); //设置<B style='color:black;background-color:#A0FFFF'>MySQL</B>的数据库名<BR>NinGoo.setUser("root"); //设置连接<B style='color:black;background-color:#A0FFFF'>MySQL</B>的用户名<BR>NinGoo.setPass("password"); //设置连接<B style='color:black;background-color:#A0FFFF'>MySQL</B>的密码<BR>
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
