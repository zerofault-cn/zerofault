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
	out.println("<span style=\"color:#0000ff\">Flash�ļ��ϴ��ɹ�!</span><br>");
	if(test.executeUpdate(sql1)==1){
		out.println("<span style=\"color:#0000ff\">д�����ݿ�ɹ�!</span><br>");
		out.println("ԭ�ļ�·��:" + myFile.getFilePathName()+ "<br>");
		out.println("���ļ�·��:" +newFile+ "<br>"); 
		out.println("�ļ���С:" + myFile.getSize() + "�ֽ�<br>"); 
		out.println("�ļ�����:" + myFile.getContentType() + "<br>"); 
		out.println("MIME����:" + myFile.getTypeMIME() + "<br>"); 
		out.println("SubTypeMIME:" + myFile.getSubTypeMIME() + "<br>");
	}
	else{
		out.println("<span style=\"color:#ff0000\">д�����ݿ�ʧ��!</span><br>");
	}
}
else{
	out.println("<span style=\"color:#ff0000\">Flash�ļ��ϴ�ʧ��!</span><br>");
}
%>
<button onclick="javascript:location='index.jsp'">������ҳ</button>
