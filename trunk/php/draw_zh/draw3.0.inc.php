<?php
/*************************************
*
**    中文显示点阵输出   version 3.0
*
**    操作：输出（$col×$row）大小的字符串到图片
*
**    更多功能，请见下一版本。
*
****************************************/
function drawer($image,$string,$x,$y,$color,$col,$row)//添加宽度大小参数（$col,$row）
{
//   $color= imagecolorallocate ($image, 255, 0, 0,);//这一行不用了
   $fp=fopen("chs16.fon","rb");
   if (!feof($fp))
   {
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
	       for($n=0;$n<$col;$n++)//增加X轴循环
	          for($j=0;$j<2;$j++)
	             for($k=0;$k<8;$k++)
		        for($m=0;$m<$row;$m++) //增加Y轴循环
		        if(((ord($buffer[$i*2+$j])>>(7-$k))&0x01))
		        {
		           imagesetpixel($image,$x+8*$j*$col+$k*$col+$m, $y+$i*$row+$n, $color);//修改输出的位置参数
           	        }
            $string=substr($string,2);
            $x+=18*$col;   //修改X轴偏移量
         }
         else
         {
            imagestring ($image,12,$x,$y,substr($string,0,1),$color); 
            $string=substr($string,1);
            $x+=10;
         }
     }
  }
  fclose($fp);
}
?>