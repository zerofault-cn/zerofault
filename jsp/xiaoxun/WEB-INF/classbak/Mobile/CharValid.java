package com.laoer.bbscs.txthtml;

/**
 * Title:        BBS-CS
 * Description:  BBS-CS(BBS式虚拟社区系统)
 * Copyright:    Copyright (c) 2002
 * Company:      loveroom.com.cn
 * @author 龚天乙（laoer）
 * @version 3.0
 */

import java.io.*;

/**
 * CharValid类用于判断所处理文字类型，即纯数字型、纯字母型和数字字母型
 */
public class CharValid{

  /**
   * 判断是否为数字组成的字串
   * @param validString 要判断的字符串
   * @return boolen值，true或false
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
   * 判断字符串是否为只包括字母和数字
   * @param validString 要判断的字符串
   * @return boolen值，true或false
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
   * 判断字符串是否只包括字母
   * @param validString 要判断的字符串
   * @return boolen值，true或false
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