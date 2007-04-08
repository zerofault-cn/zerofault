package Mobile;
import java.sql.*;
import java.lang.String;
public class OpenDb
{
	String sDBDriver="sun.jdbc.odbc.JdbcOdbcDriver";
	String sConnStr="jdbc:odbc:user_info";
	Connection conn=null;
	ResultSet rs=null;
	public OpenDb()
	{
		try{
		Class.forName(sDBDriver);
		}
		catch(java.lang.ClassNotFoundException e){
		System.err.println("opendb():"+e.getMessage());}
		}
	public ResultSet executeQuery(String sql)
	{
		rs=null;
		try{
		conn=DriverManager.getConnection(sConnStr);
		Statement stmt=conn.createStatement(java.sql.ResultSet.TYPE_SCROLL_INSENSITIVE,java.sql.ResultSet.CONCUR_READ_ONLY);	
		rs=stmt.executeQuery(sql);
		}
		catch(SQLException ex){
		System.err.println("sql.executeQuery:"+ex.getMessage());
		}
		return rs;
	}
	public int executeUpdate(String sql)
	{
		int r=0;
		try{
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement();
			r=stmt.executeUpdate(sql);
		}
		catch(SQLException e){
			System.err.println("sql.executeUpdate:"+e.getMessage());
		}
		return r;
	}
	public boolean CheckUserExist(String sql){
		ResultSet rs=null;
		try{
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement();
			rs=stmt.executeQuery(sql);
			if(rs.next())
			return true;
			else{return false;}
		}
		catch(SQLException e){
			System.err.println("sql.executeUpdate:"+e.getMessage());
			return false;
		}
		
	}
	/*public static void main(String args[])
	{
		OpenDb app=new OpenDb();
		String sql="insert into [user](host) values('13550036901') ";
		if(app.CheckUserExist(sql)){
			System.out.println("user existed");
		}
		else{
			System.out.println("user not exist");
			}
	
	}*/
}
