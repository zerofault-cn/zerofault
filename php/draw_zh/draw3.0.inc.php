<?php
/*************************************
*
**    ������ʾ�������   version 3.0
*
**    �����������$col��$row����С���ַ�����ͼƬ
*
**    ���๦�ܣ������һ�汾��
*
****************************************/
function drawer($image,$string,$x,$y,$color,$col,$row)//��ӿ�ȴ�С������$col,$row��
{
//   $color= imagecolorallocate ($image, 255, 0, 0,);//��һ�в�����
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
	       for($n=0;$n<$col;$n++)//����X��ѭ��
	          for($j=0;$j<2;$j++)
	             for($k=0;$k<8;$k++)
		        for($m=0;$m<$row;$m++) //����Y��ѭ��
		        if(((ord($buffer[$i*2+$j])>>(7-$k))&0x01))
		        {
		           imagesetpixel($image,$x+8*$j*$col+$k*$col+$m, $y+$i*$row+$n, $color);//�޸������λ�ò���
           	        }
            $string=substr($string,2);
            $x+=18*$col;   //�޸�X��ƫ����
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