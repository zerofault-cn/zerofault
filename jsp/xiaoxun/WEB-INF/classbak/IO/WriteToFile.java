package IO;
import java.io.*;
import java.io.RandomAccessFile;
public class WriteToFile
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
				System.out.println("success");
				raf.close();
				return "success";
				}
			catch (IOException e){
				System.out.print("failure");
				return "failure";
				}
		}
	/*	public static void main(String args[])
		 {
			String apath="test.txt";
			String acrlf=null;
			WriteToFile app=new WriteToFile();
			app.setPath(apath);
			acrlf=app.getCrlf();
			String asomething="This"+acrlf+"is"+acrlf+"a"+acrlf+"test";
			app.setSomething(asomething);
			app.writeSomething();
		 }
	*/

}