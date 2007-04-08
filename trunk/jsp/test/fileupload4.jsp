import java.io.*; 
import javax.servlet.ServletInputStream; 
import javax.servlet.http.HttpServletRequest; 

public class transfer_multi { 
public String[] sourcefile = new String[255];//源文件名 
public String objectpath = "c:/";//目标文件目录 
public String[] suffix = new String[255];//文件后缀名 
public String[] objectfilename = new String[255];//目标文件名 
public ServletInputStream sis = null;//输入流 
public String[] description = new String[255];//描述状态 
public long size = 100*1024;//限制大小 
private int count = 0;//已传输文件数目 
private byte[] b = new byte[4096];//字节流存放数组 
private boolean successful = true; 

public void setSourcefile(HttpServletRequest request) throws java.io.IOException{ 
sis = request.getInputStream(); 
int a = 0; 
int k = 0; 
String s = ""; 
while((a = sis.readLine(b,0,b.length)) != -1){ 
s = new String(b,0,a); 
if((k = s.indexOf("filename=")) != -1){ 
s = s.substring(k+10); 
k = s.indexOf("""); 
s = s.substring(0,k); 
sourcefile[count] = s; 

k = s.lastIndexOf("."); 
suffix[count] = s.substring(k+1); 
System.out.println(suffix[count]); 
if(canTransfer(count)) transferfile(count); 
} 
if(!successful) break; 
} 
} 
public int getCount(){ 
return count; 
} 
public String[] getSourcefile(){ 
return sourcefile; 
} 

public void setObjectpath(String objectpath){ 
this.objectpath = objectpath; 
} 
public String getObjectpath(){ 
return objectpath; 
} 
private boolean canTransfer(int i){ 
suffix[i] = suffix[i].toLowerCase(); 
//这个是我用来传图片的，各位可以把后缀名改掉或者不要这个条件 
if(sourcefile[i].equals("")||(!suffix[i].equals("gif")&&!suffix[i].equals("jpg")&&!suffix[i].equals("jpeg"))) {description[i]="ERR suffix is wrong";return false;} 
else return true; 
} 
private void transferfile(int i){ 
String x = Long.toString(new java.util.Date().getTime()); 
try{ 
objectfilename[i] = x+"."+suffix[i]; 
FileOutputStream out = new FileOutputStream(objectpath+objectfilename[i]); 
int a = 0; 
int k = 0; 
long hastransfered = 0;//标示已经传输的字节数 
String s = ""; 
while((a = sis.readLine(b,0,b.length)) != -1){ 
s = new String(b,0,a); 
if((k = s.indexOf("Content-Type:")) != -1) break; 
} 
sis.readLine(b,0,b.length); 
while((a = sis.readLine(b,0,b.length)) != -1){ 
s = new String(b,0,a); 
if((b[0]==45)&&(b[1]==45)&&(b[2]==45)&&(b[3]==45)&&(b[4]==45)) break; 
out.write(b,0,a); 
hastransfered+=a; 
if(hastransfered>=size){ 
description[count] = "ERR The file "+sourcefile[count]+" is too large to transfer. The whole process is interrupted."; 
successful = false; 
break; 
} 
} 
if(successful) description[count] = "Right The file "+sourcefile[count]+" has been transfered successfully."; 
++count; 
out.close(); 
if(!successful){ 
sis.close(); 
File tmp = new File(objectpath+objectfilename[count-1]); 
tmp.delete(); 
} 
} 
catch(IOException ioe){ 
description[i]=ioe.toString(); 
} 

} 

public transfer_multi(){ 
//可以在构建器里面构建服务器上传目录，也可以在javabean调用的时候自己构建 
setObjectpath("/home/www/jspvhost4/web/popeyelin/images/"); 
} 
}