<%@ page language="java" import="java.sql.*" %>
<%
Connection con=null;
Statement sql=null;
ResultSet rs=null;
try{
	Class.forName("com.mysql.jdbc.Driver").newInstance();
}
catch(ClassNotFoundException e){
	out.println("Unable to load driver.");
}
try{
	con=DriverManager.getConnection("jdbc:mysql://localhost/jspbbs","root","");
	sql=con.createStatement();
	rs=sql.executeQuery("select * from teacher");
	while(rs.next()){
		out.print(rs.getString("teacher"));
	}
	con.close();
}
catch(SQLException e1){
	out.print("error:"+e1);
}

%>
