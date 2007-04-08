package Mobile;

import java.io.*;
import java.util.*;

/**
 * 用于处理文本对象
*/

public class DoText {

  public DoText() {
  }

    /**
   * 分割字串
   * @param source 原始字符
   * @param div 分割符
   * @return 字符串数组
   */
  public String[] split(String source,String div){
      int arynum = 0,intIdx=0,intIdex=0,div_length = div.length();
      if(source.compareTo("")!=0){
          if(source.indexOf(div)!=-1){
              intIdx = source.indexOf(div);
              for(int intCount =1 ; ; intCount++){
                  if(source.indexOf(div,intIdx+div_length)!=-1){
                      intIdx= source.indexOf(div,intIdx+div_length);
                      arynum = intCount;
                  }
                  else {arynum+=2;break;}
              }
          }else arynum =1;
      }else arynum = 0;

      intIdx=0;
      intIdex=0;
      String[] returnStr = new String[arynum];

      if(source.compareTo("")!=0){
          if(source.indexOf(div)!=-1){
              intIdx = (int)source.indexOf(div);
              returnStr[0]= (String)source.substring(0,intIdx);
              for(int intCount =1 ; ; intCount++){
                  if(source.indexOf(div,intIdx+div_length)!=-1){
                      intIdex=(int)source.indexOf(div,intIdx+div_length);
                      returnStr[intCount] = (String)source.substring(intIdx+div_length,intIdex);
                      intIdx = (int)source.indexOf(div,intIdx+div_length);
                  }
                  else {
                      returnStr[intCount] = (String)source.substring(intIdx+div_length,source.length());
                      break;
                  }
              }
          }
          else {returnStr[0] = (String)source.substring(0,source.length());return returnStr;}
      }
      else {return returnStr;}
      return returnStr;
  }


  public String dealNull(String str) {
      String returnstr = null;
      if (str == null) returnstr = "";
      else returnstr = str;
      return returnstr;
  }

  public Object dealNull(Object obj){
      Object returnstr = null;
      if (obj == null) returnstr = (Object)("");
      else returnstr = obj;
      return returnstr;
  }

  int dealEmpty(String s) {
      s = dealNull(s);
      if (s.equals("")) return 0;
      return Integer.parseInt(s);
  }

  /**
   * 字符串替换函数
   * @param str 原始字符串
   * @param substr 要替换的字符
   * @param restr 替换后的字符
   * @return 替换完成的字符串
   */
  public String replace(String str,String substr,String restr){
      String[] tmp = split(str,substr);
      String returnstr = null;
      if(tmp.length!=0) {
          returnstr = tmp[0];
          for(int i = 0 ; i < tmp.length - 1 ; i++)
              returnstr =dealNull(returnstr) + restr +tmp[i+1];
          }
      return dealNull(returnstr);
  }

  /**
   * 将回车符替换成Html中的换行符
   * @param txt 原始文本
   * @return 替换之后的文本
   */
  public String addBr(String txt){
      if (txt != null) {
          txt = replace(txt,"\n","<br>");
      }
      return txt;
  }

  public String addColon(String txt) {
      if (txt != null) {
          txt = replace(txt,"<br>",":<br>");
      }
      return txt;
  }

  public String changeColor(String txt) {
      if (txt != null) {
          txt = replace(txt,"<br>","</font><br>");
          txt = replace(txt,"<br>:","<br><font color=#408080>:");
      }
      return txt;
  }

  /**
   * 将Html中的换行符去掉
   * @param txt 原始文本
   * @return 替换之后的文本
   */
  public String delBr(String txt){
      if (txt != null) {
          txt = replace(txt,"<br>","");
      }
      return txt;
  }

  /**
   * 为'和\增加转移符，以便加入数据库，'替换为\'，\替换为\\
   * @param txt 原始文本
   * @return 增加转移符后的文本
   */
  public String addSlashes(String txt){
      if (txt != null) {
          txt = replace(txt,"\\","\\\\");
          txt = replace(txt,"\'","\\\'");
      }
      return txt;
  }

  /**
   * 取消转移符
   * @param txt 原始文本
   * @return 取消转移符后的文本
   */
  public String stripslashes(String txt){
      if (txt != null) {
          txt = replace(txt,"\\\\","\\");
          txt = replace(txt,"\'","'");
          txt = replace(txt,"\\\"","\"");
          txt = replace(txt,"\\&quot;","\"");
      }
      return txt;
  }

  /**
   * 取消Html标记
   * @param txt 原始文本
   * @return 取消Html标记后的文本
   */
  public String htmlEncode(String txt){
      if (txt != null) {
          txt = replace(txt,"&","&amp;");
          txt = replace(txt,"&amp;amp;","&amp;");
          txt = replace(txt,"&amp;quot;","&quot;");
          txt = replace(txt,"\"","&quot;");
          txt = replace(txt,"&amp;lt;","&lt;");
          txt = replace(txt,"<","&lt;");
          txt = replace(txt,"&amp;gt;","&gt;");
          txt = replace(txt,">","&gt;");
          txt = replace(txt,"&amp;nbsp;","&nbsp;");
          //txt = replace(txt," ","&nbsp;");
      }
      return txt;
  }

  /**
   * 返回Html标记
   * @param txt 原始文本
   * @return 返回Html后的文本
   */
  public String unHtmlEncode(String txt){
      if (txt != null) {
          txt = replace(txt,"&amp;","&");
          txt = replace(txt,"&quot;","\"");
          txt = replace(txt,"&lt;","<");
          txt = replace(txt,"&gt;",">");
          txt = replace(txt,"&nbsp;"," ");
      }
      return txt;
  }

  /**
   * 去除Html中脚本标记
   * @param txt 原始文本
   * @return 去除脚本后的文本
   */
  public String ScriptEncode(String txt){
      if (txt != null) {
          txt = replace(txt,"script"," ");
          txt = replace(txt,"SCRIPT"," ");
          txt = replace(txt,"Script"," ");
          txt = replace(txt,"SCript"," ");
      }
      return txt;
  }

  /**
   * 解决中文问题，ISO转为GBK编码，用于POST，GET方式取得数据
   * @param str 原始文本
   * @return 转码后的文本
   */
  public String iso2gb(String str) {
      if (str != null) {
          byte[] tmpbyte=null;
          try {
              tmpbyte=str.getBytes("ISO8859_1");
          }
          catch (UnsupportedEncodingException e) {
              System.out.println("Error: Method: dbconn.iso2gb :"+e.getMessage());
          }
          try {
              str=new String(tmpbyte,"GBK");
          }
          catch(UnsupportedEncodingException e) {
              System.out.println("Error: Method: dbconn.gb2iso :"+e.getMessage());
          }
      }
      return str;
  }

  /**
   * 解决中文问题，GBK转ISO编码，用于从数据库中存入转码
   * @param str 原始文本
   * @return 转换后文本
   */
  public String gb2iso(String str) {
      if (str != null) {
          byte[] tmpbyte=null;
          try {
              tmpbyte=str.getBytes("GBK");
          }
          catch(UnsupportedEncodingException e) {
              System.out.println("Error: Method: dbconn.gb2iso :"+e.getMessage());
          }
          try {
              str=new String(tmpbyte,"ISO8859_1");
          }
          catch(UnsupportedEncodingException e) {
              System.out.println("Error: Method: dbconn.gb2iso :"+e.getMessage());
          }
      }
      return str;
  }
  /**public static void main(String args[])
	{
	  String str=null;
	  String sou="我日死你";
	  DoText app=new DoText();
	  str=app.gb2iso(sou);
	  sou=app.iso2gb(	str);
	  System.out.println(str);
	  System.out.println(sou);                                     
	}
  **/
}