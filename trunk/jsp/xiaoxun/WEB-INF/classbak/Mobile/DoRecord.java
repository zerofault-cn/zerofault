import java.sql.*;
import java.io.*;
import java.lang.String;
import java.io.RandomAccessFile;
public class DoRecord{

	//¶¨Òå³ÌÐòÖÐÊ¹ÓÃµÄ±äÁ¿
	OpenDb DBInstance;
	WriteToFile WriterInstance;
	String sql;
	int startrow;
	int stoprow;	
	ResultSet rs;
	String host;
	String msgtype;
	String add_friendhost;
    String del_friendhost;
    String msg;
    String alias;
    String add_class;
    String msg_class;

	//³õÊ¼»¯
	public DoRecord()
	{
		this.DBInstance=new OpenDb();
		this.WriterInstance=new WriteToFile();
		this.sql="select * from [tempuser] ";
		this.startrow=0;
		this.stoprow=0;
		this.rs=null;
		this.host=null;
		this.msgtype=null;
		this.add_friendhost=null;
		this.del_friendhost=null;
		this.msg=null;
		this.alias=null;
		this.add_class=null;
		this.msg_class=null;
	}

	//´¦Àí´ÓÊý¾Ý¿âÖÐÌáÈ¡³öµÄ±äÁ¿
	public void dofile(String Host,String Alias,String Msg,String Msgtype,String Msg_class,String Add_friendhost,String Add_class,String Del_friendhost){
		try{
			String sp=System.getProperty("file.separator");
			String path="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			File   f=new File(path);
			String host=Host;
			String alias=Alias;
			String msg=Msg;
			String msg_class=Msg_class;
			String msgtype=Msgtype;
			String add_friendhost=Add_friendhost;
			String add_class=Add_class;
			String del_friendhost=Del_friendhost;
			//½øÈëÑ­»·£¬²»Í£µÄ¼ì²éÎÄ¼þÊÇ·
			while(!f.exists()){
				if(!alias.equals(null)){
				aliasUpdate(host,alias);
				}
				break;
			}
			while(!f.exists()){
				if(!msg.equals(null)&&!msg_class.equals(null)){
					sentMsg(host,msg,msg_class);
				}
				break;
			}
			while(!f.exists()){
				if(!msgtype.equals(null)){
					msgtypeUpdate(host,msgtype);
				}
				break;
			}
			while(!f.exists()){
				if(!add_friendhost.equals(null)&&!add_class.equals(null)){
					addFriend(host,add_friendhost,add_class);
				}
				break;
			}
			while(!f.exists()){
					if(!del_friendhost.equals(null)){
						delFriend(host,del_friendhost);
					}
					break;
				}
			}catch(Exception e){
				System.err.println("dofile-Execption: "+e.getMessage());
				}
		}


	//´¦ÀíÊý¾Ý¿âÖÐµÄÃ¿Ò»ÐÐÊý¾Ý
		public void dodbs(String Sql){
		while(true){
			try{
				rs=DBInstance.executeQuery(Sql);
				rs.first();
				startrow=rs.getRow();
				rs.last();
				stoprow=rs.getRow();
				System.out.println(startrow);
				System.out.println(stoprow);
				for(;startrow<=stoprow;++startrow){
					rs.absolute(startrow);
					host=rs.getString("host");
					System.out.println("host="+host);
					alias=rs.getString("alias");
					System.out.println("alias="+alias);
					msg=rs.getString("msg");
					System.out.println("msg="+msg);
					msg_class=rs.getString("msg_class");
					System.out.println("msg_class="+msg_class);
					msgtype=rs.getString("msgtype");
					System.out.println("msgtype="+msgtype);
					add_friendhost=rs.getString("add_friendhost");
					System.out.println("add_friendhost="+add_friendhost);
					add_class=rs.getString("add_class");
					System.out.println("add_class="+add_class);
					del_friendhost=rs.getString("del_friendhost");
					System.out.println("del_friendhost="+del_friendhost);
			//		dofile(host,alias,msg,msg_class,msgtype,add_friendhost,add_class,del_friendhost);
				//	rs.deleteRow();
				}
				rs.close();
			}
				catch(Exception e){
				System.err.println("dodbs_Exception: "+e.getMessage());
				break;
				}
			}
	}



	//ÒÔÏÂÊÇ¶ÔÓ¦µÄÎÄ¼þ²Ù×÷Óï¾ä
	public void aliasUpdate(String Host,String Alias){
		//ÒªÐ´ÈëÎÄ¼þµÄ¶«Î÷
		try{
			String host=Host;
			String alias=Alias;
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éresult.txtÎÄ¼þ
			String sp=System.getProperty("file.separator");
			String apath_1="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			WriterInstance.setPath(apath_1);
			String acrlf=null;
			acrlf=WriterInstance.getCrlf();
			String asomething_1="0"+acrlf+"1"+acrlf+"158"+acrlf+"0"+acrlf+"02"+acrlf+"10"+acrlf+""+acrlf+""+acrlf+host+acrlf+""+acrlf+"032320001"+acrlf+"fromweb.txt"+acrlf+"smgid.txt";
			WriterInstance.setSomething(asomething_1);
			WriterInstance.writeSomething();
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éfromweb.txt\uFFFD
			String apath_2="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"fromweb.txt";
			WriterInstance.setPath(apath_2);
			String
			asomething_2=""+alias;
			WriterInstance.setSomething(asomething_2);
			WriterInstance.writeSomething();
			}catch(Exception e){System.err.println("aliasUpdate-Execption: "+e.getMessage());}
	}
	public void sentMsg(String Host,String Msg,String Msg_class){
		//ÒªÐ´ÈëÎÄ¼þµÄ¶«Î÷
		String host=Host;
		String msg=Msg;
		String asomething_2=null;
		String msg_class=null;
		try{
			if(Msg_class.equals(null)){
				asomething_2=""+msg;
			}
			else{
				msg_class=Msg_class;
				asomething_2="#"+msg_class+msg;
			}	
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éresult.txtÎÄ¼þ
			String sp=System.getProperty("file.separator");
			String apath_1="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			WriterInstance.setPath(apath_1);
			String acrlf=null;
			acrlf=WriterInstance.getCrlf();
			String asomething_1="0"+acrlf+"1"+acrlf+"158"+acrlf+"0"+acrlf+"02"+acrlf+"10"+acrlf+""+acrlf+""+acrlf+host+acrlf+""+acrlf+"03232"+acrlf+"fromweb.txt"+acrlf+"smgid.txt";
			WriterInstance.setSomething(asomething_1);
			WriterInstance.writeSomething();
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éfromweb.txt\uFFFD
			String apath_2="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"fromweb.txt";
			WriterInstance.setPath(apath_2);
			WriterInstance.setSomething(asomething_2);
			WriterInstance.writeSomething();
			}catch(Exception e){System.err.println("sendMsg-Execption: "+e.getMessage());}
	}
		public void msgtypeUpdate(String Host,String Msgtype){
		//ÒªÐ´ÈëÎÄ¼þµÄ¶«Î÷
		try{
			String host=Host;
			String msgtype=Msgtype;
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éresult.txtÎÄ¼þ
			String sp=System.getProperty("file.separator");
			String apath_1="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			WriterInstance.setPath(apath_1);
			String acrlf=null;
			acrlf=WriterInstance.getCrlf();
			String asomething_1="0"+acrlf+"1"+acrlf+"158"+acrlf+"0"+acrlf+"02"+acrlf+"10"+acrlf+""+acrlf+""+acrlf+host+acrlf+""+acrlf+"032320002"+acrlf+"fromweb.txt"+acrlf+"smgid.txt";
			WriterInstance.setSomething(asomething_1);
			WriterInstance.writeSomething();
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éfromweb.txt\uFFFD
			String apath_2="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"fromweb.txt";
			WriterInstance.setPath(apath_2);
			String
			asomething_2=""+msgtype;
			WriterInstance.setSomething(asomething_2);
			WriterInstance.writeSomething();
			}catch(Exception e){System.err.println("msgtypeUpdate-Execption: "+e.getMessage());}
	}
	public void addFriend(String Host,String Add_friendhost,String Add_class){
		//ÒªÐ´ÈëÎÄ¼þµÄ¶«Î÷
		try{
			String host=Host;
			String add_friendhost=Add_friendhost;
			String add_class=Add_class;
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éresult.txtÎÄ¼þ
			String sp=System.getProperty("file.separator");
			String apath_1="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			WriterInstance.setPath(apath_1);
			String acrlf=null;
			acrlf=WriterInstance.getCrlf();
			String asomething_1="0"+acrlf+"1"+acrlf+"158"+acrlf+"0"+acrlf+"02"+acrlf+"10"+acrlf+""+acrlf+""+acrlf+host+acrlf+""+acrlf+"032320003"+acrlf+"fromweb.txt"+acrlf+"smgid.txt";
			WriterInstance.setSomething(asomething_1);
			WriterInstance.writeSomething();
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éfromweb.txt\uFFFD
			String apath_2="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"fromweb.txt";
			WriterInstance.setPath(apath_2);
			String
			asomething_2=""+add_friendhost+add_class;
			WriterInstance.setSomething(asomething_2);
			WriterInstance.writeSomething();
	   		}catch(Exception e){System.err.println("add_friend-Execption: "+e.getMessage());}
	   	}
	public void delFriend(String Host,String Del_friendhost){
		//ÒªÐ´ÈëÎÄ¼þµÄ¶«\uFFFD
		try{
			String host=Host;
			String del_friendhost=Del_friendhost;
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éresult.txtÎÄ¼þ
			String sp=System.getProperty("file.separator");
			String apath_1="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"result.txt";
			WriterInstance.setPath(apath_1);
			String acrlf=null;
			acrlf=WriterInstance.getCrlf();
			String asomething_1="0"+acrlf+"1"+acrlf+"158"+acrlf+"0"+acrlf+"02"+acrlf+"10"+acrlf+""+acrlf+""+acrlf+host+acrlf+""+acrlf+"032320004"+acrlf+"fromweb.txt"+acrlf+"smgid.txt";
			WriterInstance.setSomething(asomething_1);
			WriterInstance.writeSomething();
			//ÔÚµ±Ç°Ä¿Â¼Éú³Éfromweb.txt\uFFFD
			String apath_2="d:"+sp+"Program Files"+sp+"Apache Group"+sp+"Tomcat 4.1"+sp+"webapps"+sp+"ROOT"+sp+"fromweb.txt";
			WriterInstance.setPath(apath_2);
			String
			asomething_2=""+del_friendhost;
			WriterInstance.setSomething(asomething_2);
			WriterInstance.writeSomething();
			}catch(Exception e){System.err.println("del_friend-Execption: "+e.getMessage());}
		}


	//Ð´ÈëÎÄ¼þµÄÀà
	class WriteToFile
	 {
		 private String path;
		 private String something;
		 private String crlf;
		 public WriteToFile(){
			 path = null;
			 something =null;
			 }
		 public void setPath(String apath){
			 this.path = apath;
			 }

		public String getPath(){
			return this.path;
			}
		public void setSomething(String asomething){
			this.something = asomething;
			}
		public String getSomething(){
			return this.something;
			}
		public void setCrlf(String acrlf){
			 this.path = acrlf;
			 }
		public String getCrlf(){
			 return (System.getProperties().getProperty("line.separator"));
			 }
		public String writeSomething(){
			try{
				RandomAccessFile raf = new RandomAccessFile(path,"rw");
				String temp =this.getSomething();
				byte[]bA = temp.getBytes();
				for(int i=0;i<bA.length;i++){
					raf.write(bA[i]);
				}
				//out.print(this.getSomething() + "\n");
				//out.close();
				//System.out.println("success");
				raf.close();
				return "success";
				}
			catch (IOException e){
				System.out.print("failure");
				return "failure";
				}
			}

	}


	//Á¬½ÓÊý¾Ý¿âµÄÀà
	class OpenDb
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
		//	Statement stmt=conn.createStatement();
			Statement stmt =conn.createStatement(
                                      ResultSet.TYPE_SCROLL_INSENSITIVE,
                                      ResultSet.CONCUR_UPDATABLE);

                                     
			rs=stmt.executeQuery(sql);
			}
			catch(SQLException ex){
			System.err.println("sql.executeQuery:"+ex.getMessage());
			}
			return rs;
		}
	}
    public static void main(String args[]){
          DoRecord app=new DoRecord();
          //System.out.println(app.sql);
          //System.out.println(app.DBInstance);
          //app.dofile("host","alias","Msg","Msg_type","Msg_class","Add_friendhost","Add_class","Del_friend");
          app.dodbs(app.sql);
        }
    }










