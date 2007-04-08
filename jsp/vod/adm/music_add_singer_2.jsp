<%@ page language="java" import="java.sql.*,goldsoft.*,com.jspsmart.upload.*" %>
<!-- 添加歌手信息-2,涉及文件上传 -->
<%
Opendb opendb = new Opendb();
ResultSet rs = null;
int singer_id = 0;
try
{
	rs = opendb.executeQuery("select max(singer_id) from singer_info");
    if(rs != null && rs.next())
		singer_id = rs.getInt(1);
    singer_id++;
}
catch(SQLException e) 
{
	out.println(e);
}
String pic = "";
com.jspsmart.upload.SmartUpload mySmartUpload = new com.jspsmart.upload.SmartUpload();
// Initialization
mySmartUpload.initialize(config,request,response);
try
{
	//Upload
	mySmartUpload.upload();
	String servPath = request.getSession(true).getServletContext().getRealPath(request.getServletPath());
	String path1 = servPath.substring(0,servPath.lastIndexOf(System.getProperty("file.separator")));
	String dirPath = path1.substring(0,path1.lastIndexOf(System.getProperty("file.separator"))+1)+"photo"+System.getProperty("file.separator");
	com.jspsmart.upload.Files files = mySmartUpload.getFiles();
	com.jspsmart.upload.File myFile = files.getFile(0);
	if (!myFile.isMissing()) 
	{
		pic = singer_id + myFile.getFileName().substring(myFile.getFileName().indexOf("."));
		myFile.saveAs(dirPath + pic);
	}
}
catch (Exception e)
{
	out.println("Unable to upload the file.<br>");
	out.println("Error : " + e.toString());
}
com.jspsmart.upload.Request myRequest = mySmartUpload.getRequest();
StringReplace sr = new StringReplace();
String singer_name = myRequest.getParameter("singer_name");
singer_name=sr.transIso(singer_name);
String type_area_id = myRequest.getParameter("type_area_id");
String type_chorus_id = myRequest.getParameter("type_chorus_id");
String type_other_id = myRequest.getParameter("type_other_id");
String introduce = myRequest.getParameter("introduce");
introduce = sr.newline(introduce);
introduce = sr.transIso(introduce);
String sql = "insert into singer_info values("+singer_id+",'"+singer_name+"','"+pic+"','"+introduce+"','"+type_area_id+"','"+type_chorus_id+"','"+type_other_id+"')";
int r = opendb.executeUpdate(sql);
if(r!=0)
{
	%>
	<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.jsp?content=music_add_singer_1";
		else
			window.location="index.jsp?content=music_singer_list";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("添加记录失败,请检查重试,或者报告管理员");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
