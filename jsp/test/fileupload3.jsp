package testupload;
import java.io.*;
import javax.servlet.http.HttpServletRequest;


public class RunningUpLoader {
public RunningUpLoader() {
}

/**
* 上传文件
* @param request HttpServletRequest Servlet的请求对象
* @param name String 要上传的文件在表单中的参数名
* @param fileName String 保存在服务器上的文件名
* @throws IOException
*/
public void doUpload(HttpServletRequest request, String name,String fileName) throws
IOException {
InputStream in = request.getInputStream();
byte[] buffer = getFileContent(name,in);
FileOutputStream fos = new FileOutputStream(fileName);
fos.write(buffer,0,buffer.length-1);
fos.close();
}

/**
* 获取上传的文件buffer,结尾处将多一个换行符
* @param name String 文件上传参数的名字
* @param is InputStream 服务器对话的输入流
* @return byte[] 返回获取的文件的buffer,结尾处多一个换行符
* @throws IOException
*/
private byte[] getFileContent(String name, InputStream is) throws IOException{
int index;
boolean isEnd = false;
byte[] lineSeparatorByte;
byte[] lineData;
String content_disposition;
ByteArrayOutputStream bos = new ByteArrayOutputStream();
BufferedInputStream bis = new BufferedInputStream(is);

lineSeparatorByte = readStreamLine(bis);
while(!isEnd) {
lineData = readStreamLine(bis);
if(lineData == null) {
break;
}
content_disposition = new String(lineData,"ASCII");
index = content_disposition.indexOf("name=\"" + name + "\"");
if (index >= 0 && index < content_disposition.length()) {
System.out.println(readStreamLineAsString(bis)); // skip a line
System.out.println(readStreamLineAsString(bis)); // skip a line

while ((lineData = readStreamLine(bis)) != null) {
System.out.println(new String(lineData));
if (isByteArraystartWith(lineData, lineSeparatorByte)) { // end
isEnd = true;
break;
} else {
bos.write(lineData);
}
}
}else {
lineData = readStreamLine(bis);
if(lineData == null)
return null;
System.out.println(new String(lineData,"ASCII"));
while(!isByteArraystartWith(lineData, lineSeparatorByte)) {
lineData = readStreamLine(bis);
if(lineData == null)
return null;
System.out.println(new String(lineData,"ASCII"));
}
}
}
return bos.toByteArray();
}

private byte[] readStreamLine(BufferedInputStream in) throws IOException{
ByteArrayOutputStream bos = new ByteArrayOutputStream();
int b = in.read();
if(b== -1)
return null;
while(b != -1 && b != '\n') {
bos.write(b);
b = in.read();
}
return bos.toByteArray();
}

private String readStreamLineAsString(BufferedInputStream in) throws IOException {
return new String(readStreamLine(in),"ASCII");
}

private boolean isByteArraystartWith(byte[] arr,byte[] pat) {
int i;
if(arr == null || pat == null)
return false;
if(arr.length < pat.length)
return false;
for(i=0;i if(arr[i] != pat[i])
return false;
}
return true;
}
}


