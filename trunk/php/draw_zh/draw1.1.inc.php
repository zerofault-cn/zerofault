<?php
/*************************************
*
**    中文显示点阵输出   version 1.1
*
**    操作：输出任意格式字符串（ASCII码、中文混合）
*
**    更多功能，请见下一版本。
*
****************************************/
function drawer($image,$string)
{
   $color= imagecolorallocate ($image, 255, 0, 0);
   $strlen=strlen($string);//首先记录下字符串长度，用来计算画完一个字符后，X轴位置要移动多少
   $fp=fopen("chs16.fon","rb");
   if (!feof($fp))
   {
      while($string)
      {
         $qh=ord(substr($string,0,1));
         $num=0;
         if($qh>127)                      //如果是中文字符的第一个字节
         {
	    $qh-=0xa0;
	    $wh=ord(substr($string,1,2))-0xa0;
	    $num++;                               //是中文
         }
	 if($num==1)                          //中文显示
         {
  	    $offset=(94*($qh-1)+($wh-1))*32;
	    fseek($fp,$offset,SEEK_SET);
            $buffer=preg_split('//', fread($fp,32), -1, PREG_SPLIT_NO_EMPTY);

            for($i=0;$i<16;$i++)
	       for($j=0;$j<2;$j++)
	          for($k=0;$k<8;$k++)
		     if(((ord($buffer[$i*2+$j])>>(7-$k))&0x01))
		     {
		        imagesetpixel($image,$x+8*$j+$k, $i, $color);
           	     }

            $string=substr($string,2);
         }
         else                                     //ASCII显示
         {
            imagestring ($image,12,$x,0,substr($string,0,1),$color);    //显示位置为($x,0)
            $string=substr($string,1);
         }
         $x=($strlen-strlen($string))*9;//用了strlen()之后，就不用区分是中文还是英文显示的X轴偏移量了
     }
  }
  fclose($fp);
}
?>