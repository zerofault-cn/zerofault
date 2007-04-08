<%@ page import="java.sql.*" %>
<%@page contentType="text/html;charset=gb2312" 
language="java" 
import="com.jspsmart.upload.*"
%> 
<jsp:useBean id="mySmartUpload" 
scope="page" 
class="com.jspsmart.upload.SmartUpload" /> 
<HTML> 
<BODY >
<H1>文件上传JSP</H1>
<HR>
<% 
int count=0; 
//定义目标目录 
mySmartUpload.initialize(pageContext); 
 //文件上传 
mySmartUpload.upload();
//获得文本的内容 
String date1= mySmartUpload.getRequest().getParameter("date");
out.println(date1+"<br>"); 
String type1 = mySmartUpload.getRequest().getParameter("type");
out.println(type1+"<br>"); 
String path1 = mySmartUpload.getRequest().getParameter("path");
out.println(path1+"<br>");
String title1 = mySmartUpload.getRequest().getParameter("title");
out.println(title1+"<br>");
String class1 = mySmartUpload.getRequest().getParameter("class");
out.println(class1+"<br>");
String attrib1 = mySmartUpload.getRequest().getParameter("attrib");
out.println(attrib1+"<br>"); 
String dest1="/td/";
dest1=dest1+type1+"/";
String filename1="";
//上传的情况统计 
//
for (int i=0;i<mySmartUpload.getFiles().getCount();i++){
com.jspsmart.upload.File myFile = mySmartUpload.getFiles().getFile(0); 
if (!myFile.isMissing()){ 
myFile.saveAs(dest1+ myFile.getFileName()); 
filename1=myFile.getFileName();
out.println("文件名称= " + myFile.getFieldName() + "<BR>"); 
out.println("文件大小= " + myFile.getSize() + "<BR>"); 
out.println("文件名称= " + myFile.getFileName() + "<BR>"); 
out.println("文件大小= " + myFile.getFileExt() + "<BR>"); 
out.println("文件路径名= " + myFile.getFilePathName() + "<BR>"); 
out.println("文件类型= " + myFile.getContentType() + "<BR>"); 
out.println("ContentDisp = " + myFile.getContentDisp() + "<BR>"); 
out.println("MIME类型 = " + myFile.getTypeMIME() + "<BR>"); 
out.println("SubTypeMIME = " + myFile.getSubTypeMIME() + "<BR>");
out.println(filename1); 
//count ++; 
//
} 
} 
//out.println("<BR>可以上传" + mySmartUpload.getFiles().getCount() + "个文件<BR>"); <BR>//out.println(count + "个文件已经被上传"); <BR><BR>//插入数据库记录<BR>try {<BR>Class.forName("com.mysql.jdbc.Driver").newInstance(); <BR>} <BR>catch (java.lang.ClassNotFoundException e)<BR>{ <BR>out.print("Class not found exception occur. Message is:"); <BR>out.print(e.getMessage()); <BR>} <BR>try { <BR>Connection con; <BR>Statement stmt; <BR><BR>con = DriverManager.getConnection("jdbc:mysql://localhost:3306/webuser?useUnicode=true&characterEncoding=gb2312","webuser","webuser"); <BR>stmt = con.createStatement();<BR>stmt.executeUpdate("insert into document(date,type,title) Values('"+date1+"','"+type1+"','"+filename1+"')"); }<BR>catch (SQLException e)<BR>{<BR>out.print("<br>SQL Exception occur. Message is:"); <BR>out.print(e.getMessage()); <BR>}<BR><BR>
%>
<p><a href="view.jsp">返回</a></p>
</BODY>
</HTML>