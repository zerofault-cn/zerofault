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
<H1>�ļ��ϴ�JSP</H1>
<HR>
<% 
int count=0; 
//����Ŀ��Ŀ¼ 
mySmartUpload.initialize(pageContext); 
 //�ļ��ϴ� 
mySmartUpload.upload();
//����ı������� 
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
//�ϴ������ͳ�� 
//
for (int i=0;i<mySmartUpload.getFiles().getCount();i++){
com.jspsmart.upload.File myFile = mySmartUpload.getFiles().getFile(0); 
if (!myFile.isMissing()){ 
myFile.saveAs(dest1+ myFile.getFileName()); 
filename1=myFile.getFileName();
out.println("�ļ�����= " + myFile.getFieldName() + "<BR>"); 
out.println("�ļ���С= " + myFile.getSize() + "<BR>"); 
out.println("�ļ�����= " + myFile.getFileName() + "<BR>"); 
out.println("�ļ���С= " + myFile.getFileExt() + "<BR>"); 
out.println("�ļ�·����= " + myFile.getFilePathName() + "<BR>"); 
out.println("�ļ�����= " + myFile.getContentType() + "<BR>"); 
out.println("ContentDisp = " + myFile.getContentDisp() + "<BR>"); 
out.println("MIME���� = " + myFile.getTypeMIME() + "<BR>"); 
out.println("SubTypeMIME = " + myFile.getSubTypeMIME() + "<BR>");
out.println(filename1); 
//count ++; 
//
} 
} 
//out.println("<BR>�����ϴ�" + mySmartUpload.getFiles().getCount() + "���ļ�<BR>"); <BR>//out.println(count + "���ļ��Ѿ����ϴ�"); <BR><BR>//�������ݿ��¼<BR>try {<BR>Class.forName("com.mysql.jdbc.Driver").newInstance(); <BR>} <BR>catch (java.lang.ClassNotFoundException e)<BR>{ <BR>out.print("Class not found exception occur. Message is:"); <BR>out.print(e.getMessage()); <BR>} <BR>try { <BR>Connection con; <BR>Statement stmt; <BR><BR>con = DriverManager.getConnection("jdbc:mysql://localhost:3306/webuser?useUnicode=true&characterEncoding=gb2312","webuser","webuser"); <BR>stmt = con.createStatement();<BR>stmt.executeUpdate("insert into document(date,type,title) Values('"+date1+"','"+type1+"','"+filename1+"')"); }<BR>catch (SQLException e)<BR>{<BR>out.print("<br>SQL Exception occur. Message is:"); <BR>out.print(e.getMessage()); <BR>}<BR><BR>
%>
<p><a href="view.jsp">����</a></p>
</BODY>
</HTML>