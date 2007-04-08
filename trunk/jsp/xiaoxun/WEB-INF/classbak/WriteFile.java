import java.io.*;
import java.util.*;

public class WriteFile
{
	public static void main(String[] args) 
	{ 
		try
		{ 
			RandomAccessFile rf1 = new RandomAccessFile("d:\\jeru.txt","rw"); 
			for (int i = 0; i < 10; i ++ )
			{
				String str = "xixi,这是第 "+i+"行"+"\n";
				str = new String(str.getBytes(),"ISO8859-1");
				rf1.writeBytes(str);
				//rf1.writeBytes(new String(str.getBytes("ISO8859-1"))); 
			}
			rf1.close();
			int i = 0; 
			String record = new String(); 
			RandomAccessFile rf2 = new RandomAccessFile("d:\\jeru.txt","rw"); 
			rf2.seek(rf2.length()); 
			rf2.writeBytes("lala,append line"+"\n"); 
			rf2.close(); 
			RandomAccessFile rf3 = new RandomAccessFile("d:\\jeru.txt","r"); 
			while ((record = rf3.readLine()) != null) 
			{
				i ++; 
				System.out.println("Value "+i+":"+record); 
			}
			rf3.close(); 
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
	}
	
}
 
