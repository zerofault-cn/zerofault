package IO;
import java.io.*;

public class WriteOver
{
	private String path; //文件路径
	private String something;//写入的字符串
	//初始化
	public WriteOver() 
	{
		path = null;
		something = "缺省文字";
	} 

	//设置文件路径
	public void setPath(String apath) 
	{
		path = apath;
	} 

	//得到文件路径
	public String getPath() 
	{
		return path;
	} 
	
	//得到字符串
	public void setSomething(String asomething) 
	{
		something = asomething;
	}
	
	//设置字符串
	public String getSomething() 
	{
		return something;
	}

	//写入字符串到文件中，成功则返回success字符串
//	public int writeSomething() 
	{
		int r=0;
//		try 
		{
//			File f = new File(path);
//			PrintWriter out = new PrintWriter(new FileWriter(f));
//			System.out.print(this.getSomething() + "\n");
//			System.out.close();
			r=1;
		}
//		catch (IOException e) 
		{
//			System.err.println("e.toString:"+e.toString());
		}
//		return r;
	} 
} 
　　