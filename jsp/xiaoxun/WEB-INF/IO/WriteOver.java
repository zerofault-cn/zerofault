package IO;
import java.io.*;

public class WriteOver
{
	private String path; //�ļ�·��
	private String something;//д����ַ���
	//��ʼ��
	public WriteOver() 
	{
		path = null;
		something = "ȱʡ����";
	} 

	//�����ļ�·��
	public void setPath(String apath) 
	{
		path = apath;
	} 

	//�õ��ļ�·��
	public String getPath() 
	{
		return path;
	} 
	
	//�õ��ַ���
	public void setSomething(String asomething) 
	{
		something = asomething;
	}
	
	//�����ַ���
	public String getSomething() 
	{
		return something;
	}

	//д���ַ������ļ��У��ɹ��򷵻�success�ַ���
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
����