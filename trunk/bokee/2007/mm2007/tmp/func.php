<?
define('IN_MATCH', true);
//2005-09-22 14:41
//字符串截取函数，以保证得到的字符串中没有半个汉字的情况
function substr_cut($str_cut,$length = 10)
{  
if (strlen($str_cut) > $length){ 
  for($i=0; $i < $length; $i++) 
   if (ord($str_cut[$i]) > 128) $i++; 
  $str_cut = substr($str_cut,0,$i); 
} 
return $str_cut; 
} 
?>