<?php
/*************************************
*
**    ������ʾ�������   version 1.1
*
**    ��������������ʽ�ַ�����ASCII�롢���Ļ�ϣ�
*
**    ���๦�ܣ������һ�汾��
*
****************************************/
function drawer($image,$string)
{
   $color= imagecolorallocate ($image, 255, 0, 0);
   $strlen=strlen($string);//���ȼ�¼���ַ������ȣ��������㻭��һ���ַ���X��λ��Ҫ�ƶ�����
   $fp=fopen("chs16.fon","rb");
   if (!feof($fp))
   {
      while($string)
      {
         $qh=ord(substr($string,0,1));
         $num=0;
         if($qh>127)                      //����������ַ��ĵ�һ���ֽ�
         {
	    $qh-=0xa0;
	    $wh=ord(substr($string,1,2))-0xa0;
	    $num++;                               //������
         }
	 if($num==1)                          //������ʾ
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
         else                                     //ASCII��ʾ
         {
            imagestring ($image,12,$x,0,substr($string,0,1),$color);    //��ʾλ��Ϊ($x,0)
            $string=substr($string,1);
         }
         $x=($strlen-strlen($string))*9;//����strlen()֮�󣬾Ͳ������������Ļ���Ӣ����ʾ��X��ƫ������
     }
  }
  fclose($fp);
}
?>