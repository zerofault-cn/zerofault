<%@ page language="java" import="java.io.*" %>
<center>
<jsp:useBean id="writer" scope="page" class="IO.WriteToFile"/>
<%
String grade=request.getParameter("grade");
String mobile=request.getParameter("mobile");
String sendtype=request.getParameter("sendtype");
String content=request.getParameter("content");
String acrlf=null;
acrlf=writer.getCrlf();
String apath=null;
String message=null;
String sp=System.getProperty("file.separator");
if(sendtype.equals("class"))
{
	apath="d:"+sp+"output"+sp+grade+".txt";
	message=content;
}
if(sendtype.equals("school"))
{
	apath="d:"+sp+"output"+sp+"all.txt";
	message=content;
}
File   f=new File(apath);
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