<?php
/*************************************
*
**    中文显示点阵输出   version 2.1
*
**    操作：输出$color颜色的字符串到图片
*
**    更多功能，请见下一版本。
*
****************************************/
function drawer($image,$string,$x,$y,$color)//添加颜色参数（$color）
{
//   $color= imagecolorallocate ($image, 255, 0, 0,);//这一行不用了
   $fp=fopen("chs16.fon","rb");
   if (feof($fp))
   {
      fclose($fp);
      return 0;
   }
      while($string)
      {
         $qh=ord(substr($string,0,1));
         $num=0;
         if($qh>127)
         {
	    $qh-=0xa0;
	    $wh=ord(substr($string,1,2))-0xa0;
	    $num++;
         }
	 if($num==1)
         {
  	    $offset=(94*($qh-1)+($wh-1))*32;
	    fseek($fp,$offset,SEEK_SET);
            $buffer=preg_split('//', fread($fp,32), -1, PREG_SPLIT_NO_EMPTY);

            for($i=0;$i<16;$i++)
	       for($j=0;$j<2;$j++)
	          for($k=0;$k<8;$k++)
		     if(((ord($buffer[$i*2+$j])>>(7-$k))&0x01))
		     {
		        imagesetpixel($image,$x+8*$j+$k, $y+$i, $color);
           	     }
            $string=substr($string,2);
            $x+=18;
         }
         else
         {
            imagestring ($image,12,$x,$y,substr($string,0,1),$color); 
            $string=substr($string,1);
            $x+=10;
         }
     }
//  }
//  fclose($fp);
}
?>