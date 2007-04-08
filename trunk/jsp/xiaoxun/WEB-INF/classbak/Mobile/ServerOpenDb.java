package Mobile;
import java.sql.*;
import java.lang.String;
public class ServerOpenDb
{
	String sDBDriver="sun.jdbc.odbc.JdbcOdbcDriver";
	String sConnStr="jdbc:odbc:server_user_info";
	Connection conn=null;
	ResultSet rs=null;
	public ServerOpenDb()
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
		Statement stmt=conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
		rs=stmt.executeQuery(sql);
		}
		catch(SQLException ex){
		System.err.println("sql.executeQuery:"+ex.getMessage());
		rs=null;
		}
		finally{return rs;}
		
	}
	public int executeUpdate(String sql)
	{
		int r=0;
		try{
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
			r=stmt.executeUpdate(sql);
			rs.close();
			stmt.close();
			conn.close();
		}
		catch(SQLException e){
			System.err.println("sql.executeUpdate:"+e.getMessage());
		}
		return r;
	}
	public boolean CheckUserExist(String sql){
		ResultSet rs=null;
		boolean exist=false;
		try{
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
			rs=stmt.executeQuery(sql);
			if(rs.next())
			exist=true;
			else{exist=false;}
		}
		catch(SQLException e){
			System.err.println("sql.executeUpdate:"+e.getMessage());
		}
		finally{return exist;}
	
	}
	public int getRowCount(String sql){
		int rowcount=0;
		try{
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);
			rs=stmt.executeQuery(sql);
			rs.last();
			rowcount=rs.getRow();
			rs.close();
			stmt.close();
			conn.close();
			}
		catch(SQLException e){
			System.err.println("sql.getRowCount:"+e.getMessage());
			rowcount=0;
		}
		finally{return rowcount;}
	}
		
	
//	public static void main(String args[])
//	{
//		int rowcount=0;
//  	ServerOpenDb app=new ServerOpenDb();
//		String sql="select * from friends_adding";
//		rowcount=app.getRowCount(sql);
//		System.out.println("rowcount="+rowcount);
//		
//	}
}
