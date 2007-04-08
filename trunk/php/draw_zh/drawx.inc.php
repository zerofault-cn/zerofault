<?php
function drawer($image,$string,$x,$y,$color,$co,$ro)
{
$COL= 6;
$ROW= 6;//预定义输出字符大小
//这时，$co,$ro就是字符笔划的厚度

   $fp=fopen("CHS16.fon","rb");
   if (!feof($fp))
   {
      while($string)
      {
	 $qh=ord(substr($string,0,1));
         $num=0;
         if($qh>127)
         {
	    $qh=ord(substr($string,0,1))-0xa0;
	    $wh=ord(substr($string,1,2))-0xa0;
            $num++;
         }
	 $offset=(94*($qh-1)+($wh-1))*32;
	 fseek($fp,$offset,SEEK_SET);
         $buffer=preg_split('//', fread($fp,32), -1, PREG_SPLIT_NO_EMPTY);
	 if($num==1)
         {
            for($i=0;$i<16;$i++)
	       for($n=0;$n<$ROW+$co;$n++)
	          for($j=0;$j<2;$j++)
		     for($k=0;$k<8;$k++)
		        for($m=0;$m<$COL+$ro;$m++)
			   if(((ord($buffer[$i*2+$j])>>(7-$k))&0x01))
			   {
			       imagesetpixel($image,$x+8*$j*$COL+$k*$COL+$m, $y+$i*$ROW+$n, $color);
           	           }
	    $counter++;
            $string=substr($string,2);
            //if($signal==1)
              $x+=($COL+2)*16;
            //else $x+=$place;
         }
         else
         {
	    //imagestring ($image,12,$x,$y,substr($string,0,1),$color);
            $string=substr($string,1);
            $x+=16;
         }
     }
  }
  fclose($fp);
//  return $x;//返回X轴坐标
}
?>