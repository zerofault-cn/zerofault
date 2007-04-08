<?php
function drawer($image, $string, $x, $y, $color)
{
  $fp = fopen("chs16.fon", "r"); //WIN98中，此文件在：c:\windows\command 下
  if (feof($fp))
  {
    fclose($fp);
    return 0;
  }
// gbk
  $strings = preg_split('/((?:[\\x80-\\xFF][\\x40-\\xFF])+)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
  $isch = false;
  for ($p = 0, $count = count($strings); $p < $count; $p ++) 
  {
    if ($isch)
    {
      $string = $strings[$p];
      for ($i = 0, $l = strlen($string) - 1; $i < $l; $i += 2)
      {
        $qh = ord($string{$i}); // get ascii code
        $offset = (94 * ($qh - 0xA0 - 1) + (ord($string{$i + 1}) - 0xA0 - 1)) * 32;
        fseek($fp, $offset, SEEK_SET);
        $buffer = unpack('n*', fread($fp, 32));
//        $buffers[$offset] = $buffer;
        for ($yy = 1, $ypos = $y; $yy <= 16; $yy ++, $ypos ++) 
        {
          $bits = $buffer[$yy];
          for ($xbit = 32768, $xpos = $x; $xbit > 0; $xbit >>= 1, $xpos ++) 
          {
            if ($bits & $xbit)
            {
               imagesetpixel($image, $xpos, $ypos, $color);
            }
          }
        }
        $x += 16;
      }
    }
    else
    {
      imagestring($image, 12, $x, $y, $strings[$p], $color);
      $x += strlen($strings[$p]) * 9;
    }
    $isch = !$isch;
  }
return 0;

}
?>