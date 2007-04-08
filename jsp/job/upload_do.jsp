<%@ page language="java" import="com.jspsmart.upload.*,java.util.Date,java.sql.*" %>
<jsp:useBean id="mySmartUpload" scope="page" class="com.jspsmart.upload.SmartUpload" />
<jsp:useBean id="test" scope="page" class="MySQL.dbconnect" />
<%
mySmartUpload.initialize(pageContext);
mySmartUpload.upload();
String title= mySmartUpload.getRequest().getParameter("title");
String user= mySmartUpload.getRequest().getParameter("user");
String descr= mySmartUpload.getRequest().getParameter("descr");

Date nowTime=new Date(); 
String now=String.valueOf(nowTime.getYear()+1900)+String.valueOf(nowTime.getMonth()+1)+String.valueOf(nowTime.getDate())+String.valueOf(nowTime.getHours())+String.valueOf(nowTime.getMinutes())+String.valueOf(nowTime.getSeconds());
String newFile="/upload/"+now+".swf";
String path="upload/"+now+".swf";

String sql1="insert into flash set title='"+title+"',path='"+path+"',user='"+user+"',uptime=NOW(),descr='"+descr+"'";

com.jspsmart.upload.File myFile = mySmartUpload.getFiles().getFile(0); 
if (!myFile.isMissing()){
	myFile.saveAs(newFile);
	out.println("<span style=\"color:#0000ff\">Flash文件上传成功!</span><br>");
	if(test.executeUpdate(sql1)==1){
		out.println("<span style=\"color:#0000ff\">写入数据库成功!</span><br>");
		out.println("原文件路径:" + myFile.getFilePathName()+ "<br>");
		out.println("新文件路径:" +newFile+ "<br>"); 
		out.println("文件大小:" + myFile.getSize() + "字节<br>"); 
		out.println("文件类型:" + myFile.getContentType() + "<br>"); 
		out.println("MIME类型:" + myFile.getTypeMIME() + "<br>"); 
		out.println("SubTypeMIME:" + myFile.getSubTypeMIME() + "<br>");
	}
	else{
		out.println("<span style=\"color:#ff0000\">写入数据库失败!</span><br>");
	}
}
else{
	out.println("<span style=\"color:#ff0000\">Flash文件上传失败!</span><br>");
}
%>
<button onclick="javascript:location='index.jsp'">返回首页</button>
