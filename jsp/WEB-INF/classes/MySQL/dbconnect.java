package MySQL;
import java.sql.*;

public class dbconnect
{
//	String sDBDriver="org.gjt.mm.mysql.Driver";
	String sDBDriver="com.mysql.jdbc.Driver";
	String sConnStr="jdbc:mysql://localhost/jspbbs";
	String user="root";
	String password="";
	Connection conn=null;
	ResultSet rs=null;

	public dbconnect()
	{
		try
		{
			Class.forName(sDBDriver).newInstance();
			conn=DriverManager.getConnection(sConnStr,user,password);
		}
		catch(Exception e){
			e.printStackTrace();
		}
	}

	public ResultSet executeQuery(String sql)
	{
		try
		{
			conn=DriverManager.getConnection(sConnStr,user,password);
			Statement stmt=conn.createStatement();
			rs=stmt.executeQuery(sql);
		}
		catch(SQLException ex)
		{
			System.err.println("ex.executeQuery:"+ex.getMessage());
		}
		return rs;
	}

	public int executeUpdate(String sql)
	{
		int r=0;
		try
		{
			conn=DriverManager.getConnection(sConnStr,user,password);
			Statement stmt=conn.createStatement();
			r=stmt.executeUpdate(sql);
		}
		catch(SQLException ex)
		{
			System.err.println("ex.executeQuery:"+ex.getMessage());
		}
		return r;
	}
/*
	public static void main(String[] args) 
	{
		dbconnect myconn=new dbconnect();
		ResultSet rs =myconn.executeQuery("select * from flash");
		try{
			rs.next();
			System.out.println(rs.getString(1));
		}
		catch(SQLException ex)
		{
			System.err.println("ex.executeQuery:"+ex.getMessage());
		}
	}
*/
}
