package com.laoer.bbscs.txthtml;

/**
 * Title:        BBS-CS
 * Description:  BBS-CS(BBSʽ��������ϵͳ)
 * Copyright:    Copyright (c) 2002
 * Company:      loveroom.com.cn
 * @author �����ң�laoer��
 * @version 3.0
 */

import java.io.*;

/**
 * CharValid�������ж��������������ͣ����������͡�����ĸ�ͺ�������ĸ��
 */
public class CharValid{

  /**
   * �ж��Ƿ�Ϊ������ɵ��ִ�
   * @param validString Ҫ�жϵ��ַ���
   * @return boolenֵ��true��false
   */
  public static boolean isNumber(String validString){
      byte[] tempbyte=validString.getBytes();
      for(int i=0;i<validString.length();i++) {
          //by=tempbyte[i];
          if((tempbyte[i]<48)||(tempbyte[i]>57)){
              return false;
          }
      }
      return true;
  }

  /**
   * �ж��ַ����Ƿ�Ϊֻ������ĸ������
   * @param validString Ҫ�жϵ��ַ���
   * @return boolenֵ��true��false
   */
  public static boolean isChar(String validString){
      byte[] tempbyte=validString.getBytes();
      for(int i=0;i<validString.length();i++) {
          //  by=tempbyte[i];
          if((tempbyte[i]<48)||((tempbyte[i]>57)&(tempbyte[i]<65))||(tempbyte[i]>122)||((tempbyte[i]>90)&(tempbyte[i]<97))) {
              return false;
          }
      }
      return true;
  }

  /**
   * �ж��ַ����Ƿ�ֻ������ĸ
   * @param validString Ҫ�жϵ��ַ���
   * @return boolenֵ��true��false
   */
  public static boolean isLetter(String validString){
    byte[] tempbyte=validString.getBytes();
    for(int i=0;i<validString.length();i++) {
        //by=tempbyte[i];
        if((tempbyte[i]<65)||(tempbyte[i]>122)||((tempbyte[i]>90)&(tempbyte[i]<97))) {
            return false;
        }
    }
    return true;
  }

}