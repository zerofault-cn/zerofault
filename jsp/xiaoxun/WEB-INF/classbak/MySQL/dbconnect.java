package MySQL;
import java.sql.*;


public class  dbconnect
{
	String sDBDriver="org.gjt.mm.mysql.Driver";
	String sConnStr="jdbc:mysql://localhost:3306/jspbbs";
	String user="root";
	String password="";
	Connection conn=null;
	ResultSet rs=null;

	public dbconnect()
	{
		try
		{
			Class.forName(sDBDriver);
		}
		catch(java.lang.ClassNotFoundException e)
		{
			System.err.println("Class dbconnect not found!"+e.getMessage());
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

	
}
