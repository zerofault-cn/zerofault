<?php 

//文件名  : ldap_utf8.php
//日期    : 2003年6月9日
//功能    : GB2312 BIG5与 UTF8 之间的互相转换 支持中英文混写
//作者    : loyalman
//E-MAIL  : loyalman@sina.com
//说明    : 任何人都可以自由的进行修改和引用

//读取文件只读一次 
//$gb2312_filename="gb2312.txt";
//$gb2312_tmp=file($gb2312_filename,1);

//$big5_filename = "big5.txt";
//$big5_tmp = file($big5_filename, 1);

function U2toUtf8($c)
{
	$str="";	
			
	if ($c < 0x80) 
	{
		$str.=chr($c);
	}
	else if ($c < 0x800) 
	{
		$str.=chr(0xC0 | $c>>6);
		$str.=chr(0x80 | $c & 0x3F);
	}
	else if ($c < 0x10000) 
	{
		$str.=chr(0xE0 | $c>>12);
		$str.=chr(0x80 | $c>>6 & 0x3F);
		$str.=chr(0x80 | $c & 0x3F);
	}
	else if ($c < 0x200000) 
	{
		$str.=chr(0xF0 | $c>>18);
		$str.=chr(0x80 | $c>>12 & 0x3F);
		$str.=chr(0x80 | $c>>6 & 0x3F);
		$str.=chr(0x80 | $c & 0x3F);
	}
	
	return $str;
}

function GB2312toUTF8($gb)
{
	if(!trim($gb))
	   return $gb;
	   
	$gb2312_filename="gb2312.txt";
	$gb2312_tmp=file($gb2312_filename,1);
	
	$codetable=array();
	
	while(list($key,$value)=each($gb2312_tmp))
	   $codetable[hexdec(substr($value,0,6))]=substr($value,7,6);

        $utf8="";
        while($gb)
        {
        	if (ord(substr($gb,0,1))>127)
        	{
        		$this=substr($gb,0,2);
        		$gb=substr($gb,2,strlen($gb));
        		$utf8.=U2toUtf8(hexdec($codetable[hexdec(bin2hex($this))-0x8080]));
                }
                else
                {
                	$utf8.=substr($gb,0,1);
                	$gb=substr($gb,1,strlen($gb));                	
                }
        }
        
        return $utf8;
}

function UTF8toGB2312($utf8)
{
	if(!trim($utf8))
	    return $utf8;
	    
	$gb2312_filename="gb2312.txt";
	$gb2312_tmp=file($gb2312_filename,1);
	
	$codetable=array();
	
	while(list($key,$value)=each($gb2312_tmp))	   
	   $codetable[hexdec(substr($value,7,6))] = substr($value,0,6);
	   

        $gb="";
      
        while($utf8)
        {
        	if (ord(substr($utf8,0,1)) < 127)   //1 byte 
        	{
        		$this = substr($utf8, 0, 1);
        		$utf8 = substr($utf8, 1, strlen($utf8));
        		
        		$gb .= $this;        		
        	}
        	else  if(ord(substr($utf8,0,1)) <  0xE0)  // 2 byte
        	{
        		$this =substr($utf8,0,2);
        		$utf8 = substr($utf8,2,strlen($utf8));
        		
        		$ch1 = substr($this, 0, 1);
        		$ch2 = substr($this, 1, 1);
        		
        		$num = ((ord($ch1) & 0x1F) << 6) | (ord($ch2) & 0x3F);        		
        		$num = hexdec($codetable[$num]) + 0x8080;
        		
        		$gb .= chr($num >> 8);
        		$gb .= chr($num & 0xFF);
                }
                else  if(ord(substr($utf8, 0, 1)) < 0xF0 ) // 3 byte
                {
                	$this = substr($utf8, 0, 3);
                	$utf8 = substr($utf8, 3, strlen($utf8)); 
                	
                	$ch1 = substr($this, 0, 1);                	
        		$ch2 = substr($this, 1, 1);        		
        		$ch3 = substr($this, 2, 1);
        		
        		$num = ((ord($ch1) & 0x0F) << 12) | ((ord($ch2) & 0x3F) << 6) | (ord($ch3) & 0x3F);
        		$num = hexdec($codetable[$num]) + 0x8080;
        		
        		$gb .= chr($num >> 8);
        		$gb .= chr($num & 0xFF);        		            	
                }
        }
        
        return $gb;
}

function BIG5toUTF8($big)
{
	if(!trim($big))
	   return $big;
	   
	$big5_filename = "big5.txt";
	$big5_tmp = file($big5_filename, 1);
	
	$codetable=array();
	
	while(list($key,$value)=each($big5_tmp))
	   $codetable[hexdec(substr($value,0,6))]=substr($value,7,6);

        $utf8="";
        while($big)
        {
        	if (ord(substr($big,0,1))>127)
        	{
        		$this=substr($big,0,2);
        		$big=substr($big,2,strlen($big));
        		$utf8.=U2toUtf8(hexdec($codetable[hexdec(bin2hex($this))]));
                }
                else
                {
                	$utf8.=substr($big,0,1);
                	$big=substr($big,1,strlen($big));                	
                }
        }
        
        return $utf8;
}

function UTF8toBIG5($utf8)
{
	if(!trim($utf8))
	    return $utf8;
	    
	$big5_filename = "big5.txt";
	$big5_tmp = file($big5_filename, 1);
	    	
	$codetable=array();
	
	while(list($key,$value)=each($big5_tmp))	   
	   $codetable[hexdec(substr($value,7,6))] = substr($value,0,6);
	   

      $big="";
      
      while($utf8)
        {
        	if (ord(substr($utf8,0,1)) < 127 )   //1 byte 
        	{
        		$this = substr($utf8, 0, 1);
        		$utf8 = substr($utf8, 1, strlen($utf8));
        		
        		$big .= $this;        		
        	}
        	else  if (ord(substr($utf8,0,1)) <  0xE0 )  // 2 byte
        	{
        		$this=substr($utf8,0,2);
        		$utf8=substr($utf8,2,strlen($utf8));
        		
        		$ch1 = substr($this, 0, 1);
        		$ch2 = substr($this, 1, 1);
        		
        		$num = ((ord($ch1) & 0x1F) << 6) | (ord($ch2) & 0x3F);        		
        		$num = hexdec($codetable[$num]);
        		
        		$big .= chr($num >> 8);
        		$big .= chr($num & 0xFF);
                }
                else  if ( ord(substr($utf8, 0, 1)) < 0xF0 ) // 3 byte
                {
                	$this = substr($utf8, 0, 3);
                	$utf8 = substr($utf8, 3, strlen($utf8)); 
                	
                	$ch1 = substr($this, 0, 1);                	
        		$ch2 = substr($this, 1, 1);        		
        		$ch3 = substr($this, 2, 1);
        		
        		$num = ((ord($ch1) & 0x0F) << 12) | ((ord($ch2) & 0x3F) << 6) | (ord($ch3) & 0x3F);
        		$num = hexdec($codetable[$num]) ;
        		
        		$big .= chr($num >> 8);
        		$big .= chr($num & 0xFF);        		            	
                }
        }
        
        return $big;
}
?>