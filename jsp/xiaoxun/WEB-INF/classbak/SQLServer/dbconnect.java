package SQLServer;
import java.sql.*;


public class  dbconnect
{
	String sDBDriver="sun.jdbc.odbc.JdbcOdbcDriver";
	String sConnStr="jdbc:odbc:xxt";
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
			conn=DriverManager.getConnection(sConnStr);
			Statement stmt=conn.createStatement();
			rs=stmt.executeQuery(sql);
		}
		catch(SQLException ex)
		{
			System.err.println("ax.executeQuery:"+ex.getMessage());
		}
		return rs;
	}

	public int executeUpdate(String sql)
	{
		int r=0;
		try
		{
			conn=DriverManager.getConnection(sConnStr);
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
