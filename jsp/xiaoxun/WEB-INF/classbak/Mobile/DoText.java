package Mobile;

import java.io.*;
import java.util.*;

/**
 * ���ڴ����ı�����
*/

public class DoText {

  public DoText() {
  }

    /**
   * �ָ��ִ�
   * @param source ԭʼ�ַ�
   * @param div �ָ��
   * @return �ַ�������
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
   * �ַ����滻����
   * @param str ԭʼ�ַ���
   * @param substr Ҫ�滻���ַ�
   * @param restr �滻����ַ�
   * @return �滻��ɵ��ַ���
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
   * ���س����滻��Html�еĻ��з�
   * @param txt ԭʼ�ı�
   * @return �滻֮����ı�
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
   * ��Html�еĻ��з�ȥ��
   * @param txt ԭʼ�ı�
   * @return �滻֮����ı�
   */
  public String delBr(String txt){
      if (txt != null) {
          txt = replace(txt,"<br>","");
      }
      return txt;
  }

  /**
   * Ϊ'��\����ת�Ʒ����Ա�������ݿ⣬'�滻Ϊ\'��\�滻Ϊ\\
   * @param txt ԭʼ�ı�
   * @return ����ת�Ʒ�����ı�
   */
  public String addSlashes(String txt){
      if (txt != null) {
          txt = replace(txt,"\\","\\\\");
          txt = replace(txt,"\'","\\\'");
      }
      return txt;
  }

  /**
   * ȡ��ת�Ʒ�
   * @param txt ԭʼ�ı�
   * @return ȡ��ת�Ʒ�����ı�
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
   * ȡ��Html���
   * @param txt ԭʼ�ı�
   * @return ȡ��Html��Ǻ���ı�
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
   * ����Html���
   * @param txt ԭʼ�ı�
   * @return ����Html����ı�
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
   * ȥ��Html�нű����
   * @param txt ԭʼ�ı�
   * @return ȥ���ű�����ı�
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
   * ����������⣬ISOתΪGBK���룬����POST��GET��ʽȡ������
   * @param str ԭʼ�ı�
   * @return ת�����ı�
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
   * ����������⣬GBKתISO���룬���ڴ����ݿ��д���ת��
   * @param str ԭʼ�ı�
   * @return ת�����ı�
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
	  String sou="��������";
	  DoText app=new DoText();
	  str=app.gb2iso(sou);
	  sou=app.iso2gb(	str);
	  System.out.println(str);
	  System.out.println(sou);                                     
	}
  **/
}