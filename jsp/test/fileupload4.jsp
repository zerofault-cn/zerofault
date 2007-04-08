import java.io.*; 
import javax.servlet.ServletInputStream; 
import javax.servlet.http.HttpServletRequest; 

public class transfer_multi { 
public String[] sourcefile = new String[255];//Դ�ļ��� 
public String objectpath = "c:/";//Ŀ���ļ�Ŀ¼ 
public String[] suffix = new String[255];//�ļ���׺�� 
public String[] objectfilename = new String[255];//Ŀ���ļ��� 
public ServletInputStream sis = null;//������ 
public String[] description = new String[255];//����״̬ 
public long size = 100*1024;//���ƴ�С 
private int count = 0;//�Ѵ����ļ���Ŀ 
private byte[] b = new byte[4096];//�ֽ���������� 
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
//�������������ͼƬ�ģ���λ���԰Ѻ�׺���ĵ����߲�Ҫ������� 
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
long hastransfered = 0;//��ʾ�Ѿ�������ֽ��� 
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
//�����ڹ��������湹���������ϴ�Ŀ¼��Ҳ������javabean���õ�ʱ���Լ����� 
setObjectpath("/home/www/jspvhost4/web/popeyelin/images/"); 
} 
}