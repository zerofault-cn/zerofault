<?
define('IN_MATCH', true);
//2005-09-22 14:41
//�ַ�����ȡ�������Ա�֤�õ����ַ�����û�а�����ֵ����
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