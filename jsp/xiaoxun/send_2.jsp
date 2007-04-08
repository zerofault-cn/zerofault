<%@ page language="java" import="java.io.*" %>
<jsp:useBean id="writer" scope="page" class="IO.WriteToFile"/>

<center>
<%
String grade=(String)session.getAttribute("grade");
String mobile=request.getParameter("mobile");
String sendtype=request.getParameter("sendtype");
String content=request.getParameter("content");
String acrlf=null;
acrlf=writer.getCrlf();
String apath=null;
String message=null;
String sp=System.getProperty("file.separator");

if(sendtype.equals("single"))
{
	apath="d:"+sp+"pub"+sp+mobile+".txt";
	message=content;
}
else
{
	apath="d:"+sp+"pub"+sp+grade+".txt";
	message=content;
}
File f=new File(apath);
writer.setPath(apath);
writer.setSomething(message);
String result=null;
while(true)
{
	if(!f.exists())
	{
		if(writer.writeSomething().equals("success"))
		{
			out.println("消息发送成功<br>");
			out.println("<input type=button value='关闭窗口' 	onclick='javascript:window.close();'>");
		}
		break;
	}
}

%>
</center>